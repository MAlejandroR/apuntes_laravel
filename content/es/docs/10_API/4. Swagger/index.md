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
# 📌 Documentación de API con Swagger en Laravel 11

{{% line %}}

## 🔹 Introducción

Swagger (OpenAPI) es una herramienta que permite documentar APIs de manera estructurada y visual, facilitando su uso por parte de desarrolladores y otros sistemas. En Laravel, la biblioteca ***L5 Swagger*** ayuda a integrar esta documentación automáticamente a partir de anotaciones en el código.

Este documento explica cómo configurar Swagger en Laravel 11 y cómo documentar los endpoints de una API.

{{% line %}}

## 🔹 Instalación de Swagger en Laravel 11

Ejecuta el siguiente comando para instalar la biblioteca:

{{< highlight bash "linenos=table, hl_lines=1" >}}
composer require darkaonline/l5-swagger

{{< /highlight >}}

Luego, publica la configuración:

{{< highlight bash "linenos=table, hl_lines=1" >}}
php artisan vendor:publish --provider="L5Swagger\\L5SwaggerServiceProvider"
{{< /highlight >}}

{{% line %}}

## 🔹 Configuración de Swagger

Edita el archivo ***config/l5-swagger.php*** y verifica que la configuración sea la siguiente:

{{< highlight php "linenos=table, hl_lines=1" >}}
'paths' => [
'docs' => storage_path('api-docs'),
'annotations' => base_path('app/Http/Controllers'),
],
{{< /highlight >}}

Si tu API usa autenticación, puedes configurar el esquema de seguridad:

{{< highlight php "linenos=table, hl_lines=1" >}}
'defaults' => [
'security' => [
[
'bearerAuth' => []
],
],
],
{{< /highlight >}}

{{% line %}}

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
## 🔹 1. Información General de la API (**@OA\Info**)

Define los metadatos sobre la API.

{{< highlight php "linenos=table, hl_lines=1" >}}
/**
* @OA\Info(
*      version="1.0.0",
*      title="My API",
*      description="This is an example API using Swagger in Laravel 11",
*      @OA\Contact(
*          email="admin@example.com"
*      )
* )
  */
  {{< /highlight >}}

## 🔹 2. Definir Endpoints de la API

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



## 🔹 Conclusión

Con estos pasos, has configurado ***Swagger en Laravel 11*** y documentado el primer endpoint (`index`). Puedes continuar documentando otros métodos como `store`, `update` y `destroy` siguiendo la misma estructura.
