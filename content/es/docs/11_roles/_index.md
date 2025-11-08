---
title: "Roles"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 110
icon: fa-brands fa-critical-role
---

#### Gestión de roles
****
Spatie Laravel Permision
> Obtener todos los roles

{{< highlight php "linenos=table, hl_lines=1" >}}
$rol = auth()->user()->getRoleNames();

{{< / highlight >}}

> Solo hay un rol, puedo quedarme con el primero (y único)
> {{< highlight php "linenos=table, hl_lines=1" >}}

$rol = auth()->user()->getRoleNames();
{{< / highlight >}}


### Instalación
 composer require spatie/laravel-permission

