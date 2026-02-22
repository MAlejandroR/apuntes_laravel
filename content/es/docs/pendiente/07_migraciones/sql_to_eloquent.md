---
title: "SQL vs Eloquent"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 20
icon: fa-solid fa-database
---


# Índice de contenidos - SQL vs Eloquent

{{<desplegable title="Navega por las secciones principales">}}

- [Sentencias SELECT](#sentencias-select)
- [Cláusula WHERE](#cláusula-where)
- [Cláusula GROUP BY y withCount](#cláusula-group-by-y-withcount)
- [Cláusula HAVING](#cláusula-having)
- [Cláusula ORDER BY](#cláusula-order-by)

{{</desplegable>}}

---

## Descripción breve

En esta documentación se comparan las sentencias SQL básicas con sus equivalentes en Eloquent ORM de Laravel, mostrando sintaxis, uso y ejemplos prácticos para cada cláusula fundamental en consultas:

- {{< color >}}SELECT{{< /color >}}: Proyecciones y selección de columnas.
- {{< color >}}WHERE{{< /color >}}: Filtrado de filas.
- {{< color >}}GROUP BY{{< /color >}} y {{< color >}}withCount{{< /color >}}: Agrupación y conteo de relaciones.
- {{< color >}}HAVING{{< /color >}}: Filtros sobre grupos agregados.
- {{< color >}}ORDER BY{{< /color >}}: Ordenación de resultados.

---

## Cómo usar esta guía

Cada sección incluye:
- Explicación conceptual.
- Tabla comparativa SQL vs Eloquent.
- Ejemplos con código resaltado.
- Referencias oficiales para ampliar.

---

## Enlaces directos a secciones

{{< desplegable title="Saltos rápidos">}}

- [Sentencias SELECT](#sentencias-select)
- [Cláusula WHERE](#cláusula-where)
- [Cláusula GROUP BY y withCount](#cláusula-group-by-y-withcount)
- [Cláusula HAVING](#cláusula-having)
- [Cláusula ORDER BY](#cláusula-order-by)

{{</desplegable>}}

# Sentencias SELECT

En SQL, la sentencia {{< color >}}SELECT{{< /color >}} representa una **proyección**: permite obtener ciertos campos, expresiones o agregaciones de una relación (tabla) o subconsulta.  
En la cláusula pueden ir:
- Campos (columnas)
- Funciones SQL
- Valores o expresiones calculadas

En **Eloquent** disponemos de diferentes métodos para realizar proyecciones, con diferencias importantes en el {{< color >}}tipo de resultado{{< /color >}}:

{{<definicion title="Métodos más habituales para SELECT en Eloquent">}}
- **`all()`** → Recupera **todos** los registros en una {{< color >}}colección de modelos hidratados{{< /color >}}.
- **`select()`** → Define columnas específicas a recuperar; admite expresiones (`DB::raw`).
- **`addSelect()`** → Añade más columnas a un select existente.
- **`distinct()`** → Equivalente a `SELECT DISTINCT`.
- **`pluck()`** → Recupera una o dos columnas en una colección simple (sin hidratar modelo).
- **`value()`** → Devuelve un único valor de una columna de la primera fila encontrada.
- **Agregaciones**: `count()`, `max()`, `min()`, `avg()`, `sum()` → Devuelven valores numéricos agregados.
- **`toBase()`** → Convierte el query builder Eloquent al query builder de base de datos (resultado sin hidratar modelos).
  {{</definicion>}}

{{% line %}}

## Comparativa SELECT

| Caso de uso | SQL | Eloquent | Tipo de resultado |
|---|---|---|---|
| Todos los campos | `SELECT * FROM users;` | `User::all();` | `Collection<Model>` |
| Columnas específicas | `SELECT name,email FROM users;` | `User::select('name','email')->get();` | `Collection<Model>` |
| Añadir columnas extra | — | `User::select('name')->addSelect('email')->get();` | `Collection<Model>` |
| Solo valores únicos | `SELECT DISTINCT name FROM users;` | `User::select('name')->distinct()->get();` | `Collection<Model>` |
| Proyección de una columna | `SELECT name FROM users;` | `User::pluck('name');` | `Collection<scalar>` |
| Par clave–valor | `SELECT id,name FROM users;` | `User::pluck('name','id');` | `Collection<key,value>` |
| Un solo valor | `SELECT email FROM users LIMIT 1;` | `User::value('email');` | `scalar` |
| Agregaciones | `SELECT COUNT(*) FROM users;` | `User::count();` | `int` |
| Expresiones calculadas | `SELECT price*quantity AS total FROM sales;` | `Sale::select(DB::raw('price*quantity as total'))->get();` | `Collection<Model>` |

{{< alert title="Nota" color="info" >}}
En Eloquent, {{< color >}}get(){{< /color >}} devuelve una **colección**, mientras que {{< color >}}first(){{< /color >}} o {{< color >}}find(){{< /color >}} devuelven un único modelo o `null`.  
Esto afecta cómo accedes a los datos.
{{< /alert >}}

{{% line %}}

## Ejemplos

{{<desplegable title="Ejemplo: Todos los usuarios">}}
**SQL**
{{< highlight dockerfile "linenos=table, hl_lines=1" >}}
SELECT * FROM users;
{{< / highlight >}}

**Eloquent**
{{< highlight dockerfile "linenos=table, hl_lines=1" >}}
User::all();
{{< / highlight >}}
{{</desplegable>}}

{{<desplegable title="Ejemplo: Campos específicos">}}
**SQL**
{{< highlight dockerfile "linenos=table, hl_lines=1" >}}
SELECT name, email FROM users;
{{< / highlight >}}

**Eloquent**
{{< highlight dockerfile "linenos=table, hl_lines=1" >}}
User::select('name','email')->get();
{{< / highlight >}}
{{</desplegable>}}

{{% line %}}

{{<referencias>}}
- [Documentación Laravel Eloquent ORM](https://laravel.com/docs/eloquent)
- [Manual SQL W3Schools](https://www.w3schools.com/sql/)
  {{</referencias>}}
# Cláusula WHERE

En SQL, la cláusula {{< color >}}WHERE{{< /color >}} se usa para **filtrar filas** según condiciones lógicas. Permite limitar el conjunto de resultados a solo aquellos registros que cumplen las condiciones.

En Eloquent, la función equivalente se consigue con métodos encadenables que agregan filtros a la consulta, principalmente:

- `where()`
- `orWhere()`
- `whereIn()`
- `whereNull()`
- `whereBetween()`
- Otros métodos auxiliares para condiciones específicas:
- {{<definicion title="Métodos auxiliares de filtrado en Eloquent para condiciones específicas">}}

- **`whereNull($column)`** / **`whereNotNull($column)`**: Filtra filas con valor nulo o no nulo en la columna.
- **`whereIn($column, array $values)`** / **`whereNotIn($column, array $values)`**: Filtra filas donde el valor está (o no está) dentro de un conjunto.
- **`whereBetween($column, array $range)`** / **`whereNotBetween($column, array $range)`**: Filtra filas donde el valor está (o no está) dentro de un rango.
- **`whereDate($column, $operator, $value)`**, **`whereMonth($column, $value)`**, **`whereYear($column, $value)`**: Filtrado basado en partes de fecha (fecha completa, mes o año).
- **`whereColumn($first, $operator = null, $second = null)`**: Compara el valor de una columna con otra columna (no con un valor estático).
- **`whereExists($callback)`**: Filtrado usando subconsultas con existencia de registros relacionados.
- **`whereRaw($sql, $bindings = [])`**: Permite escribir condiciones WHERE personalizadas en SQL crudo, con o sin bindings.

{{</definicion>}}

{{<definicion title="Métodos comunes para filtros en Eloquent">}}
- **`where($column, $operator = null, $value = null, $boolean = 'and')`**: Filtro básico con operador (por defecto '=').
- **`orWhere()`**: Condición OR en lugar de AND.
- **`whereIn($column, array $values)`**: Filtra si el valor está dentro de un conjunto.
- **`whereNull($column)`** / **`whereNotNull($column)`**: Filtra valores nulos o no nulos.
- **`whereBetween($column, array $range)`**: Filtra valores dentro de un rango.
- **`whereDate()`, `whereMonth()`, `whereYear()`**: Filtrado por partes de fecha.  
  {{</definicion>}}

{{% line %}}

# Cláusula WHERE

En SQL, la cláusula {{< color >}}WHERE{{< /color >}} se usa para **filtrar filas** según condiciones lógicas.  
En Eloquent, usamos métodos encadenables para construir estas condiciones.

{{<definicion title="Métodos comunes para filtros en Eloquent">}}
- **`where($column, $operator = null, $value = null, $boolean = 'and')`**: Filtro básico con operador (por defecto '=').
- **`orWhere()`**: Condición OR en lugar de AND.  
  {{</definicion>}}

{{<definicion title="Métodos auxiliares de filtrado en Eloquent para condiciones específicas">}}
- **`whereNull($column)`** / **`whereNotNull($column)`**: Filtra filas con valor nulo o no nulo en la columna.
- **`whereIn($column, array $values)`** / **`whereNotIn($column, array $values)`**: Filtra filas donde el valor está (o no está) dentro de un conjunto.
- **`whereBetween($column, array $range)`** / **`whereNotBetween($column, array $range)`**: Filtra filas donde el valor está (o no está) dentro de un rango.
- **`whereDate($column, $operator, $value)`**, **`whereMonth($column, $value)`**, **`whereYear($column, $value)`**: Filtrado basado en partes de fecha (fecha completa, mes o año).
- **`whereColumn($first, $operator = null, $second = null)`**: Compara el valor de una columna con otra columna.
- **`whereExists($callback)`**: Filtrado usando subconsultas con existencia de registros relacionados.
- **`whereRaw($sql, $bindings = [])`**: Permite escribir condiciones WHERE personalizadas en SQL crudo.  
  {{</definicion>}}

{{% line %}}

## Comparativa WHERE

| Caso de uso | SQL | Eloquent | Resultado |
|---|---|---|---|
| Igualdad simple | `SELECT * FROM users WHERE status = 'active';` | `User::where('status', 'active')->get();` | Colección de modelos |
| Mayor que | `SELECT * FROM orders WHERE total > 100;` | `Order::where('total', '>', 100)->get();` | Colección |
| Condición OR | `SELECT * FROM users WHERE status = 'active' OR role = 'admin';` | `User::where('status', 'active')->orWhere('role', 'admin')->get();` | Colección |
| IN (conjunto) | `SELECT * FROM users WHERE id IN (1,2,3);` | `User::whereIn('id', [1,2,3])->get();` | Colección |
| Valor NULL | `SELECT * FROM posts WHERE deleted_at IS NULL;` | `Post::whereNull('deleted_at')->get();` | Colección |
| Rango entre valores | `SELECT * FROM events WHERE date BETWEEN '2023-01-01' AND '2023-12-31';` | `Event::whereBetween('date', ['2023-01-01', '2023-12-31'])->get();` | Colección |

{{< alert title="Nota" color="info" >}}
Eloquent permite encadenar múltiples llamadas `where()`, que se concatenan con AND por defecto. Para condiciones complejas se usan funciones anónimas para agrupar filtros.  
{{< /alert >}}

{{% line %}}

## Ejemplos

{{<desplegable title="Ejemplo: Filtrar usuarios activos">}}
**SQL**
{{< highlight dockerfile "linenos=table, hl_lines=1" >}}
SELECT * FROM users WHERE status = 'active';
{{< / highlight >}}

**Eloquent**
{{< highlight dockerfile "linenos=table, hl_lines=1" >}}
User::where('status', 'active')->get();
{{< / highlight >}}
{{</desplegable>}}

{{<desplegable title="Ejemplo: Filtrar pedidos mayores a 100 o urgentes">}}
**SQL**
{{< highlight dockerfile "linenos=table, hl_lines=1" >}}
SELECT * FROM orders WHERE total > 100 OR urgent = 1;
{{< / highlight >}}

**Eloquent**
{{< highlight dockerfile "linenos=table, hl_lines=1" >}}
Order::where('total', '>', 100)
->orWhere('urgent', 1)
->get();
{{< / highlight >}}
{{</desplegable>}}

{{% line %}}

{{<referencias>}}
- [Laravel Query Builder - Where Clauses](https://laravel.com/docs/eloquent#where-clauses)
- [SQL WHERE Clause](https://www.w3schools.com/sql/sql_where.asp)  
  {{</referencias>}}

# Cláusula GROUP BY y método withCount en Eloquent

En SQL, la cláusula {{< color >}}GROUP BY{{< /color >}} permite **agrupar filas** según valores iguales en una o más columnas, para luego aplicar funciones de agregación sobre cada grupo.

En Eloquent, se usa el método `groupBy()` para agrupar consultas manualmente, pero además existe un método muy potente llamado **`withCount()`** que facilita contar registros relacionados sin escribir explícitamente la consulta con `GROUP BY`.

{{<definicion title="Métodos para agrupar y contar en Eloquent">}}
- **`groupBy($columns)`**: Agrupa los resultados según columnas específicas y suele usarse junto con funciones agregadas (`count()`, `sum()`, etc.).
- **`withCount($relation)`**: Agrega automáticamente un contador del número de registros relacionados para cada modelo principal. Internamente genera una consulta con `GROUP BY` y `COUNT()`.  
  {{</definicion>}}

{{% line %}}

## Comparativa GROUP BY vs withCount

| Caso de uso | SQL | Eloquent | Resultado |
|---|---|---|---|
| Agrupar por columna y contar registros |
{{< highlight dockerfile "linenos=table, hl_lines=2" >}}  
SELECT status, COUNT(*) as total FROM users GROUP BY status;  
{{< /highlight >}}  
|  
{{< highlight dockerfile "linenos=table, hl_lines=2" >}}  
User::select('status', DB::raw('COUNT(*) as total'))  
->groupBy('status')  
->get();  
{{< /highlight >}}  
| Colección con cada grupo y conteo |
| Contar registros relacionados (posts por usuario) |  
No aplica directamente, se usa join manual |  
{{< highlight dockerfile "linenos=table, hl_lines=2" >}}  
User::withCount('posts')->get();  
{{< /highlight >}}  
| Colección de usuarios con atributo extra `posts_count` |

{{< alert title="Importante" color="warning" >}}
- `withCount` simplifica mucho obtener contadores de relaciones, evita escribir consultas con `JOIN` y `GROUP BY` manualmente.
- El resultado añade automáticamente un atributo con el sufijo `_count` al modelo.  
  {{< /alert >}}

{{% line %}}

## Ejemplos

{{<desplegable title="Ejemplo: Contar usuarios por estado con GROUP BY">}}
**SQL**  
{{< highlight dockerfile "linenos=table, hl_lines=1" >}}  
SELECT status, COUNT(*) as total FROM users GROUP BY status;  
{{< /highlight >}}

**Eloquent**  
{{< highlight dockerfile "linenos=table, hl_lines=1" >}}  
User::select('status', DB::raw('COUNT(*) as total'))  
->groupBy('status')  
->get();  
{{< /highlight >}}  
{{</desplegable>}}

{{<desplegable title="Ejemplo: Contar posts por usuario con withCount">}}
**Eloquent**  
{{< highlight dockerfile "linenos=table, hl_lines=1" >}}  
$users = User::withCount('posts')->get();

foreach ($users as $user) {  
echo $user->name . ' tiene ' . $user->posts_count . ' posts.';  
}  
{{< /highlight >}}  
{{</desplegable>}}

{{% line %}}

{{<referencias>}}
- [Laravel Query Builder - Group By](https://laravel.com/docs/eloquent#grouping)
- [Laravel Eloquent - withCount](https://laravel.com/docs/eloquent-relationships#counting-related-models)
- [SQL GROUP BY Clause](https://www.w3schools.com/sql/sql_groupby.asp)  
  {{</referencias>}}
-
# Cláusula HAVING

En SQL, la cláusula {{< color >}}HAVING{{< /color >}} se usa para **filtrar grupos** que resultan de una cláusula `GROUP BY`, aplicando condiciones sobre funciones de agregación (por ejemplo, contar, sumar, etc.).

En Eloquent, la cláusula HAVING se puede implementar con el método `having()` o sus variantes (`havingRaw()`) para filtrar grupos después de aplicar agregaciones.

{{<definicion title="Métodos HAVING en Eloquent">}}
- **`having($column, $operator = null, $value = null)`**: Filtro sobre una columna o alias de agregación después de agrupar.
- **`havingRaw($sql, $bindings = [])`**: Permite escribir condiciones HAVING en SQL crudo.  
  {{</definicion>}}

{{% line %}}

## Comparativa HAVING

| Caso de uso | SQL | Eloquent | Resultado |
|---|---|---|---|
| Filtrar grupos con conteo > 10 |
{{< highlight dockerfile "linenos=table, hl_lines=2" >}}  
SELECT status, COUNT(*) as total FROM users  
GROUP BY status  
HAVING COUNT(*) > 10;  
{{< /highlight >}}  
|  
{{< highlight dockerfile "linenos=table, hl_lines=3" >}}  
User::select('status', DB::raw('COUNT(*) as total'))  
->groupBy('status')  
->having('total', '>', 10)  
->get();  
{{< /highlight >}}  
| Colección con grupos filtrados |

{{% line %}}

## Ejemplos

{{<desplegable title="Ejemplo: Filtrar estados con más de 10 usuarios">}}
**SQL**  
{{< highlight dockerfile "linenos=table, hl_lines=1" >}}  
SELECT status, COUNT(*) as total FROM users GROUP BY status HAVING COUNT(*) > 10;  
{{< /highlight >}}

**Eloquent**  
{{< highlight dockerfile "linenos=table, hl_lines=1" >}}  
User::select('status', DB::raw('COUNT(*) as total'))  
->groupBy('status')  
->having('total', '>', 10)  
->get();  
{{< /highlight >}}  
{{</desplegable>}}

---

# Cláusula ORDER BY

En SQL, la cláusula {{< color >}}ORDER BY{{< /color >}} se usa para ordenar los resultados de la consulta por una o varias columnas, en orden ascendente (ASC) o descendente (DESC).

En Eloquent, se usa el método `orderBy()` para ordenar los resultados.

{{<definicion title="Métodos ORDER BY en Eloquent">}}
- **`orderBy($column, $direction = 'asc')`**: Ordena por la columna en dirección ascendente o descendente.
- **`latest($column = 'created_at')`**: Ordena descendente por la columna especificada (usualmente fecha).
- **`oldest($column = 'created_at')`**: Ordena ascendente por la columna especificada.  
  {{</definicion>}}

{{% line %}}

## Comparativa ORDER BY

| Caso de uso | SQL | Eloquent | Resultado |
|---|---|---|---|
| Ordenar usuarios por nombre ascendente |
{{< highlight dockerfile "linenos=table, hl_lines=1" >}}  
SELECT * FROM users ORDER BY name ASC;  
{{< /highlight >}}  
|  
{{< highlight dockerfile "linenos=table, hl_lines=1" >}}  
User::orderBy('name', 'asc')->get();  
{{< /highlight >}}  
| Colección ordenada |
| Ordenar pedidos por fecha descendente |  
{{< highlight dockerfile "linenos=table, hl_lines=1" >}}  
SELECT * FROM orders ORDER BY created_at DESC;  
{{< /highlight >}}  
|  
{{< highlight dockerfile "linenos=table, hl_lines=1" >}}  
Order::latest()->get();  
{{< /highlight >}}  
| Colección ordenada |

{{% line %}}

## Ejemplos

{{<desplegable title="Ejemplo: Usuarios ordenados por nombre">}}
**SQL**  
{{< highlight dockerfile "linenos=table, hl_lines=1" >}}  
SELECT * FROM users ORDER BY name ASC;  
{{< /highlight >}}

**Eloquent**  
{{< highlight dockerfile "linenos=table, hl_lines=1" >}}  
User::orderBy('name', 'asc')->get();  
{{< /highlight >}}  
{{</desplegable>}}

{{<desplegable title="Ejemplo: Pedidos ordenados por fecha más reciente">}}
**SQL**  
{{< highlight dockerfile "linenos=table, hl_lines=1" >}}  
SELECT * FROM orders ORDER BY created_at DESC;  
{{< /highlight >}}

**Eloquent**  
{{< highlight dockerfile "linenos=table, hl_lines=1" >}}  
Order::latest()->get();  
{{< /highlight >}}  
{{</desplegable>}}

{{% line %}}

{{<referencias>}}
- [Laravel Query Builder - Ordering](https://laravel.com/docs/eloquent#ordering)
- [SQL ORDER BY Clause](https://www.w3schools.com/sql/sql_orderby.asp)  
  {{</referencias>}}