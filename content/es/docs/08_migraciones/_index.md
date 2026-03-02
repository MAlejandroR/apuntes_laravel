---
title: "Migraciones"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 80
icon: fa-solid fa-database
---

## 1. Introducción 

En proyectos reales, En el desarrollo de una aplicación, suele ocurrir que el esquema de base de datos cambia continuamente: se añaden campos, se refactorizan tablas, se crean relaciones, se aplican restricciones, etc. Hacer estos cambios _**a mano**_ en phpMyAdmin (o en un SQL suelto) suele romper la trazabilidad, dificulta el trabajo en equipo y hace frágiles los despliegues entre entornos (local, preproducción, producción).

Es cierto que una vez desarrollada la aplicación, la base de datos sigue siendo un elemento crítico, pero menos frecuentes, presentando pocos cambios (es algo ideal...).

Laravel resuelve esto con **migraciones**: una forma **versionada**, **repetible** y **automatizable** de definir la estructura de la base de datos como código. En un equipo, todos comparten el mismo histórico de cambios, y el proyecto puede “levantar” la base de datos desde cero de forma consistente.

A su vez, laravel nos va a ofrecer la posibilidad de poblar de forma automatizada las tablas de la base de datos, constituyendo un entorno ideal para poder probar nuestra aplicación según la vamos desarrollando.

Estos datos serán datos fictícios o datos faker, y constituirán un entorno ideal para poder probar nuestra aplicación.

{{< line >}}

{{< objetivos >}}

- Identificar qué problema resuelven las migraciones en un proyecto web profesional.
- Crear migraciones desde consola y localizar su archivo en el proyecto.
- Aplicar, deshacer y rehacer migraciones usando comandos de Artisan.
- Modelar columnas, índices y claves foráneas con el Schema Builder.
- Diseñar migraciones seguras (reversibles) y mantenibles en equipo.
- Detectar errores comunes en migraciones y aplicar buenas prácticas.

{{< /objetivos >}}

{{< line >}}

{{< definicion title="Migración" url="https://laravel.com/docs/12.x/migrations" >}}

Es un fichero PHP (una clase) que permite __crear/modificar/eliminar tablas__ en nuestra aplicación (podríamos decir que es el principal uso que le vamos a dar).

Además, permite mantener un **versionado del esquema de la base de datos**, lo que hace posible replicarlo exactamente en cualquier entorno (desarrollo, pruebas o producción, o cuando se clone el proyecto) simplemente ejecutando un comando.

{{< /definicion >}}

{{< definicion title="Schema Builder" url="https://laravel.com/docs/12.x/migrations#creating-columns" >}}

**Schema Builder** es la API de Laravel que permite definir **tablas, columnas, índices y restricciones** de forma expresiva, sin necesidad de escribir SQL manualmente.

Se utiliza dentro de las migraciones para estructurar la base de datos mediante métodos como **create, table, string, integer, foreignId,** etc.

Cuando hablamos aquí de API, estamos indicando un conjunto de métodos públicos disponibles en Schema y Blueprint, que podemos usar directamente. Son intuitivos y no necesitamos conocer su implementación. Es una librería de utilidades que tenemos disponibles:
```php
## Ejemplos de métodos disponibles
use Illuminate\Support\Facades\Schema;

    Schema::create()
    Schema::table()
    $table->string()
    $table->integer()
    $table->foreignId()
    $table->timestamps()
    $table->unique()
```

{{< /definicion >}}

{{< definicion title="Blueprint" url="https://laravel.com/docs/12.x/migrations#creating-columns" >}}

Es el objeto que representa el **diseño de una tabla** durante la ejecución de una migración.

Su uso es implícito, ya que Laravel **lo inyecta**, cuando usamos los métodos  dentro de Schema::create() o Schema::table(). Permite permite **definir columnas, índices y claves foráneas** utilizando una **sintaxis fluida y orientada a objetos**.
```php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('address');
            $table->timestamps();
        });
```

{{< /definicion >}}

{{< definicion title="up() / down()" url="https://laravel.com/docs/12.x/migrations#structure" >}}

{{<color>}}up() / down(){{</color>}} son los métodos principales de una migración:

- **up()**: _Crea elementos_: contiene las instrucciones para aplicar el cambio (crear tabla, añadir columnas, modificar estructura).
- **down()**: _Elimina_: revierte los cambios realizados en up() (eliminar tabla, eliminar columnas, etc.).

Esto permite que los cambios en la base de datos sean **reversibles y controlados**.
```php
  public function up(): void
    {
        Schema::create('student', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            });
    }
  public function down(): void
    {
        Schema::dropIfExists('student');
   }


```

{{< /definicion >}}

{{< definicion title="migrate / rollback / refresh" url="https://laravel.com/docs/12.x/migrations#running-migrations" >}}

_**migrate / rollback / refresh**_ son operaciones habituales ejecutadas desde Artisan:

- **migrate**: aplica las migraciones pendientes y crea las tablas definidas.
- **rollback**: revierte el último lote de migraciones ejecutadas.
- **refresh**: revierte todas las migraciones y las vuelve a ejecutar desde cero (muy útil en desarrollo).

Estas operaciones permiten gestionar la evolución del esquema de la base de datos de forma controlada.

{{< /definicion >}}

{{< line >}}

### Las migraciones

Las migraciones se guardan en: {{<color>}}database/migrations{{</color>}}

Laravel registra qué migraciones se han ejecutado en una tabla interna llamada {{<color>}}migrations{{</color>}}


Aunque es algo que no vamos a usar, es interesante saber que  el proyecto guarda el **_histórico_** de cambios en Git y la base de datos guarda el “estado aplicado” en la tabla migrations. Podríamos deshacer los 3 ultimos cambios por ejemplo o el último o deshacer todo, como veremos a continuación

---

#### Acciones concretas

1. Crear migración (nombra el cambio)
2. Programar up() y down() (reversible)
3. Ejecutar migrate (aplica en tu DB local)
4. Subir cambios a Git
5. En otro entorno (otro compañero / servidor), ejecutar migrate y obtener el mismo esquema

---

{{<color>}}1.- Crear migraciones desde consola (Artisan){{</color>}}

{{< highlight php tabla_alumnos "linenos=table, hl_lines=" >}}
    php artisan make:migration create_students_table
{{< /highlight>}}


{{<color>}}2.- Modificar una tabla existente{{</color>}}
{{< highlight php tabla_alumnos "linenos=table, hl_lines=" >}}
php artisan make:migration add_phone_to_students_table
{{< /highlight>}}


 {{<color>}}3.-Crear migración y modelo a la vez (opcional, pero común){{</color>}}
Aunque no hemos visto qué es un modelo, lo vamos a necesitar para interactuar con la base de datos desde nuestra aplicación
Lo estudiamos en el tema de modelos
{{< highlight php tabla_alumnos "linenos=table, hl_lines=" >}}
php artisan make:model Student -m
{{< /highlight>}}


{{< color >}}Convención de nombres{{< /color >}}:
* create_x_table para crear
* add_y_to_x_table para añadir
* remove_y_from_x_table para eliminar
* update_x_table o change_y_in_x_table para cambios complejos

---

#### Estructura de una migración

Una migración típica tiene esta forma:

{{< highlight php "linenos=table" >}}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
{{< /highlight >}}

{{< color >}}Puntos importantes{{< /color >}}:

- Schema::create define una tabla desde cero
- Blueprint $table define columnas, índices, etc.
- down() revierte de forma segura con dropIfExists
- up() Ejecuta la migración creando los elementos especificados (crear o modificar)

---

####  Ejecutar migraciones
Las principales acciones que vamos a realizar con las migraciones son las siguientes

{{< color >}}Ejecutar todas las migraciones pendientes{{< /color >}}
{{< highlight php tabla_alumnos "linenos=table, hl_lines=" >}}
php artisan migrate
{{< /highlight>}}

{{< color >}}Consultar el estado de las migraciones{{< /color >}}
{{< highlight bash "linenos=table" >}}
php artisan migrate:status
{{< /highlight >}}

{{< color >}}Deshacer última acción (última migración  ejecutado){{< /color >}}
{{< highlight bash "linenos=table" >}}
php artisan migrate:rollback
{{< /highlight >}}

