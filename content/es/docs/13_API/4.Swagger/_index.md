---
title: "Creando un swagger"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 30
---
## Qué es swagger y para qué sirve

## Formas de realizar la descripción
De alguna forma debemos de describir el funcionamiento de nuestra api

Principalmente para cada entrypoint:
Cómo es la url
Qué datos retorna
Qué errores puede producir 
....


## Instalando la librería
{{< highlight bash "linenos=inline, hl_lines=, style=emacs" >}}
 composer require darkaonline/l5-swagger 
{{< /highlight >}}

2. Publicamos la configuración 
 {{< highlight bash "linenos=inline, hl_lines=, style=emacs" >}}
  php artisan vendor:publish --provider="L5Swagger\L5SwaggerServiceProvider"
{{< /highlight >}}
2. Establecemos variables de configuración en el fichero {{<color>}}.env{{</color>}}
{{< highlight bash "linenos=inline, hl_lines=, style=emacs" >}}
## Describiendo su comportamiento
Podemos hacerlo con comentarios o bien con un fichero descriptivo de tipo yaml

Vamos a tomar esta segunda opción


### Especificando el comportamiento de swagger en nuestro diseño 
# --- L5-Swagger (documentación API) ---
L5_SWAGGER_GENERATE_ALWAYS=true
L5_SWAGGER_CONST_HOST="${APP_URL}"
L5_SWAGGER_BASE_PATH=/api
L5_FORMAT_TO_USE_FOR_DOCS=yaml
L5_SWAGGER_OPEN_API_SPEC_VERSION=3.0.0




{{< /highlight >}}

| Variable                            | Valor en desarrollo | Descripción |
|-------------------------------------|---------------------|-------------|
| `L5_SWAGGER_GENERATE_ALWAYS`        | `true`              | Regenera automáticamente la documentación OpenAPI en cada petición. Resulta cómodo durante el desarrollo, pero en producción se recomienda establecerlo a `false` para mejorar el rendimiento. |
| `L5_SWAGGER_CONST_HOST`             | `${APP_URL}`        | Define la URL base de la aplicación que se utilizará en las anotaciones y en la documentación generada. |
| `L5_SWAGGER_BASE_PATH`              | `/api`              | Indica el prefijo común de las rutas de la API, normalmente coincidente con las rutas definidas en `routes/api.php`. |
| `L5_FORMAT_TO_USE_FOR_DOCS`         | `json`              | Especifica el formato de la documentación generada. Swagger UI cargará el fichero `api-docs.json`. |
| `L5_SWAGGER_OPEN_API_SPEC_VERSION`  | `3.0.0`             | Versión de la especificación OpenAPI utilizada para generar la documentación. OpenAPI 3.0 es la versión más habitual en proyectos docentes y profesionales. |


3. Personalizar {{<color>}}config/l5-swagger.php{{</color>}}
{{< highlight yaml "linenos=inline, hl_lines=, style=emacs" >}}
   'title' => 'API Alumnos DGA',

    'api' => 'api/documentation',
    
      'annotations' => [
          base_path('app'),
       ],

    'docs' => storage_path('api-docs'),

    'generate_always' => env('L5_SWAGGER_GENERATE_ALWAYS', false),

    'constants' => [
         'L5_SWAGGER_CONST_HOST' => env('L5_SWAGGER_CONST_HOST', 'http://my-default-host.com'),
    ],
{{< /highlight >}}

4. Creamos el link para el storage

{{< highlight bash "linenos=inline, hl_lines=, style=emacs" >}}
php artisan storage:link
{{< /highlight >}}

6. Se puede acceder a la url
  http://localhost:8000/api/documentation

### Creando anotaciones
El fichero yaml contendrá algún dato obligatorio:

Vamos de forma creciente creando el fichero entendiendo la información que vamos aportando.
#### Información básica
Estos elementos son obligatorios
| Elemento | Ubicación | Función |
|-----------|-----------|----------|
| `info` | Raíz del documento | Define la información general de la API: título, versión, descripción, términos de uso, contacto y licencia. |
| `servers` | Raíz del documento | Lista los servidores donde está disponible la API. Swagger UI utilizará el primero por defecto. |
| `paths` | Raíz del documento | Contiene todos los endpoints de la API agrupados por URL. |

