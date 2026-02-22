---
title: "Borrando"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 40
icon: fa-solid fa-database
---
## Borrar un alumno

### Actualizando el formulario para borrar


* Lo primero debemos de generar un botón en la vista para cada alumno, y que el usuario pueda seleccionar la opción de {{<color_green>}}borrar alumno{{</color_green>}}
* Modificamos cada línea del listado añadiendo un botón de editar
* Accedemos a https://heroicons.com/ para poder captar un svg de botón de editar concretamente seleccionamos este:
  <svg  width="25px" height="25px" style="color:red" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6">
     <path strokeLinecap="round" strokeLinejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
  </svg>

* Para ello modificamos el fichero {{<color_blue>}}resources/view/alumnos/listado.blade.php{{</color_blue>}}

{{< imgproc FicheroDiaDeleteAlumno  Fill "1005x398" >}}

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

* Esta acción, {{<color_green>}}presionar el botón del formulario {{</color_green>}}, hará que se invoque el método       {{<color_blue>}}destroy{{</color_blue>}} del controlador.

*  Necesitamos que nos retorne una vista con un formulario y los datos del alumno 
   {{< highlight php "linenos=table, hl_lines=1" >}}
   public function destroy(Alumno $alumno)
   {
   $alumno->delete();
   return redirect()->route("alumnos.index");
   //
   }
   {{< / highlight >}}
*
{{< alert title="El código" color="warning" >}}
* {{<color_green>}}Borramos el registro{{</color_green>}}          
* {{<color_green>}}Retornamos la vista con todos los alumnos{{</color_green>}}   
* {{<color_green>}}Observamos que ese registro ha sido eliminado{{</color_green>}}           
{{< /alert >}}