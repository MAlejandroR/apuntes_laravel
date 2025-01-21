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
{{< alert title="Instalar Composer" color="success" >}}
* Linux- Mac: https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos
* Windows https://getcomposer.org/doc/00-intro.md#installation-windows
  {{< /alert >}}
Una vez instalado lo podremos usar desde el terminal, independientemente del sistema operativo
{{< highlight php "linenos=table, hl_lines=1" >}}
  composer -V
{{< / highlight >}}
  Entonces veremos una salida, si simplemente escribmos {{<color_blue>}}composer{{</color_blue>}} saldrán todas las opciones disponibles
  Una vez instalado en un terminal (CMD o PowerShell en windows) escribimos
  ![img_1.png](img_1.png)

## Instalar el instalardor Laravel
Laravel dispone de una utilidad, un ejecutable que nos va a permitir crear proyectos con la estructura de un proyecto laravel. En este punto es un {{< color >}} creador de proyectos de laravel {{< /color >}}

#### Laravel installer
![img.png](img.png)
****
{{<color_green>}}Laravel no es ni un EDI, ni un lenguaje de programación{{</color_green>}}, {{<color size="5">}}es un framework{{</color>}}.    


Necesitamos de alguna manera un programa que nos permita crear un proyecto nuevo con la estructura y todas las utilidades que ofrece el framework.

Podemos instalar un instalador de laravel  con composer:
{{<color_green>}}Instalador de Laravel{{</color_green>}}:  
   Alternativamente, puedes utilizar el instalador de Laravel, una herramienta ligera que se instala globalmente en tu sistema a través del comando
   {{< highlight php "linenos=table, hl_lines=1" >}}
   composer global require laravel/installer
   {{< / highlight >}}.


### Creando un proyecto

>* {{<color_green>}}Uso de Composer{{</color_green>}}:    
   Puedes crear un nuevo proyecto Laravel ejecutando el comando
   {{< highlight php "linenos=table, hl_lines=1" >}}
   composer create-project laravel/laravel nombre_proyecto
   {{< / highlight >}}     
   Este método instala Laravel y todas sus dependencias, configurando una estructura de directorios lista para comenzar a desarrollar tu aplicación.
>* A diferencia del instalador de laravel, no te asistirá ni ayudará durante el proceso de creación del proyecto

   Este instalador permite crear nuevos proyectos rápidamente con el comando laravel new nombre_proyecto.

   Además utilizando esta herramiena, el comando {{<color>}}laravel{{</color>}} durante el proceso de instalación, se irán planteando opciones durante que puedes elegir

Para crear un proyecto nuevo en laravel
{{< highlight php "linenos=table, hl_lines=1" >}}
laravel new nombre_proyecto
{{< / highlight >}}
{{< alert title="Actualiza el PATH" color="warning" >}}
Recuerda que la ruta dónde se ubique el programa de instalación, **laravel** , debe de estar incluída en el PATH del sistema
{{< /alert >}}

### {{< color >}} Instala dependencias {{< /color >}}

Laravel tiene una serie de requisitos que necesita satisfacer para poder funcionar.
* PHP >= 8.2
Extensiones necesarias queya se instalan por defecto: 
* Ctype PHP Extension
* Fileinfo PHP Extension
* Filter PHP Extension
* Hash PHP Extension
* OpenSSL PHP Extension (si no lo estuviera `php-openssl`)
* PCRE PHP Extension
* Session PHP Extension
* Tokenizer PHP Extension

* Extensiones que hay que instalar 
* cURL PHP Extension `php-curl`
* DOM PHP Extension `php-xml`
* Mbstring PHP Extension `php-mbstring`
* PDO PHP Extension `php-mysql`
* XML PHP Extension `php-xml`

Para instalar estas extensiones en linux, usaremos apt :
{{< highlight php "linenos=table, hl_lines=1" >}}
apt install php-curl php-xml php-mbstring php-mysql php-xml
{{< / highlight >}}
Para instalar estas extensiones en windows
 https://www.php.net/manual/en/install.pecl.windows.php
Hay que seguir estos pasos:
1. Abre {{< color >}} php.ini {{< /color >}} en un editor de texto como Notepad++, o bien xammp/wammp nos ofrece editar el fichero directamente .

2. Busca las líneas correspondientes a las extensiones y descoméntalas eliminando el punto y coma (;) al inicio.
{{< highlight php "linenos=table, hl_lines=1-6" >}}
   extension=curl
   extension=dom
   extension=mbstring
   extension=mysqli
   extension=pdo_mysql
   extension=xml
{{< / highlight >}}
Si alguna extensión no la tuvieses, eso implica que habría que descargar el **dll**
  https://windows.php.net/download