---
title: "Instalación"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 20
icon: fa-solid fa-arrow-right
---
## La instalación 
Como ya hemos comentado {{<color_blue>}}Laravel{{</color_blue>}}, uno de los frameworks de PHP más populares, simplifica el desarrollo web mediante una estructura organizada y herramientas potentes.    
Para comenzar un proyecto en Laravel, existen dos enfoques principales:

* crear un proyecto con composer
* Instalar un programa llamado {{<color_blue>}}laravel{{</color_blue>}} con el que crearemos proyectos.
## Instalar composer
Lo primero que necesitamos es tener {{<color_green>}}composer{{</color_green>}} instalado en nuestro sistema


{{<color_green>}}Composer{{</color_green>}} es un sistema de gestión de dependencias para PHP que permite  especificar y manejar las librerías de las cuales sus proyectos dependen, a través de un fichero llamado {{<color_green>}}composer.json{{</color_green>}}.     
Igualmente, composer permite aportar documentación sobre el proyecto y automatizar la autocarga de clases para la ejecución del mismo.    
Funciona **descargando e instalando estas librerías y sus dependencias en el proyecto, asegurando compatibilidad y facilitando la actualización**.    
Es esencial para proyectos modernos de PHP, ya que automatiza y gestiona tareas complejas de gestión de paquetes de forma eficiente.
{{< alert title="Composer" color="warning" >}}
{{<color_green>}}Para instalar composer{{</color_green>}}
* Linux- Mac: https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos
* Windows https://getcomposer.org/doc/00-intro.md#installation-windows
  {{< /alert >}}
* {{< highlight php "linenos=table, hl_lines=1" >}}
  composer -V
  {{< / highlight >}}
  Entonces veremos una salida, si simplemente escribmos {{<color_blue>}}composer{{</color_blue>}} saldrán todas las opciones disponibles
  Una vez instalado en un terminal (CMD o PowerShell en windows) escribimos
  ![img_1.png](img_1.png)

## Instalar el instalardor Laravel
{{% pageinfo%}}
#### Laravel installer
![img.png](img.png)
****
{{<color_green>}}Laravel no es ni un EDI, ni un lenguaje de programación{{</color_green>}}, {{<color_blue>}}es un framework{{</color_blue>}}.    


Necesitamos de alugna manera un programa que nos permita crear un proyecto nuevo con la estructura y todas las utilidades que ofrece el framework
Podemos instalar un instalador de laravel  con composer:
{{<color_green>}}Instalador de Laravel{{</color_green>}}:  
   Alternativamente, puedes utilizar el instalador de Laravel, una herramienta ligera que se instala globalmente en tu sistema a través del comando
   {{< highlight php "linenos=table, hl_lines=1" >}}
   composer global require laravel/installer
   {{< / highlight >}}.


{{% /pageinfo%}}
### Creando un proyecto

>* {{<color_green>}}Uso de Composer{{</color_green>}}:    
   Puedes crear un nuevo proyecto Laravel ejecutando el comando
   {{< highlight php "linenos=table, hl_lines=1" >}}
   composer create-project laravel/laravel nombre_proyecto
   {{< / highlight >}}     
   Este método instala Laravel y todas sus dependencias, configurando una estructura de directorios lista para comenzar a desarrollar tu aplicación.

   Este instalador permite crear nuevos proyectos rápidamente con el comando laravel new nombre_proyecto.
   Además utilizando esta herramiena, el comando {{<color_blue>}}laravel{{</color_blue>}} durante el proceso de instalación, se irán planteando opciones durante que puedes elegir

Este programa es un instalador de proyectos de laravel que es una herramienta en línea de comandos que nos va a permitir crear un proyecto  base de laravel.   Para ello escribimos
laravel new nombre_proyecto
Puede ser que dé algún problema y no reconozca la orden laravel. en este caso deberíamos de actualizar el path del sistema incluyendo el directorio donde haya instalado laravel



