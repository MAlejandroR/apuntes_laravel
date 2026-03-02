---
title: "Eloquent"
date: 2023-04-08T18:21:47+02:00
draft: true
weight: 10
icon: fa-solid fa-database
---
# Eloquent ORM en Laravel

Eloquent ORM en Laravel ofrece una variedad de métodos para interactuar con la base de datos de forma eficiente y elegante. Aquí tienes un resumen escueto de algunos de los métodos más comunes que puedes usar para consultas, inserciones, actualizaciones y borrados:
## Métodos para Consultas
- `all()`: Recupera una **colección** con todos los registros del modelo. Cada ítem es un objeto del modelo ya “hidratado” (con datos y métodos listos para usar).
- `find($id)`: Encuentra un registro por su clave primaria.
- `where('column', 'value')`: Aplica una condición SQL WHERE.
- `whereNull('column')`: Filtra registros donde la columna es NULL.
- `whereNotNull('column')`: Filtra registros donde la columna NO es NULL.
- `orderBy('column', 'direction')`: Ordena los resultados.
- `take($limit)`: Limita el número de resultados.
- `get()`: Ejecuta la consulta y devuelve una **colección** de modelos completamente hidratados (objetos Eloquent). Se aplica sobre un **Query Builder**.

{{< highlight php >}}
$users = User::where('active', 1)->get(); // Collection<User>
{{< /highlight >}}

## Métodos para Inserciones y Actualizaciones
- `save()`: Guarda un nuevo modelo o actualiza un modelo existente.
- `create($attributes)`: Crea un nuevo registro con los atributos proporcionados.
- `update($attributes)`: Actualiza un modelo con los atributos proporcionados.

## Métodos para Borrados
- `delete()`: Elimina un modelo de la base de datos.
- `destroy($ids)`: Elimina modelos por su clave primaria.
- `softDeletes()`: Hace un borrado suave (no elimina los registros de la base de datos, solo los marca como borrados).

# Métodos avanzados con relaciones
- `has('relation')`: Filtra los registros que **tienen al menos una** relación.

{{< highlight php >}}
Family::has('cycles')->get();
{{< /highlight >}}

- `whereHas('relation', function($query){ ... })`: Igual que `has()`, pero permite añadir condiciones a la relación.

{{< highlight php >}}
Family::whereHas('cycles', function($q) {
$q->where('year', 2025);
})->get();
{{< /highlight >}}

- `orWhereHas('relation', function($query){ ... })`: Igual que `whereHas()`, pero combina la condición usando **OR**.

- `doesntHave('relation')`: Filtra los registros que **no tienen** la relación.

- `whereDoesntHave('relation', function($query){ ... })`: Filtra los registros cuya relación **no cumple** la condición especificada.

>> 💡 Importante:

>> Todos estos métodos (has, whereHas, orWhereHas, doesntHave, whereDoesntHave) devuelven un devuelven un **Query Builder** y **no ejecutan la consulta**.
>> Para obtener la colección de resultados, hay que ejecutar la consulta con métodos como:

>> * get() → colección de modelos.

>> * first() → primer modelo o null.

>> * count() → número de resultados💡 Tanto `has` como `whereHas`, `orWhereHas`, `doesntHave` y `whereDoesntHave` 

 
- `with('relation')`: Carga (eager loading) la relación para evitar consultas N+1.
- `withCount('relation')`: Añade una columna extra con el número de elementos de la relación.
-  `role('nombre_rol')`: Añade a la consulta un filtro para obtener solo los modelos que tengan asignado el rol indicado. Devuelve un query builder (no una colección) sobre el que se pueden encadenar otros métodos como get(), first(), count(), etc.

💡 Ejemplo:

{{< highlight php >}}
User::role('teacher')->get(); // Colección de usuarios con el rol "teacher"
User::role('student')->count(); // Número de usuarios con el rol "student"
{{< /highlight >}}
> como el objeto que retorna es un query builder, se puede ver el código sql con el método toSql()
# Otros métodos importantes e interesantes para usar en Eloquent

