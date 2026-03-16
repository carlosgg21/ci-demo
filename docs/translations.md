# Sistema de Traducciones Multi-idioma

## Arquitectura General

El sistema usa un patron **columna base + JSON** para manejar traducciones:

- Los campos del **idioma default** (ej: `es`) se almacenan en columnas regulares de la tabla (`name`, `description`, etc.)
- Las traducciones a **idiomas secundarios** se almacenan en una columna `translations` de tipo JSON

```
services
+----+------------------+------------------------------+---------------------------------------+
| id | name             | description                  | translations (JSON)                   |
+----+------------------+------------------------------+---------------------------------------+
|  1 | Desarrollo Web   | Construimos sitios modernos  | {"en":{"name":"Web Development",      |
|    |                  |                              |   "description":"We build modern..."}}|
+----+------------------+------------------------------+---------------------------------------+
```

### Por que este enfoque y no tablas separadas?

| Criterio                | Columna JSON              | Tabla de traducciones separada |
|-------------------------|---------------------------|--------------------------------|
| Complejidad de queries  | Baja (un solo SELECT)     | Alta (JOINs por locale)       |
| Performance lectura     | Excelente                 | Requiere JOINs                |
| Migraciones al agregar  | Ninguna                   | Agregar filas                 |
| Busqueda full-text      | Limitada en JSON          | Nativa                        |
| Ideal para              | < 10 idiomas, CMS/landing | +50 idiomas, apps enterprise  |

Para este proyecto (CMS/landing page con pocos idiomas), la columna JSON es la opcion correcta.

---

## Componentes del Sistema

### 1. Trait `HasTranslations`

**Ubicacion:** `app/Traits/HasTranslations.php`

El trait centraliza toda la logica de traducciones. Cualquier entity que necesite soporte multi-idioma solo necesita usar el trait y definir sus campos traducibles.

#### Implementacion en una Entity

```php
<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Traits\HasTranslations;

class Service extends Entity
{
    use HasTranslations;

    // Definir los campos que se traducen
    protected array $translatable = ['name', 'description'];

    protected $casts = [
        'translations' => 'json',  // Obligatorio
    ];
}
```

#### Requisitos para usar el trait:

1. La tabla debe tener una columna `translations` de tipo `JSON` (nullable)
2. La entity debe tener `'translations' => 'json'` en `$casts`
3. La entity debe definir `$translatable` con los nombres de los campos traducibles
4. Los campos traducibles deben existir como columnas regulares en la tabla

### 2. Helper de Locale

**Ubicacion:** `app/Helpers/locale_helper.php`
**Auto-cargado** en `app/Config/Autoload.php`

| Funcion              | Retorna   | Descripcion                                      |
|----------------------|-----------|--------------------------------------------------|
| `app_locale()`       | `string`  | Locale activo (session > request > config)       |
| `default_locale()`   | `string`  | Locale default de la compania                    |
| `available_locales()` | `array`  | Todos los locales activos (objetos Locale)       |
| `secondary_locales()` | `array`  | Solo locales no-default (para tabs de traduccion)|

---

## API del Trait

### Lectura de traducciones

```php
$service = $serviceModel->find(1);

// Resolver campo al locale activo (con fallback automatico)
$service->t('name');                    // "Desarrollo Web" (si locale es 'es')
$service->t('name', 'en');              // "Web Development"
$service->t('name', 'fr');              // "Desarrollo Web" (fallback, no hay FR)

// Obtener traduccion sin fallback
$service->getTranslation('en', 'name'); // "Web Development"
$service->getTranslation('fr', 'name'); // null

// Obtener todas las traducciones de un locale
$service->getTranslationsForLocale('en');
// ['name' => 'Web Development', 'description' => 'We build modern...']

// Obtener locales que tienen traduccion
$service->getTranslatedLocales(); // ['en']
```

### Escritura de traducciones

```php
// Establecer un campo individual
$service->setTranslation('en', 'name', 'Web Development');

// Establecer todos los campos de un locale
$service->setTranslationsForLocale('en', [
    'name'        => 'Web Development',
    'description' => 'We build modern websites.',
]);

// Luego guardar normalmente
$serviceModel->save($service);
```

### Verificacion

