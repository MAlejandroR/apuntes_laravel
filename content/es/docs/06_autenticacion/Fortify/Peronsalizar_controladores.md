---
title: "Personalizar controladores"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 60
icon: fa-solid fa-sitemap
---

# Personalización del Proceso de Autenticación en Laravel Fortify

# Personalizar los  controladores para autenticación con fortify

Al instalar **{{<color_green>}}Laravel Fortify{{</color_green>}}**, los controladores que manejan el proceso de *{{<color_blue>}}login, registro y otras acciones de autenticación{{</color_blue>}}* no se encuentran de forma explícita en el directorio {{<color_blue>}}Http\Controllers{{</color_blue>}} de tu aplicación.

Estos **{{<color_green>}}Controladores{{</color_green>}}** están ubicados en **{{<color_blue>}}vendor/laravel/fortify/src/Http/Controllers{{</color_blue>}}** :
## Estos Controladores están ubicados en `vendor/laravel/fortify/src/Http/Controllers`:

### Loguearse
* {{<color_green>}}AuthenticatedSessionController{{</color_green>}}: Maneja el inicio de sesión y cierre de sesión.
* {{<color_green>}}RegisteredUserController{{</color_green>}}: Maneja el registro de nuevos usuarios.

### Confirmación, reseteo de password
* {{<color_green>}}ConfirmablePasswordController{{</color_green>}}: Maneja la confirmación de contraseñas antes de realizar ciertas acciones.
* {{<color_green>}}ConfirmedPasswordStatusController{{</color_green>}}: Proporciona el estado de la confirmación de la contraseña.
* {{<color_green>}}ConfirmedTwoFactorAuthenticationController{{</color_green>}}: Maneja la confirmación de autenticación de dos factores.
* {{<color_green>}}NewPasswordController{{</color_green>}}: Maneja el restablecimiento de contraseñas.
* {{<color_green>}}PasswordController{{</color_green>}}: Maneja la actualización de contraseñas.
* {{<color_green>}}PasswordResetLinkController{{</color_green>}}: Maneja el envío de enlaces para restablecer contraseñas.

### Verificar por email
* {{<color_green>}}EmailVerificationNotificationController{{</color_green>}}: Maneja el envío de notificaciones de verificación de correo electrónico.
* {{<color_green>}}EmailVerificationPromptController{{</color_green>}}: Muestra la solicitud de verificación de correo electrónico.
* {{<color_green>}}VerifyEmailController{{</color_green>}}: Maneja la verificación de direcciones de correo electrónico.

### Gestión de perfil
* {{<color_green>}}ProfileInformationController{{</color_green>}}: Maneja la actualización de la información del perfil del usuario.
* {{<color_green>}}RecoveryCodeController{{</color_green>}}: Maneja los códigos de recuperación para la autenticación de dos factores.

### 2FA
* {{<color_green>}}TwoFactorAuthenticatedSessionController{{</color_green>}}: Maneja la autenticación de sesiones con dos factores.
* {{<color_green>}}TwoFactorAuthenticationController{{</color_green>}}: Maneja la activación y desactivación de la autenticación de dos factores.
* {{<color_green>}}TwoFactorQrCodeController{{</color_green>}}: Muestra el código QR para la autenticación de dos factores.
* {{<color_green>}}TwoFactorSecretKeyController{{</color_green>}}: Maneja las claves secretas para la autenticación de dos factores.

Al instalar fortify los controladores que manejan el proceso de login, register y demás acciones de este paquete, no se exponen de forma explícita en el directorio **http**.

Además si instalamos Jetstream, tenemos disponibles las sigueintes fucnionalidades

# chatgpt

Para personalizar la lógica del login en Laravel Fortify, hay dos enfoques principales:

Modificar las Acciones Usadas por Fortify:
Laravel Fortify permite definir acciones personalizadas para manejar la lógica de autenticación. Puedes sobrescribir las acciones predeterminadas en config/fortify.php.

Sobrescribir los Controladores Usados por Fortify:
Aunque Fortify no expone explícitamente los controladores de autenticación como en una configuración tradicional de Laravel, puedes crear tus propios controladores y configurarlos para manejar las rutas de Fortify.

Opción 1: Modificar las Acciones Usadas por Fortify
Fortify permite definir acciones personalizadas para manejar tareas específicas como la creación de usuarios, el restablecimiento de contraseñas, etc. Puedes definir estas acciones en config/fortify.php.

Ejemplo:
Crear la Acción Personalizada:
Crea una clase de acción personalizada en App\Actions\Fortify.

