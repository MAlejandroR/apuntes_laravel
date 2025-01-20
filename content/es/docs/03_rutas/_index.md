---
title: "Rutas en laravel"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 30
icon: fa-solid fa-road
---
# Concetpo de rutas
####
![img_1.png](img_1.png)
****
Las rutas son {{<color_green>}}la forma de definir cómo se deben manejar las solicitudes HTTP a tu aplicación{{</color_green>}}.

Especifican qué acción se debe tomar cuando se accede a una URI específica, conectando URLs con el código que genera las respuestas a esas URLs.

Las podemos ver como {{<color_green>}}las reglas que determinan cómo se responde a cada petición entrante a tu aplicación web.{{</color_green>}}
## Directorio Routes   
La carpeta {{<color_green>}}routes{{</color_green>}} en un proyecto Laravel es crucial, ya que en los fichero que contiene, se van a  definir cómo tu aplicación responde a las solicitudes HTTP

Después de una instalación estándar, tedremos dos ficheros:   

![img_2.png](img_2.png)    

>* {{<color_green>}}web.php{{</color_green>}}    
En él, se definen las rutas accesibles a través del navegador, gestionando solicitudes GET, POST, PUT, PATCH, DELETE, OPTIONS.
Tendremos otros métodos disponibles, según se verán.  
Aquí puedes agrupar rutas, asignarles middleware para control de acceso, y vincularlas a controladores que manejan la lógica de la aplicación.
>* {{<color_green>}}console.php{{</color_green>}}   
Este archivo es donde defines todas las rutas CLI (Command Line Interface) o comandos de Artisan (comando que ejecutaremos desde el terminal para interactuar con nuestra aplicación
>
### Contenido
En el fichero de rutas usaremos simpre la facade {{<color_green>}}Route{{</color_green>}}
Es una Interfaz estática que va a permitir invocar  a los diferentes métodos para que nuestra aplicación ofrezca recursos web.
La idea es establecer ante una solicitud establecer una acción :

[//]: # (```mermaid)

[//]: # (graph LR)

[//]: # (A[Solicitud] --> C[Acción])

[//]: # (```)

En la imagen siguiente especificamos con más detelle el contenido

[//]: # ({{< imgproc  Fill "400x450" >}})

[//]: # ()
[//]: # ({{< /imgproc >}})
### La solicitud
### La acción 

***

 
## Rutas
## Artisan