```php
// Verificar si hay traduccion para un locale
$service->hasTranslation('en');              // true (al menos un campo)
$service->hasTranslation('en', 'name');      // true (campo especifico)
$service->hasTranslation('fr');              // false

// Porcentaje de completitud (util para badges en admin)
$service->getTranslationCompleteness('en');  // 100 (ambos campos llenos)
$service->getTranslationCompleteness('fr');  // 0
```

### Utilidades

```php
// Obtener campos traducibles de la entity
$service->getTranslatableFields(); // ['name', 'description']

// Obtener array crudo de traducciones
$service->getTranslationsArray(); // ['en' => ['name' => '...', 'description' => '...']]

// Construir traducciones desde input de formulario (metodo estatico)
$json = Service::buildTranslationsFromInput(
    $request->getPost('translations'),  // ['en' => ['name' => 'Web Dev', ...]]
    ['name', 'description']
);
// Retorna JSON string o null si vacio
```

---

## Uso por Contexto

### En el Admin (Controller / Request)

Al crear o actualizar, extraer las traducciones del formulario:

```php
// En StoreServiceRequest::validated() o UpdateServiceRequest::validated()
$data = [
    'name'         => $request->getPost('name'),
    'description'  => $request->getPost('description'),
    // ... otros campos ...
    'translations' => Service::buildTranslationsFromInput(
        $request->getPost('translations') ?? [],
        (new Service())->getTranslatableFields()
    ),
];
```

### En la Landing Page (vista publica)

```php
// En el controller, establecer el locale segun la URL o sesion
session()->set('app_locale', $locale); // 'en', 'es', etc.

// En la vista, usar t() — resuelve automaticamente
<h2><?= esc($service->t('name')) ?></h2>
<p><?= esc($service->t('description')) ?></p>
```

### En la API publica

```php
// Endpoint: GET /api/v1/services?lang=en
$locale = $this->request->getGet('lang') ?? app_locale();

$data = array_map(fn($s) => [
    'id'          => $s->id,
    'slug'        => $s->slug,
    'name'        => $s->t('name', $locale),
    'description' => $s->t('description', $locale),
    'icon'        => $s->icon,
    'image'       => $s->image,
], $services);
```

### En la API admin (devolver todo para edicion)

```php
// Devolver el servicio completo con translations como objeto
return ApiResponse::success([
    'id'           => $service->id,
    'name'         => $service->name,
    'description'  => $service->description,
    'translations' => $service->getTranslationsArray(),
    // ... otros campos
]);
```

---

## Entidades con Traducciones

| Entity          | Tabla              | Campos traducibles                          |
|-----------------|--------------------|---------------------------------------------|
| Service         | `services`         | `name`, `description`                       |
| TeamMember      | `team_members`     | `name`, `position`, `bio`                   |
| Testimonial     | `testimonials`     | `client_name`, `client_position`, `content` |
| ContentSection  | `content_sections` | `title`, `subtitle`, `content`, `button_text`|

---

## Agregar traducciones a una nueva entidad

### Paso 1: Migracion

Agregar columna `translations` a la tabla:

```php
'translations' => ['type' => 'JSON', 'null' => true],
```

### Paso 2: Model

Agregar `'translations'` a `$allowedFields` y a `$casts`:

```php
protected $allowedFields = [
    // ... otros campos ...
    'translations',
];

protected array $casts = [
    'translations' => 'json',
];
```

### Paso 3: Entity

Usar el trait y definir campos traducibles:

```php
use App\Traits\HasTranslations;

class MiEntidad extends Entity
{
    use HasTranslations;
    protected array $translatable = ['titulo', 'descripcion'];
    protected $casts = ['translations' => 'json'];
}
```

### Paso 4: Request

Agregar validacion para traducciones en Store/Update Request.

### Paso 5: Vista/Drawer

Agregar los campos de traduccion en el formulario del admin (ver seccion de UI/UX).

---

## Estructura del JSON

```json
{
    "en": {
        "name": "Web Development",
        "description": "We build fast and modern websites."
    },
    "fr": {
        "name": "Developpement Web",
        "description": "Nous construisons des sites web modernes."
    }
}
```

- La clave raiz es el **codigo de locale** (debe coincidir con `locales.code`)
- Dentro, un objeto con los **mismos nombres de campo** que las columnas traducibles
- Los locales sin traduccion simplemente no aparecen en el JSON
- Si todos los campos de un locale estan vacios, el locale se omite del JSON