php
Copiar código
namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
public function create(array $input)
{
Validator::make($input, [
'name' => ['required', 'string', 'max:255'],
'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
'password' => ['required', 'string', 'min:8', 'confirmed'],
])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
Configurar la Acción Personalizada en Fortify:
Modifica config/fortify.php para usar tu acción personalizada.

php
Copiar código
use App\Actions\Fortify\CreateNewUser;

return [
'guard' => 'web',
'passwords' => 'users',

    'username' => 'email',
    'email' => 'email',

    'features' => [
        Features::registration(),
        Features::resetPasswords(),
        Features::emailVerification(),
        Features::updateProfileInformation(),
        Features::updatePasswords(),
        Features::twoFactorAuthentication([
            'confirm' => true,
            'confirmPassword' => true,
        ]),
    ],

    'actions' => [
        'register' => CreateNewUser::class,
    ],
];
Opción 2: Sobrescribir los Controladores Usados por Fortify
Para personalizar completamente los controladores de Fortify, puedes crear tus propios controladores y configurarlos en las rutas de Fortify. Esto te da control total sobre la lógica de autenticación.

Ejemplo:
Crear el Controlador Personalizado:
Crea un controlador personalizado en App\Http\Controllers\Auth.

php
Copiar código
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\LoginViewResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController as BaseAuthenticatedSessionController;
use Laravel\Fortify\Http\Requests\LoginRequest;

class CustomAuthenticatedSessionController extends BaseAuthenticatedSessionController
{
protected $guard;

    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

    public function create(Request $request): LoginViewResponse
    {
        return Inertia::render('Auth/Login');
    }

    public function store(LoginRequest $request)
    {
        return $this->loginPipeline($request)->then(function ($request) {
            return app(LoginResponse::class);
        });
    }

    public function destroy(Request $request): LogoutResponse
    {
        $this->guard->logout();

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return app(LogoutResponse::class);
    }
}
Configurar las Rutas para Usar tu Controlador Personalizado:
Configura las rutas de Fortify para usar tu controlador personalizado en routes/web.php o en un archivo de rutas específico.

php
Copiar código
use App\Http\Controllers\Auth\CustomAuthenticatedSessionController;

Fortify::loginView([CustomAuthenticatedSessionController::class, 'create']);
Route::post('/login', [CustomAuthenticatedSessionController::class, 'store']);
Route::post('/logout', [CustomAuthenticatedSessionController::class, 'destroy'])->name('logout');
Resumen
Modificación de Acciones: Útil para personalizar tareas específicas sin cambiar la estructura general de los controladores.
Sobrescribir Controladores: Útil para tener control total sobre la lógica de autenticación y las rutas asociadas.
Ambas opciones son válidas y puedes elegir la que mejor se adapte a tus necesidades de personalización en Laravel Fortify.

Si no establezco esa ruta de login, dónde se asocia el controlador a la ruta login ?
ChatGPT
En Laravel Fortify, las rutas de autenticación, incluyendo la ruta de login, se configuran automáticamente y se asocian a controladores predeterminados mediante el proveedor de servicios de Fortify. No necesitas definir explícitamente estas rutas a menos que desees personalizarlas.

Asociación Automática de Rutas en Fortify
Laravel Fortify asocia las rutas a los controladores predeterminados utilizando el servicio de rutas que se configura en el proveedor de servicios de Fortify (FortifyServiceProvider). Aquí es donde Fortify define y registra las rutas predeterminadas para login, registro, restablecimiento de contraseñas, etc.

Registro de Rutas en FortifyServiceProvider
El archivo vendor/laravel/fortify/src/FortifyServiceProvider.php es donde se realiza la magia. Aquí es donde Fortify configura las rutas predeterminadas.

php
Copiar código
public function register()
{
$this->registerRoutes();
}

protected function registerRoutes()
{
if (Fortify::$registersRoutes) {
Route::group([
'namespace' => 'Laravel\Fortify\Http\Controllers',
'domain' => config('fortify.domain', null),
'prefix' => config('fortify.prefix'),
'middleware' => config('fortify.middleware', ['web']),
], function () {
$this->loadRoutesFrom(__DIR__.'/../routes/routes.php');
});
}
}
El archivo de rutas que se carga es vendor/laravel/fortify/routes/routes.php.

Rutas Definidas en Fortify
Dentro de routes/routes.php, Fortify define las rutas predeterminadas:

php
Copiar código
Route::group(['middleware' => config('fortify.middleware', ['web'])], function () {
// Authentication...
Route::get('/login', 'AuthenticatedSessionController@create')
->middleware(['guest:'.config('fortify.guard')])
->name('login');

    Route::post('/login', 'AuthenticatedSessionController@store')
        ->middleware(['guest:'.config('fortify.guard')]);

    Route::post('/logout', 'AuthenticatedSessionController@destroy')
        ->name('logout');

    // Registration...
    Route::get('/register', 'RegisteredUserController@create')
        ->middleware(['guest:'.config('fortify.guard')])
        ->name('register');

    Route::post('/register', 'RegisteredUserController@store')
        ->middleware(['guest:'.config('fortify.guard')]);

    // Password Reset...
    Route::get('/forgot-password', 'PasswordResetLinkController@create')
        ->middleware(['guest:'.config('fortify.guard')])
        ->name('password.request');

    Route::post('/forgot-password', 'PasswordResetLinkController@store')
        ->middleware(['guest:'.config('fortify.guard')])
        ->name('password.email');

    Route::get('/reset-password/{token}', 'NewPasswordController@create')
        ->middleware(['guest:'.config('fortify.guard')])
        ->name('password.reset');

    Route::post('/reset-password', 'NewPasswordController@store')
        ->middleware(['guest:'.config('fortify.guard')])
        ->name('password.update');
        
    // Email Verification...
    Route::get('/email/verify', 'EmailVerificationPromptController@show')
        ->middleware(['auth:'.config('fortify.guard')])
        ->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', 'VerifyEmailController@__invoke')
        ->middleware(['auth:'.config('fortify.guard'), 'signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', 'EmailVerificationNotificationController@store')
        ->middleware(['auth:'.config('fortify.guard'), 'throttle:6,1'])
        ->name('verification.send');

    // Profile Information...
    Route::put('/user/profile-information', 'ProfileInformationController@update')
        ->middleware(['auth:'.config('fortify.guard')])
        ->name('user-profile-information.update');

    // Passwords...
    Route::put('/user/password', 'PasswordController@update')
        ->middleware(['auth:'.config('fortify.guard')])
        ->name('user-password.update');

    // Two Factor Authentication...
    Route::post('/user/two-factor-authentication', 'TwoFactorAuthenticationController@store')
        ->middleware(['auth:'.config('fortify.guard')]);

    Route::delete('/user/two-factor-authentication', 'TwoFactorAuthenticationController@destroy')
        ->middleware(['auth:'.config('fortify.guard')]);

    Route::get('/user/two-factor-qr-code', 'TwoFactorQrCodeController@show')
        ->middleware(['auth:'.config('fortify.guard')]);

    Route::get('/user/two-factor-secret', 'TwoFactorSecretController@show')
        ->middleware(['auth:'.config('fortify.guard')]);

    Route::get('/user/two-factor-recovery-codes', 'RecoveryCodeController@index')
        ->middleware(['auth:'.config('fortify.guard')]);

    Route::post('/user/two-factor-recovery-codes', 'RecoveryCodeController@store')
        ->middleware(['auth:'.config('fortify.guard')]);
});
Personalización del Controlador
Para personalizar el proceso de login sin redefinir todas las rutas, puedes sobrescribir las acciones de Fortify como se mencionó anteriormente, o puedes extender el controlador predeterminado de Fortify.

Ejemplo de Extensión del Controlador
Crea el Controlador Personalizado:

php
Copiar código
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

class CustomAuthenticatedSessionController extends AuthenticatedSessionController
{
// Sobrescribe los métodos que necesitas personalizar
public function create()
{
// Tu lógica personalizada
return view('auth.login');
}
}
Configura Fortify para Usar tu Controlador:

Modifica las rutas en routes/web.php para usar tu controlador personalizado.

php
Copiar código
use App\Http\Controllers\Auth\CustomAuthenticatedSessionController;

Route::get('/login', [CustomAuthenticatedSessionController::class, 'create'])
->middleware(['guest'])
->name('login');

Route::post('/login', [CustomAuthenticatedSessionController::class, 'store'])
->middleware(['guest']);

Route::post('/logout', [CustomAuthenticatedSessionController::class, 'destroy'])
->name('logout');
Resumen
Fortify registra automáticamente las rutas y las asocia a sus controladores predeterminados. Si deseas personalizar la lógica de login, puedes:

Sobrescribir las acciones de Fortify en config/fortify.php.
Crear controladores personalizados y configurar las rutas para usarlos.
La segunda opción requiere que definas explícitamente las rutas para usar tu controlador personalizado, mientras que la primera opción permite personalizar la lógica específica sin cambiar las rutas.

****