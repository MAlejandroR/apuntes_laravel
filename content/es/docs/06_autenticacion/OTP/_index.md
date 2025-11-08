---
title: "OTP One-Time Password"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 60
icon: fa-solid fa-sitemap
---

## Implementación
Vamos a implementar un sistema de verificación por código (OTP) o password de un solo uso con estos pasos:

1. El usuario introduce su email (o lo tiene ya registrado).
2. Laravel genera un código aleatorio.
3. Laravel envía ese código por email.
4. El usuario lo introduce en un formulario de verificación.
5. Si el código es correcto, puede continuar.

{{< color >}} Pasos a realizar {{< /color >}}
1. Crea una tabla para guardar los códigos
   Vamos a crear una tabla email_verifications.

* {{< highlight php "linenos=table, hl_lines=1" >}}
 php artisan make:migration create_email_verifications_table
{{< / highlight >}}

* Especificamos los campos de la tabla
* {{< highlight php "linenos=table, hl_lines=1" >}}
  Schema::create('email_verifications', function (Blueprint $table) {
  $table->id();
  $table->string('email');
  $table->string('code');
  $table->timestamp('expires_at');
  $table->timestamps();
  });
  {{< / highlight >}}

2. Creamos un modelo para la talba
* {{< highlight php "linenos=table, hl_lines=1" >}}
  php artisan make:model EmailVerification
  {{< / highlight >}}
  
3.Creamos un controlador para enviar el código
* {{< highlight php "linenos=table, hl_lines=1" >}}
  php artisan make:controller EmailVerificationController
  {{< / highlight >}}

* Escribimos el código para enviar el email
{{< highlight php "linenos=table, hl_lines=1" >}}
  public function sendOtp(Request $request)
  {
  //Validamos que haya un email
  $request->validate(['email'=>'required|email']);
        //Geramo el códiog
        $otp=rand(100000, 999999);

* //Guardamos el código en la cache o bien en base de datos:
        //En cache
        // Cache::put("otp_".$request->email, $otp, noew()->addMinutes(10));
        //En base de datos
        EmailVerification::updateOrCreate(['email'=>$request->email], ['otp'      =>$otp,
                                                                       'expire_at'=>now()->addMinutes(10)]);

//Enviamos el correo
Mail::raw('Su código de verificación es: ' . $otp, function ($message) use ($request) {
$message->to($request->email)->subject('Verificación de correo');
});

        return response()->json(['message'=>'Código de verificación enviado'], 200);

    }

{{< / highlight >}}
4. Creamos una ruta para enviar el código
{{< highlight php "linenos=table, hl_lines=1" >}}
   Route::post('/email/send-code', [EmailVerificationController::class, 'sendCode']);

{{< / highlight >}}