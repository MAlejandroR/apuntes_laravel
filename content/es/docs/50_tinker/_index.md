---
title: "tinker"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 50
---

# Tinker

En esta página explico **cómo usar Laravel Tinker** para probar consultas Eloquent, ver qué clases y variables tienes definidas, y algunas funciones nativas de PHP que pueden ayudarte a explorar el entorno.

---

## ✏️ ¿Qué es Tinker?

Tinker es un **REPL** interactivo incluido en Laravel.

---

## 🧩 ¿Qué significa REPL?

**REPL** son las siglas en inglés de:

- **Read** – Leer: Escribes código y el intérprete lo lee.
- **Eval** (Evaluate) – Evaluar: El intérprete ejecuta ese código.
- **Print** – Imprimir: Muestra el resultado en pantalla.
- **Loop** – Bucle: Espera a que escribas más código, y el ciclo se repite.

En resumen:  
Puedes escribir código, verlo ejecutarse inmediatamente, ver el resultado y seguir probando más cosas en la misma sesión.

---

## 🚀 ¿Cómo iniciar Tinker?

Muy fácil, en la terminal escribe:

{{< highlight bash >}}
php artisan tinker
{{< /highlight >}}

---

## 📚 Usar Eloquent dentro de Tinker

Puedes ejecutar cualquier consulta Eloquent directamente:

{{< highlight php >}}
use App\Models\User;

// Obtener todos los usuarios
$users = User::all();

// Buscar un usuario por clave primaria
$user = User::find(1);

// Crear un nuevo usuario
User::create([
'name' => 'John Doe',
'email' => 'john@example.com',
'password' => bcrypt('secret'),
]);
{{< /highlight >}}

---

## 🧪 Ver variables y funciones definidas

A veces es útil saber qué tienes definido en la sesión de Tinker.

Puedes usar funciones nativas de PHP como:

{{< highlight php >}}
// Mostrar todas las variables definidas
get_defined_vars();

// Mostrar todas las funciones definidas
get_defined_functions();

// Mostrar todas las clases declaradas
get_declared_classes();
{{< /highlight >}}

> ⚠️ Importante: En Tinker, cada comando se ejecuta por separado, así que puede que no veas variables de comandos anteriores.  
> Estas funciones son más útiles dentro de scripts o cuando pruebas varias líneas a la vez.

---

## ✅ Consejos

- Recuerda importar tus modelos con `use`.
- Usa colecciones: Tinker muestra muy bien los resultados de colecciones y modelos.
- Combina con `dd()` o `dump()` para depurar datos.

---

## 🛠 Ejemplo de sesión

{{< highlight php >}}
use App\Models\Post;

// Obtener todos los posts
$posts = Post::all();

// Ver qué clases están cargadas
$clases = get_declared_classes();

dump($clases);
{{< /highlight >}}

---

*Documentación actualizada y explicada para que lo entiendas mejor 📚*