Además del método `role()` que vimos antes, Eloquent tiene otros métodos muy útiles para trabajar con consultas y modelos:

| Método         | Descripción                                               | Retorno / Uso                             |
|----------------|-----------------------------------------------------------|------------------------------------------|
| `toSql()`      | Devuelve la consulta SQL generada por el query builder    | Cadena (string) con la consulta SQL      |
| `get()`        | Ejecuta la consulta y devuelve una colección de modelos   | `Collection` de modelos                   |
| `first()`      | Devuelve el primer resultado o `null`                     | Modelo o `null`                           |
| `pluck('campo')`| Obtiene una colección con los valores de un campo específico | `Collection` con valores simples         |
| `count()`      | Devuelve el número total de registros                      | Entero (int)                             |
| `paginate(n)`  | Ejecuta la consulta paginada con `n` resultados por página | `LengthAwarePaginator`                    |
| `where()`      | Añade condiciones a la consulta                            | Query Builder para encadenar más métodos |
| `with('relacion')`| Carga relaciones para evitar consultas N+1              | Query Builder con eager loading           |
| `orderBy('campo', 'asc|desc')`| Ordena los resultados                   | Query Builder                            |
| `exists()`     | Comprueba si existen registros que cumplen la consulta    | Booleano (`true` o `false`)               |
| `select('campos')` | Especifica los campos que se quieren recuperar en la consulta | Query Builder (permite encadenar más métodos) |
| `addSelect('campos')` | Añade más campos a la selección sin eliminar los anteriores  | Query Builder                            |
| `distinct()`     | Devuelve solo resultados únicos (sin duplicados)             | Query Builder                            |
| `groupBy('campo')` | Agrupa resultados según un campo                             | Query Builder                            |
| `having()`       | Condición para grupos después de un `groupBy()`              | Query Builder                            |
| `limit(n)`       | Limita el número de resultados devueltos                      | Query Builder                            |
| `offset(n)`      | Desplaza el inicio de los resultados (para paginación manual)| Query Builder                            |
| `selectRaw('expresión SQL')` | Permite usar expresiones SQL en el select              | Query Builder                            |
| `orderBy('campo', 'asc|desc')` | Ordena resultados                                  | Query Builder                            |

---



## Explicación de `withCount`

- El método `withCount` se usa para obtener el **número de registros relacionados** de forma eficiente, sin cargar toda la relación.
- El parámetro que recibe debe ser el **nombre del método de relación definido en el modelo**, no el nombre de la tabla en la base de datos.
- Por ejemplo, si en el modelo `Cycle` tienes un método llamado `enrollments()` que define la relación con las inscripciones, usarás:

{{< highlight php >}}
Cycle::withCount('enrollments')->get();
{{< /highlight >}}

- Esto añadirá automáticamente un atributo `enrollments_count` a cada instancia de `Cycle` con el número de inscripciones relacionadas.

### Alias para la columna con el conteo

- Si quieres cambiar el nombre de la columna generada por el conteo, puedes usar un alias con la sintaxis `as`:

{{< highlight php >}}
Cycle::withCount('enrollments as total_alumnos')->get();
{{< /highlight >}}

- Esto añadirá un atributo llamado `total_alumnos` en lugar de `enrollments_count`.

---

## ✅ Diferencia entre `has` y `whereHas` en Eloquent

- `has('relacion')`  
  Devuelve modelos que **tienen al menos un registro relacionado**.  
  Solo comprueba la existencia.

- `whereHas('relacion')`  
  Funciona igual que `has`, pero **permite añadir condiciones** en un callback.

Si no añades condiciones, ambos devuelven exactamente el mismo resultado.

---
# Diferencia entre `select()` y `pluck()` en Eloquent

| Método       | Qué hace                                                        | Resultado                              |
|--------------|----------------------------------------------------------------|--------------------------------------|
| `select()`   | Especifica los campos que quieres recuperar en la consulta SQL | Devuelve una colección de modelos con solo esos campos cargados (Collection de modelos) |
| `pluck()`    | Obtiene directamente los valores de un campo específico        | Devuelve una colección simple con los valores del campo seleccionado (Collection de valores) |

