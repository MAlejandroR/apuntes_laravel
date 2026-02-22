---
title: "Laravel Idea"
date: 2025-07-27T12:30:00+02:00
draft: false
weight: 70
---

# Cómo usar Laravel Idea

Laravel Idea es un plugin premium para PhpStorm que facilita el desarrollo de proyectos Laravel.

---

##  Instalación

1. Abre **PhpStorm**.
2. Ve a **Preferences / Settings → Plugins**.
3. Busca “Laravel Idea”.
4. Instala el plugin y reinicia PhpStorm.
5. Activa la licencia (puedes probarlo gratis unos días).

---

## ️ Configuración

En **Preferences → Laravel Idea** puedes ajustar:

- Autocompletado de rutas, vistas y traducciones.
- Generación de migrations, factories y seeders junto al modelo.
- Integración con tests.
- Reglas para nombres de tablas, campos y relaciones.
- Soporte para paquetes externos (ej: Spatie, Filament).

---

## ️ Generar código (ejemplo)

Para crear un modelo con migration y factory:

1. Pulsa `Alt+Insert` (o clic derecho).
2. Selecciona **Generate Laravel Code**.
3. Elige **Model**.
4. Escribe el nombre: `Book`.
5. Añade campos: `title:string`, `author_id:foreignId`, `published_at:datetime`.
6. Pulsa **OK**.

Laravel Idea generará automáticamente:

- Modelo: `app/Models/Book.php`
- Migration: `database/migrations/xxxx_create_books_table.php`
- Factory: `database/factories/BookFactory.php`
- Seeder (si lo marcas)

{{< highlight php >}}
php artisan make:model Book -mfs
{{< /highlight >}}

---


## ️ Actualizar

Para actualizar el plugin:

1. Ve a **Preferences → Plugins → Laravel Idea**.
2. Si hay actualización disponible, pulsa **Update**.
3. Reinicia PhpStorm.

---

##  Integración con paquetes populares

Laravel Idea ofrece autocompletado y helpers para:

- **Spatie** (Roles & Permissions, MediaLibrary, etc.)
- **Filament**
- **Laravel Debugbar**
- **Livewire**
- **Sanctum / Passport**

> Ayuda a escribir menos código manual y detectar errores antes de ejecutar.

---

## ️ Tabla de atajos útiles

| Acción                                         | Atajo (Mac / Windows)                     |
|-----------------------------------------------|-------------------------------------------|
| Generar código Laravel                        | `Alt+Insert` o clic derecho → Generate   |
| Buscar cualquier archivo, clase o vista       | `Shift+Shift`                            |
| Navegar a definición (ir a modelo, vista...)  | `Ctrl+Click` o `Cmd+Click`                |
| Buscar dentro de archivos abiertos            | `Cmd+E` o `Ctrl+E`                        |
| Mostrar estructura del archivo                | `Cmd+F12` o `Ctrl+F12`                    |
| Generar métodos mágicos (ej: `getXAttribute`) | `Alt+Insert` en la clase                  |

---

##  Consejos finales

- Usa los snippets para relaciones: `hasMany`, `belongsTo`, `belongsToMany`, etc.
- Activa sugerencias para *casts*, scopes y recursos.
- Configura nombres automáticos para migrations y tablas.
- Explora la opción **"Find Laravel usages"** para ver dónde se usa un modelo, ruta o vista.

Laravel Idea te ayuda a escribir menos y pensar más en la lógica de tu proyecto.

---

# Resumen del flujo de trabajo con Laravel Idea

Laravel Idea ayuda a organizar y acelerar el desarrollo siguiendo un flujo de trabajo ordenado.

---

##  Flujo recomendado

1. **Definir la idea del modelo**  
   Pensar qué entidades vas a necesitar, sus campos y relaciones.

---

2. **Generar el modelo**

- <code>Alt+Insert → Generate Laravel Code → Model</code>
- Añadir campos y relaciones.
- Generar migration, factory y seeder automáticamente.

---

3. **Ejecutar migration**

{{< highlight bash >}}

php artisan migrate
{{< /highlight  >}}

---

###  Crear recurso Filament (si aplica)

- <code>Alt+Insert → Generate Laravel Code → Filament Resource</code>
- Elegir el modelo creado.
- Generar páginas: <code>List</code>, <code>Create</code>, <code>Edit</code>.

---

### ️ Configurar el formulario y la tabla

- Usar autocompletado para campos:  
  <code>TextInput</code>, <code>Select</code>, <code>DatePicker</code>.
- Añadir validaciones, labels y relaciones.
- Configurar columnas de tabla con:  
  <code>TextColumn</code>, <code>DateColumn</code>, etc.

---

###  Añadir relaciones y métodos en el modelo

- Crear relaciones como:  
  <code>hasMany</code>, <code>belongsTo</code>, etc.
- Laravel Idea sugiere y completa estos métodos automáticamente.

---

###  Probar en el panel Filament

- Acceder al panel y verificar que todo funciona correctamente.

---

###  Refinar

- Ajustar formularios y tablas.
- Crear <code>policies</code>, <code>tests</code> y <code>factories</code> extra si son necesarios.
- Configurar traducciones y permisos.

---

##  Ventajas de este flujo

- Menos errores manuales.
- Archivos relacionados generados automáticamente.
- Autocompletado para métodos, relaciones y campos.
- Mejor organización del código desde el inicio.

> Laravel Idea se convierte en tu **asistente** para programar más rápido, de forma más ordenada y segura.
