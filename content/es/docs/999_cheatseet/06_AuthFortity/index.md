---
title: "Laravel: Uso de la Facade File"
date: 2025-03-02
weight: 60
draft: true
categories: ["Laravel", "Auth", "Fortity"]
tags: ["Auth", "Laravel", "Fortity"]
---

# ✅ Laravel Auth Cheatsheet (Facade & Helpers)

> Autenticación usando el facade `Auth` y el helper `auth()`  
> *(Válido para Laravel + Fortify)*

---

## 🔐 Inicio y cierre de sesión

| Código | Descripción |
|--------|-------------|
| `Auth::login($user)` | Inicia sesión con el usuario indicado |
| `Auth::logout()` | Cierra la sesión del usuario |
| `Auth::attempt(['email' => ..., 'password' => ...])` | Intenta iniciar sesión con credenciales |
| `auth()->login($user)` | Igual que `Auth::login()` (helper) |
| `auth()->logout()` | Igual que `Auth::logout()` |
| `auth()->attempt([...])` | Igual que `Auth::attempt()` |

---

## 👤 Acceder al usuario autenticado

| Código | Descripción |
|--------|-------------|
| `Auth::user()` | Devuelve el usuario actual autenticado (o `null`) |
| `auth()->user()` | Igual que arriba |
| `Auth::id()` | Devuelve el ID del usuario autenticado |
| `auth()->id()` | Igual que arriba |
| `Auth::check()` | Devuelve `true` si hay un usuario autenticado |
| `auth()->check()` | Igual que arriba |
| `Auth::guest()` | Devuelve `true` si **no** hay usuario autenticado |

---

## 🛡️ Proteger rutas

En tu archivo `routes/web.php`:

{{< highlight php "linenos=table, hl_lines=1" >}}
Route::middleware(['auth'])->group(function () {
Route::get('/dashboard', fn () => view('dashboard'));
});
{{< /highlight >}}

O directamente:

{{< highlight php "linenos=table" >}}
Route::get('/dashboard', fn () => view('dashboard'))->middleware('auth');
{{< /highlight >}}

---

## 🔁 Redirección después del login (Fortify)

En `FortifyServiceProvider` o en `App\Providers\RouteServiceProvider`:

{{< highlight php "linenos=table" >}}
use Illuminate\Support\Facades\Redirect;

Fortify::redirects([
'login' => function () {
$role = auth()->user()->getRoleNames()->first();
return match ($role) {
'admin' => '/admin',
'teacher' => '/teacher',
'student' => '/student',
default => '/',
};
}
]);
{{< /highlight >}}

También puedes usar la propiedad `RouteServiceProvider::$redirectTo` si usas Fortify con configuración clásica.

---

## ⚙️ Otros métodos útiles

| Código | Descripción |
|--------|-------------|
| `Auth::viaRemember()` | Comprueba si el usuario se autenticó con “recordarme” |
| `auth()->viaRemember()` | Igual que arriba |
| `auth()->setUser($user)` | Establece manualmente un usuario en la request (avanzado) |

---

## 🧪 Ejemplo con Tinker

{{< highlight bash "linenos=table" >}}
php artisan tinker
>>> $user = App\Models\User::find(1);
>>> Auth::login($user);
>>> Auth::user()->name;
{{< /highlight >}}
