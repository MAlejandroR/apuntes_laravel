---
title: "Plantilla para Crud"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 120
icon: fa-solid fa-layer-group
---

## Planteamiento

Se trata de crear un sistema automatizado para generar un crud genérico a partir de un fichero de configuración.

En el fichero especificaremos los recursos que queremos gestionar

Este proyecto automatizará una gran parte del proceso
****

```plantuml
title Planteamiento Crud genérico


component "Fichero config/resource.php" as Config #5DADE2
component "main.blade.php" as Vista #F5B041
component "CrudController.php" as Controller #58D68D

Config --> Vista:   config("resources")
Vista --> Controller : <resource>

note right of Controller
Genera datos:
- resource
- rows
- fields
- table
end note


````

## Creamos el fichero de configuración

En la carpeta **config** creamos un fichero llamado **resources.php**

En una primera acción simplemente los recursos que queremos gestionar

La idea será que si añadimos aquí resucursos mi aplicción funione y se adapte a todos los recursos que aquí
especifiquemos

```php

<?php
return [
    'projects'
    'users'
    'teachers'
    'students'
    'guests' //usuario registrado que no es ni profesor ni estudiante
    'tasks
];
```

'

## Creamos el fichero main

Ahora queremos crear un main con tantas tarjetas como recursos tenga.

Las tarjetas que estamos usando son las de daysy, y las hemos creado en componentes html
Esta sería una tarjeta que tenemos ahora

```php
  <x-card>
                    <x-slot name="label">{{__("Ver Proyectos")}}</x-slot>
                    <x-slot name="img">{{ asset("/images/project.jpeg") }}</x-slot>
                    <x-slot name="title">Gestión de Proyectos</x-slot>
                    <x-slot name="description">Vamos a ver un Crud con los proyecots</x-slot>
                    <x-slot name="ref">{{route("proyecto.index")}}</x-slot>
                </x-card>
```

Queremos creaer tantas tarjetas como elementos tengamos en el fichero de resources

Analizamos los datos que necesitamos en el card y vemos cómo obtenerlos:

* Vamos a obviar de momento el nombre traducido, y vamos a usar como nombre siempre el valor del recurso que tengo en el
  fichero.
* El tema de las imágenes, lo solucionaremos teniendo imágenes todas con el nombre del recurso, en nuestro caso:
  !(img_1.png)[img_1.png]
* El tema de la ruta, es diferente, necesito rutas pero que el recurso que quiere gestionar sea parametrizable. Para
  resolver este punto ver el apartado siguiente

Ahora tenemos
Una vez que tenemos esto la creación del **main** se vuelve sencilla

```php
            @foreach(config('resources') as $resource)
                <x-card>
                    <x-slot name="label">{{__("Ver $resource")}}</x-slot>
                    <x-slot name="img">{{ asset("/images/$resource.jpeg") }}</x-slot>
                    <x-slot name="title">Gestión de {{$resource}}</x-slot>
                    <x-slot name="description">Vamos a ver un Crud con los {{$resource}}</x-slot>
                    <x-slot name="ref">{{route("crud.index",$resource)}}</x-slot>
                </x-card>
        @endforeach
