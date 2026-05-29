---
title: "Creando un api"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 130
icon: fas fa-code
---
# Creando una API
{{% pageinfo%}}
### Términos importantes que hay que conocer
* API
* REST
* VERBOS HTTP
* RECURSOS
* CÓDIGOS DE ESTADO
#### 
****
{{% /pageinfo%}}
## API
Una {{<color_green>}}Interfaz de programación de aplicaciones {{</color_green>}}
*****Son sistemas o servicios que permiten que otras aplicaciones se comuniquen con ellos para intercambiar información o recursos.*****


Para ello exponen una {{<color>}}interfaz{{</color>}} que define cómo otras aplicaciones pueden comunicarse con ellas.

Por un lado una aplicación solicita datos {{<color_blue>}}(request){{</color_blue>}}, y la API se los devuelve {{<color_blue>}}(response){{</color_blue>}}.

{{<color_green>}}Application Programming Interface{{</color_green>}}
{{< imgproc API Fill "1800x1000" >}}
API Programa que recibe solicitudes y envía respuesta a otros programas
{{< /imgproc >}}
## REST
{{<color_green>}}REpresentational  State Transfer{{</color_green>}}(
Transferencia de Estado representacional)

{{< alert title="REST" color="warning" >}}
{{<color_green>}}REST{{</color_green>}} es una especificación o recomendación basada {{<color_green>}}en seis principios fundamentales {{</color_green>}}que definen su arquitectura. 
{{< /alert >}}

Estos principios indican {{<color_green>}}cómo deben representarse los datos que se desean transferir{{</color_green>}}, proporcionando una guía para el desarrollo de sistemas web eficientes y bien estructurados.
## PRINCIPIOS QUE DEFINEN LA ARQUITECTURA DE REST
****
{{<color_green>}}REST se basa en una serie de principios y restricciones que definen su arquitectura. A continuación, se resumen las seis guías o restricciones principales de REST:
{{</color_green>}}
_________

#### Arquitectura Cliente-Servidor:

- La arquitectura cliente-servidor separa la interfaz de usuario y la lógica del usuario (cliente) de la lógica del servidor.
- Mejora la portabilidad del cliente y la escalabilidad del servidor, ya que cada parte puede evolucionar independientemente.
- O sea que el API y el CLIENTE son dos entes independientes

#### Sin Estado (Stateless):

- Cada solicitud del cliente al servidor debe contener toda la información necesaria para entender y procesar la solicitud.
- El servidor no debe almacenar el estado del cliente entre solicitudes; cada solicitud desde un cliente se trata de forma independiente, por lo que - El servidor no debe depender de sesiones almacenadas entre peticiones. 
- La información necesaria para autenticar al usuario suele enviarse en cada petición, por ejemplo mediante tokens.


#### Cacheable (Almacenamiento en Caché):

- Las respuestas del servidor deben indicar si se pueden almacenar en caché o no.
- La caché puede mejorar la eficiencia y la escalabilidad al reducir la necesidad de recuperar la misma información una y otra vez.

#### Interfaz Uniforme:

- Define una interfaz uniforme entre los componentes, lo que facilita la independencia y la evolución de cada componente.
- 
- La interfaz uniforme se compone de cuatro restricciones:
    - Identificación de Recursos: Cada recurso (información o servicio) se identifica mediante un URI (Uniform Resource Identifier).
    - Manipulación de Recursos a través de Representaciones: Los recursos pueden ser representados y manipulados en diferentes formatos, como JSON o XML.
    - Mensajes Autodescriptivos: Cada mensaje incluye suficiente información para describir cómo procesar la solicitud.
    - HATEOAS (Hypertext As The Engine Of Application State): La aplicación es conducida por hipermedios proporcionados dinámicamente a través de aplicaciones de navegadores, es decir {{<color_green>}}el servidor debe de facilitar información que nos diga cómo navegar por la API, no solo facilitar datso{{</color_green>}}

#### Sistema de Capas (Layered System):

- La arquitectura se puede organizar en capas jerárquicas.
- Cada capa realiza una funcionalidad específica y solo interactúa directamente con las capas adyacentes.

#### Codigo Bajo Demanda (Code on Demand) [opcional]:

- Los clientes pueden descargar y ejecutar código (como applets o scripts) desde el servidor.
- Esta restricción es opcional y no se utiliza comúnmente en aplicaciones RESTful.

Estas restricciones definen los principios clave de REST y proporcionan una guía para desarrollar sistemas web eficientes, escalables y bien estructurados.


## Verbos HTTP
{{<color>}}Una API RESTful{{</color>}} suele utilizar HTTP y sus verbos para operar sobre recursos.
HTTP sabemos que es _un protocolo de comunicación utilizado para intercambiar información entre clientes y servidores web._
{{< alert title="Recurso" color="warning" >}}
Un recurso es información que está en el servidor a la cual vamos a poder acceder a través de una url
ej: http://localhost:8000/alumnos {{<color_green>}}alumnos es un recurso{{</color_green>}}
{{< /alert >}}
### Resource
### Representación