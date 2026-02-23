---
title: "Plantillas en laravel"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 10
icon: fa-brands fa-html5
---

## Plantillas con Blade

Una herramienta poderosa y flexible incluida en Laravel, que nos va a permitir {{<color>}}escribir html e incluir php y visualizar datos del servidor{{</color>}}
{{<color>}}balde.php{{</color>}} de una forma elegante y descriptiva. (Esto facilita visualizar datos  

Los ficheros blade, tienen extensión  {{<color>}}blade.php{{</color>}} y estarán ubicados en la carpeta {{<color>}}./resources/view{{</color>}}.  
Cuando hagamos referencia a los ficheros blade, esta información __no hay que especificar__, ni su __ubicación__, ni su __extensión__, como podemos ver en el siguiente ejemplo
 ***
{{< highlight php "linenos=table, hl_lines=1" >}}
return view('welcome');
//Va a retornar el fichero ./resources/view/welcome.blade.php
{{< / highlight >}}
### Contenido de un fichero blade
  __Dentro de un fichero blade__ {{<color>}}(.blade.php){{</color>}}

En él podemos  encontrar el siguiente tipo de __código o instrucciones__:
* {{<color>}}Código html y js{{</color>}}  
>>(como cualquier página html)    
* {{<color>}}\{{}} Doble braquets{{</color>}}
* >> Para mostrar el contenido de variables PHP o lo que retornara una expresión o función
{{< highlight php tabla_alumnos "linenos=table, hl_lines=" >}}
  {{date(d-m-Y}} => Mostrará el resultado de la función 
  {{ $variable }}  => Se mostrará el valor de la varialbe
{{< /highlight>}}
* >> No se puede  incluir código php
{{< highlight php tabla_alumnos "linenos=table, hl_lines=" >}}
  {{$a = 5}} => Esto no se puede hacer
{{< /highlight>}}
* >> Blade automáticamente escapa el HTML en las variables para evitar ataques XSS.        
* >> También para comentar, en lugar de __\<!- - Comentario html - ->__, podemos usar  __{{- - Comentario html - -}}__

* {{<color>}}@{{</color>}}   
* >> para utilizar directivas/estructuras de control propias de laravel, como como condicionales y bucles. 
* >> Por ejemplo, {{<color>}}@if, @foreach, @switch{{</color>}}, @auth -- @endauth, @guest - @endguest entre otras.
* >> Otro ejemplo es incluir código php con la diretiva @php 
{{< highlight php tabla_alumnos "linenos=table, hl_lines=" >}}
  @php
    $a = 5 //Aquí creamos la variable $a y la podremos usar  
  @endphp 
{{< /highlight>}}


### Herencia: Creando un layout

#### Concepto
En el desarrollo web con Laravel, {{<color>}}la herencia en las plantillas Blade {{</color>}} proporciona una forma eficiente de garantizar {{<color>}}una estructura consistente en todas las páginas{{</color>}}, fomentando un diseño corporativo uniforme.
#### Idea de su uso/funcionamiento
# Herencia mediante Componentes Blade

## Concepto

En el desarrollo web con Laravel, la reutilización de estructuras comunes se realiza actualmente mediante **componentes Blade**, que permiten definir una estructura base reutilizable para todas las páginas.

En lugar de utilizar las directivas `@extends` y `@yield`, se crea un componente de layout (por ejemplo `<x-layout>`) que encapsula la estructura general de la interfaz: cabecera, navegación, pie de página, estilos y scripts.

Este componente actúa como contenedor común sobre el que se insertan los contenidos específicos de cada vista.

---

## Idea de uso y funcionamiento

Con este enfoque se define un **componente principal** que representa el diseño corporativo general de la aplicación.

Cada página no hereda formalmente mediante directivas, sino que **compone su contenido dentro del componente**.

El funcionamiento es el siguiente:

- El layout define la estructura global.
- Las páginas insertan su contenido en el `{{ $slot }}`.
- Opcionalmente pueden definirse *slots nombrados* como `title`, `header`, `description`, etc.

De este modo:

- Se mantiene coherencia visual en toda la aplicación.
- Se separa claramente la estructura global del contenido específico.
- Se adopta un enfoque basado en composición, más cercano al modelo de trabajo de frameworks como React o Vue.

---

## Ventajas frente al enfoque clásico con `@extends`

- Arquitectura más moderna y alineada con componentes.
- Mejor encapsulación del diseño.
- Mayor reutilización.
- Modelo mental más coherente para estudiantes que trabajan también con frontend basado en componentes.

---

## Conclusión

El uso de componentes Blade para estructurar layouts permite mantener la coherencia visual de la aplicación y facilita el mantenimiento.

Cualquier modificación en el componente principal se reflejará automáticamente en todas las vistas que lo utilicen, garantizando consistencia, modularidad y escalabilidad en el diseño.


### Comentarios blade

****
#### Insertando comentarios en fichero .blade.php
****
Dentro de un fichero {{<color>}}Blade{{</color>}}, podemos comentar de dos maneras
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
