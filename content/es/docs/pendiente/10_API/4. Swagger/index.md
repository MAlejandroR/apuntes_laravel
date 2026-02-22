---
title: "swagger"
date: "2025-03-03"
categories: [ ]
tags: [ ]
---



{{< highlight php "linenos=table, hl_lines=1" >}}

{{< / highlight >}}

{{<referencias>}}
*  https://github.com/DarkaOnLine/L5-Swagger/wiki
{{</referencias>}} 
# Swagger en Laravel 11

{{% line %}}

## Introducción

{{< color >}} Swagger (OpenAPI) {{< /color >}} es una herramienta que permite documentar APIs de manera estructurada y visual, facilitando su uso por parte de desarrolladores y otros sistemas.

En Laravel, la biblioteca {{< color >}} L5 Swagger {{< /color >}} ayuda a integrar esta documentación automáticamente a partir de anotaciones en el código.

Este documento explica cómo configurar Swagger en Laravel 11 y cómo documentar los endpoints de una API.

{{% line %}}

## Instalación de Swagger en Laravel 12

Instalamos con composer la librería **darkaonline/l5-swagger**

{{< highlight bash "linenos=table, hl_lines=1" >}}
  composer require darkaonline/l5-swagger
{{< /highlight >}}

Publicamos la configuración para ponerla disponible en el direcotiro del proyecto.

{{< highlight bash "linenos=table, hl_lines=1" >}}
php artisan vendor:publish --provider="L5Swagger\\L5SwaggerServiceProvider"
{{< /highlight >}}

{{% line %}}

## Configuración de Swagger

