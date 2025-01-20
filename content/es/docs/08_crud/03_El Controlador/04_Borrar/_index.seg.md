---
title: "El controlador y las vistas"
date: 2023-04-08T18:21:47+02:00
draft: true
weight: 80
icon: fa-solid fa-database
---

## Creamos las rutas

{{% pageinfo%}}

####

****

Ahora tenemos que establecer las rutas para las solicitudes
Simpelemente agregamos la ruta {{<color_blue>}}resources{{</color_blue>}} en fichero de rutas {{<color_blue>}}web.php{{</color_blue>}}

{{% imgproc web Fill "200x150" %}}

{{% /imgproc %}}
En él incluímos la sigueinte línea
{{< highlight php "linenos=table, hl_lines=1" >}}
Route::resource("Alumnos", \App\Http\Controllers\AlumnoController::class);
{{< / highlight >}}
Alternativamente puedes establecer con {{<color_blue>}}use{{</color_blue>}} que vas a utilizar ese {{<color_blue>}}namespace{{</color_blue>}}
{{< highlight php "hl_lines=1 3" >}}
use App\Http\Controllers\AlumnoController;

Route::resource("Alumnos", AlumnoController::class);

{{< / highlight >}}
{{< alert title="Warning" color="warning" >}}
Ahora puedes ver las rutas escribiendo en el termina
{{< /alert >}}
{{< highlight php "linenos=table, hl_lines=1" >}}
php artisan route:list
{{< / highlight >}}
{{% imgproc routelist Fill "1500x200" %}}

{{% /imgproc %}}

{{% /pageinfo%}}
## Escribiendo los métodos y creando las vistas

{{% pageinfo%}}
****
**Ahora debemos de realizar realmente la parte de programación**
**Debemos de realizar cada una de las acciones ante cada solicitud y retornar una vista**
{{% /pageinfo%}}

### Obtener listado de alumnos

{{% pageinfo%}}
{{% imgproc vistaListadoAlumnos Fill "200x100" %}}

{{% /imgproc %}}

#### Primero implementamos el controlador

{{<color_green>}}En el controlador implementaremos el método index.php{{</color_green>}}
{{% imgproc controlador Fill "200x100" %}}

{{% /imgproc %}}
{{< highlight php "linenos=table, hl_lines=6 10" >}}
public function index()
{
//Obtenemos todos los alumnos con el método all()
//del modelo correspondiente
//esto es lo mismo que select * from alumnos previa conexión a la bd
$alumnos = Alumno::all();

            //retronamos una vista a la que le pasamos una collección con todos los alumnos
            //una colección la gestionaremos como un array de objetos de alumnos
            return view ("alumnos.listado", ["alumnos"=>$alumnos]);
    }

{{< / highlight >}}

#### Ahora generamos la vista correspondiente

*Primero creamos la carpeta alumnos dentro de {{<color_blue>}}resources/view{{</color_blue>}} para tener todo más
organizado
{{% imgproc vistaListadoAlumnos Fill "400x100" %}}

{{% /imgproc %}}
{{< highlight php "linenos=table, hl_lines=16 18-22 " >}}
<!doctype html>
<html lang="en">
<head>
  <!--  ...    -->
</head>
<body>
    <h1>Listado de alumnos</h1>
    <table>
        <tr>
            <th>Nombre</th>
            <th>DNI</th>
            <th>Dirección</th>
            <th>Email</th>
            <th>Edad</th>
        </tr>
        @foreach($alumnos as $alumno)
            <tr>
                <td>{{$alumno->nombre}}</td>
                <td>{{$alumno->dni}}</td>
                <td>{{$alumno->direccion}}</td>
                <td>{{$alumno->email}}</td>
                <td>{{$alumno->edad}}</td>
            </tr>
        @endforeach
    </table>

</body>
</html>
{{< / highlight >}}

{{< alert title="directivas blade" color="warning" >}}

Observa cómo recorremos el array

Recibimos del controlador un {{<color_green>}}array $alumnos{{</color_green>}}
Es un array {{<color_green>}}de objetos de alumnos{{</color_green>}}
Visualizo {{<color_green>}}cada campo del alumno{{</color_green>}}
{{< /alert >}}
****
{{% /pageinfo%}}