{{< highlight yaml "linenos=inline, hl_lines=, style=emacs" >}}
openapi: 3.0.0

info:
title: API Gestión de Alumnos
version: 1.0.0

paths:{}
{{< /highlight >}}
Con esto ya podríamos tener una primera versión mínima (no operativa), de nuestro swagger


#### Aportando los entrypoints
A continuación aportarmeos información para cada uno de los  o entrypoint, igualmente vamos de forma general al detalle. 
Para ello crearemos un elemento por verbo http que corresponde a un rest full

PAra cada verbo vamos a agregar un argumento que es el **summary** o título

{{< highlight yaml "linenos=inline, hl_lines=, style=emacs" >}}
paths:
/students:
    get:
        summary: Listar alumnos
    post:
        summary: Insertar un alumno
    delete:
        summary: Eliminst un alumno
    put:
        summary: Modificar todos los datos de un alumno
    patch:
        summary: Modificar algún dato de un alumno
{{< /highlight >}}

Además del summary podemos (debemos aportar el código de respuesta con una descripcción)

{{< highlight yaml "linenos=inline, hl_lines=, style=emacs" >}}
openapi: 3.0.0

info:
title: API Gestión de Alumnos
version: 1.0.0

paths:
    /students:
        get:
            summary: Listar alumnos
            responses:
                '200':
                    description: Operación correcta
        post:
            summary: Insertar un alumno
            responses:
                '201':
                    description: Se ha incorporado el nuevo studiante
        delete:
            summary: Eliminado un alumno
            responses:
                '204':
                    description:Alumno eliminado
        put:
            summary: Modificar todos los datos de un alumno
            responses:
                '200':
                    description: Se han modificado todos los datos de un alumno 
        patch:
            summary: Modificar algún dato de un alumno
            responses:
                '200':
                    description: Se han modificado todos los datos de un alumno
{{< /highlight >}}
| Elemento | Función |
|-----------|----------|
| `/students` | Recurso de la API. |
| `get` | Verbo HTTP utilizado para consultar recursos. |
| `summary` | Descripción breve de la operación. |
| `responses` | Lista de respuestas posibles. |
| `200` | Código HTTP que indica éxito. |
| `description` | Explicación de la respuesta. |

#### Añadiendo  parámetros
Ahora la descripción empieza a hacer que el fichero crezca
Es el momento de describir de forma detallada cada item del recurso
| Elemento | Función |
|-----------|----------|
| `parameters` | Lista de parámetros de entrada. |
| `name` | Nombre del parámetro. |
| `in` | Ubicación del parámetro (`path`, `query`, `header` o `cookie`). |
| `required` | Indica si el parámetro es obligatorio. |
| `schema` | Define el tipo de dato. |
| `type` | Tipo del dato (`string`, `integer`, `boolean`, etc.). |

En nuestro caso (lo hacemos para get)
{{< highlight yaml "linenos=inline, hl_lines=, style=emacs" >}}
paths:
/students/{id}:
    get:
        summary: Obtener alumno
        parameters:
            - name: id
              in: path
              required: true
              schema:
                type: integer
            - name: name
              in: path
              required: true
              schema:
                type: string
            - name: email
              in: path
              required: true
              schema:
                type: string
            - name: age
              in: path
              required: true
              schema:
                type: integer

      responses:
        '200':
          description: Alumno encontrado
{{< /highlight >}}



#### Describiendo el contenido de la respuesta
Ahora toca especificar cómo es cada respuesta, según estos paráemtros


| Elemento | Función |
|-----------|----------|
| `content` | Describe el contenido devuelto por la API. |
| `application/json` | Tipo MIME de la respuesta. |
| `schema` | Estructura de los datos devueltos. |
| `properties` | Lista de atributos del objeto. |
| `example` | Ejemplo de respuesta. |


En nuestro ejemplo:
{{< highlight yaml "linenos=inline, style=emacs" >}}
paths:
/students/{id}:
    get:
      summary: Obtener alumno
      parameters:
        - name: id
          in: path
          required: true
          schema:
            type: integer
      responses:
        '200':
          description: Alumno encontrado
          content:
            application/json:
              schema:
                type: object
                properties:
                  id:
                    type: integer
                  name:
                    type: string
                  email:
                    type: string
                  age:
                    type: integer
              example:
                id: 1
                name: María Rodríguez
                email: juan@example.com
                age: 18
{{< /highlight >}}



