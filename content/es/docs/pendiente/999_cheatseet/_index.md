---
title: "Cheat Sheet"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 999
---
# Resumen de acciones de laravel


## Instalación:    

Debemos tener instalado {{<color_blue>}}composer{{</color_blue>}}

{{% pageinfo%}}      

**Instalamos {{<color_green>}}el instalador de proyectos de laravel{{</color_green>}} para crear nuevos proyectos**


{{< highlight shell "linenos=table, hl_lines=1" >}}
composer global require laravel/installer
{{< / highlight >}}
{{% /pageinfo%}}
**Ahora ya podemos crear un proyecto nuevo de laravel**
{{< highlight php "linenos=table, hl_lines=1" >}}
laravel new NuevoProyectoLaravel
{{< / highlight >}}
- 
  ```bash
  composer create-project --prefer-dist laravel/laravel project-name
2. Artisan Commands:
   Create a controller:

bash
Copy code
php artisan make:controller ControllerName
Create a model:

bash
Copy code
php artisan make:model ModelName
Run migrations:

bash
Copy code
php artisan migrate
3. Routing:
   Define a route in routes/web.php:
   php
   Copy code
   Route::get('/route', 'ControllerName@method');
4. Views:
   Blade template:
   php
   Copy code
<p>{{ $variable }}</p>
5. Database:
Eloquent ORM:

php
Copy code
$model = ModelName::find($id);
Query Builder:

php
Copy code
$results = DB::table('table')->get();
6. Middleware:
   Apply middleware in routes:
   php
   Copy code
   Route::get('/admin', 'Controller@method')->middleware('auth');
7. Authentication:
   Create authentication scaffolding:
   bash
   Copy code
   php artisan make:auth
8. Validation:
   Validate requests in controllers:
   php
   Copy code
   $validatedData = $request->validate([
   'field' => 'required|numeric',
   ]);
9. Testing:
   Run tests:
   bash
   Copy code
   php artisan test
10. Artisan Tinker:
    Interact with your application:
    bash
    Copy code
    php artisan tinker

## 
## Rutas
## Artisan
## MVC