### ✏ Ejemplo:

{{< highlight php >}}
Family::has('specializations.users')->pluck('name');
Family::whereHas('specializations.users')->pluck('name');
{{</ highlight >}}

Ambos devuelven las familias que tienen al menos un usuario a través de sus especializaciones.

---

### 📌 Tabla resumen:

|                     | `has()`                          | `whereHas()`                                |
|---------------------|----------------------------------|---------------------------------------------|
| Comprobar existencia| ✔                                | ✔                                          |
| Añadir condiciones  | ✖                                | ✔                                          |
| Sin condiciones     | Mismo resultado                  | Mismo resultado                            |

---

✅ **Tip:**  
Usa `has` si solo necesitas saber si existen registros relacionados.  
Usa `whereHas` si además necesitas filtrar los registros relacionados por alguna condición.


## Métodos para transformación y extracción de datos
- `pluck('column')`: Obtiene directamente los valores de una columna como colección.
- `value('column')`: Obtiene el valor de la columna en el primer registro.
- `toArray()`: Convierte el resultado a array.
- `toJson()`: Convierte el resultado a JSON.
- `chunk($cantidad, $callback)`: Procesa los resultados por partes.
- `dd()`: Dump & Die, muestra el contenido y detiene la ejecución.
- `dump()`: Igual que dd pero sin detener la ejecución.

## Métodos para Consultas
- `all()`: Recupera todas las filas de la tabla.
- `find($id)`: Encuentra un registro por su clave primaria.
- `where('column', 'value')`: Aplica una condición SQL WHERE.
- `whereNull('column')`: Filtra registros donde la columna es NULL.
- `whereNotNull('column')`: Filtra registros donde la columna NO es NULL.
- `orderBy('column', 'direction')`: Ordena los resultados.
- `take($limit)`: Limita el número de resultados.
- `get()`: Obtiene los resultados de una consulta.

## Métodos para Inserciones y Actualizaciones
- `save()`: Guarda un nuevo modelo o actualiza un modelo existente.
- `create($attributes)`: Crea un nuevo registro con los atributos proporcionados.
- `update($attributes)`: Actualiza un modelo con los atributos proporcionados.

## Ejemplos

{{< highlight php >}}
User::pluck('email');
{{</ highlight >}}

{{< highlight php >}}
User::whereHas('roles', fn($q) => $q->where('name', 'admin'))->exists();
{{</ highlight >}}

{{< highlight php >}}
User::count();
{{</ highlight >}}

{{< highlight php >}}
User::with('specialization.family')->get();
{{</ highlight >}}

{{< highlight php >}}
User::chunk(100, function($users) {
foreach ($users as $user) {
// procesar
}
});
{{</ highlight >}}

{{< highlight php >}}
$totalSalaries = User::sum('salary');
{{</ highlight >}}


## Otros Métodos Útiles
- `firstOrCreate($attributes)`: Obtiene el primer registro encontrado o crea uno nuevo.
- `findOrFail($id)`: Encuentra un registro por su clave primaria o falla.
- `whereHas('relation', $callback)`: Aplica condiciones a las consultas de relaciones.

Este resumen proporciona una vista rápida de los métodos más usados en Eloquent para realizar operaciones comunes de base de datos en Laravel. Estos métodos facilitan la realización de consultas, inserciones, actualizaciones y borrados, así como el manejo de relaciones entre modelos, de una manera más legible y menos propensa a errores en comparación con las consultas SQL crudas.

## 🔗 Campos foráneos y claves externas en Laravel

En migraciones de Laravel, podemos crear claves foráneas (foreign keys) de dos formas:

- Usando `constrained()`:

{{< highlight php "linenos=table, hl_lines=1" >}}
$table->foreignId('specialization_id')
->nullable()
->constrained('specializations')
->onDelete('cascade');
{{% / highlight %}}