### Fase 6. Definición de modelos

En lugar de repetir la definición de un alumno en cada endpoint, podemos crear un modelo reutilizable.

{{< highlight yaml "linenos=inline, style=emacs" >}}
components:

schemas:

    Student:

      type: object

      required:
        - id
        - name
        - email

      properties:

        id:
          type: integer

        name:
          type: string

        email:
          type: string

        age:
          type: integer
{{< /highlight >}}

Ahora podemos reutilizarlo en cualquier respuesta:

{{< highlight yaml "linenos=inline, style=emacs" >}}
responses:

'200':
description: Alumno encontrado

    content:
      application/json:

        schema:
          $ref: '#/components/schemas/Student'
{{< /highlight >}}

### Fase 7. Definición de errores

Una API debe documentar tanto los casos de éxito como los posibles errores.

{{< highlight yaml "linenos=inline, style=emacs" >}}
responses:

'200':
description: Alumno encontrado

'404':
description: Alumno no encontrado

'500':
description: Error interno del servidor
{{< /highlight >}}

También podemos definir un modelo reutilizable para los errores:

{{< highlight yaml "linenos=inline, style=emacs" >}}
components:

schemas:

    Error:

      type: object

      properties:

        status:
          type: integer

        title:
          type: string

        detail:
          type: string
{{< /highlight >}}

### Fase 8. Cabeceras HTTP

Además de los parámetros de ruta o consulta, las peticiones HTTP pueden incluir información adicional en las cabeceras.

{{< highlight yaml "linenos=inline, style=emacs" >}}
parameters:

- name: Accept
  in: header
  required: true

  schema:
  type: string

- name: Content-Type
  in: header
  required: true

  schema:
  type: string
  {{< /highlight >}}

### Fase 9. Cabeceras obligatorias en JSON:API

El estándar JSON:API exige el uso del tipo MIME `application/vnd.api+json`.

{{< highlight yaml "linenos=inline, style=emacs" >}}
parameters:

- name: Accept
  in: header
  required: true

  schema:
  type: string
  default: application/vnd.api+json

- name: Content-Type
  in: header
  required: true

  schema:
  type: string
  default: application/vnd.api+json
  {{< /highlight >}}

Una petición real tendría este aspecto:

{{< highlight http "linenos=inline, style=emacs" >}}
GET /api/students/1 HTTP/1.1
Accept: application/vnd.api+json
Content-Type: application/vnd.api+json
{{< /highlight >}}

### Fase 10. Componentes reutilizables para JSON:API

Como estas cabeceras se utilizarán en muchos endpoints, resulta conveniente reutilizarlas.

{{< highlight yaml "linenos=inline, style=emacs" >}}
components:

parameters:

    AcceptJsonApi:

      name: Accept
      in: header
      required: true

      schema:
        type: string
        default: application/vnd.api+json

    ContentTypeJsonApi:

      name: Content-Type
      in: header
      required: true

      schema:
        type: string
        default: application/vnd.api+json
{{< /highlight >}}

Posteriormente podremos utilizarlas mediante referencias:

{{< highlight yaml "linenos=inline, style=emacs" >}}
parameters:

- $ref: '#/components/parameters/AcceptJsonApi'

- $ref: '#/components/parameters/ContentTypeJsonApi'
  {{< /highlight >}}

### Fase 11. Autenticación

Muchas APIs requieren que el cliente se autentique mediante un token.

Primero definimos el mecanismo de autenticación:

{{< highlight yaml "linenos=inline, style=emacs" >}}
components:

securitySchemes:

    BearerAuth:

      type: http
      scheme: bearer
      bearerFormat: JWT
{{< /highlight >}}

Y después indicamos qué operaciones lo requieren:

{{< highlight yaml "linenos=inline, style=emacs" >}}
security:

- BearerAuth: []
  {{< /highlight >}}

La petición incluiría una cabecera similar a:

{{< highlight http "linenos=inline, style=emacs" >}}
Authorization: Bearer eyJhbGciOiJIUzI1NiIs...
{{< /highlight >}}

### Fase 12. Resultado final

