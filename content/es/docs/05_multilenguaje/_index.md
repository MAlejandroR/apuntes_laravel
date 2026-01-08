---
title: "Multilenguaje"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 50
---

# Selector de idioma en Laravel 12 con Alpine.js

En este apartado se explica **paso a paso** cómo implementar un **selector de idiomas desplegable** usando **Alpine.js**, con **persistencia del idioma en sesión** mediante un **middleware en Laravel 12**.

---

## 1. Instalación del paquete de idiomas

Laravel incluye el sistema de localización, pero **no incluye traducciones**.  
El paquete recomendado actualmente es `laravel-lang/lang`.

### Instalación

{{< highlight bash "linenos=table" >}}
composer require laravel-lang/lang
{{< /highlight >}}

### Añadir idiomas

Ejemplo: español e inglés.

{{< highlight bash "linenos=table" >}}
php artisan lang:add es
php artisan lang:add en
{{< /highlight >}}

Esto genera la estructura:

lang/
- en/
- es/

con archivos como `auth.php`, `validation.php`, etc.

---

## 2. Configuración básica de localización

Archivo `config/app.php`:

{{< highlight php "linenos=table" >}}
'locale' => 'es',

'fallback_locale' => 'en',
{{< /highlight >}}

- `locale`: idioma por defecto
- `fallback_locale`: idioma de respaldo

---

## 3. Middleware para establecer el idioma

El idioma se almacenará en **sesión**, y un middleware se encargará de aplicarlo en cada request.

---

### 3.1 Crear el middleware

{{< highlight bash "linenos=table" >}}
php artisan make:middleware SetLocale
{{< /highlight >}}

---

### 3.2 Implementación del middleware

Archivo `app/Http/Middleware/SetLocale.php`:

{{< highlight php "linenos=table" >}}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = session('locale', config('app.locale'));

        App::setLocale($locale);

        return $next($request);
    }
}
{{< /highlight >}}

Este middleware:
- Lee el idioma desde sesión
- Aplica el locale dinámicamente a Laravel

---

### 3.3 Registro del middleware (Laravel 12)

En Laravel 12 **no existe Kernel.php**.  
El middleware se registra en `bootstrap/app.php`.

{{< highlight php "linenos=table" >}}
->withMiddleware(function ($middleware) {
    $middleware->append(\App\Http\Middleware\SetLocale::class);
})
{{< /highlight >}}

De esta forma el middleware es **global**.

---

## 4. Ruta para cambiar el idioma

Se define una ruta que:
- Recibe el idioma
- Lo guarda en sesión
- Redirige a la página anterior

{{< highlight php "linenos=table" >}}
use Illuminate\Support\Facades\Route;

Route::get('/lang/{locale}', function (string $locale) {
    if (! in_array($locale, ['es', 'en'])) {
        abort(400);
    }

    session(['locale' => $locale]);

    return redirect()->back();
})->name('lang.switch');
{{< /highlight >}}

---

## 5. Alpine.js en Laravel 12

Laravel 12 ya incluye Alpine.js si se ha instalado Breeze o Jetstream.

Si no está instalado:

{{< highlight bash "linenos=table" >}}
npm install alpinejs
{{< /highlight >}}

Archivo `resources/js/app.js`:

{{< highlight js "linenos=table" >}}
import Alpine from 'alpinejs'

window.Alpine = Alpine
Alpine.start()
{{< /highlight >}}

---

## 6. Componente desplegable de idiomas

Se crea un componente Blade con Alpine.js.

Archivo `resources/views/components/language-switcher.blade.php`:

{{< highlight html "linenos=table" >}}
<div x-data="{ open: false }" class="relative inline-block text-left">
    <button
        @click="open = !open"
        class="inline-flex items-center px-4 py-2 bg-gray-200 rounded-md"
    >
        {{ strtoupper(app()->getLocale()) }}
        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    <div
        x-show="open"
        @click.outside="open = false"
        x-transition
        class="absolute right-0 z-50 mt-2 w-32 bg-white border rounded shadow"
    >
        <a href="{{ route('lang.switch', 'es') }}"
           class="block px-4 py-2 hover:bg-gray-100">
            Español
        </a>

        <a href="{{ route('lang.switch', 'en') }}"
           class="block px-4 py-2 hover:bg-gray-100">
            English
        </a>
    </div>
</div>
{{< /highlight >}}

---

## 7. Uso del componente

En cualquier vista Blade:

{{< highlight blade "linenos=table" >}}
<x-language-switcher />
{{< /highlight >}}

Ejemplo en un layout:

{{< highlight blade "linenos=table" >}}
<header class="flex justify-end p-4">
    <x-language-switcher />
</header>
{{< /highlight >}}

---

## 8. Uso de traducciones

### Ejemplo simple

{{< highlight blade "linenos=table" >}}
{{ __('Welcome') }}
{{< /highlight >}}

---

### Archivos personalizados

Archivo `lang/es/messages.php`:

{{< highlight php "linenos=table" >}}
return [
    'welcome' => 'Bienvenido',
];
{{< /highlight >}}

Archivo `lang/en/messages.php`:

{{< highlight php "linenos=table" >}}
return [
    'welcome' => 'Welcome',
];
{{< /highlight >}}

Uso en Blade:

{{< highlight blade "linenos=table" >}}
{{ __('messages.welcome') }}
{{< /highlight >}}

---

## 9. Flujo completo del sistema

1. El usuario selecciona un idioma
2. Se llama a la ruta `/lang/{locale}`
3. El idioma se guarda en sesión
4. El middleware `SetLocale` se ejecuta
5. Laravel ajusta el locale
6. Las vistas se renderizan traducidas

---

## 10. Observaciones importantes

- El uso de sesión es preferible a cookies directas
- El middleware debe ejecutarse antes de renderizar vistas
- Alpine.js es ideal para componentes pequeños y reactivos
- El sistema es compatible con Blade, Inertia y Filament

---