✅ Esto:
- Crea la columna `specialization_id` como nullable.
- Crea la foreign key que referencia a `specializations(id)`.
- Aplica "on delete cascade" para borrar en cascada.

⚠ **Importante:** el método `nullable()` debe ir *antes* de `constrained()`.  
Si escribes `->constrained()->nullable()`, el campo se crea como NOT NULL.

---

- Sin usar `constrained()`:

{{< highlight php "linenos=table, hl_lines=1" >}}
$table->foreignId('specialization_id')->nullable();
$table->foreign('specialization_id')
->references('id')
->on('specializations')
->onDelete('cascade');
{{% / highlight %}}

✅ Esto:
- Separa la definición de la columna y la clave foránea.
- Permite más control (por ejemplo, si usamos nombres de columnas o tablas diferentes).

---

✅ **Resumen rápido**:
- `constrained()` → crea la foreign key automáticamente.
- `nullable()` debe ir antes de `constrained()`.
- `onDelete('cascade')` solo funciona si existe la foreign key.
- Si no usas `constrained()`, debes crear la foreign key manualmente con `foreign()`.

## 🔗 ¿Cuándo pasar el nombre de la tabla a `constrained()`?

- Si usas una clave foránea que sigue la convención:
  - Nombre de columna: `specialization_id`
  - Nombre de tabla: `specializations`

Puedes usar directamente:

{{< highlight php "linenos=table" >}}
$table->foreignId('specialization_id')
->nullable()
->constrained()
->onDelete('cascade');
{{% / highlight %}}

Laravel deduce automáticamente que la clave apunta a la tabla `specializations`.

---

- Si la tabla tiene un nombre distinto, o la columna no sigue la convención:
  Debes pasar el nombre de la tabla como parámetro:

{{< highlight php "linenos=table" >}}
$table->foreignId('spec_id')
->nullable()
->constrained('specializations')
->onDelete('cascade');
{{% / highlight %}}
> Cuando se usa el método constrained() en Laravel, si no le pasas ningún parámetro, por defecto Laravel asume que la tabla relacionada es el plural del nombre de la columna sin el sufijo _id.
# 🧩 Relaciones muchos a muchos (M:N) en Laravel

En Eloquent, las relaciones muchos a muchos permiten que los registros de un modelo estén relacionados con muchos registros de otro modelo, y viceversa.  
Por ejemplo: un usuario puede estar matriculado en varios ciclos, y un ciclo puede tener muchos usuarios.

---

## 🛠️ Métodos para definir relaciones entre modelos en Laravel

Estos métodos se incluyen en los modelos:

- `hasMany(Model::class, 'foreign_key')`  
  Relación **uno a muchos**.  
  Ejemplo: una familia tiene muchas especializaciones.

- `belongsTo(Model::class, 'foreign_key')`  
  Relación **muchos a uno**.  
  Se usa cuando el modelo actual tiene la clave foránea.  
  Ejemplo: un usuario pertenece a una especialización.

- `hasOne(Model::class, 'foreign_key')`  
  Relación **uno a uno**.  
  Se usa cuando el modelo actual NO tiene la clave foránea.

- `belongsToMany(Model::class)`  
  Relación **muchos a muchos**, usando una tabla pivote.  
  Ejemplo: un usuario está matriculado en muchos ciclos, y un ciclo tiene muchos usuarios.

---

## ✅ Cómo definir una relación muchos a muchos

Se definen con `belongsToMany` en ambos modelos implicados:

{{< highlight php "linenos=table" >}}
// En User.php
public function cycles()
{
return $this->belongsToMany(Cycle::class);
}

// En Cycle.php
public function users()
{
return $this->belongsToMany(User::class);
}
{{< /highlight >}}

---
## 📌 Tabla pivote: nombre y convención

Laravel espera que la tabla pivote se llame con los **nombres de los modelos en singular y en orden alfabético**.  
Esto significa que debes tomar los nombres de los modelos, ponerlos en **singular**, ordenarlos **alfabéticamente** y unirlos con guion bajo (`_`).

