---
title: "app.php"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 100
---
{{< objetivos  >}}
Ciclo de vida de una app 
{{< /objetivos >}}

### El Archivo de Arranque : bootstrap/app.php

{{< alert title="Importante" color="blue" >}}
* El archivo de arranque para una aplicación laravel es  `bootstrap/app.php`,
* Es fundamental para configurar tu aplicación Laravel. 

* En la versión 11, se ha modificado su funcionalidad, de forma que aspectos que se cubrían en otros ficheros, ahora se han centralizado aquí.
* De esta forma se ha convertido en un archivo de configuración basado en código, unificando ajustes clave para nuestra app.
{{< /alert >}}

### Propósito del Archivo

{{<definicion title="Bootstrap" icon="fas fa-layer-group" >}}
El archivo de bootstrap es el punto inicial donde Laravel configura aspectos esenciales como rutas, middleware y excepciones, antes de cargar el resto de la aplicación.
{{</definicion>}}

{{% line %}}

## Análisis del Código

A continuación, exploramos el código del archivo `bootstrap/app.php`:

{{< highlight dockerfile "linenos=table, hl_lines=1 2 7 10" >}}
return Application::configure(basePath: dirname(__DIR__))
->withRouting(
web: __DIR__.'/../routes/web.php',
commands: __DIR__.'/../routes/console.php',
health: '/up',
)
->withMiddleware(function (Middleware $middleware) {
// Añadir middlewares personalizados aquí
})
->withExceptions(function (Exceptions $exceptions) {
// Configurar manejadores de excepciones
})->create();
{{< /highlight >}}

{{% line %}}

### Desglose

#### `Application::configure(basePath: dirname(__DIR__))`
- Define la ruta base de la aplicación, que es la raíz del proyecto (`basePath`). A partir de esta configuración, Laravel sabe dónde encontrar carpetas clave como `app`, `config` y `routes`.

#### `->withRouting(...)`
- Configura las rutas de la aplicación:
	- `web`: Define las rutas para solicitudes web desde `routes/web.php`.
	- `commands`: Define rutas para comandos de consola en `routes/console.php`.
	- `health`: Establece una ruta para comprobaciones de salud del sistema (por ejemplo, `/up`).

#### `->withMiddleware(...)`
- Aquí puedes registrar middlewares globales. Los middlewares actúan como capas que se ejecutan antes o después de una solicitud HTTP.

{{< highlight dockerfile "linenos=table" >}}
->withMiddleware(function (Middleware $middleware) {
$middleware->add(SomeCustomMiddleware::class);
})
{{< /highlight >}}

#### `->withExceptions(...)`
- Configura los manejadores de excepciones personalizados. Esto es útil para centralizar la lógica de manejo de errores.

{{< highlight dockerfile "linenos=table" >}}
->withExceptions(function (Exceptions $exceptions) {
$exceptions->handler(CustomExceptionHandler::class);
})
{{< /highlight >}}

#### `->create()`
- Finaliza la configuración y devuelve una instancia de la aplicación lista para usar.

{{% line %}}

## Ventajas

1. **Centralización:**
	- Unifica configuraciones clave en un solo archivo, lo que mejora la organización del proyecto.

2. **Legibilidad:**
	- Estructura clara y fácil de entender.

3. **Flexibilidad:**
	- Facilita añadir configuraciones personalizadas como middlewares o manejadores de excepciones.

{{< alert title="Nota" color="success" >}}
Este es un nuevo enfoque en la versión 11 que  permite trabajar de manera más explícita con la configuración de Laravel y reduce la dependencia de archivos distribuidos.
{{< /alert >}}

{{% line %}}