[//]: # (MRM => Revisar este apartado  )

Swagger tiene un fichero de cofiguracion en la carpeta **config**:
* ***config/l5-swagger.php***
En su contendio podemos especificar diferentes directivas, como el directorio dónde se ubica los fichero de anotaciones o especificación general:

{{< highlight php "linenos=table, hl_lines=2 3" >}}
'paths' => [
            'docs' => storage_path('api-docs'),
            'annotations' => base_path('app/Http/Controllers'),
          ],
{{< /highlight >}}

Si tu API usa autenticación, puedes configurar el esquema de seguridad:

{{< highlight php "linenos=table, hl_lines=4" >}}
'defaults' => [
      'security' => [
          [
              'bearerAuth' => []
          ],
      ],
],
{{< /highlight >}}

{{% line %}}

## Incluir informacion sobre el api usando swager
Para incluir información sobre nuestra api, lo realizaremos incluyendo las {{< color >}} Etiquetas de swagger {{< /color >}} o {{< color >}} Anotaciones de swagger {{< /color >}}.

Estas etiquetas se incluyen entre comentarios en el fichero correspondiente usando la forma de comentar
{{< highlight php "linenos=table, hl_lines=1-3" >}}
/**
 @OA/anotacion (anotaciones swager)
*/
{{< / highlight >}}
{{% line %}}
Las anotaciones más comúnmente usadas son:
| Anotación            | Descripción en Español |
|----------------------|----------------------|
| `@OA\Info`         | Define los metadatos de la API (título, versión, descripción). |
| `@OA\Get`          | Define una petición GET. |
| `@OA\Post`         | Define una petición POST. |
| `@OA\Put`          | Define una petición PUT. |
| `@OA\Delete`       | Define una petición DELETE. |
| `@OA\Schema`       | Define un modelo reutilizable. |
| `@OA\Property`     | Define una propiedad dentro de un esquema. |
| `@OA\Parameter`    | Define un parámetro de consulta o ruta. |
| `@OA\RequestBody`  | Define el cuerpo de una petición (POST/PUT). |
| `@OA\Response`     | Define posibles respuestas. |
| `@OA\JsonContent`  | Define la estructura JSON dentro de una respuesta. |
| `@OA\SecurityScheme` | Define el método de autenticación (Bearer, API Key). |
| `@OA\Tag`         | Agrupa endpoints bajo una etiqueta. |
| `@OA\Server`      | Define la URL base del servidor. |

> A continuación mostramos un ejemplo de información general de nuestra API, que habrá que ubicarlo en {{< color >}} el fichero del controlador antes de la especificación de la clase {{< /color >}}
>> {{<summary title="Ejemplo de @OA\Info">}}
```php
<?php

namespace App\Http\Controllers;

use  ...
/**
* @OA\Info(
*     title="API de Alumnos",
*     version="1.0.0",
*     description="Para obtener listado de alumnos",
*     @OA\Contact(
*         name="Manuel",
*         email="manuelromeromiguel@gmail.com"
*     ),
*     @OA\License(
*         name="MIT",
*         url="https://opensource.org/license/mit"
*     )
* )
  */

class AlumnoApiController extends Controller{
.....
 ```
{{</summary>}}


 
* Una vez escritos las anotaciones, ya las podemos ver en la web, para ello temeos que generar la documentación y acceder a la web donde se ha generado dicha información:
```bash
  php artisan l5-swagger:generate
```
* Y ahora accedemos a la web.

> _(debemos tener levantada nuestra aplicación, si estamos en local podemos ejecutar el script dev de composer.json)_:
>> {{< highlight php "linenos=table, hl_lines=1" >}}
composer run dev
{{< / highlight >}}
 
Y podemos acceder a la información en nuestro navegador
```php
http://127.0.0.1:8000/api/documentation
```

### Incluyendo información general

La información general, debería de ir en un fichero dedicado para esto: {{< color >}} app/Http/Swagger.php {{< /color >}}.   

Alternativamente podemos incluirlo directamente el en controlador de la API, y así  tener todo concentrado en un solo fichero.


#### Principales Campos de Metadatos en @OA\Info

Estos son los campos de {{< color >}} metadatos {{< /color >}} u opciones  más importantes utilizados en `@OA\Info`:
{{< summary title="Principales Campos en @OA\Info" >}}
| **Campo**           | **Descripción en Español**                                      | **Obligatorio** |
|---------------------|----------------------------------------------------------------|----------------|
| `title`            | Define el título de la API.                                    | ✅ **Sí** |
| `version`          | Especifica la versión de la API.                               | ✅ **Sí** |
| `description`      | Proporciona una descripción general de la API.                 | ❌ **No** |
| `termsOfService`   | Enlace a los términos de servicio de la API.                   | ❌ **No** |
| `@OA\Contact`      | Información de contacto del responsable de la API.             | ❌ **No** |
| `@OA\License`      | Detalles sobre la licencia de la API.                          | ❌ **No** |
{{</summary>}}

> Vemos que tenemos dos componentes o campos de anotación como elementos del componente {{< color >}} OA\Info {{< /color >}}:
>> {{< summary title="Campos dentro de @OA\Contact" >}}
| **Opción**  | **Descripción** | **Obligatorio** |
|------------|----------------|----------------|
| `name`     | Nombre de la persona de contacto. | ❌ No |
| `email`    | Dirección de correo electrónico de contacto. | ❌ No |
| `url`      | URL con más información de contacto. | ❌ No |
{{</summary>}}
>> {{< summary title="Campos dentro de @OA\License" >}}
| **Campo**  | **Descripción en Español** | **Obligatorio** |
|------------|----------------------------|----------------|
| `name`     | Nombre de la licencia de la API. | ✅ **Sí** |
| `url`      | Enlace a la licencia de la API. | ❌ **No** |
{{</summary>}}



### 🔹 2. Definir Endpoints de la API
Para poder general la información de nuestra apì, al menos tenemos que tener un entrypoint de acceso, si no, no nos generará la documentación
#### Principales Campos de Metadatos en @OA\Get, @OA\Post, @OA\Put y @OA\Delete

Estos son los campos de metadatos más importantes utilizados en los métodos HTTP dentro de Swagger:

| **Anotación**       | **Descripción en Español**                                      | **Obligatorio** |
|---------------------|----------------------------------------------------------------|---------------|
| `path`             | Define la ruta de la API donde se ejecutará la operación.      | ✅ Sí  |
| `operationId`      | Identificador único de la operación dentro de la API.         | ✅ Sí  |
| `tags`            | Agrupa las operaciones en categorías dentro de la documentación. | ❌ No  |
| `summary`         | Breve descripción de la operación.                              | ❌ No  |
| `description`     | Explicación más detallada de la operación.                      | ❌ No  |
| `@OA\Response`    | Define las respuestas esperadas de la API.                      | ✅ Sí  |
| `@OA\Parameter`   | Define los parámetros que recibe la API en la URL o query.      | ✅ Solo si hay parámetros en la URL |
| `@OA\RequestBody` | Define los datos que se envían en una petición (POST o PUT).    | ✅ Solo en `POST` y `PUT` |
| `@OA\JsonContent` | Especifica el formato de respuesta en JSON.                     | ✅ Solo si la respuesta es JSON |
| `@OA\Items`       | Define los elementos dentro de una respuesta que es un array.   | ✅ Solo si la respuesta es un array |

{{< summary title="@OA\Response" >}}
| **Opción**         | **Descripción** | **Obligatorio** |
|---------------------|----------------|----------------|
| `response`         | Código de estado HTTP (`200`, `400`, `404`, etc.). | ✅ Sí |
| `description`      | Breve descripción de la respuesta. | ✅ Sí |
| `@OA\JsonContent`  | Define el contenido en formato JSON. | ❌ No |
| `@OA\XmlContent`   | Define el contenido en formato XML. | ❌ No |
{{</summary>}}

{{% line %}}

{{< summary title="@OA\Parameter" >}}
| **Opción**  | **Descripción** | **Obligatorio** |
|------------|----------------|----------------|
| `name`     | Nombre del parámetro (`id`, `page`, etc.). | ✅ Sí |
| `in`       | Ubicación (`query`, `path`, `header`, `cookie`). | ✅ Sí |
| `required` | Indica si el parámetro es obligatorio (`true` o `false`). | ✅ Solo en `path` |
| `@OA\Schema` | Define el tipo de dato (`string`, `integer`, `boolean`). | ❌ No |
{{</summary>}}

{{% line %}}

{{< summary title="@OA\RequestBody" >}}
| **Opción**    | **Descripción** | **Obligatorio** |
|--------------|----------------|----------------|
| `required`   | Indica si el cuerpo es obligatorio (`true` o `false`). | ✅ Sí |
| `description` | Explicación del contenido del cuerpo. | ❌ No |
| `@OA\JsonContent` | Define el contenido en JSON. | ✅ Solo si la petición envía datos |
| `@OA\XmlContent`  | Define el contenido en XML (opcional). | ❌ No |
{{</summary>}}

{{% line %}}

{{< summary title="@OA\JsonContent" >}}
| **Opción**   | **Descripción** | **Obligatorio** |
|-------------|----------------|----------------|
| `type`      | Tipo de dato (`object`, `array`). | ✅ Sí |
| `@OA\Items` | Define elementos dentro de un array. | ❌ No |
| `@OA\Property` | Define propiedades dentro de un objeto JSON. | ❌ No |
{{</summary>}}

{{% line %}}

{{< summary title="@OA\Items" >}}
| **Opción**   | **Descripción** | **Obligatorio** |
|-------------|----------------|----------------|
| `type`      | Tipo de dato de los elementos (`string`, `integer`, `object`). | ✅ Sí |
| `@OA\Property` | Define propiedades dentro del objeto del array. | ❌ No |
| `example`   | Define un valor de ejemplo para un elemento del array. | ❌ No |
| `ref`       | Permite hacer referencia a un esquema predefinido (`ref="#/components/schemas/Alumno"`). | ❌ No |
{{</summary>}}
{{% line %}}

{{< summary title="@OA\Property" >}}
| **Opción**  | **Descripción** | **Obligatorio** |
|------------|----------------|----------------|
| `property` | Nombre de la propiedad en el objeto JSON. | ✅ Sí |
| `type`     | Tipo de dato (`string`, `integer`, `boolean`, `array`, `object`). | ✅ Sí |
| `format`   | Formato del dato (`date-time`, `email`, `uuid`, etc.). | ❌ No |
| `example`  | Valor de ejemplo para la propiedad. | ❌ No |
| `description` | Breve explicación de la propiedad. | ❌ No |
| `@OA\Items` | Se usa si la propiedad es un array (`type="array"`). | ❌ No |
| `@OA\Schema` | Se usa si la propiedad es un objeto (`type="object"`). | ❌ No |
{{</summary>}}

{{% line %}}

Cada método HTTP tiene su propia anotación:

### 🟢 **GET Request (@OA\Get)** - Recupera datos

{{< highlight php "linenos=table, hl_lines=1" >}}
/**
* @OA\Get(
*      path="/api/users",
*      operationId="getUsersList",
*      tags={"Users"},
*      summary="Get all users",
*      description="Returns a list of users",
*      @OA\Response(
*          response=200,
*          description="Successful response",
*          @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/User"))
*      )
* )
  */
  {{< /highlight >}}

### 🟡 **POST Request (@OA\Post)** - Crea un nuevo recurso

{{< highlight php "linenos=table, hl_lines=1" >}}
/**
* @OA\Post(
*      path="/api/users",
*      operationId="createUser",
*      tags={"Users"},
*      summary="Create a new user",
*      description="Stores a new user in the database",
*      @OA\RequestBody(
*          required=true,
*          @OA\JsonContent(
*              required={"name","email","password"},
*              @OA\Property(property="name", type="string", example="John Doe"),
*              @OA\Property(property="email", type="string", example="johndoe@example.com"),
*              @OA\Property(property="password", type="string", example="123456")
*          )
*      ),
*      @OA\Response(response=201, description="User created successfully")
* )
  */
  {{< /highlight >}}

## 🔹 3. Definir Modelos de Respuesta (**@OA\Schema**)

{{< highlight php "linenos=table, hl_lines=1" >}}
/**
* @OA\Schema(
*     schema="User",
*     type="object",
*     required={"id", "name", "email"},
*     @OA\Property(property="id", type="integer", example=1),
*     @OA\Property(property="name", type="string", example="John Doe"),
*     @OA\Property(property="email", type="string", example="johndoe@example.com")
* )
  */
  {{< /highlight >}}

## 🔹 4. Autenticación (**@OA\SecurityScheme**)

{{< highlight php "linenos=table, hl_lines=1" >}}
/**
* @OA\SecurityScheme(
*      securityScheme="bearerAuth",
*      type="http",
*      scheme="bearer",
*      bearerFormat="JWT"
* )
  */
  {{< /highlight >}}
## 🔹 Documentar el método ***index***

Edita `app/Http/Controllers/Api/UserController.php` y agrega las anotaciones de Swagger:

{{< highlight php "linenos=table, hl_lines=1" >}}
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
* @OA\Get(
*      path="/api/users",
*      operationId="getUsersList",
*      tags={"Usuarios"},
*      summary="Obtener lista de usuarios",
*      description="Retorna una lista de usuarios",
*      @OA\Response(
*          response=200,
*          description="Éxito",
*          @OA\JsonContent(
*              type="array",
*              @OA\Items(
*                  type="object",
*                  @OA\Property(property="id", type="integer", example=1),
*                  @OA\Property(property="name", type="string", example="Juan Pérez"),
*                  @OA\Property(property="email", type="string", example="juan@example.com")
*              )
*          )
*      )
* )
  */
  class UserController extends Controller
  {
  public function index()
  {
  return response()->json([
  ['id' => 1, 'name' => 'Juan Pérez', 'email' => 'juan@example.com'],
  ['id' => 2, 'name' => 'Ana Gómez', 'email' => 'ana@example.com'],
  ]);
  }
  }
  {{< /highlight >}}

{{% line %}}

## 🔹 Generar y visualizar la documentación

Ejecuta el siguiente comando para generar la documentación:

{{< highlight bash "linenos=table, hl_lines=1" >}}
php artisan l5-swagger:generate
{{< /highlight >}}

Luego, inicia el servidor:

{{< highlight bash "linenos=table, hl_lines=1" >}}
php artisan serve
{{< /highlight >}}

Y accede a la documentación desde el navegador:

{{< color >}}http://127.0.0.1:8000/api/documentation{{< /color >}}

{{% line %}}



## 🔹 Conclusión

Con estos pasos, has configurado ***Swagger en Laravel 11*** y documentado el primer endpoint (`index`). Puedes continuar documentando otros métodos como `store`, `update` y `destroy` siguiendo la misma estructura.