📘 Por ejemplo, para los modelos `User` y `Cycle`:

- 🔤 Orden alfabético: `Cycle`, `User`
- 🧩 Nombre correcto de la tabla pivote: `cycle_user`

✅ Correcto:
- `cycle_user`

⛔️ Incorrecto:
- `user_cycle` (no respeta el orden alfabético)
- `users_cycles` (en plural)
- `cycleusers` (sin guion bajo)

👉 Laravel utilizará este nombre por convención si no se especifica otro en la relación. Si tu tabla tiene un nombre diferente, deberás indicarlo manualmente:

{{< highlight php >}}
return $this->belongsToMany(Cycle::class, 'nombre_personalizado');
{{< /highlight >}}

## 🧱 Cuándo crear la tabla pivote explícitamente

Debes **crear manualmente la tabla pivote** si:

- Quieres añadir **atributos extra** a la relación (por ejemplo, `year` de matrícula).
- Quieres usar `withPivot()` para acceder a esos atributos.
- Quieres usar un modelo intermedio (por ejemplo, `Enrollment`).

---

## 📄 Ejemplo de migración de tabla pivote con columna extra

{{< highlight php "linenos=table" >}}
Schema::create('cycle_user', function (Blueprint $table) {
$table->id();
$table->foreignId('user_id')->constrained()->onDelete('cascade');
$table->foreignId('cycle_id')->constrained()->onDelete('cascade');
$table->year('year'); // ➕ Atributo adicional
$table->timestamps();
});
{{< /highlight >}}

---

## 🧩 Acceder a los campos adicionales de la tabla pivote

Usando `pivot`:

{{< highlight php >}}
$user = User::find(1);
foreach ($user->cycles as $cycle) {
echo $cycle->pivot->year;
}
{{< /highlight >}}

Para que funcione correctamente, debes indicarlo en el modelo:

{{< highlight php >}}
// En User.php
public function cycles()
{
return $this->belongsToMany(Cycle::class)->withPivot('year');
}
{{< /highlight >}}

---

## 🤔 Diferencia entre `hasMany()` y `belongsToMany()`

| Relación            | Descripción                                                                 |
|---------------------|-----------------------------------------------------------------------------|
| `hasMany()`         | Uno a muchos. El modelo actual tiene muchos del otro modelo.                |
| `belongsToMany()`   | Muchos a muchos. Hay una **tabla intermedia** y la relación va en ambos lados.|

**Ejemplo práctico**:

- Una **familia** tiene muchas **especializaciones** → `hasMany()`
- Un **usuario** está en muchos **ciclos**, y cada **ciclo** tiene muchos **usuarios** → `belongsToMany()`

---

## 🧩 Resumen visual

```php
// Uno a muchos:
Family          ---<     Specialization
hasMany()             belongsTo()

// Muchos a muchos:
User           >---<     Cycle
belongsToMany()    belongsToMany()

// Uno a uno:
User          ---       Profile
hasOne()           belongsTo()

## ✏ Métodos útiles

- `attach($id, ['extra'])`: Relaciona un registro y añade datos extra.
- `detach($id)`: Quita la relación.
- `sync([id1, id2])`: Sincroniza relaciones.
- `updateExistingPivot($id, ['extra'])`: Actualiza datos de la tabla pivote.

---

✅ **Resumen rápido**:
- Relación muchos a muchos → `belongsToMany`.
- Tabla pivote automática (ejemplo: `cycle_user`).
- Si necesitas columnas extra → crear migración y (opcional) modelo Pivot.
- Acceder a las columnas extra → `$model->pivot->campo`.

## 📊 Tabla resumen

|                          | Sin datos extra                        | Con datos extra en pivote                |
|------------------------|----------------------------------------|------------------------------------------|
| Migración              | Laravel la crea si usas `belongsToMany`| Necesitas crearla manualmente            |
| Modelo pivote          | No necesario                          | Recomendado (`CycleUser`)                |
| Acceso a datos pivote  | `$model->relation`                    | `$model->relation` + `$model->pivot->campo` |
| Métodos                | `attach()`, `detach()`, `sync()`      | Igual, pero pasando datos extra en array |

---

## ✏ Ejemplo visual

Un **usuario** puede estar matriculado en varios **ciclos**:
- Ciclo A (año 2023)
- Ciclo B (año 2024)

En la tabla pivote `cycle_user` guardamos:

| user_id | cycle_id | year |
|--------|----------|------|
| 1      | 5        | 2023 |
| 1      | 6        | 2024 |

---

## 🔧 Ejemplo en código

{{< highlight php >}}
// Obtener los ciclos de un usuario y mostrar el año de matriculación
$user = User::find(1);

foreach ($user->cycles as $cycle) {
echo $cycle->name . ' - Año: ' . $cycle->pivot->year;
}
{{</ highlight >}}

---

## 📐 Diagrama (en texto)

```text
User                Cycle
 |                    |
 | <--- cycle_user -->|
 |                    |
