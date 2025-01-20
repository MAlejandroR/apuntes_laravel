---
title: "Introducción"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 10
icon: fa-solid fa-info
---
{{< objetivos  title="Objetivos de este curso">}}
Idea de lo que es un framework.
Trabajar con una herramienta profesional. 
Entender el entorno (Instalación y configuración de Laravel).
El patrón MVC y cómo Laravel lo implementa.
El sistema de enrutamiento, middleware, y controladores.
El ORM Eloquent para operaciones de base de datos.
Autenticación, autorización y seguridad.
Pruebas unitarias y de integración.
Hacer un proyecto con Laravel y deplegarlo en un hosting o amazon
{{< /objetivos >}}
> 
> 
{{<finalidad title="Al terminar este módulo">}}
Saber trabajar con laravel
Desarrollar un full stack (diseño, front, back, API's)
A través de este viaje, no solo aprenderás a usar un framework, sino a adoptar una forma de trabajar que te hará una mejor desarrolladora.
{{</finalidad>}}





## Laravel: un framework de php

**![img.png](img.png)**
*********
En este módulo, vamos a sumergirnos en el mundo de {{<color_green>}}Laravel{{</color_green>}}, **un framework de PHP**, del que podríamos afirmar  *que ha revolucionado la forma en que desarrollamos aplicaciones web*.

{{<color_green>}}Laravel{{</color_green>}} no es solo un conjunto de herramientas, que también las aporta;

Lo podemos ver como una  **una metodología**,  ****una forma de pensar en el desarrollo web**** que nos permite crear aplicaciones robustas, escalables y mantenibles con eficiencia y elegancia.   

  {{<color>}}Laravel constituye un fullstack a la hora de desarrollar una aplicación web{{</color>}}

****
## ¿Por qué Laravel?

Laravel se ha ganado un lugar destacado en el desarrollo web por varias razones:   


* {{<color_blue>}}Estructura de Carpetas Organizada:{{</color_blue>}}   
  
 >Laravel ofrece una **estructura de carpetas y ficheros del proyecto**  bien definida.    
 > Esto  **facilita el mantenimiento** del código y la colaboración entre desarrolladores.    
 > Es una organización intuitiva, pero puede ser uno de los puntos flojos, ya que nos tenemos que mover entre diferentes carpetas para localizar nuestros ficheros, y eso, sobre todo al principio, cuesta acostumbrarse.  
 > En la versión actual, **versión 11**, se ha reducido bastante respecto a versiones anteriores.  
  {{< imgproc estructura_carpetas Fill "300x250" >}}
 Proyecto de laravel creado con phpstorm 
 {{< /imgproc >}}
 
* {{<color_blue>}}Conjunto de Librerías y Herramientas:{{</color_blue>}} >
 
> Viene cargado con {{< color >}} bibliotecas y herramientas {{< /color >}} que resuelven muchos problemas comunes en el desarrollo web, como _autenticación, enrutamiento, manejo de sesiones y protección contra vulnerabilidades_. 
> Esto nos permite centrarnos en las características únicas de nuestra aplicación (programa tus aplicaciones, no tus herramientas).
 
{{<color_blue>}}Ecosistema y Comunidad:{{</color_blue>}} 
> Laravel tiene un ecosistema rico, con herramientas como Laravel Forge, Laravel Vapor, y Nova, así como un sistema robusto de paquetes a través de Composer. Además, la vibrante comunidad en torno a Laravel ofrece un vasto recurso de conocimiento, tutoriales y soporte.
> {{< imgproc img_2 Fill "900x1000" >}}
  https://laravel.com/ (Ecosystem)
{{< /imgproc >}}
****

* {{<color_blue>}}MVC y Patrones de Diseño:{{</color_blue>}}
> Laravel se adhiere al patrón Modelo-Vista-Controlador (MVC), promoviendo un desarrollo limpio y **separando la lógica de negocio de la presentación**.
> Además, el uso de otros patrones de diseño y prácticas recomendadas está profundamente integrado en su arquitectura.
![img_3.png](img_3.png)
***




## Qué es un framework Vs Librería
Un framework es una forma de trabajar con una determinada tecnología , donde nos van a marcar diferentes aspectos como la ubicación de ficheros, la forma de nombrar los componentes (clases), nos van a ofrecer herramientas y utilidades para hacer más sencillo nuestra forma de desarrollar la aplicación

{{< alert title="Anotaciones" color="warning" >}}
* Nos va a marcar una organización de la estructura completa de nuestro proyecto
* Nos ofrece librerías y métodos para realizar gran cantidad de trabajo típico de desarrollos (acceso a base de datos, gestión de cookies, autenticación, …)
* Estos conceptos tienen un tiempo de aprendizaje que hay que dedicar con un poco de paciencia las ventajas son muy significativas

{{< /alert >}}

{{< imgproc listado_frameworks Fill "600x400" >}}

{{< /imgproc >}}
![img_5.png](img_5.png)

### Laravel
{{< alert title="Especificación actual" color="warning" >}}
* Lenguaje de programación: PHP
* Fecha del lanzamiento inicial: junio de 2011
* Desarrollador: Taylor Otwell
* Licencia: Licencia MIT
* Tipo de programa: Framework
* Versión actual  11 (enero 2025)
* Lanzamiento de próxima versión  Primer trimestre 2025 (esperándolo)
* Versión de php 8.2
{{< /alert >}}

{{% pageinfo%}}
Laravel es un framework de código abierto.     
Usa tecnología php para desarrollar aplicaciones de forma elegante y simple.     
Tiene una curva de aprendizaje muy suave, lo que permite no necesitar demasiado tiempo para desarrollar aplicaciones.

{{% /pageinfo%}}


