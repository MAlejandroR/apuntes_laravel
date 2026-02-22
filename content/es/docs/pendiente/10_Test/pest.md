---
title: "Pest"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 30
---
{{<definicion title="Pest">}}
Pest es un framework de testing para PHP que utiliza PHPUnit por debajo, pero ofrece una sintaxis mucho más simple y expresiva.
{{</definicion>}}
{{% line %}}


# 🧪 Cheatsheet de tests con Pest en Laravel

Esta chuleta resume cómo usar `it`, `beforeEach`, `Mockery`, `$this->get`, `$this->assertDatabaseHas`, y más en Pest + Laravel.

---

## Instalar pest en el proyecto
{{< highlight bash Pest "linenos=table, hl_lines=" >}}
composer require pestphp/pest --dev --with-all-dependencies
{{< /highlight>}}
* Instalar el plugin de pest para php
{{< highlight php tabla_alumnos "linenos=table, hl_lines=" >}}
 composer require pestphp/pest-plugin-laravel --dev
{{< /highlight>}}
* Crear un test:
·Esto creará un test llamado UserCourseContentServiceTest
{{< highlight php tabla_alumnos "linenos=table, hl_lines=" >}}
 php artisan pest:test UserCourseContentServiceTest
{{< /highlight>}}
 


## ✅ Estructura básica de un archivo de test

{{< highlight php "linenos=table" >}}
<?php
uses(Tests\TestCase::class);

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Contracts\User as SocialUserContract;
use Spatie\Permission\Models\Role;
use Mockery;
{{< /highlight >}}

---

## 🔁 Reutilizar código con `beforeEach`

- Se ejecuta **antes de cada test**.
- Puedes usar `$this->` para compartir variables entre los bloques `it`.

{{< highlight php "linenos=table" >}}
beforeEach(function () {
    $this->googleUser = Mockery::mock(SocialUserContract::class);
    $this->googleUser->shouldReceive('getEmail')->andReturn('student@gmail.com');
    $this->googleUser->shouldReceive('getName')->andReturn('Estudiante');

    $provider = Mockery::mock(\Laravel\Socialite\Contracts\Provider::class);
    $provider->shouldReceive('stateless')->andReturnSelf();
    $provider->shouldReceive('user')->andReturn($this->googleUser);

    Socialite::shouldReceive('driver')
        ->with('google')
        ->andReturn($provider);

    Role::findOrCreate('student');
});
{{< /highlight >}}

---

## ✅ Crear un test con `it(...)`

- Cada test debe tener su descripción clara.
- Usa `$this->get()` para simular una petición HTTP.
- Usa `$this->assertDatabaseHas()` para comprobar la base de datos.

{{< highlight php "linenos=table" >}}
it('crea un nuevo usuario estudiante con Google', function () {
    $this->get('/auth/google/callback');

    $this->assertDatabaseHas('users', [
        'email' => 'student@gmail.com',
        'name'  => 'Estudiante',
    ]);
});
{{< /highlight >}}

---

## 📧 Mock de servicios personalizados (por ejemplo OTP)

{{< highlight php "linenos=table" >}}
$otpMock = Mockery::mock(\App\Services\OtpService::class);
$otpMock->shouldReceive('sendOtp')->once();
app()->instance(\App\Services\OtpService::class, $otpMock);
{{< /highlight >}}

---

## 🧪 Validar si el usuario está logueado

{{< highlight php "linenos=table" >}}
expect(Auth::check())->toBeTrue();
expect(Auth::user()->email)->toBe('student@gmail.com');
{{< /highlight >}}

---

## 🔀 Llamar directamente a un controlador en tests

Útil si quieres evitar depender de rutas.

{{< highlight php "linenos=table" >}}
$response = app(\App\Http\Controllers\HandlerProviderCallback::class)->__invoke('google');
{{< /highlight >}}

---

## ✅ Comprobar redirecciones con Inertia o rutas

{{< highlight php "linenos=table" >}}
expect($response->getTargetUrl())->toBe('/student');
{{< /highlight >}}

---

## ⚠️ Errores comunes y cómo solucionarlos

| Error                                               | Causa posible                                  | Solución                                             |
|----------------------------------------------------|------------------------------------------------|------------------------------------------------------|
| `Target class [config] does not exist.`            | `beforeAll()` ejecutando código demasiado pronto | Usar `beforeEach()` en lugar de `beforeAll()`       |
| `Unsupported cipher or incorrect key length.`      | Falta o clave inválida en `.env.testing`        | `php artisan key:generate --env=testing`            |
| `Route not found`                                  | Estás usando una URL que no existe              | Revisa tus rutas en `routes/web.php`                |
| `Database assertion failed (table is empty)`       | No se ejecutó bien el controlador o la ruta     | Asegúrate de usar la URL correcta o llama al controlador directamente |

---

## 🧹 Limpieza final de mocks (opcional)

{{< highlight php "linenos=table" >}}
afterEach(function () {
    Mockery::close();
});
{{< /highlight >}}

---

## 💡 Tip final

Cuando no sabes si un test llega a ejecutarse o qué valores está usando:

{{< highlight php "linenos=table" >}}
dump($variable); // para ver el contenido
{{< /highlight >}}

---

¡Y eso es todo! 🎉
# ✅ Cheatsheet: Validaciones en la Base de Datos con Pest / PHPUnit

---

## 🧪 ¿Qué usamos?

Laravel (con PHPUnit y Pest) nos da helpers especiales para comprobar si hay registros en la base de datos.  
**NO se usa expect() para esto.**

---

## 📌 Métodos más comunes

| Método                                 | ¿Qué hace?                                                  |
|----------------------------------------|--------------------------------------------------------------|
| `$this->assertDatabaseHas()`           | Verifica que un registro **existe** en la base de datos      |
| `$this->assertDatabaseMissing()`       | Verifica que un registro **NO existe** en la base de datos   |
| `$this->assertSoftDeleted()`           | Verifica que el modelo ha sido eliminado de forma "soft"     |
| `$this->assertDatabaseCount()`         | Verifica el número de filas en una tabla (Laravel 9+)        |

---

## ✔️ Ejemplos prácticos

### ✅ Verificar que el usuario existe

{{< highlight php "linenos=table" >}}
$user = User::factory()->create([
    'email' => 'manuel@gmail.com'
]);

$this->assertDatabaseHas('users', [
    'email' => 'manuel@gmail.com',
]);
{{< /highlight >}}

---

### ❌ Verificar que el usuario NO existe

{{< highlight php "linenos=table" >}}
$this->assertDatabaseMissing('users', [
    'email' => 'otro@gmail.com',
]);
{{< /highlight >}}

---

### 💀 Verificar eliminación soft (soft deletes)

Si tu modelo usa `use SoftDeletes;`, puedes hacer:

{{< highlight php "linenos=table" >}}
$user = User::factory()->create();
$user->delete();

$this->assertSoftDeleted('users', [
    'id' => $user->id,
]);
{{< /highlight >}}

---

### 🔢 Verificar cuántas filas hay

(Laravel 9+)

{{< highlight php "linenos=table" >}}
$this->assertDatabaseCount('users', 5);
{{< /highlight >}}

---

## 👀 Tip extra: usar `artisan migrate:fresh --seed` antes de testear

Para empezar con una base limpia:

    php artisan migrate:fresh --seed

---

## 💡 Recomendación

Usa estas validaciones dentro de tests de tipo `Feature` donde estés probando comportamiento completo (como un login, un registro o un formulario).

---

## 📚 Más info

- Laravel docs: https://laravel.com/docs/testing#available-assertions  
- Pest docs: https://pestphp.com/docs/database-testing

---
