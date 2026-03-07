# CI Demo — Admin Panel

Panel de administración full-stack construido con **CodeIgniter 4**, diseñado como base reutilizable para proyectos CMS multi-tenant con API REST incluida.

## Stack

| Capa | Tecnología |
|------|-----------|
| Backend | PHP 8.2+, CodeIgniter 4.7 |
| Frontend | Alpine.js 3, Bootstrap 5.3, Bootstrap Icons |
| Gráficas | Chart.js 4 |
| Iconos de país | Flag Icons 7 |
| Base de datos | MySQL (MySQLi) |
| Testing | PHPUnit 10, Faker |

## Módulos

| Módulo | Descripción |
|--------|-------------|
| **Usuarios** | Gestión de cuentas con roles (`super_admin`, `admin`, `editor`) |
| **Empresas** | Entidades multi-tenant base del sistema |
| **Monedas** | Catálogo de divisas con símbolo, ISO numérico y bandera |
| **Locales** | Configuración de idiomas/regiones |
| **Ajustes** | Configuración global de la aplicación |
| **Servicios** | Catálogo de productos/servicios paginado |
| **Miembros del equipo** | Perfiles con relación a empresa |
| **Testimonios** | Reseñas de clientes |
| **Secciones de contenido** | Bloques de landing page con soporte i18n (JSON) |
| **Tipos de sección** | Definición de plantillas de sección |
| **Medios** | Gestión de archivos/uploads |
| **Redes sociales** | Links a perfiles de redes |
| **Contacto** | Bandeja de formularios de contacto |

## Arquitectura

```
app/
├── Controllers/          # Web controllers (HTML) + Api/ (JSON)
├── Models/               # CI4 Models con soft delete y timestamps
├── Entities/             # Entidades tipadas con cast helpers
├── Repositories/         # Capa de abstracción sobre Models
├── Requests/             # Validación de entrada centralizada
├── Exceptions/           # Excepciones de dominio
├── Views/
│   ├── layouts/          # Layout principal (main.php) y auth
│   ├── partials/         # Sidebar, navbar
│   └── [módulo]/         # Vista index + _drawer por módulo
└── Database/
    ├── Migrations/       # 12 migraciones
    └── Seeds/            # Seeders de datos de prueba
```

**Patrones aplicados:**
- Repository Pattern — controllers nunca tocan models directamente
- Entity Pattern — objetos tipados con métodos helper (`getStatusBadge()`, `getFlagHtml()`, etc.)
- Request Objects — validación desacoplada del controller

## API REST

Endpoints bajo `/api/v1/` con soporte completo CRUD:

```
GET    /api/v1/services
POST   /api/v1/services
GET    /api/v1/services/{id}
PUT    /api/v1/services/{id}
DELETE /api/v1/services/{id}
```

Estructura lista para versionado (`v1`, `v2`).

## Instalación

**Requisitos:** PHP 8.2+, MySQL, Composer, Node.js

```bash
# 1. Clonar e instalar dependencias PHP
git clone https://github.com/carlosgg21/ci-demo.git
cd ci-demo
composer install

# 2. Instalar assets frontend
npm install

# 3. Configurar entorno
cp env .env
# Editar .env: CI_ENVIRONMENT, database.*, app.baseURL

# 4. Crear base de datos y migrar
php spark db:create bd_ci_demo   # si no existe
php spark migrate
php spark db:seed MainSeeder     # datos de prueba (opcional)
```

## Configuración del servidor

Apuntar el document root a la carpeta `public/`:

```apache
# Apache VirtualHost
DocumentRoot /ruta/al/proyecto/public
```

```nginx
# Nginx
root /ruta/al/proyecto/public;
```

Con Laragon, configurar el host virtual apuntando a `public/`.

## Variables de entorno clave

```ini
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost/ci-demo/public/'

database.default.hostname = localhost
database.default.database = bd_ci_demo
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
```

## Tests

```bash
php spark test
# o
./vendor/bin/phpunit
```

## Requisitos PHP

- PHP 8.2+
- Extensiones: `intl`, `mbstring`, `json`, `mysqlnd`, `libcurl`
