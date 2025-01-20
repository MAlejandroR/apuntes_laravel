---
title: "Instalacion y rutas"
date: 2023-04-08T18:21:47+02:00
draft: true
weight: 10
---
## Creando el proyecto
Vamos a instalar e un 
```shell
mkdir books
cd books

```

{{< highlight bash "linenos=table,anclorlinenos=true, hl_lines=1-11" >}}

laravel new api --git
cd api
git init
git add *
git commit -m inicial
{{< / highlight >}}

Vamos documentando el Readme.md

### Rutas
Como la aplicación va a ser un API, vamos al fichero de rutas ***routes/api.php***
{{< highlight  "linenos=table,anclorlinenos=true, hl_lines=" >}}

{{< / highlight >}}
{{% pageinfo color="primary" %}}
Entre web.php y api.php hay como diferencias los middeleware que se utilizan. Esto se puede ver en 
{{% /pageinfo %}}   
En el caso de api.php, casi el único middleware que utiliza es el ThrottleRequests, es decir, poder crear un límite de peticiones, no necesitamos sesiones, cookies ni compartir errores entre ficheros.
Vemos si hacemos un **route:list** que las rutas que aparecen son las de **web.php** y también las de **api.php** que no habíamos visto
Las de **api** tiene prefijo, es por que se establece en el **routeservicesproviders.php**

Ahora vamos a crar un modelo, y queremos crear también la migración y el factory y también un controlador con todos los métodos de gestión rest que ya  hemos visto
{{< highlight bash "linenos=table,anclorlinenos=true, hl_lines=" >}}
php artisan make:model Book -mf --api
{{< / highlight >}}
Ahora debemos de agregar rutas
{{< imgproc api_rest.png Fit "1000x7000 center" >}}
imagen api
{{< /imgproc >}}
De todas ellas, como solo estamos creando un api, que es para consultar, no realizaremos la acción de editar para modificar, ni de crear por lo que las rutas nos quedarían
{{< imgproc api_rest2.png Fit "1000x7000 center" >}}
imagen api
{{< /imgproc >}}
Creamos estas rutas en el fichero **routes/api.php**
{{< highlight php "linenos=table,anclorlinenos=true, hl_lines=1" >}}
Route::apiResource('books', \App\Http\Controllers\BookController::class);
{{< / highlight >}}
Podemos ejectura route:list para ver las 5 rutas que hemos creado

