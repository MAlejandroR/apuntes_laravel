---
title: "Eloquent"
date: 2023-04-08T18:21:47+02:00
draft: true
weight: 10
icon: fa-solid fa-database
---

## Eloquent ORM en Laravel

Eloquent ORM en Laravel ofrece una variedad de métodos para interactuar con la base de datos
de forma eficiente, expresiva y orientada a objetos.  
Permite **construir consultas SQL**, **ejecutarlas**, y **trabajar con los resultados**
como objetos PHP (modelos y colecciones).

---

###  Idea fundamental de Eloquent (clave para entenderlo)

Mientras **encadenas métodos**, Eloquent **NO ejecuta la consulta**.  
Solo estás **construyendo una consulta SQL**.

La consulta **solo se ejecuta** cuando llamas a un **método terminal**.

El objeto intermedio que representa una consulta sin ejecutar es el:

**Query Builder**

---

###  Qué puede devolver Eloquent (esquema conceptual)

Eloquent **solo puede devolver tres tipos de cosas**:

1. **Query Builder** → consulta sin ejecutar
2. **Model** → una fila (un registro)
3. **Collection** → varias filas (colección de modelos)

👉 Si distingues claramente estos tres tipos, desaparece la confusión al usar Eloquent.

---

### 1️ Query Builder (consulta pendiente)

Un **Query Builder** representa una consulta SQL **todavía no ejecutada**.

{{< highlight php >}}
$query = Alumno::where('activo', true);
{{< /highlight >}}

En este punto:
-  No hay datos
-  No se ha ejecutado SQL
- ✔ Solo se ha construido la consulta

Tipo conceptual:

Puedes seguir encadenando métodos:

{{< highlight php >}}
$query->where('edad', '>', 18)->orderBy('nombre');
{{< /highlight >}}

En esta sentencia, ️ Aún no hay resultados.

---

### 2️ Métodos TERMINALES (ejecutan la consulta)

Los **métodos terminales**, por llamarlos de alguna forma, son los que  {{<color>}}ejecutan la consulta y devuelven datos reales{{</color>}}.

#### Devuelven **Collection**
- `get()`
- `all()`

{{< highlight php >}}
$users = User::where('active', 1)->get(); // Collection<User>
{{< /highlight >}}

Resultado:

---

#### Devuelven **Model o null**
- `first()`
- `find($id)`

{{< highlight php >}}
$user = User::where('active', 1)->first();
{{< /highlight >}}

---

#### Devuelven **Model o 404**
- `firstOrFail()`
- `findOrFail()`

Laravel lanza automáticamente una **404** si no existe el registro.

---

#### Devuelven **valores simples**
- `count()` → int
- `exists()` → bool
- `sum('campo')`
- `value('campo')`
- `pluck('campo')` → Collection de valores simples

---

### ️ Métodos que YA ejecutan la consulta (sin ->get)

Algunos métodos **no devuelven Query Builder**, sino resultados directamente.

#### `find()` no devuelve Builder

{{< highlight php >}}
Alumno::find(5);
{{< /highlight >}}

 Ejecuta la consulta  
 Devuelve `Alumno|null`  
 No se puede encadenar `->get()`, ya que el método está retornando el resultado de la consulta

---

#### `all()` tampoco devuelve Builder

{{< highlight php >}}
Alumno::all();
{{< /highlight >}}

 Devuelve directamente una `Collection<Alumno>`

---

##  Errores típicos

{{< highlight php >}}
Alumno::find(5)->get(); // MAL
{{< /highlight >}}

`find()` ya ejecutó la consulta.  
Devuelve un modelo, no una consulta.

{{< highlight php >}}
Alumno::where('activo', true)->find(5); // MAL
{{< /highlight >}}

`find()` ignora el builder previo y busca directamente por ID.

---

##  Tabla resumen

| Código | Qué devuelve |
|------|-------------|
| `Model::where(...)` | Query Builder |
| `->get()` | Collection |
| `->first()` | Model o null |
| `->find(id)` | Model o null |
| `->all()` | Collection |
| `->count()` | int |
| `->pluck()` | Collection |
| `->exists()` | bool |

---

##  Query Builder vs Collection

### Query Builder
- No tiene datos
- Representa SQL
- Vive antes de ejecutar
- Permite `toSql()`

---

### Collection
- Tiene datos en memoria
- Se trabaja en PHP
- Métodos como `map()`, `filter()`, `each()`

{{< highlight php >}}
$alumnos = Alumno::where('activo', true)->get();

$mayores = $alumnos->filter(fn ($a) => $a->edad >= 18);
{{< /highlight >}}

---
