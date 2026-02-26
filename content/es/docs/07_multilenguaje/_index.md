---
title: "Multilenguaje"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 70
---

# Selector de idioma en Laravel 12 con Alpine.js

En este apartado se explica **paso a paso** cómo implementar:
* Un **selector de idiomas desplegable** ,
* Cambio en un **controlador**,
* Con **persistencia del idioma en sesión** 
* mediante un **middleware en Laravel4**.
Necesitaremos un poco de js para ante el cambio den el botón de cambio de idioma se llame al controlador

* La siguiente imagen muestra el flujo de trabajo de nuestro objetivo:

![flujo_cambio_idioma.png](flujo_cambio_idioma.png)

---

## 1. Instalación del paquete de idiomas

Laravel incluye el sistema de localización, pero **no incluye traducciones**.  
El paquete recomendado actualmente es `laravel-lang/common`.

### Instalación
Este paquete requiere la librería php-math que no suele estar instalada, Es este un paquete de matemáticas que se necesita para publicar idiomas

{{< highlight bash "linenos=table" >}}
sudo apt install php-math
{{< /highlight>}}

Ahora ya instalamos el paquete de idiomas

{{< highlight php tabla_alumnos "linenos=table, hl_lines=" >}}

composer require laravel-lang/common
{{< /highlight >}}

### Añadir idiomas
Una vez instalado es sencillo añadir idiomas.
Lo único que hay que conocer es el identificador del idiomam llamado código de idioma según SIO 639-1m que identifica el idioma de manera normalizada usando **2 letras**
Ejemplo: españo, inglés y francés.

{{< highlight bash "linenos=table" >}}
php artisan lang:add es
php artisan lang:add en
php artisan lang:add fr
{{< /highlight >}}

Esto genera la estructura:

lang/
- en/
- es/
- fr/
- es.json
- en.json
- fr.json


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

Estas variables las tenemos disponibles en el fichero de configuración **.ENV**
{{< highlight php tabla_alumnos "linenos=table, hl_lines=" >}}
APP_LOCALE=en
APP_FALLBACK_LOCALE=en
{{< /highlight>}}
- ---
## Acciones en nuestra aplicación
Para realizar una adaptación de esta nueva funcionalidad en nuestra aplicción, necesitamos seguir un proceso de acciones
### La parte de la vista
Aquí debemos de realizar dos acciones:
1. Añadir un elemento gráfico que nos permita seleccionar el idioma
2. Recoger el evento para llamar al controlador del servidor
3. Realizar un wrapper de todos  los textos que queramos traducir en nuestra página html
* {{<color>}}Añadiendo el elemento html{{</color>}}
* {{<color>}}Recoger el evento{{</color>}}
* {{<color>}}Wrapper con la función __  o trans {{</color>}}
### Actulizar los ficheros de idiomas
*Vamos a crear un fichero de configuración para generalizar y poder incorporar más idiomas con facilidad
* Creamos este fichero en la carpeta {{<color>}}config{{</color>}}
{{< highlight php tabla_alumnos "linenos=table, hl_lines=" >}}
 <?php
    return [
        "es" => [
            "name" => "Español",
            "flag" => "🇪🇸"
        ],
        "fr" => [
            "name" => "France",
            "flag" => "🇫🇷"
        ],
        "en" => [
            "name" => "English",
            "flag" => "🇬🇧"
        ]
    ];
{{< /highlight>}}
* Este ficheor se lee en cuanlquier momento en nuestro código con el helper {{<color>}}config("nombre_fichero"){{</color>}}

*Ahora en nuestro componenete **header** añadimos un elemento select de html


### La parte del controlador
### Creando un middleware 


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


