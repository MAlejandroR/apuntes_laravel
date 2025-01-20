---
title: "Dashboard según rol"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 10
icon: fa-solid fa-sitemap
---
# Página user autenticado según rol
> Se pretende una vez autenticado entregar un dashboard u otro
> 
En este caso tenemos 3 roles:
* admin
* studnet
* teacher
### Crear middleware
Primero creamos un **middleware** para que se ejecute una vez autenticado
{{< highlight bash "linenos=table, hl_lines=1" >}}
  php artisan make:middleware RedirectIfAuthenticated
{{< / highlight >}}
### El código