Una vez incorporados todos estos elementos, disponemos de una documentación completa y profesional.

{{< highlight yaml "linenos=inline, style=emacs" >}}
openapi: 3.0.0

info:
title: API Gestión de Alumnos
version: 1.0.0

paths:

/students/{id}:

    get:

      summary: Obtener alumno

      parameters:

        - $ref: '#/components/parameters/StudentId'

        - $ref: '#/components/parameters/AcceptJsonApi'

      responses:

        '200':

          description: Alumno encontrado

          content:

            application/json:

              schema:

                $ref: '#/components/schemas/Student'

      security:

        - BearerAuth: []

components:

schemas:
...

parameters:
...

securitySchemes:
...
{{< /highlight >}}

A partir de este momento Swagger UI puede generar automáticamente una documentación interactiva y permitir probar los endpoints directamente desde el navegador.

[//]: # ()
[//]: # (| `components` | Raíz del documento | Repositorio reutilizable de parámetros, esquemas, respuestas, cabeceras y mecanismos de seguridad. |)

[//]: # (| `components.schemas` | `components` | Define modelos de datos reutilizables &#40;Alumno, Error, Usuario, etc.&#41;. |)

[//]: # (| `components.parameters` | `components` | Define parámetros reutilizables para cabeceras, rutas o query strings. |)

[//]: # (| `components.responses` | `components` | Define respuestas reutilizables para distintos códigos HTTP. |)

[//]: # (| `components.securitySchemes` | `components` | Define mecanismos de autenticación &#40;Bearer Token, OAuth2, API Key, etc.&#41;. |)

[//]: # (| `tags` | Raíz del documento | Agrupa endpoints por categorías funcionales dentro de Swagger UI. |)

[//]: # (| `security` | Raíz del documento o endpoint | Define los mecanismos de autenticación requeridos globalmente o para una operación concreta. |)

[//]: # (| `parameters` | Endpoint u operación | Define parámetros de entrada &#40;path, query, header o cookie&#41;. |)

[//]: # (| `requestBody` | Operación | Describe el cuerpo de una petición POST, PUT o PATCH. |)

[//]: # (| `responses` | Operación | Describe las posibles respuestas de un endpoint y sus códigos HTTP. |)

[//]: # (| `schema` | Dentro de parámetros, requestBody o responses | Describe la estructura y tipo de los datos intercambiados. |)

[//]: # (| `example` | Dentro de schema | Proporciona un ejemplo de valor para facilitar el uso de la API. |)

[//]: # (| `enum` | Dentro de schema | Limita los valores permitidos a una lista predefinida. |)

[//]: # (| `required` | Parámetros o propiedades | Indica que un campo o parámetro es obligatorio. |)

[//]: # (| `description` | Cualquier elemento | Añade documentación descriptiva visible en Swagger UI. |)

[//]: # ()
[//]: # (Y para parameters:)

[//]: # (| Parámetro | Función |)

[//]: # (|------------|----------|)

[//]: # (| `AcceptJsonApi` | Cabecera `Accept` obligatoria para indicar que el cliente acepta respuestas en formato JSON:API &#40;`application/vnd.api+json`&#41;. |)

[//]: # (| `ContentTypeJsonApi` | Cabecera `Content-Type` obligatoria para indicar que el cuerpo de la petición utiliza el estándar JSON:API. |)

[//]: # (| `StudentId` | Parámetro reutilizable de ruta &#40;`path`&#41; que identifica un alumno concreto. |)

[//]: # (| `PageNumber` | Parámetro opcional para paginación &#40;`page[number]`&#41;. |)

[//]: # (| `PageSize` | Parámetro opcional para tamaño de página &#40;`page[size]`&#41;. |)

[//]: # (| `Sort` | Parámetro opcional para ordenar resultados. |)

[//]: # (| `Filter` | Parámetro opcional para filtrar recursos según determinados criterios. |)

[//]: # (| `Include` | Parámetro opcional para incluir relaciones asociadas en la respuesta JSON:API. |)

[//]: # (| `Fields` | Parámetro opcional para seleccionar únicamente determinados atributos de un recurso. |)

[//]: # (| `Authorization` | Cabecera utilizada para enviar el token Bearer de autenticación. |)

[//]: # ()
[//]: # ()
