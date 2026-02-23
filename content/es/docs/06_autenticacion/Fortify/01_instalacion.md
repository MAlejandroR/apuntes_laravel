---
title: "Instalación"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 10
icon: fa-solid fa-sitemap
---
# Instalando fortify
* Referencia en la web https://laravel.com/docs/master/fortify

* Instalación
{{< highlight bash "linenos=table, hl_lines=1" >}}
  composer require laravel/fortify # Instalar el paquete
  php artisan fortify:install # publicar los recursos de fortify
  php artisan migrate # ejecutar las migraciones
* {{< / highlight >}}
**Qué se ha instalado y cómo usarlo
Observamos que no se ha 
**Http/Controller**:
 ![img.png](img.png)   
Por otro lado, respecto a las migracines aparece una migración que modifica la tabla **users**, añadiendo los siguientes campos para la autenticaciń 2FA:

* 
## Personalizando

### Enlazando el front

### Actuando en el registro

### Actuando en el logout

### Redirigir (next login or logout)

### Personalizando perfiles

### Los teams

### Subiendo imágenes
