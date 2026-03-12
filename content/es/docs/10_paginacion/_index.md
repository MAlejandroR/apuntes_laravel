---
title: "Paginando datos"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 100
icon: fa-solid fa-table-list
---


# Paginación en un CRUD con Laravel 12

{{<definicion title="Paginación" icon="fa-solid fa-table-cells-large">}}
La **paginación** es una técnica que permite dividir un conjunto grande de registros en **bloques más pequeños llamados páginas**.

En lugar de mostrar todos los registros de una tabla, el sistema muestra solo un número limitado de elementos y permite navegar entre páginas.
{{</definicion>}}

{{< line >}}

## ¿Por qué usar paginación?

En aplicaciones reales es habitual tener cientos o miles de registros.

Sin paginación:

- Se cargan {{< color >}}demasiados datos{{< /color >}}
- La página tarda más en renderizar
- La experiencia del usuario empeora

Con paginación:

- Se cargan {{< color >}}solo los registros necesarios{{< /color >}}
- Se mejora el rendimiento
- La navegación es más cómoda

{{< alert title="Idea clave" color="warning" >}}
Un CRUD profesional **siempre utiliza paginación** cuando se listan registros de base de datos.
{{< /alert >}}

{{% line %}}

# Ejemplo con recurso Teachers

En nuestro caso concreto:

- Modelo: **Teacher**
- Controlador: **TeacherController**
- Vista: **teachers.index** (usando **crud.blade.php**)


{{< line >}}

# 1. Paginación en el controlador

Laravel proporciona el método: {{< color >}}paginate(int $numero_registros){{< /color >}} que divide automáticamente los resultados en páginas, indicando en su argumento el número de registros por página.

{{< highlight dockerfile "linenos=table, hl_lines=3" >}}
public function index()
{
    $teachers = Teacher::paginate(10);
    return view('teachers.index', compact('teachers'));
}
{{< / highlight >}}

### Explicación

- `paginate(10)` → devuelve **10 registros por página**
- Laravel crea automáticamente:
    - número de páginas
    - enlaces de navegación
    - información de página actual

{{< alert title="Importante" color="warning" >}}
El método **paginate()** devuelve un objeto especial llamado **Paginator** que contiene los registros y la información de navegación.
{{< /alert >}}

{{< line >}}

# 2. Mostrar los datos en la vista

En la vista `teachers/index.blade.php` mostramos los registros normalmente.

{{< highlight dockerfile "linenos=table, hl_lines=2" >}}
@foreach($teachers as $teacher)
<tr>
    <td>{{$teacher->name}}</td>
    <td>{{$teacher->email}}</td>
</tr>
@endforeach
{{< / highlight >}}

Aquí Laravel ya solo devuelve los registros de la página actual. En nuestro caso, usamos el componente **crud.blade.php** donde de forma general visualizamos los registros de una tabla

{{< line >}}

# 3. Mostrar los enlaces de paginación

Para mostrar los botones de navegación utilizamos: el método {{< color >}}links(){{< /color >}} del objeto **paginator** que hemos generado en el controlador

{{< highlight dockerfile "linenos=table, hl_lines=1" >}}
{{$teachers->links()}}
{{< / highlight >}}

Laravel genera automáticamente los botones para navegar:

- botón **Previous** 
- botón **Next**
- números de página



{{< line >}}

### 4. Paginación simple
Alternativa al método **paginate** tenemos otros como **simplePaginate** que lo que hace es modificar lo que retorna **links()** haciendo más sencilla la navegación: solo queremos **Anterior / Siguiente** sin números de página:

{{< highlight dockerfile "linenos=table, hl_lines=3" >}}
public function index()
{
$teachers = Teacher::simplePaginate(10);

    return view('teachers.index', compact('teachers'));
}
{{< / highlight >}}

Diferencia:

| Método | Resultado |
|------|------|
paginate() | números de página |
simplePaginate() | solo anterior / siguiente |

{{< alert title="Cuándo usar simplePaginate()" color="warning" >}}
Es útil cuando la tabla tiene **muchísimos registros**, ya que es más eficiente.
{{< /alert >}}

{{% line %}}

### 5. Mantener filtros o parámetros

Cuando hay filtros o parámetros en la URL, debemos conservarlos.

Ejemplo:

```
/teachers?page=2
```

Laravel lo gestiona automáticamente con `links()`.

Pero si añadimos filtros:

```
/teachers?department=math&page=2
```

Podemos mantenerlos usando:

{{< highlight dockerfile "linenos=table, hl_lines=1" >}}
{{$teachers->appends(request()->query())->links()}}
{{< / highlight >}}

{{% line %}}

## 6. Saber en qué página estamos

Cuando estamos implementando un crud, es muy importante conocer la página en la que estamos, de forma que is estamos en una página, cualquier acción (borrar o editar), 
El punto clave es ser consciente de que la navegación se basa en el parámetro `page` que se recibe en  la URL (es decir es un parámetro por get).

Ejemplo:

```
/teachers?page=3
```

Podemos obtenerlo con:

{{< highlight dockerfile "linenos=table, hl_lines=1" >}}
request()->get('page')
{{< / highlight >}}

Esto es útil para:

- volver a la página anterior
- mantener contexto después de editar

{{< alert title="Ejemplo práctico" color="success" >}}
Si editas un profesor desde la página 4 del listado, puedes redirigir de nuevo a esa página usando el parámetro `page`.
{{< /alert >}}

{{% line %}}

# 7. Cambiar la cantidad de registros por página

Simplemente cambiando el parámetro de `paginate()`.

{{< highlight dockerfile "linenos=table, hl_lines=3" >}}
$teachers = Teacher::paginate(20);
{{< / highlight >}}

Esto mostrará:

- 20 registros por página.

{{% line %}}

# Resumen

La paginación en Laravel es muy sencilla:

1. Obtener registros paginados

{{< highlight dockerfile "linenos=table, hl_lines=1" >}}
$teachers = Teacher::paginate(10);
{{< / highlight >}}

2. ️⃣ Mostrar registros

{{< highlight dockerfile "linenos=table, hl_lines=1" >}}
@foreach($teachers as $teacher)
{{< / highlight >}}

3. Mostrar navegación

{{< highlight dockerfile "linenos=table, hl_lines=1" >}}
{{$teachers->links()}}
{{< / highlight >}}

{{< alert title="Conclusión" color="success" >}}
Laravel implementa la paginación de forma {{< color >}}automática, limpia y muy eficiente{{< /color >}}, lo que facilita construir CRUD profesionales con muy poco código.
{{< /alert >}}

{{<referencias>}}

Laravel Documentation — Pagination  
https://laravel.com/docs/pagination

{{</referencias>}}