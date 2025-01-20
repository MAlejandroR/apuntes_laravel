---
title: "Diseñando el layout"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 20
icon: fa-solid fa-layer-group
---

## Creando un diseño
{{% pageinfo %}}
 ****
#### Proceso de diseño
****
Diseñar es un aspecto fundamentan antes de crear las páginas     
Para crear un proyecto debemos crear previaemnte **los mockups** o **Prototipados de pantallas**    
Posteriormente hemos de crear las páginas usando los estilos adecuados para conseguir los diseños previamente prototipados, esto implicará usar **html y css**
Para crear los diseños se usan herramientas gráficas de prototipado, y para el css normalmente usaremos algún fremework tipo **Bootstrap** o **tailwindcss**
{{% /pageinfo%}}

### Herramientas para el diseño
{{% pageinfo%}}
#### 
Vamos a usar **Balsamiq** porque disponemos de licencia estudiante en el centro    
Existen varias herramientas alternativas:    
****

1. **[Pencil Project](https://pencil.evolus.vn/):**
    - Pencil Project es una herramienta de prototipado de código abierto que te permite crear mockups de manera sencilla. Es fácil de usar y ofrece una variedad de elementos predefinidos.     
2. **[MockFlow](https://www.mockflow.com/):**
    - MockFlow es una plataforma en línea que ofrece una herramienta de diseño de wireframes y mockups. La versión gratuita tiene algunas limitaciones, pero aún así proporciona funcionalidades útiles.    
3. **[Balsamiq Cloud (versión gratuita)](https://balsamiq.cloud/) ):**
   - Balsamiq, conocido por su aplicación de escritorio, también ofrece una versión en línea gratuita llamada Balsamiq Cloud que permite crear mockups y wireframes.       
4. **[Figma](https://www.figma.com/):**
   - Figma es una herramienta de diseño colaborativo en línea que permite crear mockups, wireframes y prototipos. Tiene una versión gratuita con muchas funcionalidades.  
5. **[Wireframe.cc](https://wireframe.cc/):**
   - Wireframe.cc es una herramienta simple y fácil de usar para crear wireframes rápidos y sencillos. Puedes comenzar a usarla directamente en el navegador.     
{{% /pageinfo%}}

### Laravel como fullstack
**Laravel es un poderoso framework de backend.**    

Con Laravel, es posible realizar {{<color_blue>}}desarrollos web full-stack{{</color_blue>}}. Esto  significa que este framework nos habilita para gestionar tanto **el backend como el frontend** de una aplicación web.   
Así, Laravel se convierte en **una solución integral** que permite implementar todas las facetas del desarrollo web, desde la lógica del servidor hasta la interfaz de usuario.


{{< alert title="Recuerda" color="warning" >}}
{{<color_green>}}Laravel {{</color_green>}}Permite integrar de {{<color_blue>}}forma agnóstica{{</color_blue>}} cualquier herramienta para el front.     

Muchos paquetes traen integrado los framework {{<color_green>}}tailwind{{</color_green>}} y   {{<color_green>}}vue{{</color_green>}}
{{< /alert >}}


### Instalación de [Tailwind](https://tailwindcss.com/): framework de css
{{% pageinfo%}}
#### **Introducción**
{{<color_green>}}Tailwind CSS{{</color_green>}}  es un poderoso framework de estilos de CSS que se puede utilizar de manera efectiva con Laravel.    

La  simplicidad y flexibilidad de {{<color_green>}}Tailwind{{</color_green>}} permiten una integración fluida con proyectos Laravel, y es común ver su uso en conjunción con este framework de PHP.

Muchos paquetes y recursos integrados en el ecosistema de Laravel incorporan Tailwind CSS como herramienta preferida para la estilización de componentes y diseños, por ese motivo lo vamos a utilizar en este curso.      
****
#### **Instalación**
{{% pageinfo color="info" %}}
Para la instalación necesitamos herramientas para gestionar paquetes del cliente **node y npm**, y vamos a usar **vite** como herramienta de compilación (traspilación) de ficheros en el frontend
*****
##### **Node y npm**
**[Node](https://nodejs.org/)**
{{% imgproc node Fill "400x100" %}}
{{% /imgproc %}}
1. Descarga e instala Node.js desde el [sitio web oficial](https://nodejs.org/).


Antes de integrar Tailwind CSS en tu proyecto Laravel, necesitarás tener Node.js instalado.
{{<color_green>}}node{{</color_green>}} y{{<color_green>}} npm{{</color_green>}} son Gestores de paquetes para el front
Van a crear un fichero llamado {{<color_green>}}pakage.json (vs composer.json){{</color_green>}}     


````bash
npm install
````
Al ejecutar {{<color_green>}}npm install{{</color_green>}},  se creará en el proyecto una carpeta llamada {{<color_green>}}node_modules{{</color_green>}}, donde se instalarán los paquetes especificados en el fichero json.   
 Este directorio {{<color_blue>}}node_modules{{</color_blue>}} tampoco hay que subir a git, ya que lo podremos generar a partir del fichero {{<color_blue>}}pakage.json{{</color_blue>}} .     
Su instalación es sencilla. Una vez instalado cerramos el terminal y al volverlo a abrir, ya lo podemos utilizar.

{{% imgproc node_install Fill "2000x900" %}}

{{% /imgproc %}}

*****
##### **Tailwindcss**
**[Tailwindcss](https://tailwindcss.com/docs/installation/framework-guides)**
{{% imgproc tailwindcss Fill "400x100" %}}
{{% /imgproc %}}
{{% imgproc instalar_tailwind1 Fill "2000x1000" %}}

{{% /imgproc %}}

{{% imgproc instalar_tailwind2 Fill "2000x1000" %}}

{{% /imgproc %}}
*****
##### **Vite**
**[Vite](https://vitejs.dev/)**
{{% imgproc vite Fill "300x100" %}}

{{% /imgproc %}}
{{<color_blue>}}Vite{{</color_blue>}} en un proyecto Laravel es un moderno entorno de {{<color_green>}}construcción frontend{{</color_green>}} que proporciona una compilación (transpilación)rápida y eficiente de los recursos del front para ponerlos disponibles en ejecución.

******
{{<color_blue>}}Vite{{</color_blue>}}, por ejemplo, {{<color_green>}}transpila archivos SCSS o LESS a CSS{{</color_green>}}, {{<color_green>}}procesa las directivas de Tailwind CSS para generar clases CSS utilizables{{</color_green>}}.                       

*******
Además, {{<color_green>}}compila componentes de Vue o React a JavaScript{{</color_green>}}, facilitando su ejecución en el navegador.
{{% /pageinfo%}}
{{% /pageinfo%}}
### Diseño del layout
{{% pageinfo%}}
#### Planteamos el siguiente layout general
{{% imgproc Plantilla_detalle Fit "1900x1000" %}}

{{% /imgproc %}}
**Para conseguirlo escribimos el siguiente código**
{{< highlight php "linenos=table, hl_lines=4 8 11 15 18 22 23 25" >}}
<!doctype html>
<html lang="en">
   <head>
       @vite(['resources/css/app.css', 'resources/js/app.js'])
       <title>Document</title>
   </head>
   <body>
      <header class="lg:hidden bg-header flex flex-col justify-center items-center  py-2 space-y-1">
         HEADER MÓVIL
      </header>
      <header class="hidden lg:flex h-15v bg-header flex flex-row justify-center items-center">
         HEADER DESKTOP
      </header>
      <nav>
          <nav class="hidden lg:flex h-10v bg-nav flex flex-row justify-start items-center space-x-2">
            NAV MÓVIL
          </nav>
          <nav class="lg:hidden bg-nav flex flex-col justify-start space-y-1 px-2">
            NAV DESKTOP
          </nav>
      </nav>
      <main class="h-65v bg-main">
          @yield("contenido")
      </main>
      <footer  class="h-10v bg-footer footer items-center p-4 bg-neutral text-neutral-content">
         FOOTER          
      </footer>
   </body>
</html>
{{< / highlight >}}

{{% /pageinfo%}}
#### Diseño de la cabecera {{<color_blue>}}header{{</color_blue>}} 
{{% pageinfo%}}
{{% imgproc header Fit "4000x900" %}}

{{% /imgproc %}}
**Escribimos el siguiente código**
{{< highlight php "linenos=table, hl_lines=2 3 4  7 8 9 10 11 12 13 14" >}}
 <header class="lg:hidden bg-header flex flex-col justify-center items-center  py-2 space-y-1">
        <img class="h-3/5" src="{{asset("images/logos/nett_logo.png")}}" alt="logo nett">
        <button class="h-1/5 w-full btn bg-main "> Acceder</button>
        <button class="h-1/5 w-full btn  bg-main">Registrar</button>
    </header>
    <header class="hidden lg:flex h-15v bg-header flex flex-row justify-center items-center">
        <img class="w-1/5 max-h-full w-auto  p-5 " src="{{asset("images/logos/nett_logo.png")}}" alt="logo nett">
        <div class="w-3/5 flex justify-center items-center">
            <h1 class="text-3xl text-white h-auto max-w-full truncate ">APLICACIÓN EJEMPLO LARAVEL</h1>
        </div>
        <div class=" w-1/5 h-auto max-w-full flex items-center space-x-4 ">
            <button class="btn glass  text-white"> Acceder</button>
            <button class="btn  glass text-white">Registrar</button>
        </div>
    </header>
{{< / highlight >}}
{{% /pageinfo%}}

#### Diseño de la sección de menú:  {{<color_blue>}}nav{{</color_blue>}}

{{% pageinfo%}}
{{% imgproc nav Fit "2000x1000" %}}

{{% /imgproc %}}
****
**Escribimos el siguiente código**
{{< highlight php "linenos=table, hl_lines= 2 3 4 5 6 7 8 11 12 13 14 15 16" >}}
   <nav class="hidden lg:flex h-10v bg-nav flex flex-row justify-start items-center space-x-2">
        <a href="{{ route('home') }}" class="btn ">Inicio</a>
        <a href="{{ route('about') }}" class="btn ">Acerca de Nosotros</a>
        <a href="{{ route('projects') }}" class="btn">Proyectos</a>
        <a href="{{ route('contact') }}" class="btn">Contacto</a>
        <a href="{{ route('students') }}" class="btn">Alumnos</a>
        @yield("nav")
    </nav>
    <nav class="lg:hidden bg-nav flex flex-col justify-start space-y-1 px-2">
        <a href="{{ route('home') }}" class="btn btn-primary  ">Inicio</a>
        <a href="{{ route('about') }}" class="btn btn-primary">Acerca de Nosotros</a>
        <a href="{{ route('projects') }}" class="btn btn-primary">Proyectos</a>
        <a href="{{ route('contact') }}" class="btn btn-primary">Contacto</a>
        <a href="{{ route('students') }}" class="btn btn-primary">Alumnos</a>
        @yield("nav")
    </nav>
{{< / highlight >}}

{{% /pageinfo%}}
{{< alert title="helper route" color="warning" >}}
El helper {{<color_blue>}}route{{</color_blue>}} llama a una ruta creada con un nombre en el fichero {{<color_green>}}routes/web.php{{</color_green>}} 
{{< /alert >}}
**

#### Diseño de la sección de principal :  {{<color_blue>}}main{{</color_blue>}}
En este caso vamos a escribir el contenido de una página {{<color_blue>}}landing page{{</color_blue>}}    

Para ello usaremos de la librería {{<color_blue>}}[Daisy](https://daisyui.com){{</color_blue>}}, el componente {{<color_blue>}}[Hero](https://daisyui.com/components/hero/){{</color_blue>}}
{{% pageinfo%}}
{{% imgproc main Fit "2000x1000" %}}

{{% /imgproc %}}
**Escribimos el siguiente código**
{{< highlight php "linenos=table, hl_lines=1" >}}
<main class="h-65v bg-main">
   @yield("contenido")
</main>

{{< / highlight >}}
Y el contenido de la página {{<color_blue>}}home.blade.php{{</color_blue>}}
{{< highlight php "linenos=table, hl_lines=3-13" >}}
@extends("layouts.layout")
@section ("contenido")
   <div class="hero h-full"
   style="background-image: url(https://daisyui.com/images/stock/photo-1507358522600-9f71e620c44e.jpg);">
      <div class="hero-overlay bg-opacity-60">
      </div>
      <div class="hero-content text-center text-neutral-content">
        <div class="max-w-md">
          <h1 class="mb-5 text-5xl font-bold">Bienvenido a nuestro proyecto de apredizaje</h1>
          <p class="mb-5">Accederás a las diferentes prácticas realizadas en las tutorías</p>
          <button class="btn btn-primary">Empezar</button>
        </div>
      </div>
    </div>

@endsection
{{< / highlight >}}
{{< alert title="@extend" color="warning" >}}
Establece una página de hereda de otra (un layout)
{{< /alert >}}
{{< alert title="@yield" color="warning" >}}
Para establecer una sección dónde se aportará contenido en la página que herede de ella
{{< /alert >}}
{{% alert title="@section @endsection" color="warning" %}}
Para establecer contenido en una sección previamente establecida en el layout bajo la directiva **yield**
{{% /alert %}}
{{% /pageinfo%}}
****
#### Diseño footer
{{% pageinfo%}}
#### 
****

#### Diseño de la sección de pie de página :  {{<color_blue>}}footer{{</color_blue>}}
En este caso vamos a escribir el contenido de una página {{<color_blue>}}landing page{{</color_blue>}}

En este caso vamos a seleccionar un {{<color_blue>}}footer{{</color_blue>}} de la página de [Daisy](https://daisyui.com)  boscamos en los componenetes [footer](https://daisyui.com/components/footer/)

{{% imgproc footer Fit "2000x1000" %}}

{{% /imgproc %}}

{{< highlight php "linenos=table, hl_lines=1" >}}
<footer  class="h-10v bg-footer footer items-center p-4 bg-neutral text-neutral-content">
    <aside class="items-center grid-flow-col">
        <svg width="36" height="36" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd"
             clip-rule="evenodd" class="fill-current">
            <path
                d="M22.672 15.226l-2.432.811.841 2.515c.33 1.019-.209 2.127-1.23 2.456-1.15.325-2.148-.321-2.463-1.226l-.84-2.518-5.013 1.677.84 2.517c.391 1.203-.434 2.542-1.831 2.542-.88 0-1.601-.564-1.86-1.314l-.842-2.516-2.431.809c-1.135.328-2.145-.317-2.463-1.229-.329-1.018.211-2.127 1.231-2.456l2.432-.809-1.621-4.823-2.432.808c-1.355.384-2.558-.59-2.558-1.839 0-.817.509-1.582 1.327-1.846l2.433-.809-.842-2.515c-.33-1.02.211-2.129 1.232-2.458 1.02-.329 2.13.209 2.461 1.229l.842 2.515 5.011-1.677-.839-2.517c-.403-1.238.484-2.553 1.843-2.553.819 0 1.585.509 1.85 1.326l.841 2.517 2.431-.81c1.02-.33 2.131.211 2.461 1.229.332 1.018-.21 2.126-1.23 2.456l-2.433.809 1.622 4.823 2.433-.809c1.242-.401 2.557.484 2.557 1.838 0 .819-.51 1.583-1.328 1.847m-8.992-6.428l-5.01 1.675 1.619 4.828 5.011-1.674-1.62-4.829z"></path>
        </svg>
        <p>Copyright © 2024 - All right reserved</p>
    </aside>
    <nav class="grid-flow-col gap-4 md:place-self-center md:justify-self-end">
        <a>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current">
                <path
                    d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"></path>
            </svg>
        </a>
        <a>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current">
                <path
                    d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"></path>
            </svg>
        </a>
        <a>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current">
                <path
                    d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"></path>
            </svg>
        </a>
    </nav>
</footer>

{{< / highlight >}}


{{% /pageinfo%}}