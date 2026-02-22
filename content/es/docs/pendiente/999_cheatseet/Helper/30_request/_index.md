---
title: "Request en Laravel"
date: 2023-08-13T18:21:47+02:00
draft: false
weight: 30
---

# Helpers y métodos para obtener datos de la Request en Laravel
En Laravel podemos acceder a los datos de la petición HTTP usando:

- El **helper global** `request()`
- La **fachada** `Request` (`Illuminate\Support\Facades\Request`)
- Inyección de la clase `Illuminate\Http\Request`

A continuación, los métodos más usados:

## `request('clave')`
- Obtiene el valor de la clave indicada, buscando en GET, POST, JSON, etc.
- Ejemplo:  
  {{< highlight php >}}
  request('family_id');
  {{< /highlight >}}

## `request()->input('clave')`
- Equivalente a `request('clave')`.
- Ejemplo:  
  {{< highlight php >}}
  request()->input('family_id');
  {{< /highlight >}}

## `request()->query('clave')`
- Obtiene el valor **solo de la query string** (`?param=valor`).
- Ejemplo:  
  {{< highlight php >}}
  request()->query('family_id');
  {{< /highlight >}}

## `request()->post('clave')`
- Obtiene el valor **solo del cuerpo POST**.
- Ejemplo:  
  {{< highlight php >}}
  request()->post('family_id');
  {{< /highlight >}}

## `request()->all()`
- Obtiene **todos los datos** de la petición (GET, POST, JSON, etc.)
- Ejemplo:  
  {{< highlight php >}}
  request()->all();
  {{< /highlight >}}

## `request()->only([...])`
- Obtiene **solo** las claves especificadas.
- Ejemplo:  
  {{< highlight php >}}
  request()->only(['name', 'email']);
  {{< /highlight >}}

## `request()->except([...])`
- Obtiene todos los datos **excepto** las claves indicadas.
- Ejemplo:  
  {{< highlight php >}}
  request()->except(['password']);
  {{< /highlight >}}

## `request()->has('clave')`
- Devuelve `true` si la clave existe (aunque esté vacía).
- Ejemplo:  
  {{< highlight php >}}
  request()->has('family_id');
  {{< /highlight >}}

## `request()->filled('clave')`
- Devuelve `true` si la clave existe y **no está vacía**.
- Ejemplo:  
  {{< highlight php >}}
  request()->filled('family_id');
  {{< /highlight >}}

## `request()->missing('clave')`
- Devuelve `true` si la clave no existe o es null.
- Ejemplo:  
  {{< highlight php >}}
  request()->missing('family_id');
  {{< /highlight >}}

## `request()->ajax()`
- Devuelve `true` si la petición es AJAX.
- Ejemplo:  
  {{< highlight php >}}
  request()->ajax();
  {{< /highlight >}}

## `request()->isJson()`
- Devuelve `true` si la petición es de tipo JSON.
- Ejemplo:  
  {{< highlight php >}}
  request()->isJson();
  {{< /highlight >}}

## `request()->method()`
- Devuelve el método HTTP (`GET`, `POST`, `PUT`…).
- Ejemplo:  
  {{< highlight php >}}
  request()->method();
  {{< /highlight >}}

## `request()->isMethod('metodo')`
- Comprueba si el método HTTP es el indicado.
- Ejemplo:  
  {{< highlight php >}}
  request()->isMethod('post');
  {{< /highlight >}}

## `request()->fullUrl()`
- Devuelve la URL completa con query string.
- Ejemplo:  
  {{< highlight php >}}
  request()->fullUrl();
  {{< /highlight >}}

## `request()->url()`
- Devuelve la URL sin query string.
- Ejemplo:  
  {{< highlight php >}}
  request()->url();
  {{< /highlight >}}

## `request()->path()`
- Devuelve solo el path de la URL.
- Ejemplo:  
  {{< highlight php >}}
  request()->path();
  {{< /highlight >}}

---

# Uso con la fachada `Request`
Podemos hacer lo mismo usando la fachada:

{{< highlight php >}}
use Illuminate\Support\Facades\Request;

Request::input('family_id');
Request::query('family_id');
Request::post('family_id');
Request::all();
Request::only(['name', 'email']);
Request::fullUrl();
{{< /highlight >}}

📌 **Nota:** Tanto `request()` como `Request` usan internamente el mismo objeto `Illuminate\Http\Request`.

---

# Tabla resumen de métodos principales

| Método                          | Origen de datos                         | Descripción                                                        | Ejemplo |
|---------------------------------|------------------------------------------|--------------------------------------------------------------------|---------|
| `request('clave')`              | GET, POST, JSON                          | Busca la clave en todos los datos de la petición                   | `request('id')` |
| `input('clave')`                | GET, POST, JSON                          | Igual que `request('clave')`                                       | `request()->input('id')` |
| `query('clave')`                | Query string (`?param=`)                 | Solo busca en los parámetros de la URL                             | `request()->query('page')` |
| `post('clave')`                 | Cuerpo POST                              | Solo busca en el contenido del formulario o cuerpo POST            | `request()->post('email')` |
| `all()`                         | GET, POST, JSON                          | Devuelve todos los datos                                            | `request()->all()` |
| `only([...])`                   | GET, POST, JSON                          | Devuelve solo las claves indicadas                                 | `request()->only(['name'])` |
| `except([...])`                 | GET, POST, JSON                          | Devuelve todos excepto las claves indicadas                        | `request()->except(['password'])` |
| `has('clave')`                  | GET, POST, JSON                          | Existe la clave (aunque esté vacía)                                | `request()->has('name')` |
| `filled('clave')`               | GET, POST, JSON                          | Existe y tiene valor no vacío                                      | `request()->filled('name')` |
| `missing('clave')`              | GET, POST, JSON                          | No existe o está vacía                                              | `request()->missing('token')` |
| `ajax()`                        | Encabezado `X-Requested-With`            | Comprueba si la petición es AJAX                                   | `request()->ajax()` |
| `isJson()`                      | Cabecera `Content-Type`                  | Comprueba si es JSON                                               | `request()->isJson()` |
| `method()`                      | Método HTTP                              | Devuelve el método usado (`GET`, `POST`, etc.)                     | `request()->method()` |
| `isMethod('metodo')`            | Método HTTP                              | Comprueba si el método es el indicado                              | `request()->isMethod('post')` |
| `fullUrl()`                     | URL completa                             | Devuelve la URL con query string                                   | `request()->fullUrl()` |
| `url()`                         | URL base                                 | Devuelve la URL sin query string                                   | `request()->url()` |
| `path()`                        | URL base                                 | Devuelve solo el path                                              | `request()->path()` |

