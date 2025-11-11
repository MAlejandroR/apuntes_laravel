---
title: "Roles"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 110
icon: fa-brands fa-critical-role
---

#### Gestión de roles
****

**Spatie Laravel Permission**

El paquete [spatie/laravel-permission](https://spatie.be/docs/laravel-permission) permite gestionar **roles** y **permisos** fácilmente en Laravel.  
Se integra con el sistema de autenticación estándar, por lo que puedes asignar y comprobar el rol de cualquier usuario autenticado.

---

### 🧩 Instalación

{{< highlight bash "linenos=table" >}}
composer require spatie/laravel-permission
{{< /highlight >}}

Publica la configuración y migraciones:

{{< highlight bash "linenos=table" >}}
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
{{< /highlight >}}

Ejecuta las migraciones:

{{< highlight bash "linenos=table" >}}
php artisan migrate
{{< /highlight >}}

Esto creará las tablas necesarias:
- `roles`
- `permissions`
- `model_has_roles`
- `model_has_permissions`
- `role_has_permissions`

---

### ⚙️ Configuración inicial

En el modelo `User.php` añade el trait:

{{< highlight php "linenos=table" >}}
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
use HasRoles;
}
{{< /highlight >}}

> Si tu modelo autenticable es `Student` (en lugar de `User`), añade el mismo `use HasRoles;` allí.

---

### 🧱 Crear roles

Puedes crear roles desde el seeder, Tinker o directamente en código:

{{< highlight php "linenos=table" >}}
use Spatie\Permission\Models\Role;

// Crear roles
Role::create(['name' => 'student']);
Role::create(['name' => 'teacher']);
Role::create(['name' => 'admin']);
{{< /highlight >}}

También puedes hacerlo desde un seeder:

{{< highlight bash "linenos=table" >}}
php artisan make:seeder RolesTableSeeder
{{< /highlight >}}

Y dentro de él:

{{< highlight php "linenos=table" >}}
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
public function run(): void
{
Role::firstOrCreate(['name' => 'student']);
Role::firstOrCreate(['name' => 'teacher']);
Role::firstOrCreate(['name' => 'admin']);
}
}
{{< /highlight >}}

Ejecuta el seeder:

{{< highlight bash "linenos=table" >}}
php artisan db:seed --class=RolesTableSeeder
{{< /highlight >}}

---

### 👤 Asignar un rol a un usuario

Cuando registras un usuario o estudiante, puedes asignarle un rol inmediatamente:

{{< highlight php "linenos=table" >}}
$user = User::create([
'name' => 'Manuel',
'email' => 'manuel@example.com',
'password' => Hash::make('12345678'),
]);

$user->assignRole('student');
{{< /highlight >}}

También puedes hacerlo dinámicamente:

{{< highlight php "linenos=table" >}}
auth()->user()->assignRole('teacher');
{{< /highlight >}}

---

### 🔍 Obtener y comprobar roles

> Obtener todos los roles del usuario autenticado:

{{< highlight php "linenos=table, hl_lines=1" >}}
$roles = auth()->user()->getRoleNames();
{{< /highlight >}}

> Si el usuario solo tiene un rol, puedes obtener el primero:

{{< highlight php "linenos=table, hl_lines=1" >}}
$rol = auth()->user()->getRoleNames()->first();
{{< /highlight >}}

> Comprobar si el usuario tiene un rol específico:

{{< highlight php "linenos=table, hl_lines=1" >}}
if (auth()->user()->hasRole('teacher')) {
// Mostrar contenido solo para profesores
}
{{< /highlight >}}

> Comprobar si tiene alguno de varios roles:

{{< highlight php "linenos=table, hl_lines=1" >}}
if (auth()->user()->hasAnyRole(['admin', 'teacher'])) {
// Acceso especial
}
{{< /highlight >}}

---

### 🛡️ Usar roles en vistas (Blade)

{{< highlight blade "linenos=table" >}}
@role('admin')
<p>Panel de administración</p>
@endrole

@hasrole('teacher')
<p>Zona del profesor</p>
@endhasrole
{{< /highlight >}}

También puedes usar directivas condicionales:

{{< highlight blade "linenos=table" >}}
@hasanyrole('admin|teacher')
<p>Bienvenido profesor o administrador</p>
@endhasanyrole
{{< /highlight >}}

---

### 🧭 Resumen final

| Acción | Ejemplo |
|--------|----------|
| **Instalar paquete** | `composer require spatie/laravel-permission` |
| **Publicar y migrar** | `php artisan vendor:publish ... && php artisan migrate` |
| **Añadir HasRoles al modelo** | `use HasRoles;` |
| **Crear roles** | `Role::create(['name' => 'student']);` |
| **Asignar rol a usuario** | `$user->assignRole('student');` |
| **Comprobar rol** | `auth()->user()->hasRole('admin');` |
| **Obtener rol actual** | `auth()->user()->getRoleNames()->first();` |

---

{{< color "info" >}}
🧠 **Consejo:**  
Puedes combinar roles con permisos (`permissions`) para definir acciones más precisas, como “crear ejercicios”, “editar unidades” o “ver reportes”.
{{< /color >}}
****