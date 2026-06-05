---
title: "Cabeceras http"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 30
---
## Las cabeceras HTTP

La especificación JSON:API establece una serie de requisitos sobre las cabeceras HTTP que deben enviarse tanto en las solicitudes (*request*) como en las respuestas (*response*).

Estas cabeceras permiten que cliente y servidor acuerden el formato de los datos intercambiados y garantizan que ambos cumplen la especificación.

La gestión de las cabeceras en nuestra aplicación tiene dos sentidos:

### En las solicitudes

El servidor debe verificar que el cliente ha enviado las cabeceras requeridas.

Por ejemplo, en una operación de creación o modificación de recursos, el cliente deberá indicar que está enviando datos en formato JSON:API mediante la cabecera:

{{< highlight http >}}
Content-Type: application/vnd.api+json
{{< /highlight >}}

Asimismo, el cliente puede indicar que espera recibir la respuesta en formato JSON:API mediante:

{{< highlight http >}}
Accept: application/vnd.api+json
{{< /highlight >}}

Si alguna de estas cabeceras es incorrecta o no está presente cuando es obligatoria, el servidor deberá devolver el código de error correspondiente.

### En las respuestas

El servidor también debe incluir determinadas cabeceras en las respuestas que envía al cliente.

Por ejemplo, una respuesta correcta debería indicar el formato utilizado:

{{< highlight http >}}
Content-Type: application/vnd.api+json
{{< /highlight >}}

Además, en determinadas operaciones pueden ser necesarias otras cabeceras adicionales.

Por ejemplo, tras crear un recurso mediante una petición POST, es habitual devolver la ubicación del nuevo recurso utilizando la cabecera:

{{< highlight http >}}
Location: /api/students/15
{{< /highlight >}}

### Cabeceras más utilizadas en JSON:API

| Cabecera | Quién la envía | Finalidad |
|-----------|-----------|-----------|
| Accept | Cliente | Indica el formato que espera recibir. |
| Content-Type | Cliente y servidor | Indica el formato de los datos enviados. |
| Location | Servidor | Informa de la URI de un recurso recién creado. |
| Authorization | Cliente | Envía credenciales de autenticación. |

### Validación de cabeceras

Una buena práctica consiste en validar las cabeceras antes de procesar la petición.

Por ejemplo:

- Si falta la cabecera `Accept`, puede devolverse `406 Not Acceptable`.
- Si falta la cabecera `Content-Type` o contiene un valor incorrecto, puede devolverse `415 Unsupported Media Type`.
- Si la autenticación es obligatoria y no existe la cabecera `Authorization`, puede devolverse `401 Unauthorized`.

De esta forma evitamos procesar peticiones que no cumplen las reglas establecidas por la API.
## Cabeceras requeridas según el verbo HTTP

La especificación JSON:API establece principalmente el uso de las cabeceras `Accept` y `Content-Type`.

| Verbo HTTP | Accept | Content-Type | Observaciones |
|------------|---------|--------------|---------------|
| GET | Obligatoria | No necesaria | El cliente indica que espera recibir JSON:API. |
| POST | Obligatoria | Obligatoria | Se envían datos JSON:API al servidor. |
| PATCH | Obligatoria | Obligatoria | Se envían modificaciones de un recurso. |
| DELETE | Obligatoria | No necesaria | No se envía cuerpo en la petición. |
| HEAD | Obligatoria | No necesaria | Similar a GET, pero sin cuerpo de respuesta. |
| OPTIONS | Recomendada | No necesaria | Consulta capacidades del recurso. |

### Valores esperados

#### Accept

{{< highlight http >}}
Accept: application/vnd.api+json
{{< /highlight >}}

#### Content-Type

{{< highlight http >}}
Content-Type: application/vnd.api+json
{{< /highlight >}}

### Resumen práctico

| Verbo | Cabeceras mínimas |
|--------|------------------|
| GET | Accept |
| POST | Accept + Content-Type |
| PATCH | Accept + Content-Type |
| DELETE | Accept |
|

### Cabeceras en las respuestas

Todas las respuestas JSON:API deberían incluir:

{{< highlight http >}}
Content-Type: application/vnd.api+json
{{< /highlight >}}

Y en el caso de creación de recursos (`201 Created`) es recomendable incluir:

{{< highlight http >}}
Location: /api/students/15
{{< /highlight >}}