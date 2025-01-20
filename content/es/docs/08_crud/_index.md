---
title: "Creando un CRUD"
date: 2023-04-08T18:21:47+02:00
draft: true
weight: 80
icon: fa-solid fa-database
---

# Realizar un CRUD

{{% pageinfo%}}

#### CRUD

****
Vamos a hacer una aplicación que premita interactuar con una tabla en la base de datos a través de la aplicaicón.

La palabra CRUD viene de Create Read Update Delete, es decir, que desde nuestra aplicación podamos hacer estas acciones
sobre la tabla

{{<color_blue>}}Acciones necesarias{{</color_blue>}}
> * Creamos un proyecto nuevo
> * Crear la tabla
> * Poblar la tabla con valores
> * Crear un Modelo
> * Crear un Controlador de tipo recurso
> * Establecer las rutas y conocerlas
> * Escribir las acciones para cada método del controlador según la ruta solicitada
> * En cada solicitud crear la vista necesaria para visualizar información

{{% /pageinfo%}}

## Creando un proyecto nuevo

{{% pageinfo%}}
{{< highlight php "linenos=table, hl_lines=1" >}}
laravel new gestion_alumnos
{{< / highlight >}}
{{< alert title="Warning" color="warning" >}}
Puedes usar un proyecto que ya tuvieras
Podemos instalar {{<color_blue>}}breeze{{</color_blue>}} así ya tenemos tailwindcss disponible {{<color_blue>}}tailwindcss{{</color_blue>}}
{{< /alert >}}

{{% /pageinfo%}}

## Crear los elementos necesarios:

En lugar de crear cada uno de los elementos :{{<color_green>}}tabla, factorías y seeder, modelo y controlador de tipo
recurso{{</color_green>}} vamos a usar un parámetro a la hora de creaer el modelo que lo crea todo
{{% pageinfo%}}
{{< highlight php "linenos=table, hl_lines=1" >}}
php artisan make:model Alumno --all
{{< / highlight >}}
{{< alert title="Importante" color="warning" >}}
El modelo simpre en singular
{{< /alert >}}
{{% imgproc creacion_model Fill "1000x500" %}}

{{% /imgproc %}}

{{% /pageinfo%}}


### Qué son los elementos

#### Clases especiales de laravel que creamos

{{% pageinfo%}}

### Migration

{{<color_green>}}Son clases anónimas clase nos va a permitir realizar acciones de tipo DDL sobre la base de datos{{<
/color_green>}}:

> * crear
> * modificar
> * borrar
> * tablas
> * índices, etc

****
Cada clase tiene dos métodos:
{{< alert title="up()" color="warning" >}}
Método que creará elementos
Se ejecutará cuando ejecute una migración
{{< /alert >}}
{{< alert title="down()" color="warning" >}}
Este método debería de elminar los elementos creados en up
Se ejecutará cuando ejecute un dehacer migración (con rollback o reset)
{{< /alert >}}

Cada migración va a ser una clase ubicada en {{<color_green>}}./database/migrations/fecha_create_xxxx.php{{<
/color_green>}}

### Factory

Para dar {{<color_green>}}fabricar o crear valores o filas de una determinada tabla {{</color_green>}}.
{{< alert title="Aclaración" color="warning" >}}
Las factorías crean valores, no los inserta en la tabla
{{< /alert >}}
Las factorías se ubican en {{<color_green>}}./database/factory/NombreFactory.php{{</color_green>}}
{{% imgproc factoria Fill "300x100" %}}

{{% /imgproc %}}

### Seeder

Esta clase va a llamar a la {{<color_green>}}factoría y cada fila que nos retorna la vamos a insertar en la tabla {{<
/color_green>}}.
{{< alert title="Aclaración" color="warning" >}}
Los seeder crean valores, no los inserta en la tabla
{{< /alert >}}
Las seeder se ubican en {{<color_green>}}./database/seeder/NombreSeeder.php{{</color_green>}}
{{% imgproc seeder Fill "300x150" %}}
{{% /imgproc %}}
{{< alert title="Warning" color="warning" >}}
Como puede haber varios seeder, todos se van a ejecutar a través de DatabaseSeeder.php
Por ejemplo si tuviera varios seeder {{<color_blue>}}Nombre1Seeder, Nombre2Seeder, Nombre3Seeder:{{</color_blue>}}
{{< /alert >}}
{{< highlight php "linenos=table, hl_lines=1" >}}
$this->call([
Nombre1Seeder::class,
Nombre2Seeder::class,
Nombre3Seeder::class,
]);
{{% / highlight %}}

### Modelo

Es una clase que nos va a permitir {{<color_green>}}interactuar con una determinada tabla de la base de datos de forma
directa{{</color_green>}}
Para ello utilizaremos {{<color_blue>}}objetos y métodos{{</color_blue>}} sin necesidad de implementar consultas sql y
enviarlas a la base de datos a través de los recursos mysqli o PDO.
Para ello se usa {{<color_blue>}}Eloquent{{</color_blue>}} Que es un {{<color_blue>}}ORM{{</color_blue>}}

{{% imgproc eloquent Fill "400x450" %}}

{{% /imgproc %}}
Las modelos se ubican en {{<color_green>}}./app/Models/Modelo.php{{</color_green>}}
{{% imgproc modelo Fill "300x150" %}}

{{% /imgproc %}}

Un modelo asume por defecto valores para interactuar con una tabla sin tener que especificar nada:

> * Nombre de la tabla igual que {{<color_blue>}} nombre del modelo en plural{{</color_blue>}}. En este caso {{<
    color_green>}}alumnos{{</color_green>}}
> * Clave en la tabla {{<color_blue>}}id (autoincrement ){{</color_blue>}}
> * Tiene los campos de maracas de tiempo: {{<color_blue>}}create_at update_at{{</color_blue>}}

{{< alert title="Warning" color="warning" >}}
Estos valores se pueden cambiar estableciéndolos en el modelo correspondiente
{{< /alert >}}

### Controlador resource

### Policy

### Request

{{% /pageinfo%}}




