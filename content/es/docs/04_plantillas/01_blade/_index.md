---
title: "Plantillas en laravel"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 10
icon: fa-brands fa-html5
---
## Plantillas con Blade
{{% pageinfo%}}
 ****
## Blade
****
Una herramienta poderosa y flexible incluida en Laravel, que nos va a permitir {{<color_blue>}}escribir html e incluir php y visualizar datos del servidor{{</color_blue>}}
{{<color_green>}}balde.php{{</color_green>}} de una forma elegante y descriptiva. (Esto facilita visualizar datos  

Los ficheros blade, tienen extensión  {{<color_green>}}blade.php{{</color_green>}} y estarán ubicados en la carpeta {{<color_green>}}./resources/view{{</color_green>}}.  
Cuando hagamos referencia a los ficheros blade, esta información __no hay que especificar__, ni su __ubicación__, ni su __extensión__, como podemos ver en el siguiente ejemplo
 ***
{{< highlight php "linenos=table, hl_lines=1" >}}
return view('welcome');
//Va a retornar el fichero ./resources/view/welcome.blade.php
{{< / highlight >}}
{{% /pageinfo%}}
### Contenido de un fichero blade
{{% pageinfo%}}
  __Dentro de un fichero blade__ {{<color_green>}}(.blade.php){{</color_green>}}

En él podemos  encontrar el siguiente tipo de __código o instrucciones__:
* {{<color_blue>}}Código html y js{{</color_blue>}}  
>>(como cualquier página html)    
* {{<color_blue>}}\{{}} Doble braquets{{</color_blue>}}
>> Para mostrar el contenido de variables PHP.      
>> Blade automáticamente escapa el HTML en las variables para evitar ataques XSS.        
>> También para comentar, en lugar de __\<!- - Comentario html - ->__, podemos usar  __{{- - Comentario html - -}}__

* {{<color_blue>}}@{{</color_blue>}}   
>> para utilizar directivas/estructuras de control propias de laravel, como como condicionales y bucles. Por ejemplo, @if, @foreach, @switch, entre otras.
>> También acciones propias de laravel con sus directivas, como heredar de una plantilla o incluir en una determinada sección un código html como veremos a continuación en las herecias    
 

{{< highlight javascript "linenos=table,anclorlinenos=true, hl_lines=2 5 6 7" >}}
{{--Especificamos que heredamos la estructura de esta página--}}
@extends("layouts.layout")

{{--    Especificamos que aportamos contenido específico para una sección--}}
@section ("contenido")
  <h1>About us</h1> {{--Código html normal--}}
  @if($user) {{--Directiva de tipo if (se sustituirá por código php)--}}
    <h1>Estás autenticado</h1>
  @endif    
@endsection
{{< / highlight >}}
{{% /pageinfo%}}

### Herencia: Creando un layout
{{% pageinfo%}}

#### Concepto
En el desarrollo web con Laravel, {{<color_blue>}}la herencia en las plantillas Blade {{</color_blue>}} proporciona una forma eficiente de garantizar {{<color_blue>}}una estructura consistente en todas las páginas{{</color_blue>}}, fomentando un diseño corporativo uniforme.
{{% /pageinfo%}}
{{% pageinfo%}}
#### Idea de su uso/funcionamiento
Con este concepto {{<color_blue>}}se establece una página inicial o 'layout' que define los aspectos generales de la interfaz, dejando espacios designados para personalizaciones específicas{{</color_blue>}}
Con ello, cada página individual {{<color_green>}}hereda de esta plantilla principal {{</color_green>}}, permitiendo inlcuir su propio contenido __(el de la página)__  sin perder la coherencia visual __(el de la plantilla)__.

Este método facilita la gestión y mantenimiento del diseño, ya que cualquier cambio realizado en la plantilla principal se reflejará automáticamente en todas las páginas que heredan de ella. De este modo, la herencia en las plantillas Blade contribuye a una experiencia de desarrollo eficiente y a la creación de interfaces consistentes y atractivas.
{{% /pageinfo%}}


### Comentarios blade

{{% pageinfo%}}
****
#### Insertando comentarios en fichero .blade.php
****
Dentro de un fichero {{<color_blue>}}Blade{{</color_blue>}}, podemos comentar de dos maneras
1. Comentarios HTML (`<!-- Comentarios -->`)
2. Comentarios Blade (`{{-- Comentarios --}}`)   
> Hay diferencias significativas entre comentar con `<!-- Comentarios -->` y `{{-- Comentarios --}}` en un fichero Blade de Laravel.        
> Estas diferencias se relacionan principalmente con cómo se manejan y se muestran estos comentarios en el HTML generado y enviado al navegador.

**Comentarios HTML (`<!-- Comentarios -->`):**
- Son comentarios estándar de HTML.
- Serán visibles en el código fuente del HTML generado y enviado al navegador.
- Cualquiera que inspeccione el código fuente de la página en el navegador podrá ver estos comentarios.
- Son útiles para anotaciones que no afectan la presentación de la página pero podrían ser de ayuda durante el desarrollo o para otros desarrolladores.

**Comentarios Blade (`{{-- Comentarios --}}`):**
- Son específicos del motor de plantillas Blade de Laravel.
- No serán incluidos en el HTML final generado. Esto significa que no aparecerán en el código fuente de la página cuando se vea en un navegador.
- Son útiles para dejar notas o comentarios en el código que solo deben ser visibles durante el desarrollo y no deben ser expuestos a los usuarios finales o en el ambiente de producción.
- Proporcionan una manera de hacer anotaciones en las plantillas Blade sin afectar lo que ve el usuario.

 ***
 ![]()
{{% /pageinfo%}}
