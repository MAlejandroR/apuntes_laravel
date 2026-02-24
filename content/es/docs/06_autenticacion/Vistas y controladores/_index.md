---
title: "auth: Vistas y Controladores"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 20
icon: fa-solid fa-user-lock
---
# Autenticación en Laravel (Breeze)
Control de acceso con directivas Blade, middleware y obtención del usuario autenticado.

---

## Directivas Blade: `@auth` y `@guest`

Laravel proporciona directivas específicas para comprobar si el usuario está autenticado.

###  @auth

Renderiza el contenido solo si el usuario está autenticado.

{{< highlight blade >}}
@auth
<p>Bienvenido {{ auth()->user()->name }}</p>
@endauth
{{< /highlight >}}

Equivalente interno:

{{< highlight php >}}
if (auth()->check()) {
// usuario autenticado
}
{{< /highlight >}}

---

##  @guest

Renderiza el contenido solo si NO hay usuario autenticado.

{{< highlight blade >}}
@guest
<a href="{{ route('login') }}">Login</a>
<a href="{{ route('register') }}">Register</a>
@endguest
{{< /highlight >}}

Equivalente interno:

{{< highlight php >}}
if (!auth()->check()) {
// usuario no autenticado
}
{{< /highlight >}}

---

##  Middleware `auth` en rutas

El middleware protege rutas para que solo accedan usuarios autenticados.

### En routes/web.php

{{< highlight php >}}
Route::get('/dashboard', function () {
return view('dashboard');
})->middleware('auth');
{{< /highlight >}}

{{<color>}} Agrupando rutas{{</color>}}

{{< highlight php >}}
Route::middleware('auth')->group(function () {
Route::get('/profile', [ProfileController::class, 'edit']);
Route::get('/settings', [SettingsController::class, 'index']);
});
{{< /highlight >}}

Si el usuario no está autenticado:
- Laravel redirige automáticamente a `/login`.

---

[//]: # ()
[//]: # (##  Middleware dentro del Controller)

[//]: # ()
[//]: # (Puedes proteger todo el controlador desde el constructor.)

[//]: # ()
[//]: # ({{< highlight php >}})

[//]: # (class DashboardController extends Controller)

[//]: # ({)

[//]: # (public function __construct&#40;&#41;)

[//]: # ({)

[//]: # ($this->middleware&#40;'auth'&#41;;)

[//]: # (})

[//]: # ()
[//]: # (    public function index&#40;&#41;)

[//]: # (    {)

[//]: # (        return view&#40;'dashboard'&#41;;)

[//]: # (    })

[//]: # (})

[//]: # ({{< /highlight >}})

[//]: # ()
[//]: # (## Proteger solo métodos concretos)

[//]: # ()
[//]: # ({{< highlight php >}})

[//]: # ($this->middleware&#40;'auth'&#41;->only&#40;['index', 'edit']&#41;;)

[//]: # ($this->middleware&#40;'auth'&#41;->except&#40;['publicMethod']&#41;;)

[//]: # ({{< /highlight >}})

[//]: # ()
[//]: # (---)

## Obtener el usuario autenticado en un Controller



{{< highlight php >}}
$user = auth()->user();
{{< /highlight >}}

{{<color>}} Alternativa con Request{{</color>}}

{{< highlight php >}}
    public function index(Request $request)
    {
          $user = $request->user();
    }
{{< /highlight >}}

---

{{<color>}}¿Qué ocurre si no hay usuario autenticado?{{</color>}}

Si la ruta NO está protegida con middleware:

{{< highlight php >}}
$user = auth()->user(); // devuelve null si no está autenticado
{{< /highlight >}}

Por eso es recomendable:

{{< highlight php >}}
    if (auth()->check()) {
       $user = auth()->user();
    }
{{< /highlight >}}

---

# Resumen conceptual

- `@auth` → Mostrar contenido solo si hay usuario autenticado.
- `@guest` → Mostrar contenido solo si NO hay usuario autenticado.
- `middleware('auth')` → Protege rutas o controladores.
- `auth()->user()` → Devuelve el usuario autenticado o `null`.

Laravel centraliza la autenticación mediante:
- Guards
- Middleware
- Facade `Auth`
- Helper `auth()`

Esto permite mantener el código limpio y coherente en toda la aplicación.

###  ¿Qué es un Guard en Laravel? (Explicación básica)

Un **Guard** es el mecanismo que Laravel usa para saber:

> {{<color>}}¿Quién está autenticado y cómo lo he autenticado?{{</color>}}

Es decir, el guard decide:
- DÓNDE se guarda la información del login
- CÓMO se comprueba si un usuario está autenticado

---

{{<color>}}Comparaitiva para mejor comprensión{{</color>}}

Imagina que Laravel es un edificio con varias puertas.

Cada puerta tiene un sistema diferente para comprobar la identidad:

- 🔑 Una puerta usa **sesiones** (login clásico con formulario)
- 🔐 Otra puerta usa **tokens API**
- 🪪 Otra podría usar **JWT**
- 🧩 Otra podría usar autenticación externa

Cada sistema de acceso es un **Guard**.

---

###  El Guard por defecto

En aplicaciones web normales (con Breeze), Laravel usa el guard:
{{<color>}}Web{{</color>}}
Este guard:
- Usa sesiones
- Guarda el usuario autenticado en la sesión
- Funciona con login tradicional (email + password)

Está definido en:

{{< highlight php >}}
config/auth.php
{{< /highlight >}}

### ¿Por qué existen varios Guards?

Porque una misma aplicación puede tener:

- 👤 Usuarios normales (web)
- 🤖 API externa con tokens
- 👨‍🏫 Panel admin separado
- 📱 App móvil con autenticación diferente

Cada tipo puede usar un guard distinto.

Ejemplo típico:

{{< highlight php >}}
'guards' => [
'web' => [
'driver' => 'session',
'provider' => 'users',
],

    'api' => [
        'driver' => 'token',
        'provider' => 'users',
    ],
]
{{< /highlight >}}

---

### Acciones de un guard

Un guard se encarga de:

1. Comprobar si hay usuario autenticado
2. Recuperar el usuario actual
3. Validar credenciales
4. Gestionar login / logout

---

### Guard Vs Provider

- **Guard** → Cómo se autentica
- **Provider** → De dónde salen los usuarios (tabla users, otra tabla, etc.)

---

{{<color>}} Resumen{{</color>}}

> 🔐 Guard = Sistema de autenticación  
> 👤 Provider = Fuente de usuarios  
> 🧾 Middleware auth = Filtro que obliga a estar autenticado

---

{{<color>}}En nuestros proyectos usaremos{{</color>}}

* **Guard: web**
* **Driver: session**
* **Provider: users**


Y funcionará automáticamente.

No tenéis que tocar nada hasta que trabajéis con APIs o múltiples tipos de autenticación.