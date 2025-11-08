---
title: "Collection en Laravel"
date: 2025-07-24T12:00:00+02:00
draft: false
weight: 60
---

# Collection

Las Collections en Laravel son una herramienta muy poderosa que extiende las posibilidades de trabajar con {{< color >}}arrays{{< /color >}} de PHP.
Permiten transformar, filtrar, ordenar o agrupar datos de forma más {{< color >}}expresiva, elegante y legible{{< /color >}}.

---

## ✏️ ¿Qué es una Collection en Laravel?

{{<definicion title="Collection" icon="fa-solid fa-layer-group">}}
Una Collection es un objeto de la clase `Illuminate\Support\Collection` que envuelve un array y nos da métodos extra para trabajar de forma fluida y encadenada.
{{</definicion>}}

---

## 🔍 Diferencia principal con un array tradicional

Un **array** de PHP tiene funciones globales como `array_map`, `array_filter`…  
Una **Collection** permite {{< color >}}encadenar métodos{{< /color >}}, haciendo el código más limpio y fácil de leer.

{{% line %}}

---

## 🧪 Ejemplo rápido en Tinker

Abre Tinker:

{{< highlight dockerfile "linenos=table" >}}
php artisan tinker
{{< /highlight >}}

Crea una colección y transforma sus valores:

{{< highlight dockerfile "linenos=table" >}}
collect([1, 2, 3, 4])->map(fn($n) => $n * 2);
// Resultado: [2, 4, 6, 8]
{{< /highlight >}}

---

## ✅ Métodos más usados

A continuación, algunos métodos básicos que marcan la diferencia frente a los arrays:

---

### 🧰 map()

Aplica una función a cada elemento.

{{< highlight dockerfile "linenos=table" >}}
collect([1, 2, 3])->map(fn($n) => $n + 10);
// [11, 12, 13]
{{< /highlight >}}

---

### 🔎 filter()

Filtra elementos que cumplen una condición.

{{< highlight dockerfile "linenos=table" >}}
collect([1, 2, 3, 4])->filter(fn($n) => $n > 2);
// [3, 4]
{{< /highlight >}}

---

### ➕ reduce()

Reduce la colección a un solo valor.

{{< highlight dockerfile "linenos=table" >}}
collect([1, 2, 3])->reduce(fn($carry, $n) => $carry + $n, 0);
// 6
{{< /highlight >}}

---

## 📚 Más métodos interesantes

- `first()`: devuelve el primer elemento.
- `pluck('campo')`: extrae los valores de una clave de un array de arrays u objetos.
- `sort()`: ordena los elementos.
- `sum()`: suma todos los valores.

---

## 🧩 ¿Por qué usar Collections?

{{< alert title="Ventaja principal" color="success" >}}
Permiten escribir código más {{< color >}}declarativo, limpio y mantenible{{< /color >}}, sobre todo cuando trabajamos con datos de base de datos o APIs.
{{< /alert >}}

---

## 📌 Conclusión

Las Collections hacen que trabajar con datos sea más fácil y claro.
Aunque internamente son arrays, nos ofrecen {{< color >}}decenas de métodos{{< /color >}} que podemos encadenar para transformar y filtrar datos de forma elegante.

---

{{<referencias title="Laravel Collections" sub_title="Documentación oficial" icon_image="laravel.svg">}}
- https://laravel.com/docs/12.x/collections
  {{</referencias>}}

# 🛠️ Añadir métodos personalizados a las Collections

Laravel permite añadir nuevos métodos a las Collections usando la función {{< color >}}macro(){{< /color >}}.  
Esto es muy útil si queremos reutilizar lógica que usamos frecuentemente.

---

## ⚙️ ¿Cómo hacerlo?

Se hace dentro del método `boot` de un {{< color >}}Service Provider{{< /color >}}.

Normalmente, puedes usar el `AppServiceProvider` que Laravel crea por defecto.

---

