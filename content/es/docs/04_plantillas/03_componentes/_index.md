---
title: "Componentes "
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 30
icon: fa-regular fa-window-restore

---

# Introducción a los Componentes de Blade en Laravel

## ¿Qué son los Componentes de Blade?

{{< color >}} Los componentes de Blade  {{< /color >}}en Laravel son una poderosa herramienta para reutilizar código HTML y PHP en tus vistas.

Estos componentes son archivos **.blade.php** que residen en la carpeta **resources/views/components**. Si la carpeta no existe, puedes crearla manualmente. El hecho de que cada componente sea un archivo .blade.php independiente, facilita su reutilización y mantenimiento.

{{< alert title="Idea de usar componentes" color="success" >}}
**Descomponer** un diseño complejo (layout) **en elementos más pequeños y manejables** conocidos como **componentes**.
{{< /alert >}}


Al crear un layout, este se convierte en una composición de estos ficheros individuales. Cada componente representa {{<color_green>}}una parte del layout{{</color_green>}}, como:  **una cabecera, pie de página, sección principal o barra de navegación** como podemos ver en la siguiente imagen:

{{< imgproc componentes_laravel_general Fit "2000x1000" >}}

{{< /imgproc >}}

## Creación y Uso de Componentes

Tenemos dos formas de crear un componente:
* {{< color >}} Componente anónimo {{< /color >}}. Crear el fichero directamente en la carpeta correspondiente
* {{< color >}} Componentes basados en clases {{< /color >}}. A través de {{<color_green>}}una clase usando Artisan****{{</color_green>}}
* 
#### Creando el componentes directamente
Simplemente creamos el fichero desde nuestro EDI.    
En nuestro caso creamos los ficheros {{<color_blue>}}header.blade,php, main.blade.php, nav.blade.php {{</color_blue>}} y {{<color_blue>}} footer.blade.php{{</color_blue>}}.     

Como son parte del layout, podríamos crearlo dentro de una carpeta llamada layout, por cuestiones organizativas:
{{< imgproc creacion_componentes_layout_1 Fit "700x700" >}}


{{< /imgproc >}}

#### Creando el componente con Artisan

Podemos crearlo a partir de una clase. El funcionamiento es igual. La forma de crearlo sería con artisan:
Vamos a hacerlo para nuestro ejemplo:
{{< highlight php "linenos=table, hl_lines=1" >}}
php artisan make:Component nombre_componente
{{< / highlight >}}
#### Crear componente directo Vs con Artisan
##### **Artisan**
Usar {{<color_green>}}Artisan para crear componentes{{</color_green>}} tiene ventajas:

- {{<color_blue>}}Estructura Consistente{{</color_blue>}}: Artisan genera automáticamente la estructura de archivos necesaria, asegurando consistencia en todo el proyecto.
- {{<color_blue>}}Rapidez {{</color_green>}} y {{<color_green>}} Conveniencia{{</color_blue>}}: Es rápido y evita la posibilidad de errores al crear los archivos manualmente.
  - {{<color_blue>}}Comandos Claros{{</color_blue>}}: Los comandos de Artisan son claros y documentados, lo que facilita su uso y aprendizaje.
  {{< highlight php "linenos=table, hl_lines=1" >}}
    php artisan make:component NombreDelComponente
  {{< / highlight >}}
Si queremos crear el componente en una carpeta concreta lo podemos hacer especificandolo
{{< highlight php "linenos=table, hl_lines=1" >}}
    php artisan make:component directorio/.../NombreDelComponente
{{< / highlight >}}
  - Esto crea un nuevo componente en {{<color_blue>}}resources/views/components{{</color_blue>}} y un archivo de clase correspondiente en {{<color_blue>}}app/View/Components{{</color_blue>}}.
##### **Crear Componentes Manualmente**
{{<color_green>}}Crear componentes manualmente{{</color_green>}} también buena que te da más control en la estructura y organización de carpetas:

- {{<color_blue>}}Flexibilidad{{</color_blue>}}: Tienes control total sobre la estructura y organización de tus archivos.
- {{<color_blue>}}Simplicidad{{</color_blue>}}: Para proyectos más pequeños o si prefieres un enfoque más "manual", este método puede ser más directo.
{{% pageinfo%}}
#### 
- Para crear un componente manualmente:

1. Crea un archivo Blade en {{<color_blue>}}resources/views/components{{</color_blue>}}.
1. Opcionalmente, crea una clase de componente en {{<color_blue>}}app/View/Components{{</color_blue>}}.

{{% /pageinfo%}}
{{< alert title="Conclusión personal" color="warning" >}}
- Proyectos Grandes o en Equipos:
> Usar Artisan es generalmente más recomendado, ya que asegura una estructura coherente y reduce el riesgo de errores.
- Para Proyectos Pequeños o Preferencias Personales:
> Si prefieres un control más directo o trabajas en un proyecto más pequeño, crear los archivos manualmente puede ser igualmente efectivo.
{{< /alert >}}

### Referenciar un Componente

Para usar un componente en tus vistas Blade, lo referencias como un elemento HTML, pero con una sintaxis especial que incluye un prefijo `x-`::
```html
<x-miComponente />
```
{{< alert title="x-nombre" color="warning" >}}
Cuando referenciamos un elemento con {{<color_blue>}}<x-...>{{</color_blue>}} laravel buscará el fichero en la carpeta {{<color_blue>}}resources/views/components{{</color_blue>}}
{{< /alert >}}
{{< alert title="x-capeta.sub.nombre" color="warning" >}}
Si el componentes estuvier en subcarpetas, lo podemos especicar con puntos.