## Obteniendo sentencia SQL a partir de Eloquent o Builder Class

En Laravel es habitual querer ver la **sentencia SQL** que genera una consulta Eloquent o un Query Builder.  
Ten en cuenta que `toSql()` devuelve la consulta con **placeholders** (`?`) — los valores reales están en `getBindings()`.

---

### 1) Diferencia esencial
- `all()` y `get()` **ejecutan** la consulta y devuelven una `Collection`.  
- `toSql()` **no ejecuta** la consulta: solo funciona sobre un Query Builder y devuelve la cadena SQL con `?`.

{{< highlight php >}}
// Incorrecto: ya es una Collection
User::all()->toSql(); // ❌ No funciona

// Correcto: obtenemos la SQL sin ejecutar
User::query()->toSql(); // ✅ "select * from `users`"
{{< /highlight >}}

---

### 2) Ejemplo con bindings (valores)
{{< highlight php >}}
$query = User::where('email', 'like', '%@gmail.com%');
$sql = $query->toSql();          // "select * from `users` where `email` like ?"
$bindings = $query->getBindings(); // ["%@gmail.com%"]

dd($sql, $bindings);
{{< /highlight >}}

---

### 3) Ejemplo con scope (p.ej. Spatie `role()`)
Las macros/scopes devuelven un Builder, así que `toSql()` funciona:

{{< highlight php >}}
// Devuelve la SQL (con subconsultas si aplica) y los bindings
$query = User::role('student');
dd($query->toSql(), $query->getBindings());
{{< /highlight >}}

---

### 4) Ejemplo con joins / group by / agregados
{{< highlight php >}}
use Illuminate\Support\Facades\DB;

$query = DB::table('users')
    ->join('enrollments', 'users.id', '=', 'enrollments.user_id')
    ->join('cycles', 'cycles.id', '=', 'enrollments.cycle_id')
    ->select('cycles.name', DB::raw('count(users.id) as total_students'))
    ->groupBy('cycles.name');

dd($query->toSql(), $query->getBindings());
{{< /highlight >}}

---

### 5) `withCount()` y subqueries (ejemplo práctico para tus ciclos)
Si quieres ver la SQL generada por un `withCount()` con condiciones:

{{< highlight php >}}
$year = 2025;

$query = \App\Models\Cycle::withCount([
    'users as students_count' => function ($q) use ($year) {
        $q->whereHas('roles', fn($r) => $r->where('name', 'student'))
          ->wherePivot('year', $year);
    }
]);

// Ver la SQL del builder principal (incluye subqueries en SELECT)
dd($query->toSql(), $query->getBindings());
{{< /highlight >}}

---

### 6) Ver la SQL con los valores interpolados (para depuración)
Laravel devuelve `?` en la SQL; para ver la consulta con los valores insertados puedes interpolarlos **con cuidado**:

#### Opción A — helper `str_replace_array` (Laravel)
{{< highlight php >}}
$sqlWithBindings = str_replace_array('?', $query->getBindings(), $query->toSql());
dd($sqlWithBindings);
{{< /highlight >}}