### Crear un nuevo alumno

Crear un nuevo alumno es una acción de dos pasos

1. Primero retornamos un formulario para rellenar los datos del nuevo alumno
2. Segundo guardamos el alumno en la base de datos y retornamos todos un listado con todos los alumnos

#### Retornando el formulario

{{% pageinfo%}}

{{< imgproc createAlumno Fill "913x372" >}}

{{< /imgproc >}}

* Lo primero debemos de generar un botón en la vista para que el usuario pueda seleccionar la opción de crear un nuevo
  alumno.
* Para ello modificamos el fichero {{<color_blue>}}resources/view/alumnos/listado.blade.php{{</color_blue>}}
  {{< highlight php "linenos=table, hl_lines=3 6 7 9" >}}

<head>
<!-- ....  -->
    @vite(["resources/css/app.css"])
</head>
<body>
<div class="flex flex-col justify-center items-center w-full">
<a href="{{route("alumnos.create")}}" class="bg-amber-700 text-4xl text-white p-5 m-5 rounded-3xl outline-4  ">Crear Nuevo Alumno</a>
    <table>
        <caption class="text-3xl text-green-800 mb-5">Listado de alumnos</caption>

       <!-- .... -->

</div>

{{< / highlight >}}
{{< alert title="Acciones" color="warning" >}}
Hemos usado tailwindcss y agregado {{<color_blue>}}el nuevo botón{{</color_blue>}}.
La línea 7 es dónde añadimos el botón
Para referenciar la ruta que tiene nombre usamos el helper {{<color_blue>}}route(){{</color_blue>}}
Se da un poco de estilo para que el botón y la tabla queden en medio

{{< /alert >}}

#### El controlador

* Esta acción, {{ <color_green>}}presionar el botón del formulario {{</color_green>}}, hará que se invoque el método       {{<color_blue>}}create {{ </color_blue>}} del controlador.
* Tenemos que especificar qué acción queremos hacer en el método correspondiente:  {{<color_blue>}}create{{</color_blue>}}

*  Necesitamos que nos retorne una vista con un formulario para insertar el nuevo alumno
{{< highlight php "linenos=table, hl_lines=1" >}}
  public function create()
  {
  return view ("alumnos.create");
  //
  }
 {{< / highlight >}}
*

#### Creando la vista

{{< imgproc vistaCrearAlumno Fill "250x100" >}}
{{<color_green>}}Vista crear un alumno{{</color_green>}}
{{< /imgproc >}}

* Debemos retornar una vista con un formulario para rellenar datos de un nuevo {{ <color_blue> }}alumno{{ </color_blue> }}

El fichero {{ <color_blue> }}create.blade.php{{ </color_blue> }}


{{< highlight php "linenos=table, hl_lines=8 12 13 15 20 25 30 35 40" >}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulario</title>
    @vite(["resources/css/app.css"])
</head>

<body class="flex items-center justify-center h-screen bg-gray-100">
    <form action="" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="mb-4">
            <label for="nombre" class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
            <input type="text" name="nombre" id="nombre"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="direccion" class="block text-gray-700 text-sm font-bold mb-2">Dirección:</label>
            <input type="text" name="direccion" id="direccion"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
            <input type="text" name="email" id="email"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="dni" class="block text-gray-700 text-sm font-bold mb-2">DNI:</label>
            <input type="text" name="dni" id="dni"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="flex items-center justify-between">
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Guardar
            </button>
            <button type="button"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Cancelar
            </button>
        </div>
    </form>
</body>

</html>
{{< / highlight >}}

{{< alert title="El formulario" color="warning" >}}
Este html lo ha retornado chat-gpt para centrar el formulario
Lo importante es respetar que {{<color_green>}}los name de los input sean los nombres de las tabls{{</color_green>}}
{{< /alert >}}

{{< imgproc formularioNuevoAlumno Fill "500x700" >}}

{{< /imgproc >}}

_

{{% /pageinfo%}}