De esta forma {{<color_blue>}}x-capeta.sub.componentes{{</color_blue>}} implicará la ubicaicón en {{<color_blue>}}resources/views/components/carpeta/sub/nombre.blade.php{{</color_blue>}} 
{{< /alert >}}

## Nuestro ejemplo
Creamos los componentes usando artisan.
{{< alert title="Ubicación" color="warning" >}}
Como todos son para el layout, los creamos en la carpeta layout
{{< /alert >}}

{{< highlight php "hl_lines=1-4" >}}
php artisan make:component layout/Header
php artisan make:component layout/Nav
php artisan make:component layout/Main
php artisan make:component layout/Footer
{{< / highlight >}}
La imagen muestra el resultado generado
{{< imgproc img Fill "600x700" >}}
{{<color_green>}}Creción de componentes con artisan{{</color_green>}}
{{< /imgproc >}}

## Variables en Componentes 

Los componentes de Blade  {{<color_green>}} ofrecen acceso a varias variables y objetos especiales{{</color_green>}} que facilitan la construcción de interfaces dinámicas y reutilizables. Los más usados
- $slot
- $attributes
- $errors

{{% pageinfo%}}
### $slot
{{<color_green>}} Contiene el contenido que se pasa al componente desde donde se llama.{{</color_green>}}
****
>Fichero layout

{{< highlight html "hl_lines=2" >}}
<x-layout.main>
<h1> Este es un contendio para el componente, lo recibirá como $slot</h1>
</x-layout.main>
{{< / highlight >}}

> Fichero del componente {{<color_blue>}}main.blade.php{{</color_blue>}}
{{< highlight php "hl_lines=5" >}}
 <header class="hidden lg:flex h-15v bg-header flex flex-row justify-center items-center">
    <img class="w-1/5 max-h-full w-auto  p-5 " src="{{asset("images/logos/logo.png")}}" alt="logo nett">
    <div class="w-3/5 flex justify-center items-center">
        <h1 class="text-3xl text-white h-auto max-w-full truncate ">
          {{$slot}}
        </h1>
    </div>
<!-- ...  -->
</header>
{{< / highlight >}}

{{% /pageinfo%}}

{{% pageinfo%}}
### $atributes

{{<color_green>}} Permite acceder a atributos adicionales pasados al componente.{{</color_green>}}
La variable {{<color_blue>}}$attributes{{</color_blue>}} en los componentes de Blade de Laravel {{<color_green>}}es una instancia de Illuminate\View\ComponentAttributeBag{{</color_green>}}

Proporciona varios métodos útiles para manipular los atributos que se pasan a un componente  
{{<color_green>}}Uno de los métodos más útiles es merge(){{</color_green>}}:
{{< alert title="merge()" color="warning" >}}
Fusiona los atributos predeterminados del componente con los atributos adicionales proporcionados en la vista.
{{< /alert >}}

{{<color_green>}}El método merge(){{</color_green>}} se usa comúnmente para combinar clases CSS y otros atributos. Esto es especialmente útil cuando deseas que tu componente tenga algunas clases CSS por defecto, pero también quieres permitir que se añadan clases adicionales desde fuera del componente.

Supongamos el siguiente ejemplo donde tenemos un  componente boton.blade.php:    
Aquí, btn btn-default son las clases predeterminadas para todos los botones.
{{< highlight php "linenos=table, hl_lines=1" >}}
<button {{ $attributes->merge(['class' => 'btn btn-default']) }}>
{{ $slot }}
</button>
{{< / highlight >}}
Cuando usas el componente y pasas clases adicionales:

Laravel fusionará las clases, resultando en un botón que tiene class="btn btn-default btn-large".

{{< highlight php "linenos=table, hl_lines=1" >}}

<x-boton class="btn-large">Click Aquí</x-boton>

{{< / highlight >}}
Laravel fusionará las clases, resultando en un botón que tiene class="btn btn-default btn-large".    

****

#### Otros Métodos de $attributes

* `only()`: Devuelve solo un subconjunto de los atributos.       
 
* `except()`: Devuelve todos los atributos excepto los especificados.      
 
* `class()`: Devuelve una instancia de Illuminate\View\ComponentAttributeBag solo con las clases.     
 
* `first()`: Devuelve el primer valor de los atributos especificados.    

{{% /pageinfo%}}


### Pasando atributos a un componentes 


Para pasar atributos a un componente, usamos una sintaxis similar a la de las etiquetas HTML:

```blade
<x-miComponente atributo="valor" />
```

Posteriormente en el componete podemos utilzar dicho valor. 

Si lo establecemos, Laravel proporciona una conversión automática entre la notación kebab-case en la invocación del componente y camelCase dentro del componente.

## Notación Kebab-Case y CamelCase

- **Kebab-Case**: Usada al pasar atributos al componente. Ejemplo: `mi-atributo`.
- **CamelCase**: Usada dentro del componente para referenciar estos atributos. Ejemplo: `miAtributo`.

{{<color_green>}}Cuando invocas un componente y pasas un atributo, usas kebab-case:{{</color_green>}}

```blade
<x-miComponente mi-atributo="valor" />
```

{{<color_green>}}Dentro del archivo del componente, Laravel convierte automáticamente mi-atributo a miAtributo:{{</color_green>}}

````blade
<!-- miComponente.blade.php -->
<div>
    {{ $miAtributo }} <!-- Accede al valor de 'mi-atributo' -->
</div>
```