```

## Creamos el controlador genérico

Creamos un controlador de tipo API que va a ser genérico, es decir el recurso que va a gestionar.

El controlador le llamamos **CrudController**

```php
php artisan make:controller CrudController --api
```

Por ser de tipo API tendrá todos los métodos para atender las solicitudes
| Método | Endpoint | Método Controller | Descripción |
|--------|---------------------|-------------------|----------------------------------------------|
| GET | /recurso | index()           | Listado de todos los registros del recurso |
| GET | /recurso/{id} | show()            | Mostrar un registro concreto |
| POST | /recurso | store()           | Crear un nuevo registro |
| PUT | /recurso/{id} | update()          | Actualizar un registro completo |
| PATCH | /recurso/{id} | update()          | Actualizar parcialmente un registro |
| DELETE | /recurso/{id} | destroy()         | Eliminar un registro |

Como el recurso es te tipo parámetro, paremetrizamos la ruta. y le ponemos nombre
| Método | Endpoint | Método Controller | Descripción | Ruta |
|--------|----------------------|--------------------------------|----------------------------------------------|--------------|
| GET | /{resource} | index(string $resource)        | Listado de todos los registros del recurso | crud.index |
| GET | /{resource}/{id} | show(string $resource, $id)    | Mostrar un registro concreto | crud.show |
| POST | /{resource} | store(string $resource)        | Crear un nuevo registro | crud.store |
| PUT | /{resource}/{id} | update(string $resource, $id)  | Actualizar un registro completo | crud.update |
| PATCH | /{resource}/{id} | update(string $resource, $id)  | Actualizar parcialmente un registro | crud.update |
| DELETE | /{resource}/{id} | destroy(string $resource, $id) | Eliminar un registro | crud.destroy |

Para ello sería deseable crear en **web.php** con el método **Route::resources**

```php
Route::resource("{resource}", CrudController::class)->middleware('auth');
```

Pero esto no funciona, así que tendremos que crear la ruta, de una en una
Como todas ellas son rutas protegidas, en lugar de hacerlo de una en una, las puedo envolver en el método middleware

```php
Route::middleware('auth')->group(function () {
   Route::get('{resource}', [CrudController::class,'index'])->name('crud.index');
   Route::get('{resource}/create', [CrudController::class,'create'])->name('crud.create');
   Route::post('{resource}', [CrudController::class,'store'])->name('crud.store');
   Route::get('{resource}/{id}/edit', [CrudController::class,'edit'])->name('crud.edit');
   Route::put('{resource}/{id}', [CrudController::class,'update'])->name('crud.update');
   Route::delete('{resource}/{id}', [CrudController::class,'destroy'])->name('crud.destroy');
});
```

Ahora ya tenemos las rutas creadas a partir de los nombres de los recursos que tenemos identificados en el fichero *
*config/resources.php**

Para adecuarlo todo tendremos que añadir el parámetro en cada método del controlador, existen otras opciones, pero
tomamos esta por ser la más directa.

```php
    public function index(string $resource)
    public function store(string $resource,Request $request)
    public function show(string $resource,string $id)
    public function update(string $resource,Request $request, string $id)
    public function destroy(string $resource,string $id)
```


## Componente para crear los modelos
Lo que sí que vamos a necesitar es un modelo, una tabla y posiblemente queramos hacer factoría y seeder

Para ello lo ideal sería tener un comando de **php artisan** y que automáticamente lo cree todo
Es conveniente tener clara la estructura de datos que tenemos en este caso y conseguir un sistema adaptable a cualquiera.

Partimos de nuestro sistema con el diagram E/R
{{< imgproc ER Fill "814x577" >}}
  
{{< /imgproc >}}

Pero ahora van a sugir unas circunstancias que tenemos que analizar:
1. {{<color>}}No todos los recursos serán tablas y modelos{{</color>}}
>Esto es porque hay recursos que en realidad son subtipos o quedan especificados por roles, por lo tanto necesito saber si un recurso es o no rol

2. {{<color>}} No todos los recursos serán tablas y modelos{{</color>}}
>Todos los modelos incorporar filleble, por lo que estaría bien saber sus atributos.

3. {{<color>}}En la fábrica conocer los atributos{{</color>}}
>Si sabemos los atributos de cada modelo, podré crear la fábrica ya con el esqueleto

Empezamos con esta acción que puede ser nueva, y por ello muy interesante

### Creando el nuevo comando
```php
php artisan make:command GenerateModels
```

Ahora accedemos al fichero generado en **app\Console\Commands\GenerateModels.php**  y escribimos el código

```php
    protected $signature = 'generate:models';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generar Moldels y migraciones a partir del ficherode configuración resources.php';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $resources = config("resources"); //Leemos los recursos
        foreach ($resources as $resource ) {
        //Cambiamos el nombre del resource a nombre de Model (mayúscula y en singular)
            $modelName = Str::studly(Str::singular($resource));
            $modelPath = app_path("Models/{$modelName}.php");
            if (!file_exists($modelPath)) {
            
            //Esta es la forma de ejecutar una función y pasarle los argumentos
            //La forma de especificar los argumentos puede ser nueva, pero se entiendo fácilmente
                $this->call('make:model', ['name' => $modelName, 
                '--migration' => true]);
                $this->info("Modelo $modelName generado con exito");
            } else
                $this->info("El Modelo $modelName Ya existe");

        }
        //
    }
}
```
* **Problema**: que nos crea modelos que no debería, ya que son roles.
* **Solución**: Vamos a detallar info en el fichero de resources, lo vamos a convertir en un array asociativo para ir dando detalles que nos interesen, aportando metadatos
```php
return [
    'projects'=>[],
    'users' =>[],
    'teachers'=>['rol'=>'teacher'],
    'students'=>['rol'=>'student'],
    'guests'=>['rol'=>'guest'],
    'tasks'=>[],
];

