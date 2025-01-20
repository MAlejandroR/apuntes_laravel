---
title: "Instalación"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 10
icon: fa-solid fa-sitemap
---
# Instalando breeze
* Referencia en la web https://laravel.com/docs/master/fortify

* Instalación
{{< highlight bash "linenos=table, hl_lines=1" >}}
  composer require laravel/breeze --dev

 php artisan breeze:install
 php artisan migrate
 npm install
 npm run dev
* {{< / highlight >}}

{{< alert title="pendiente" color="warning" >}}
Falta explicar los conceptos de qué se instala en cada caso y la opción de iniciar el proceso con un start en la instalación del proyecto
{{< /alert >}}
### Usando docker para la bd

### Redirección una vez autenticado con Laravel Breeze

En Laravel Breeze, la redirección después de autenticarse se gestiona en el controlador `AuthenticatedSessionController`. Este controlador define el comportamiento de inicio de sesión y la redirección predeterminada.

{{% line %}}

#### **Ubicación del Controlador**

El controlador se encuentra en la siguiente ruta del proyecto:

{{< highlight bash "linenos=table" >}}
app/Http/Controllers/Auth/AuthenticatedSessionController.php
{{< /highlight >}}

{{% line %}}

#### **Modificar la Redirección**

Para cambiar la ruta a la que se redirige al usuario después de iniciar sesión, edita el método `store` del controlador. Este es el fragmento relevante:

{{< highlight php "linenos=table, hl_lines=7" >}}
public function store(Request $request): RedirectResponse
{
$request->authenticate();

    $request->session()->regenerate();

    return redirect()->intended('/dashboard'); // Cambia '/dashboard' por tu ruta deseada
}
{{< /highlight >}}

- **`redirect()->intended('/dashboard')`**: Lleva al usuario a la página protegida que intentaba acceder antes de iniciar sesión.
- Si no hay una página pendiente, lo redirige a la ruta `/dashboard`.

{{% line %}}

#### **Ejemplo Práctico**

Si deseas redirigir al usuario a una página personalizada, por ejemplo, `/inicio`, modifica la línea de redirección:

{{< highlight php "linenos=table, hl_lines=7" >}}
return redirect()->intended('/inicio');
{{< /highlight >}}

{{% line %}}

{{< alert title="Nota importante" color="blue" >}}
Si estás utilizando middleware como `auth`, asegúrate de que la ruta de destino esté protegida para evitar accesos no autorizados.
{{< /alert >}}

{{% line %}}

{{<referencias>}}
{{</referencias>}}
### Redirección después de registro con Laravel Breeze

En Laravel Breeze, la redirección después de que un usuario se registre se gestiona en el controlador `RegisteredUserController`. Este controlador define el comportamiento para registrar nuevos usuarios y, al completarse, redirigirlos a una página específica.

{{% line %}}

#### Ubicación del Controlador

El controlador se encuentra en la siguiente ruta dentro del proyecto:

{{< highlight bash "linenos=table" >}}
app/Http/Controllers/Auth/RegisteredUserController.php
{{< /highlight >}}

{{% line %}}

#### Modificar la Redirección

Para cambiar la redirección una vez que el usuario se registre, edita el método `store` en el controlador. Este es el fragmento relevante:

{{< highlight php "linenos=table, hl_lines=11" >}}
public function store(Request $request): RedirectResponse
{
$user = User::create([
'name' => $request->name,
'email' => $request->email,
'password' => Hash::make($request->password),
]);

    event(new Registered($user));

    Auth::login($user);

    return redirect('/dashboard'); // Cambia '/dashboard' por tu ruta deseada
}
{{< /highlight >}}

- **`return redirect('/dashboard')`**: Indica a dónde será redirigido el usuario después de registrarse.
- Puedes cambiar `/dashboard` por cualquier ruta que desees, como `/welcome` o `/inicio`.

{{% line %}}

#### Ejemplo Práctico

Si deseas redirigir a los usuarios recién registrados a una página de bienvenida personalizada (`/welcome`), edita el método de la siguiente manera:

{{< highlight php "linenos=table, hl_lines=11" >}}
return redirect('/welcome');
{{< /highlight >}}

{{% line %}}

#### Nota Adicional

La autenticación del usuario tras el registro está integrada en el método `Auth::login($user)`. Esto asegura que el usuario esté autenticado inmediatamente después de registrarse y sea redirigido a la página deseada.

{{< alert title="Nota importante" color="blue" >}}
Si usas middleware como `auth` para proteger las rutas, asegúrate de que la ruta de redirección esté correctamente configurada para usuarios autenticados.
{{< /alert >}}

{{% line %}}


