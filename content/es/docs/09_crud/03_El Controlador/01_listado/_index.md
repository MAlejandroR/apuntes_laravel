---
title: "Obtener el listado"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 10
icon: fa-solid fa-database
---

## Obtener listado de alumnos
**Obtener el listado de alumnos conrresponde a la siguinte diagrama
{{< imgproc listado Fill "682x317" >}}

{{< /imgproc >}}
{{% pageinfo%}}

### Primero implementamos el controlador

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

> {{< alert title="Directivas blade" color="warning" >}}

Observa cómo recorremos el array

Recibimos del controlador un {{<color_green>}}array $alumnos{{</color_green>}}
Es un array {{<color_green>}}de objetos de alumnos{{</color_green>}}
Visualizo {{<color_green>}}cada campo del alumno{{</color_green>}}

{{< /alert >}}
****
{{% /pageinfo%}}
**El resultado**
{{< imgproc vistaAlumnos Fill "2000x500" >}}

{{< /imgproc >}}