```
Y ahora modificamos el código

```php
  $resources = config("resources");
        foreach ($resources as $resource => $data) {
            if (isset($data['roll']))
                continue;
            $modelName = Str::studly(Str::singular($resource));
            $modelPath = app_path("Models/{$modelName}.php");
            if (!file_exists($modelPath)) {
                $this->call('make:model', ['name' => $modelName, '--migration' => true]);
                $this->info("Modelo $modelName generado con exito");
            } else
                $this->info("El Modelo $modelName Ya existe");

        }
```
Podríamos añadir los nombres de los campos y así que nos cree los fillable, la migración con los campos , la fábrica y el seeder

Luego habrá que revisar los ficheros generados y ajustarlos.

Primero aportamos la información en el fichero resources:

```php
<?php
return [
    'projects'=>[
        'fields'=>['name','title','description', 'hours','start_date']
    ],
    'users' =>[
        'fields'=>['name','email','password','phone', 'dni','department']
    ],
    'teachers'=>['type'=>'rol'],
    'students'=>['type'=>'rol'],
    'registereds'=>['type'=>'rol'],
    'tasks'=>[
        'fields'=>['name','title','description', 'status','priority']
    ],
];
```
Modificamos el comando para crear los fillable y el método getLabels que vamos a usar también en todos los casos

```php
    public function handle()
    {
        $resources = config("resources");
        foreach ($resources as $resource => $data) {
            if ($data['type'] ?? null == 'rol')
                continue;
            $modelName = Str::studly(Str::singular($resource));
            $modelPath = app_path("Models/{$modelName}.php");
            if (!file_exists($modelPath)) {
                $this->call('make:model',
                    ['name' => $modelName,
                        '--migration' => true,
                        '--factory' => true,
                        '--seed' => true,
                    ]);
                $this->info("Modelo $modelName generado con exito");

                $fillable = "'" . implode("', '", $data["fields"]) . "'";
                $getLabel = "public static function getLabels(){
                return __(\"$resource.fields\");
                }";

                $content = file_get_contents($modelPath);
                $content = str_replace(
                    "use HasFactory;",
                    "use HasFactory; \n\n
protected \$fillable=[$fillable];\n
$getLabel",
                    $content
                );
                file_put_contents($modelPath, $content);
            } else
                $this->info("El Modelo $modelName Ya existe");

        }
        //
    }
```

OK! Ahora ya tenemos la infraestructura de los modelos creados.

Para terminar correctamente este paso, nos falta crear los ficheros de traducción que también  lo vamos automatizar

1. Creando el comando
```php
return [
    'fields' => [
        "name" => "Name",
        "email" => "Email",
        "phone" => "Phone",
        "password" => "Password",
        "dni" => "DNI",
    ]
```
'
2. Escribiendo el código en el fichero
   Accedemos al fichero recién creado y escribimos el código
```php
**<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class GenerateLangsFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:langs-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera ficheros para cada modelo y traducir sus campos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $resources = config('resources');
        $langs = config("langs");
        $files = new Filesystem();
        $fieldArray="";

        foreach ($langs as $lang=>$content) {

            $base_path = lang_path($lang);
            foreach ($resources as $resource=>$data) {
                $fieldArray="";
                if ($data['type'] ?? null == 'rol')
                    continue;

                $fields = $data['fields'];
                foreach ($fields as $field) {
                    $fieldArray .= " '$field'=> '',\n ";
                }
                $content = <<<FIN
                   <?php
                    return[
                    'fields'=>[\n$fieldArray],\n
                    'table'=>''
                    ];
FIN;
                $field_Path = $base_path . "/$resource.php";
                $files->put($field_Path, $content);
                $this->info("Se generaron $field_Path");

            }
        }

        //
    }
}

```
3. Ejecutándolo
```php
php artisan generate:langs-files
```

4.- Ahora toca revisar los contendios y actualizarlo correctamente





## Componente para crear los fichero de labels


## Revisar todos los ficheros creados y actualizarlos
