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


#### Qué hacemos en este proceso de instalación

{{< highlight php tabla_alumnos "linenos=table, hl_lines=" >}}
    composer require laravel/breeze --dev
{{< /highlight>}}

Este comando:

- Descarga el paquete laravel/breeze como dependencia de desarrollo
- No crea aún ningún archivo de autenticación
- Añade al proyecto los comandos necesarios para generar el sistema de login

En este punto, el proyecto sigue siendo funcionalmente igual; Breeze solo está disponible para ser instalado.

---

{{< highlight php tabla_alumnos "linenos=table, hl_lines=" >}}
php artisan breeze:install
{{< /highlight>}}

Este es el comando clave del proceso.  
Al ejecutarlo, Laravel:

- Copia controladores de autenticación al proyecto
- Genera vistas Blade para login, registro, recuperación de contraseña, etc.
- Añade rutas de autenticación en el sistema de rutas
- Configura el uso de Tailwind y Alpine
- Publica componentes Blade reutilizables

Durante la ejecución, Breeze puede preguntar por el stack a utilizar (Blade, React, Vue, API, etc.).  
Si no se especifica nada, se instala el stack Blade por defecto.

--- 
{{< highlight php tabla_alumnos "linenos=table, hl_lines=" >}}
php artisan migrate
{{< /highlight>}}
 

Este comando:

- Ejecuta las migraciones de base de datos
- Crea, entre otras, la tabla users necesaria para la autenticación
- Deja el sistema preparado para registrar y autenticar usuarios reales

Sin este paso, el login no funcionaría porque no existirían las tablas necesarias.

---
{{< highlight php tabla_alumnos "linenos=table, hl_lines=" >}}
    npm install
{{< /highlight>}}


Este comando:

- Instala las dependencias frontend definidas en package.json
- Incluye Tailwind CSS, Vite y otras herramientas necesarias
- Prepara el entorno para compilar los assets

Es imprescindible tras instalar Breeze, ya que se añaden dependencias nuevas.

---

### Advertencia sobre Tailwind 4 y Breeze

Laravel Breeze, **por defecto**, está preparado para funcionar con **Tailwind CSS 3**.  
Aun así, es posible forzar el proyecto para usar **Tailwind CSS 4**, pero debes asumir que:

- No es un camino “oficial” en Breeze.
- Puede haber **pequeños fallos visuales** en algunas vistas (normalmente mínimos y fáciles de ajustar).
- El mayor riesgo es dejar el proyecto en un estado “híbrido” (Tailwind 4 + PostCSS antiguo), lo que rompe Vite.

---

#### Qué ocurre al instalar Breeze

Después de ejecutar `php artisan breeze:install` suelen ocurrir estos cambios:

1. **Se sobreescriben o regeneran rutas**  
   Breeze necesita añadir rutas de autenticación. Si tu `routes/web.php` estaba personalizado, revisa cambios y recupera tu contenido si fuese necesario.

2. **Se instalan controladores, vistas y rutas de autenticación**  
   Se generan (o se añaden) controladores de autenticación, vistas Blade y rutas para:
   login, register, logout, forgot password, reset password, email verification, etc.

3. **Se instala Tailwind 3 y se modifica el frontend**  
   Breeze añade dependencias y ficheros del stack frontend (Tailwind 3 por defecto).  
   Esto puede implicar que tu `resources/css/app.css` se reemplace o se ajuste para Tailwind 3.

---

### Migrar el proyecto a Tailwind 4 (mínimo y limpio)

Objetivo: dejar el proyecto en un estado coherente con Tailwind 4:

- Tailwind 4
- Sin PostCSS
- Sin autoprefixer
- Vite usando el plugin `@tailwindcss/vite`
- CSS usando `@import "tailwindcss";`

---

#### 1) Eliminar PostCSS del proyecto

Borra el fichero de configuración de PostCSS (si existe):

- `postcss.config.js`

Nota: Si este fichero existe, Vite intentará cargar PostCSS y fallará si no tienes `autoprefixer`.

