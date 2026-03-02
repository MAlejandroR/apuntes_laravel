---
title: "Creando elementos"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 20
icon: fa-solid fa-database
---
## Crear un nuevo alumno

**Crear un nuevo alumno es una acción de dos pasos**

1. Primero {{<color_green>}}retornamos un formulario{{</color_green>}} para rellenar los datos del nuevo alumno
2. Segundo {{<color_green>}}guardamos el alumno en la base de datos{{</color_green>}} y retornamos todos un listado con todos los alumnos

### Retornando el formulario


* Lo primero debemos de generar un botón en la vista para que el usuario pueda seleccionar la opción de crear un nuevo
  alumno.
* Para ello modificamos el fichero {{<color_blue>}}resources/view/alumnos/listado.blade.php{{</color_blue>}}

{{< imgproc createAlumno Fill "913x372" >}}

{{< /imgproc >}}

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

### El controlador

* Esta acción, {{<color_green>}}presionar el botón del formulario {{</color_green>}}, hará que se invoque el método       {{<color_blue>}}create {{</color_blue>}} del controlador.
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

### Creando la vista

{{< imgproc vistaCrearAlumno Fill "250x100" >}}
{{<color_green>}}Vista crear un alumno{{</color_green>}}
{{< /imgproc >}}

* Debemos retornar una vista con un formulario para rellenar datos de un nuevo {{<color_blue>}}alumno{{</color_blue>}}

El fichero {{<color_blue>}}create.blade.php{{</color_blue>}}


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

### Método store
*Ahora debemos de implementar el método {{<color_blue>}}store{{</color_blue>}} del controlador.
{{< highlight php "linenos=table, hl_lines=1" >}}
   public function store(StoreAlumnoRequest $request){
        //Obtener los datos del formulario
        $datos = $request->input();
        $alumno = new Alumno($datos);
        $alumno->save();
        
        return redirect()->route("alumnos.index");

        //
    }
{{< / highlight >}}
*Si ahora rellenamos y {{<color_green>}}damos a guardar{{</color_green>}} obtenemos {{<color_green>}}un forbbiden{{</color_green>}} por parte del servidor:
{{< imgproc forbbiden Fill "700x250" >}}

{{< /imgproc >}}
**Esto se debe a que hay unq clase {{<color_green>}}Request{{</color_green>}} que va a controlar la autorizacioń**

### Clases de Request en Laravel
{{% pageinfo%}}
#### 
****


Las clases de Request en Laravel, como `ProfileUpdateRequest`, `StoreAlumnoRequest`, y `UpdateAlumnoRequest`, son una parte integral de la validación de datos en aplicaciones Laravel. 

Estas clases extienden la clase base `FormRequest` de Laravel y proporcionan un lugar centralizado y organizado para manejar la validación y la autorización de las solicitudes HTTP entrantes.

## Características
- **Validación Personalizada**: Permiten especificar reglas de validación para los datos entrantes de manera detallada y clara. Esto lo veremos más adelante
- **Autorización**: Pueden contener lógica para determinar si un usuario tiene permiso para realizar la solicitud.
- **Reutilización**: Facilitan la reutilización de reglas de validación en diferentes partes de la aplicación.

## Ejemplos

- `ProfileUpdateRequest`: Podría contener reglas para validar la actualización de perfiles de usuario.
- `StoreAlumnoRequest`: Específica para validar los datos al crear un nuevo alumno.
- `UpdateAlumnoRequest`: Utilizada para validar los datos al actualizar la información de un alumno existente.

Al usar el comando `php artisan make:model Alumno --all`, Laravel genera automáticamente estas clases de Request (si se especifica) para proporcionar una estructura inicial para la validación y autorización relacionadas con el modelo `Alumno`.

*En nuestro clasoo tendremos que especificar en {{<color_green>}}StoreAlumnoRequest{{</color_green>}} en el método {{<color_green>}}autorize{{</color_green>}} que retorne un {{<color_green>}}true{{</color_green>}} para dar permisos a todos los usuarios para almacenar Alumnos
{{< highlight php "linenos=table, hl_lines=1" >}}
public function authorize(): bool
   {
      return true;
   }
{{< / highlight >}}
{{% /pageinfo%}}








