---
title: "Rutas"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 20
---

# Helpers de Laravel para Rutas
Laravel proporciona varios helpers útiles para trabajar con rutas.    
Estos son algunos de los más importantes:    

## `route('nombre_ruta')`
- Genera una URL para una ruta nombrada.
- Podemos pasar parámetros a la ruta como un array asociativo {{<color_green>}}['variable'=>valor]{{</color_green>}}
```php
route('user.profile', ['id' => 1]);
```

## `url('path')`

- Genera una URL absoluta para el path dado.
- Ejemplo: `url('/user')`

## `redirect()->route('nombre_ruta')`

- Redirige a una ruta nombrada.
- Ejemplo: `redirect()->route('home')`

## `action('NombreControlador@metodo')`

- Genera una URL para el controlador y método especificados.
- Ejemplo: `action('UserController@show', ['id' => 1])`

## `back()`

- Redirige al usuario a la ubicación anterior.
- Ejemplo: `return back()`

## `current()`

- Obtiene la URL actual.
- Ejemplo: `url()->current()`

## `previous()`

- Obtiene la URL previa a la actual.
- Ejemplo: `url()->previous()`
