---
title: "Fortify y Jetstream"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 60
icon: fa-solid fa-sitemap
---
# Introducción y concepto del paquete
* Referencia oficial: https://laravel.com/docs/master/fortify
> Fortify es un paquete que podemos instalar en nuestras aplicaciones Laravel para gestionar el sistema de autenticación.

{{% pageinfo %}}
#### 
****

A la hora de instalar, podemos hacerlo primero con Fortify y luego con Jetstream, pero se recomienda instalar directamente Jetstream, ya que este **ya incluye Fortify como dependencia**.

Este paquete se centra en la parte del **backend**, dejando al desarrollador libertad para implementar el **frontend** (las vistas), que no se incluyen por defecto.

Entre sus funcionalidades más destacadas:
* Registro de usuarios.
* Inicio de sesión.
* Restablecimiento de contraseñas.
* Verificación de correo electrónico.
* **Verificación en dos pasos (2FA)** *(no disponible en Breeze)*.

Además, permite gestionar otras funcionalidades que no vienen activadas por defecto:
* **Administración de sesiones** *(no disponible en Breeze)*.
* **Bloqueo de usuarios** *(no disponible en Breeze)*.
  {{% /pageinfo %}}

Si lo instalamos mediante Jetstream, añadimos además las siguientes funcionalidades ya configuradas en el frontend:

* {{< color >}} Interfaz de usuario predefinida con Livewire o Inertia. {{< /color >}}
{{<desplegable title="Gestión de perfil de usuario">}}
  <ul>
    <li>Cambiar nombre, email, contraseña.</li>
    <li>Subir foto de perfil..</li>
    <li>Activar/desactivar 2FA.</li>
    <li>Cerrar otras sesiones del navegador.</li>
  </ul>
* {{</desplegable>}}
* {{< color >}} Gestión de sesiones activas. {{< /color >}}
* {{< color >}}Verificación en dos pasos (2FA) integrada.{{< /color >}}
* {{<desplegable title="Gestión de equipos (opcional)" >}}
<ol>
  <li>Crear equipos.</li>
  <li>Invitar usuarios a un equipo.</li>
  <li>Cambiar roles de los miembros.</li>
  <li>Cambiar entre equipos (multi-equipo).</li>
</ol>
{{</desplegable>}}


{{% line %}}
## Su funcionamiento

### Instalación

{{< highlight bash "linenos=table, hl_lines=1" >}}
composer require laravel/fortify       # Instalar el paquete
php artisan fortify:install            # Publicar los recursos de Fortify
php artisan migrate                    # Ejecutar las migraciones
{{< /highlight >}}

Una vez instalado el paquete, observamos que **no se ha creado ningún controlador** dentro de `Http/Controllers`.

![img.png](img.png)

Respecto a las migraciones, se ha generado una que **modifica la tabla `users`**, añadiendo campos necesarios para la autenticación en dos pasos (2FA).

* 
## Personalizando
{{< desplegable title="Resumen visual: Personalización en Fortify::boot()" >}}

Fortify::loginView() → Vista de inicio de sesión

Fortify::registerView() → Vista de registro

Fortify::requestPasswordResetLinkView() → Vista para solicitar enlace de restablecimiento  

Fortify::resetPasswordView() → Vista para restablecer contraseña con token

Fortify::verifyEmailView() → Vista de verificación de email

Fortify::twoFactorChallengeView() → Vista del reto de 2FA

Fortify::authenticateUsing() → Proceso personalizado de autenticación  

Fortify::confirmPasswordView() → Vista para confirmar contraseña  

Fortify::twoFactorAuthenticationView() → Vista para configurar la autenticación en dos pasos



{{< /desplegable >}}
{{< highlight php "linenos=table, hl_lines=1" >}}
public function boot(): void
{
// 👤 Vista personalizada para el login
Fortify::loginView(function () {
return view('auth.login');
});

    // 📝 Vista personalizada para el registro
    Fortify::registerView(function () {
        return view('auth.register');
    });

    // 🔑 Vista para solicitar recuperación de contraseña
    Fortify::requestPasswordResetLinkView(function () {
        return view('auth.forgot-password');
    });

    // 🔁 Vista para reiniciar la contraseña con el token
    Fortify::resetPasswordView(function ($request) {
        return view('auth.reset-password', ['request' => $request]);
    });

    // 📧 Vista para verificación del email
    Fortify::verifyEmailView(function () {
        return view('auth.verify-email');
    });

    // 📲 Vista para verificar el código de 2FA
    Fortify::twoFactorChallengeView(function () {
        return view('auth.two-factor-challenge');
    });

    // ✅ Proceso de autenticación personalizado (puedes usar otro campo que no sea email)
    Fortify::authenticateUsing(function (Request $request) {
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            return $user;
        }

        return null;
    });

    // 📞 Vista para confirmar contraseña antes de una acción sensible
    Fortify::confirmPasswordView(function () {
        return view('auth.confirm-password');
    });

    // 🔐 Vista para configurar la autenticación en dos pasos
    Fortify::twoFactorAuthenticationView(function () {
        return view('auth.two-factor-authentication');
    });
}

{{< / highlight >}}
### Enlazando el front

### Actuando en el registro

### Actuando en el logout

### Redirigir (next login or logout)

### Personalizando perfiles

### Los teams

### Subiendo imágenes
