---
title: "El controlador y las vistas"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 80
icon: fa-solid fa-database
---
{{% pageinfo%}}
#### Acciones a realizar 
****
Esta es la parte qué logicamente  {{<color_green>}}mas implicación tiene a nivel de back{{</color_green>}}

Tendremos que seguir el MVC es decir como podemos ver en este diagrama: 


````mermaid
graph LR
  subgraph "Usuario Inicial"
    UI[Usuario Inicial]
  end
  subgraph "Solicitudes"
    UI -->|Petición| B[Controladores]
  end
  subgraph "Controladores"
    B -->|Manejo de solicitudes| C[Base de Datos]
    B -->|Retornar Vistas directamente| E[Retornar Vistas]
  end
  subgraph "Base de Datos"
    C -->|Operaciones CRUD| D[Base de Datos]
    D -->|Respueta BD| C
  end
  E -->|Vistas sin Datos| UF[Usuario Final]
  C -->|Datos para vista | UF
````
**En el diagrama se representan dos situaciones generales a partir de una solicitud de usuario:**    
1. El controlador directamente {{<color_green>}}retorna una vista{{</color_green>}}.     
2. El controlador ha de {{<color_green>}}realizar una consulta en la base de datos, obtener  valores y retornarlos a la vista{{</color_green>}}, donde se renderizan para entregar al usuario final
{{% /pageinfo%}}

## Creamos las rutas

{{% pageinfo%}}

### Lo primero crearemos las rutas para atender a las solicitudes

****

Para ello  agregamos la ruta {{<color_blue>}}resources{{</color_blue>}} en fichero de rutas {{<color_blue>}}web.php{{</color_blue>}}

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