---

#### 2) Ajustar dependencias (package.json)

Asegúrate de que NO existan estas dependencias en `devDependencies` del fichero {{<color>}}package.json{{</color>}}. Puedes borrar directamente esas líneas:

- `postcss`
- `autoprefixer`
- `tailwindcss` versión 3

Instala Tailwind 4 y el plugin oficial para Vite:

- `tailwindcss`
- `@tailwindcss/vite`
{{< highlight php tabla_alumnos "linenos=table, hl_lines=" >}}
- npm install -D tailwindcss@latest @tailwindcss/vite
{{< /highlight>}}
* {{<color>}}tailwindcss@latest: {{</color>}}  Instala la versión más reciente de Tailwind (actualmente 4.x).
* {{<color>}}@tailwindcss/vite{{</color>}} Es imprescindible para Tailwind 4. Sustituye completamente a PostCSS con autoprefixer.

* {{<color>}}-D (--save-dev){{</color>}} Tailwind es una dependencia de desarrollo. (En producción, ya se transpila al css
---

#### 3) Limpiar instalación de npm y reinstalar

Elimina dependencias instaladas y el lockfile, y reinstala:
{{< highlight php tabla_alumnos "linenos=table, hl_lines=" >}}
 rm -rf node_modules package-lock.json
 npm install
{{< /highlight>}}

- borrar `node_modules`
- borrar `package-lock.json`
- ejecutar `npm install`

Esto evita que queden restos de Tailwind 3 o PostCSS en caché.

---

#### 4) Configurar Vite para Tailwind 4

En `vite.config.js` añade el plugin:

- importar `tailwindcss` desde `@tailwindcss/vite`
- incluir `tailwindcss()` en `plugins`

Debe quedar (estructura):


{{< highlight php tabla_alumnos "linenos=table, hl_lines=6" >}}
export default defineConfig({
    plugins: [
        laravel({
            // Lo que hubiera
        }),
        tailwindcss(),
    ],

});
{{< /highlight>}}

---

#### 5) Cambiar `resources/css/app.css` al formato Tailwind 4

En Tailwind 4 NO se usan directivas clásicas `@tailwind ...;`.

El contenido mínimo recomendado es:

- `@import "tailwindcss";`

---

#### 6) Ejecutar Vite

Finalmente:

- `npm run dev`

Si Vite arranca sin errores, Tailwind 4 está funcionando.

---

### Nota sobre estilos “raros” tras la migración

Recuerda que estás usando tailwind en versión 4 y podría ser que alguna vista, algún componente tenga algún detall de estilo diferente en la versión 3:
- No es un fallo de Laravel.
- Es un cambio esperado por las diferencias entre Tailwind 3 y Tailwind 4.
- Normalmente se corrige ajustando clases concretas en las vistas de Breeze.


---

### Limpieza paso a paso (checklist rápida)

- Borrar `postcss.config.js`
- Quitar `postcss` y `autoprefixer` de `package.json`
- Sustituir Tailwind 3 por Tailwind 4
- `rm -rf node_modules package-lock.json`
- `npm install`
- Configurar `vite.config.js` con `@tailwindcss/vite`
- Cambiar `app.css` a `@import "tailwindcss";`
- `npm run dev`


### Opción alternativa: iniciar el proyecto directamente con Breeze

Laravel permite crear un proyecto nuevo e instalar Breeze desde el inicio usando un parámetro

{{< highlight bash >}}
laravel new proyecto --breeze
{{< /highlight >}}
 Actualmente en el proceso de instalación es habitual que nos pregunte si queremos disponer de esta librería en nuestro proyecto.

Con esta opción:

- Breeze se instala automáticamente durante la creación del proyecto
- Se generan directamente las vistas, controladores y rutas
- Aun así, será necesario ejecutar migrate y npm install / npm run dev

Esta opción es útil cuando se sabe desde el principio que el proyecto necesitará autenticación básica.

---


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