## ✏️ Ejemplo práctico

Imagina que queremos crear un método llamado {{< color >}}toUpper{{< /color >}} para transformar todos los strings de una colección a mayúsculas.

---

### 📂 Paso 1: Editar el Service Provider

Edita `app/Providers/AppServiceProvider.php` y dentro del método `boot` añade:

{{< highlight dockerfile "linenos=table" >}}
use Illuminate\Support\Collection;

public function boot()
{
Collection::macro('toUpper', function () {
return $this->map(function ($value) {
return strtoupper($value);
});
});
}
{{< /highlight >}}

---

## ✅ Paso 2: Usarlo en Tinker o en el código

Abre Tinker:

{{< highlight dockerfile "linenos=table" >}}
php artisan tinker
{{< /highlight >}}

Crea una colección y aplica tu nuevo método:

{{< highlight dockerfile "linenos=table" >}}
collect(['hola', 'mundo'])->toUpper();
// ['HOLA', 'MUNDO']
{{< /highlight >}}

---

## 📌 Resumen

- `macro()` es un método estático para añadir métodos personalizados a las Collections.
- Se suele registrar en el método `boot` de un Service Provider.
- Permite extender las Collections con métodos que necesitemos frecuentemente.

---

## 📚 Más información

{{<referencias title="Laravel Collections Macro" sub_title="Documentación y ejemplos" icon_image="laravel.svg">}}
- https://laravel.com/docs/12.x/collections#extending-collections
  {{</referencias>}}
-
# 🐫 Crear un macro para convertir claves a camelCase

A veces tenemos una colección de arrays con claves en {{< color >}}snake_case{{< /color >}} y queremos transformarlas en {{< color >}}camelCase{{< /color >}}.

Con un macro, podemos hacerlo de forma elegante y reutilizable.

---

## ⚙️ Paso 1: Definir el macro en el Service Provider

Edita el archivo `app/Providers/AppServiceProvider.php`:

{{< highlight dockerfile "linenos=table" >}}
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

public function boot()
{
Collection::macro('camelKeys', function () {
return $this->map(function ($item) {
if (is_array($item)) {
return collect($item)->mapWithKeys(function ($value, $key) {
return [Str::camel($key) => $value];
})->all();
}
return $item;
});
});
}
{{< /highlight >}}

---

## ✏️ Explicación rápida

- Recorremos cada elemento de la colección.
- Si el elemento es un array, convertimos sus claves a camelCase usando `Str::camel`.
- Si no es un array, lo devolvemos tal cual.

---

## 🧪 Paso 2: Probarlo en Tinker

Abre Tinker:

{{< highlight dockerfile "linenos=table" >}}
php artisan tinker
{{< /highlight >}}

Creamos una colección con arrays que tienen claves en snake_case:

{{< highlight dockerfile "linenos=table" >}}
$data = collect([
['first_name' => 'Juan', 'last_name' => 'Pérez'],
['first_name' => 'Ana', 'last_name' => 'García']
]);
{{< /highlight >}}

---

Aplicamos el nuevo macro:

{{< highlight dockerfile "linenos=table" >}}
$data->camelKeys();

// Resultado esperado:
// [
//     ['firstName' => 'Juan', 'lastName' => 'Pérez'],
//     ['firstName' => 'Ana', 'lastName' => 'García']
// ]
{{< /highlight >}}

---

## ✅ Ventajas

{{< alert title="Reutilizable" color="info" >}}
Con este macro, cada vez que tengas arrays con claves en snake_case,
puedes transformarlas a camelCase de forma directa, sin escribir la lógica de nuevo.
{{< /alert >}}

---

## 📚 Más información

{{<referencias title="Laravel Collections Macro" sub_title="Documentación y ejemplos" icon_image="laravel.svg">}}
- https://laravel.com/docs/12.x/collections#extending-collections
- https://laravel.com/docs/12.x/helpers#method-camel-case
  {{</referencias>}}