{{< color >}}Deshacer las últimas N migraciones ejecutadas{{< /color >}}
{{< highlight bash "linenos=table" >}}
php artisan migrate:rollback --step=3
{{< /highlight >}}

{{< color >}}Reiniciar el esquema completo (rollback total + migrate){{< /color >}}
{{< highlight bash "linenos=table" >}}
php artisan migrate:refresh
{{< /highlight >}}

{{< color >}}Borrar todas las tablas y volverlo a crear (muy usado en desarrollo){{< /color >}}
Esta acción la haremos con mucha frecuencia
{{< highlight bash "linenos=table" >}}
php artisan migrate:fresh
{{< /highlight >}}

{{< color >}}Borrar todo y además ejecutar los seeders{{< /color >}}
{{< highlight bash "linenos=table" >}}
php artisan migrate:fresh --seed
{{< /highlight >}}
{{< color >}}Criterio profesional{{< /color >}}:
- fresh es ideal para desarrollo local cuando puedes perder datos
- en producción casi siempre se usa migrate (nunca fresh)

---

#### 4.6. Tipos de columnas más habituales (Laravel 12)


{{<color>}}Identificadores y timestamps{{</color>}}
- id(): BIGINT autoincremental
- timestamps(): created_at / updated_at
- softDeletes(): deleted_at para borrado lógico

{{< highlight php "linenos=table" >}}
Schema::create('students', function (Blueprint $table) {
    $table->id();
    $table->timestamps();
    $table->softDeletes();
});
{{< /highlight >}}

{{<color>}}Strings, texto y números{{</color>}}
- string: VARCHAR(255) por defecto
- text: TEXT
- integer, bigInteger
- decimal(8,2) para importes
- boolean

{{< highlight php "linenos=table" >}}
Schema::table('students', function (Blueprint $table) {
    $table->string('name', 120);
    $table->text('notes')->nullable();
    $table->integer('age')->nullable();
    $table->decimal('tuition_fee', 8, 2)->default(0);
    $table->boolean('active')->default(true);
});
{{< /highlight >}}

{{<color>}}Fechas{{</color>}}
- date, time, dateTime
- timestamp

{{< highlight php "linenos=table" >}}
Schema::table('students', function (Blueprint $table) {
    $table->date('birth_date')->nullable();
    $table->dateTime('last_login_at')->nullable();
});
{{< /highlight >}}

---

#### Índices y restricciones: performance + integridad
El tema de índices es muy importante y lo tenemos que tener muy claro

{{<color>}}Índices y únicos{{</color>}}
- index() acelera búsquedas
- unique() evita duplicados

{{< highlight php "linenos=table" >}}
Schema::table('students', function (Blueprint $table) {
    $table->string('dni', 12)->unique();
    $table->string('city')->index();
});
{{< /highlight >}}

{{< color >}}Regla práctica{{< /color >}}:
- index: para columnas que se filtran mucho (where)
- unique: para “identificadores” (email, dni, código, etc.)

---

