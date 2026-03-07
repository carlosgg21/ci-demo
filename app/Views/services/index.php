<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios</title>
</head>
<body>
    <h1><?= $title ?></h1>
  

   <?php 
    $table = new \CodeIgniter\View\Table();
  
    // Configurar cabeceras de la tabla
    $table->setHeading('#', 'Servicio', 'Descripción', 'Estado');

    // Convertir objetos a arrays
    $servicesArray = array_map(function ($service) {
        return [$service->id, $service->name, $service->description, $service->status];
    }, $services);
    
    echo $table->generate($servicesArray);
    ?>
    
</body>
</html>