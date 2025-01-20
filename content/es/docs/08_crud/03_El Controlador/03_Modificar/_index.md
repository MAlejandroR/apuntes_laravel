---
title: "Modificando elementos"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 30
icon: fa-solid fa-database
---
## Modificar un alumno

**Al igual que Crear, Modificar  un  alumno es una acción de dos pasos**

1. Primero {{<color_green>}}retornamos un formulario con los datos del alumno{{</color_green>}} para modificar
2. Segundo {{<color_green>}}actualizamos los datos  en la base de datos{{</color_green>}}

### Retornando el formulario


* Lo primero debemos de generar un botón en la vista para cada alumno, y que el usuario pueda seleccionar la opción de editar alumno
* Modificamos cada línea del listado añadiendo un botón de editar
* Accedemos a https://heroicons.com/ para poder captar un svg de botón de editar concretamente seleccionamos este:
 <svg height="25px" width="25px" style="color:red" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
</svg>

* Para ello modificamos el fichero {{<color_blue>}}resources/view/alumnos/listado.blade.php{{</color_blue>}}

{{< imgproc FicheroDiaUpdateAlumno  Fill "1005x398" >}}

{{< /imgproc >}}

  {{< highlight php "linenos=table, hl_lines=13-21" >}}
<head>
<!-- ....  -->
    @vite(["resources/css/app.css"])
</head>
<!---
        @foreach($alumnos as $alumno)
            <tr class="space-x-20 mx-10">
                <td class="px-10">{{$alumno->nombre}}</td>
                <td  class="px-10">{{$alumno->dni}}</td>
                <td class="px-10">{{$alumno->direccion}}</td>
                <td class="px-10">{{$alumno->email}}</td>
                <td class="px-10">{{$alumno->edad}}</td>
                <td>
                    <a href="{{route("alumnos.edit", $alumno->id)}}">
                    <svg width="30px" height="30px" class=" w-6 h-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                    </a>


                </td>
            </tr>
        @endforeach
{{< / highlight >}}
{{< alert title="Acciones" color="warning" >}}
Hemos usado tailwindcss y agregado {{<color_blue>}}una nueva celda en cada fila{{</color_blue>}}.


Para referenciar la ruta que tiene nombre usamos el helper {{<color_blue>}}route(){{</color_blue>}}    
En este caso es importante ver que la ruta necesita el {{<color_blue>}}id del alumno{{</color_blue>}}
Lo pasamos como según parámetro en el helper {{<color_blue>}}route("alumnos.edit", $alumno->id){{</color_blue>}}

{{< /alert >}}

### El controlador

* Esta acción, {{<color_green>}}presionar el botón del formulario {{</color_green>}}, hará que se invoque el método       {{<color_blue>}}edit {{</color_blue>}} del controlador.

*  Necesitamos que nos retorne una vista con un formulario y los datos del alumno 
   {{< highlight php "linenos=table, hl_lines=1" >}}
   public function edit(Alumno $alumno)
   {
    return view("alumnos.edit", compact("alumno"));

   }

   {{< / highlight >}}
*
{{< alert title="El código" color="warning" >}}
Retornamos la vista {{<color_green>}}alumnos.edit{{</color_green>}}    
Le pasamos el alumno que queremos editar {{<color_green>}}(Alumno $alumno){{</color_green>}}     
Observa como laravel asocia de forma automática {{<color_green>}}el modelo a partir de un identificador{{</color_green>}}     
Esto se conocoe como  {{<color_green>}}"enlace implícito de modelo" (Implicit Model Binding) en Laravel.{{</color_green>}}
{{< /alert >}}
### Creando la vista

{{< imgproc vistaEditAlumno Fill "250x100" >}}
{{<color_green>}}Vista editar  un alumno{{</color_green>}}
{{< /imgproc >}}


* Debemos retornar una vista con un formulario para con los datos {{<color_green>}}del alumno que queremos editar{{</color_green>}}

El fichero {{<color_blue>}}edit.blade.php{{</color_blue>}}

El código es el mismo que en crear, pero en cada input ponemos el value del alumno que recibimos desde el controlador

{{< highlight html "linenos=table, hl_lines=3 6 10 16 22 28 34" >}}
<!DOCTYPE html>
<!-- ..  -->
<form action="{{route("alumnos.update", $alumno->id)}}" method="POST"
      class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
    @csrf
    @method('PUT')
    <div class="mb-4">
        <label for="nombre" class="block text-gray-700 text-sm font-bold mb-2">Nombre</label>
        <input type="text" name="nombre" id="nombre"
         value="{{$alumno->nombre}}"
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>
    <div class="mb-4">
        <label for="direccion" class="block text-gray-700 text-sm font-bold mb-2">Dirección</label>
        <input type="text" name="direccion" id="direccion"
          value="{{$alumno->direccion}}"
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>
    <div class="mb-4">
        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
        <input type="text" name="email" id="email"
          value="{{$alumno->email}}"
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>
    <div class="mb-4">
        <label for="dni" class="block text-gray-700 text-sm font-bold mb-2">DNI</label>
        <input type="text" name="dni" id="dni"
          value="{{$alumno->dni}}"
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>
    <div class="mb-4">
        <label for="edad" class="block text-gray-700 text-sm font-bold mb-2">Edad </label>
        <input type="text" name="edad" id="edad"
         value="{{$alumno->edad}}"
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
Hemos añadido  de forma explícita {{<color_green>}}el método PATCH{{</color_green>}}     
HTML solo admite en la etiqueta action {{<color_green>}}el método POST y GET{{</color_green>}}    
debemos añadir explícitametne con la directiva {{<color_green>}}@method{{</color_green>}}
{{< /alert >}}

### Método update
*Ahora debemos de implementar el método {{<color_blue>}}update{{</color_blue>}} del controlador.

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
* Al igual que en el caso del store, si actualizamos campos  y {{<color_green>}}damos a guardar{{</color_green>}} obtenemos {{<color_green>}}un forbbiden{{</color_green>}} por parte del servidor:
{{< imgproc forbbiden Fill "700x250" >}}

{{< /imgproc >}}

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

*En nuestro clasoo tendremos que especificar en {{<color_green>}}UpdateAlumnoRequest{{</color_green>}} en el método {{<color_green>}}autorize{{</color_green>}} que retorne un {{<color_green>}}true{{</color_green>}} para dar permisos a todos los usuarios para almacenar Alumnos
{{< highlight php "linenos=table, hl_lines=1" >}}
public function authorize(): bool
   {
      return true;
   }
{{< / highlight >}}
{{% /pageinfo%}}








