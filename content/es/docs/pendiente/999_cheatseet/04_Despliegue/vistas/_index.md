---
title: "Vistas"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 20
---

# Helpers de Vistas en Laravel

## ¿Qué son los Helpers de Vistas?

Los helpers de vistas en Laravel son funciones que facilitan el manejo y la renderización de las vistas. Estos helpers permiten una interacción más simple y eficiente con las plantillas Blade del framework.

Cómo helper de vistas, tenemos  la función {{<color_blue>}}view(){{</color_blue>}} de Laravel.

Este helper {{<color_green>}}retorna una instancia de una vista{{</color_green>}}. 

Esta función no solo carga y retorna la vista especificada, sino que también permite {{<color_green>}}el encadenamiento de métodos adicionales disponibles en la instancia del objeto de la vista{{</color_green>}}.

Esto facilita **la manipulación y personalización de la vista** antes de que se envíe al navegador.

## Principales Helpers de Vistas

### **`view()`**
- Genera una nueva vista.
- Ejemplo: `view('welcome', ['data' => $data])` carga la vista `welcome` con datos.

### **`view()->make()`**
- Similar a `view()`, pero con una sintaxis alternativa.
- Ejemplo: `view()->make('welcome', ['data' => $data])`.

### **`view()->exists()`**
- Comprueba si una vista existe.
- Ejemplo: `view()->exists('welcome')` devuelve `true` si la vista `welcome` existe.

### **`view()->first()`**
- Intenta renderizar la primera vista existente de una lista.
- Ejemplo: `view()->first(['custom', 'default'])` carga la primera vista que exista entre `custom` y `default`.

### **`view()->share()`**
- Comparte una variable en todas las vistas.
- Ejemplo: `view()->share('key', 'value')` hace que `key` esté disponible globalmente en todas las vistas.

### **`view()->composer()`**
- Asigna datos a una vista cada vez que se carga.
- Ejemplo: `view()->composer('welcome', function ($view) { ... })`.

### **`view()->creator()`**
- Similar a `view()->composer()`, pero se ejecuta cuando la vista se crea.
- Ejemplo: `view()->creator('welcome', function ($view) { ... })`.

Estos helpers son fundamentales para la gestión de vistas en Laravel, permitiendo un flujo de trabajo más ágil y una mayor flexibilidad en la renderización y el manejo de datos en las vistas.

- Ejemplo: `url()->previous()`