[//]: # (#### 4.8. Relaciones y claves foráneas &#40;foreign keys&#41;)

[//]: # (#### Caso real: students pertenece a courses)

[//]: # ()
[//]: # (1&#41; Crear tabla courses  )

[//]: # (2&#41; Crear students con course_id y foreign key)

[//]: # ()
[//]: # ({{< highlight php "linenos=table" >}})

[//]: # (Schema::create&#40;'courses', function &#40;Blueprint $table&#41; {)

[//]: # (    $table->id&#40;&#41;;)

[//]: # (    $table->string&#40;'name'&#41;;)

[//]: # (    $table->timestamps&#40;&#41;;)

[//]: # (}&#41;;)

[//]: # ({{< /highlight >}})

[//]: # ()
[//]: # ({{< highlight php "linenos=table" >}})

[//]: # (Schema::create&#40;'students', function &#40;Blueprint $table&#41; {)

[//]: # (    $table->id&#40;&#41;;)

[//]: # ()
[//]: # (    $table->foreignId&#40;'course_id'&#41;)

[//]: # (        ->constrained&#40;&#41;)

[//]: # (        ->cascadeOnUpdate&#40;&#41;)

[//]: # (        ->restrictOnDelete&#40;&#41;;)

[//]: # ()
[//]: # (    $table->string&#40;'name'&#41;;)

[//]: # (    $table->string&#40;'email'&#41;->unique&#40;&#41;;)

[//]: # (    $table->timestamps&#40;&#41;;)

[//]: # (}&#41;;)

[//]: # ({{< /highlight >}})

[//]: # ()
[//]: # (Interpretación técnica:)

[//]: # (- foreignId&#40;'course_id'&#41; crea un BIGINT UNSIGNED)

[//]: # (- constrained&#40;&#41; asume tabla courses e id &#40;convención&#41;)

[//]: # (- cascadeOnUpdate: si cambia el id del curso, se propaga &#40;poco común en ids, pero correcto&#41;)

[//]: # (- restrictOnDelete: evita borrar un curso si hay alumnos asociados)

[//]: # ()
[//]: # ({{< color >}}Decisión de arquitectura{{< /color >}}:)

[//]: # (- cascadeOnDelete: borra alumnos si borras curso &#40;riesgo de pérdida masiva&#41;)

[//]: # (- restrictOnDelete: obliga a “desasociar” antes &#40;más seguro en sistemas académicos&#41;)

[//]: # ()
[//]: # (---)

[//]: # ()
[//]: # (### 4.9. Modificar columnas: add, drop, rename, change)

[//]: # ()
[//]: # (#### Añadir una columna)

[//]: # ({{< highlight php "linenos=table" >}})

[//]: # (Schema::table&#40;'students', function &#40;Blueprint $table&#41; {)

[//]: # (    $table->string&#40;'phone', 20&#41;->nullable&#40;&#41;->after&#40;'email'&#41;;)

[//]: # (}&#41;;)

[//]: # ({{< /highlight >}})

[//]: # ()
[//]: # (#### Eliminar una columna)

[//]: # ({{< highlight php "linenos=table" >}})

[//]: # (Schema::table&#40;'students', function &#40;Blueprint $table&#41; {)

[//]: # (    $table->dropColumn&#40;'phone'&#41;;)

[//]: # (}&#41;;)

[//]: # ({{< /highlight >}})

[//]: # ()
[//]: # (#### Renombrar una columna &#40;refactor&#41;)

[//]: # ({{< highlight php "linenos=table" >}})

[//]: # (Schema::table&#40;'students', function &#40;Blueprint $table&#41; {)

[//]: # (    $table->renameColumn&#40;'name', 'full_name'&#41;;)

[//]: # (}&#41;;)

[//]: # ({{< /highlight >}})

[//]: # ()
[//]: # ({{< color >}}Nota importante{{< /color >}}:)

[//]: # (Renombrar o cambiar tipos puede depender del driver &#40;MySQL/PostgreSQL&#41; y de capacidades internas. En entornos de equipo, prueba siempre la migración en una base real del mismo tipo que producción.)

[//]: # ()
[//]: # (---)

[//]: # ()
[//]: # (### 4.10. Down&#40;&#41; reversible: requisito profesional)

[//]: # ()
[//]: # (Si tu up&#40;&#41; hace “add column”, tu down&#40;&#41; debería “drop column”.  )

[//]: # (Si tu up&#40;&#41; hace “create table”, tu down&#40;&#41; debería “drop table”.)

[//]: # ()
[//]: # (Ejemplo completo add + rollback:)

[//]: # ()
[//]: # ({{< highlight php "linenos=table" >}})

[//]: # (return new class extends Migration)

[//]: # ({)

[//]: # (    public function up&#40;&#41;: void)

[//]: # (    {)

[//]: # (        Schema::table&#40;'students', function &#40;Blueprint $table&#41; {)

[//]: # (            $table->string&#40;'phone', 20&#41;->nullable&#40;&#41;->after&#40;'email'&#41;;)

[//]: # (        }&#41;;)

[//]: # (    })

[//]: # ()
[//]: # (    public function down&#40;&#41;: void)

[//]: # (    {)

[//]: # (        Schema::table&#40;'students', function &#40;Blueprint $table&#41; {)

[//]: # (            $table->dropColumn&#40;'phone'&#41;;)

[//]: # (        }&#41;;)

[//]: # (    })

[//]: # (};)

[//]: # ({{< /highlight >}})

[//]: # ()
[//]: # ({{< color >}}Regla de oro{{< /color >}}:)

[//]: # (Si no puedes escribir un down&#40;&#41; seguro, revisa el diseño del cambio &#40;o documenta claramente el riesgo&#41;.)

[//]: # ()
[//]: # ({{< line >}})

[//]: # ()
[//]: # (## 5. Esquemas o listas estructuradas)

[//]: # ()
[//]: # (### 5.1. Mapa mental mínimo)

[//]: # ()
[//]: # (- Migraciones)

[//]: # (  - up&#40;&#41;: aplicar cambios)

[//]: # (  - down&#40;&#41;: revertir cambios)

[//]: # (  - Artisan)

[//]: # (    - make:migration)

[//]: # (    - migrate)

[//]: # (    - migrate:status)

[//]: # (    - rollback)

[//]: # (    - refresh / fresh)

[//]: # (  - Schema Builder)

[//]: # (    - create / table / dropIfExists)

[//]: # (    - columnas)

[//]: # (    - índices)

[//]: # (    - claves foráneas)

[//]: # ()
[//]: # (### 5.2. Checklist de una migración bien hecha)

[//]: # ()
[//]: # (- Nombre describe el cambio)

[//]: # (- up&#40;&#41; y down&#40;&#41; coherentes)

[//]: # (- Columnas con nullability y defaults definidos)

[//]: # (- Índices donde toca)

[//]: # (- Foreign keys con estrategia de borrado pensada)

[//]: # (- Probada en local antes de commit)

[//]: # ()
[//]: # ({{< line >}})

[//]: # ()
[//]: # (## 6. Ejemplos prácticos reales &#40;Laravel 12 + Blade&#41;)

[//]: # ()
[//]: # (### 6.1. Caso: módulo DWES “Gestión de Alumnos”)

[//]: # ()
[//]: # (Objetivo de datos:)

[//]: # (- Tabla students con nombre, email único, timestamps)

[//]: # (- Tabla courses y relación)

[//]: # (- Campo opcional phone)

[//]: # (- Soft deletes para no perder histórico)

[//]: # ()
[//]: # (Migración students:)

[//]: # ()
[//]: # ({{< highlight php "linenos=table" >}})

[//]: # (Schema::create&#40;'students', function &#40;Blueprint $table&#41; {)

[//]: # (    $table->id&#40;&#41;;)

[//]: # ()
[//]: # (    $table->foreignId&#40;'course_id'&#41;)

[//]: # (        ->constrained&#40;&#41;)

[//]: # (        ->restrictOnDelete&#40;&#41;;)

[//]: # ()
[//]: # (    $table->string&#40;'name', 120&#41;;)

[//]: # (    $table->string&#40;'email'&#41;->unique&#40;&#41;;)

[//]: # (    $table->string&#40;'phone', 20&#41;->nullable&#40;&#41;;)

[//]: # ()
[//]: # (    $table->timestamps&#40;&#41;;)

[//]: # (    $table->softDeletes&#40;&#41;;)

[//]: # (}&#41;;)

[//]: # ({{< /highlight >}})

[//]: # ()
[//]: # (### 6.2. Conexión con Blade &#40;contexto de uso&#41;)

[//]: # ()
[//]: # (Las migraciones no “pintan” nada en Blade, pero habilitan el flujo:)

[//]: # (- migración define tabla/columnas)

[//]: # (- modelo consulta)

[//]: # (- controlador pasa datos a Blade)

[//]: # ()
[//]: # (Ejemplo de listado en Blade &#40;solo contexto&#41;:)

[//]: # ()
[//]: # ({{< highlight blade "linenos=table" >}})

[//]: # (<table>)

[//]: # (    <thead>)

[//]: # (        <tr>)

[//]: # (            <th>Nombre</th>)

[//]: # (            <th>Email</th>)

[//]: # (            <th>Curso</th>)

[//]: # (        </tr>)

[//]: # (    </thead>)

[//]: # (    <tbody>)

[//]: # (        @foreach&#40;$students as $student&#41;)

[//]: # (            <tr>)

[//]: # (                <td>{{ $student->name }}</td>)

[//]: # (                <td>{{ $student->email }}</td>)

[//]: # (                <td>{{ $student->course->name }}</td>)

[//]: # (            </tr>)

[//]: # (        @endforeach)

[//]: # (    </tbody>)

[//]: # (</table>)

[//]: # ({{< /highlight >}})

[//]: # ()
[//]: # ({{< color >}}Punto arquitectónico{{< /color >}}:)

[//]: # (Una migración bien diseñada evita “parches” posteriores en el código &#40;por ejemplo, emails duplicados o course_id sin integridad&#41;.)

[//]: # ()
[//]: # ({{< line >}})

[//]: # ()
[//]: # (## 7. Errores comunes)

[//]: # ()
[//]: # (1&#41; **Olvidar el down&#40;&#41; o hacerlo incorrecto**  )

[//]: # (Consecuencia: rollbacks fallan, pipelines de despliegue se complican.)

[//]: # ()
[//]: # (2&#41; **Cambiar una migración ya ejecutada y commiteada**  )

[//]: # (Consecuencia: tu entorno y el de tus compañeros divergen.  )

[//]: # (Solución: crea una migración nueva que “corrija” lo anterior.)

[//]: # ()
[//]: # (3&#41; **Crear tablas en orden incorrecto &#40;foreign keys&#41;**  )

[//]: # (Si students referencia courses, courses debe existir antes.)

[//]: # ()
[//]: # (4&#41; **No definir nullability/defaults**  )

[//]: # (Campos que deberían ser opcionales causan errores al insertar.)

[//]: # ()
[//]: # (5&#41; **Usar fresh en entornos con datos reales**  )

[//]: # (Pérdida de información.)

[//]: # ()
[//]: # (6&#41; **No indexar columnas muy consultadas**  )

[//]: # (Rendimiento pobre en listados y filtros.)

[//]: # ()
[//]: # ({{< line >}})

[//]: # ()
[//]: # (## 8. Buenas prácticas profesionales)

[//]: # ()
[//]: # (- {{< color >}}Migraciones inmutables{{< /color >}}: una vez compartidas, no se “reescriben”; se añaden nuevas migraciones.)

[//]: # (- Nombres descriptivos y coherentes con el cambio.)

[//]: # (- down&#40;&#41; siempre que sea razonablemente posible.)

[//]: # (- Definir constraints &#40;unique, foreign keys&#41; para reforzar integridad.)

[//]: # (- Pensar estrategia de delete:)

[//]: # (  - restrictOnDelete para evitar borrados accidentales)

[//]: # (  - cascadeOnDelete solo si el dominio lo justifica)

[//]: # (- Usar softDeletes cuando el negocio requiera auditoría/histórico.)

[//]: # (- En equipo: probar migrate y rollback antes de hacer push.)

[//]: # (- En despliegues: ejecutar migrate como paso controlado &#40;y con backup si es crítico&#41;.)

[//]: # ()
[//]: # ({{< line >}})

{{< summary  title="Resumen">}}

- Las migraciones nos van a permitir crear la base de datos y gestionarla 
- Permiten versionar el esquema de base de datos como código.
- Se crean con make:migration y se aplican con migrate.
- up() aplica cambios; down() los revierte: migraciones reversibles son más profesionales.
- Schema Builder define columnas, índices y claves foráneas de forma expresiva.
- Evita editar migraciones ya ejecutadas: crea nuevas migraciones para corregir/refactorizar.
- En producción, normalmente se usa migrate (no fresh).

{{< /summary >}}

{{< line >}}

## referencias 

- {{< web title="Migraciones y Schema Builder" img="migration.jpeg">}}Documentación oficial de Laravel: Migrations / Schema Builder{{< /web >}}
- {{< web title="Comandos Artisan para migraciones" img="artisan_migration.png">}}Artisan: comandos de migración (migrate, rollback, fresh, status){{< /web >}}