> ⚠️ `str_replace_array` reemplaza `?` por los bindings en orden. Si los bindings requieren comillas o escape, tendrás que añadirlas.

#### Opción B — función segura usando reemplazos uno a uno
{{< highlight php >}}
function interpolateQuery($query) {
    $sql = $query->toSql();
    foreach ($query->getBindings() as $binding) {
        $value = is_numeric($binding) ? $binding : "'".addslashes($binding)."'";
        $sql = preg_replace('/\?/', $value, $sql, 1);
    }
    return $sql;
}

$prettySql = interpolateQuery($query);
dd($prettySql);
{{< /highlight >}}

> Nota: esto es para depuración. No uses interpolación para ejecutar consultas (riesgo SQL injection si manipulas manualmente).

---

### 7) Escuchar y registrar todas las consultas (útil en runtime)
#### Usando `DB::listen()` — ideal para logging o debugging en runtime:
{{< highlight php >}}
\DB::listen(function ($query) {
    \Log::info('SQL: '.$query->sql, $query->bindings);
});
{{< /highlight >}}

#### Usando Query Log temporal:
{{< highlight php >}}
\DB::enableQueryLog();

// Ejecuta tus consultas aquí
User::role('student')->get();

$log = \DB::getQueryLog();
dd($log);
{{< /highlight >}}

---

### 8) Ejemplos en Tinker
{{< highlight php >}} 
# En Tinker
>>> User::query()->toSql();
=> "select * from `users`"

>>> $q = User::where('id', '>', 10);
>>> $q->toSql();
=> "select * from `users` where `id` > ?"
>>> $q->getBindings();
=> [10]
{{< /highlight >}}

---

### 9) Consejos y buenas prácticas
- Usa `toSql()` **antes** de ejecutar la consulta.  
- Para ver valores reales, combina `toSql()` + `getBindings()` o usa una función de interpolación solo para **depuración**.  
- Para debugging en desarrollo, `DB::listen()` o Laravel Telescope/Debugbar son soluciones más potentes.  
- Evita interpolar manualmente consultas para volver a ejecutarlas (riesgo de seguridad).  
- `toSql()` no muestra cambios hechos por middlewares o por el driver (p.ej. fechas automáticas), pero es suficiente para entender la estructura de la consulta generada por Eloquent/Builder.

---

### Ejemplos

#### Usando Query Builder
{{< highlight php >}}
$query = DB::table('users')->where('active', 1);

$sql = $query->toSql(); 
// SELECT * FROM `users` WHERE `active` = ?

$bindings = $query->getBindings(); 
// [1]
{{< /highlight >}}

#### Usando Eloquent
{{< highlight php >}}
$query = User::where('active', 1);

$sql = $query->toSql(); 
// SELECT * FROM `users` WHERE `active` = ?

$bindings = $query->getBindings(); 
// [1]
{{< /highlight >}}

#### Convertir a SQL + valores enlazados (debug rápido)
Puedes combinar `toSql()` y `getBindings()` para imprimir la consulta completa:
{{< highlight php >}}
$query = User::where('active', 1);

$sql = vsprintf(str_replace('?', "'%s'", $query->toSql()), $query->getBindings());

echo $sql;
// SELECT * FROM `users` WHERE `active` = '1'
{{< /highlight >}}

#### Por qué `User::all()->toSql()` no funciona
El método `all()` ejecuta la consulta inmediatamente y devuelve una colección de resultados, por lo que ya no es una instancia de *builder*.  
Para obtener la SQL antes de ejecutar, usa:
{{< highlight php >}}
User::query()->toSql();
{{< /highlight >}}
o bien:
{{< highlight php >}}
User::select('*')->toSql();
{{< /highlight >}}
### One-liner para ver SQL de cualquier consulta Eloquent
{{< highlight php >}}
dd(User::where('active', 1)->toSql(), User::where('active', 1)->getBindings());
{{< /highlight >}}

