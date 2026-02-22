---
title: "Plantillas en laravel"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 40
icon: fa-brands fa-html5"
---
# Plantillas en Laravel

En Laravel, las plantillas constituyen {{<color>}}la capa de presentación de la aplicación{{</color>}}. 

Son la parte encargada de generar {{<color>}}el HTML que finalmente recibe el navegador del usuario{{</color>}}. Sin embargo, no se trata de HTML estático aislado: _**las plantillas están directamente relacionadas con el código del backend**_, ya que:
* reciben datos desde los controladores, 
* muestran información dinámica 
* permiten integrar lógica mínima de presentación.

Dentro de la arquitectura MVC, las plantillas forman parte de la **Vista (View)**. El controlador prepara los datos y los envía a la vista, que se encarga de representarlos en formato HTML (o en otros formatos como JSON, si se trata de una API). De esta forma, se mantiene la separación entre lógica de negocio y presentación.
Las plantillas las escribiremos en la carpeta {{<color>}}./resources{{</color>}}.

Laravel ofrece distintas formas de gestionar esta capa de presentación, dependiendo del enfoque arquitectónico que se quiera adoptar.

---

## Blade

Blade es el motor de plantillas nativo de Laravel. Permite escribir HTML enriquecido con directivas especiales (`@if`, `@foreach`, `@extends`, etc.) que facilitan la inserción de datos dinámicos y la reutilización de estructuras.

Blade no es un framework frontend, sino un sistema de renderizado del lado del servidor. El HTML se genera completamente en el backend antes de enviarse al navegador. Es ideal para aplicaciones clásicas basadas en renderizado server-side y para proyectos donde no se necesita una SPA (Single Page Application).

En este caso Las plantillas se escriben en la carpeta ./resources/views.

Laravel no las sirve directamente al navegador. Cuando una vista se renderiza, el motor Blade la compila internamente a código PHP y la almacena en storage/framework/views.
* Ese código PHP compilado se ejecuta en el servidor y genera el HTML final que se envía al cliente.
---

## Vue, React u otros frameworks frontend

Laravel puede integrarse con frameworks modernos de frontend como Vue o React. En este caso, la generación del HTML dinámico se traslada principalmente al cliente (navegador), mientras que Laravel actúa como backend o como proveedor de API.

Esta integración puede realizarse de distintas formas:
- Como backend API puro (Laravel devuelve JSON).
- Mediante Inertia.js, que permite usar Vue o React sin necesidad de construir una API REST tradicional.
- En combinación con Vite, que gestiona el empaquetado de los recursos frontend.

Este enfoque es adecuado cuando se desea construir interfaces más dinámicas y reactivas.

En este caso, los ficheros (componentes), se escriben  en la carpeta resources/js.

Mediante herramientas como {{<color>}}Vite{{</color>}}, el código es procesado, transpìlado (por ejemplo, JSX o sintaxis moderna de JavaScript a JavaScript compatible con el navegador), y empaquetado en archivos optimizados que se generan en el directorio public/build.

Estos archivos son los que finalmente se sirven al navegador.

---

## Livewire

Livewire es una solución intermedia que permite crear interfaces dinámicas sin abandonar completamente el renderizado del lado del servidor. Funciona integrando componentes PHP que se comunican con el frontend mediante peticiones AJAX automáticas.

El desarrollador escribe principalmente código PHP y Blade, y Livewire se encarga de sincronizar los cambios con el navegador sin necesidad de escribir JavaScript complejo. Es una alternativa interesante cuando se quiere interactividad avanzada manteniendo una arquitectura centrada en Laravel.

---

En resumen, Laravel permite múltiples estrategias para la capa de presentación:

- Blade → Renderizado clásico del lado del servidor.
- Vue / React → Renderizado dinámico del lado del cliente.
- Livewire → Interactividad avanzada con lógica principalmente en PHP.

La elección depende del nivel de dinamismo requerido, la complejidad de la interfaz y la arquitectura general del proyecto.
