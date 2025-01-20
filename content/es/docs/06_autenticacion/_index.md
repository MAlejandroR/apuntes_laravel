---
title: "Autenticación"
date: 2023-04-08T18:21:47+02:00
draft: true
weight: 60
icon: fa-solid fa-sitemap
---
## Autenticación

**La autenticación** es *el proceso de verificar la identidad de un usuario que intenta acceder a una aplicación*.   

Su gestión debe de ser cuidadosa y correctapara proteger la información sensible y a mantener la integridad y privacidad de los datos de los usuarios. 

Además, siempre debemos tener en cuenta que estamos gestionando datos confidenciales de las entidades que se registran. Es fundamental respetar los principios de privacidad de datos y asegurarnos de cumplir con las normativas y mejores prácticas en protección de datos.    
 



### Opciones de Autenticación en Laravel

Laravel ofrece varias opciones para implementar la autenticación en una aplicación, cada una con sus propias características y casos de uso.

Cuando instalamos un nuevo proyecto de Laravel (usando Laravel 11 con el instalador de Laravel, no Composer), se nos plantea si queremos iniciar con uno de los stacks Breeze o Jetstream. 

A continuación, comentamos estos paquetes y otros disponibles, así como sus posibles combinaciones.
### Paquetes o Stacks Disponibles

* **Breeze**: Proporciona una implementación de autenticación simple y ligera, con vistas y controladores preconfigurados. 
* **Fortify**: Implementación de backend . No incluye vistas predeterminadas.
* **Sanctum**: Proporciona una solución ligera para la autenticación de API.
* **Jetstream**:  incluye  Fortify y otras opciones además de posibilidad de  frontend .
* **Passport**: Proporciona una implementación completa de OAuth2 para la autenticación de API.
* **Socialite**: autenticación social, permitiendo a los usuarios iniciar sesión utilizando proveedores de identidad como Facebook, Google, Twitter, etc.

Vamos a hacer una descripción sencilla pero un poco más detallada

#### 1. Laravel Breeze

**Descripción**: Laravel Breeze es una solución de autenticación simple y ligera que incluye vistas, controladores y rutas preconfiguradas. Está diseñado para proyectos pequeños y medianos donde se necesita una configuración rápida y sencilla.

**Características**:
- Configuración rápida y sencilla.
- Proporciona vistas y controladores básicos para la autenticación.
- Ideal para aplicaciones pequeñas o prototipos.

#### 2. Laravel Fortify

**Descripción**: Laravel Fortify es una implementación de backend para la autenticación de Laravel. Proporciona la funcionalidad básica de autenticación como inicio de sesión, registro, restablecimiento de contraseñas, verificación de correo electrónico y autenticación de dos factores, pero no incluye vistas predeterminadas.

**Características**:
- Mayor flexibilidad para crear tus propias vistas y lógica de frontend.
- Ideal para proyectos donde deseas un control completo sobre el diseño y la experiencia del usuario.

#### 3. Laravel Jetstream

**Descripción**: Laravel Jetstream es un paquete más completo que incluye todas las características de Fortify, además de gestión de equipos, perfiles de usuario y administración de sesiones. Ofrece dos opciones de frontend: Livewire (Blade) y Inertia.js (Vue.js).

**Características**:
- Proporciona un conjunto completo de características listas para usar.
- Incluye gestión de equipos, perfiles de usuario y administración de sesiones.
- Opciones de frontend con Livewire y Inertia.js.
- Ideal para aplicaciones complejas que requieren funcionalidad avanzada.

#### 4. Laravel Sanctum

**Descripción**: Laravel Sanctum proporciona una solución ligera para la autenticación de API, tokens API simples y autenticación basada en cookies para aplicaciones SPA (Single Page Applications).

**Características**:
- Tokens API simples sin la complejidad de OAuth.
- Autenticación basada en cookies para SPAs.
- Ideal para aplicaciones que necesitan autenticación de API sencilla.

#### 5. Laravel Socialite

**Descripción**: Laravel Socialite es una solución para la autenticación social, permitiendo a los usuarios iniciar sesión utilizando proveedores de identidad como Facebook, Google, Twitter, etc.

**Características**:
- Fácil integración con proveedores de identidad social.
- Manejo sencillo de OAuth.
- Ideal para aplicaciones que desean permitir a los usuarios iniciar sesión con sus cuentas de redes sociales.

#### 6. Laravel Passport

**Descripción**: Laravel Passport proporciona una solución completa de OAuth2 para la autenticación de API. Es ideal para aplicaciones que necesitan un control detallado sobre los tokens de acceso y la autenticación de terceros.

**Características**:
- Implementación completa de OAuth2.
- Administración avanzada de tokens de acceso.
- Ideal para aplicaciones que necesitan autenticación de API robusta y segura.

### Combinaciones y Agrupaciones

Algunas de estas opciones pueden ser combinadas entre sí, mientras que otras son mutuamente excluyentes.

#### Agrupaciones Compatibles:

1. **Jetstream + Fortify**:
    - Jetstream utiliza Fortify como backend de autenticación.
    - Incluye características avanzadas como gestión de equipos y administración de sesiones.

2. **Fortify + Sanctum**:
    - Fortify puede manejar la autenticación de usuarios.
    - Sanctum puede proporcionar tokens API para la autenticación de aplicaciones SPA.

3. **Jetstream + Sanctum**:
    - Jetstream, que ya utiliza Fortify, puede integrarse con Sanctum para manejar tokens API y autenticación basada en cookies para SPAs.

4. **Fortify + Socialite**:
    - Fortify maneja la autenticación básica.
    - Socialite permite la autenticación social mediante proveedores de identidad.

5. **Jetstream + Socialite**:
    - Jetstream (con Fortify) maneja la autenticación básica y avanzada.
    - Socialite permite la autenticación social mediante proveedores de identidad.

6. **Fortify + Passport**:
    - Fortify maneja la autenticación de usuarios.
    - Passport proporciona una implementación completa de OAuth2 para la autenticación de API.

7. **Jetstream + Passport**:
    - Jetstream (con Fortify) maneja la autenticación básica y avanzada.
    - Passport proporciona una implementación completa de OAuth2 para la autenticación de API.

#### Agrupaciones Mutuamente Excluyentes:

1. **Breeze y Jetstream**:
    - Breeze y Jetstream son paquetes de inicio que proporcionan configuraciones completas de autenticación, por lo que no se utilizan juntos.
    - Breeze es para una configuración rápida y sencilla, mientras que Jetstream ofrece más funcionalidades avanzadas.
2. **Sanctum y Passport**:
   - Ambos proporcionan soluciones para la autenticación de API, pero con enfoques diferentes. Sanctum es ideal para aplicaciones más ligeras y sencillas, mientras que Passport ofrece una implementación completa de OAuth2 para necesidades más complejas.
   - No se utilizan juntos ya que ambos manejan la autenticación de API de maneras diferentes y no complementarias.

### Resumen

Cada una de estas opciones ofrece diferentes niveles de funcionalidad y complejidad. La elección de la solución de autenticación adecuada depende de las necesidades específicas de tu aplicación y del nivel de control que desees tener sobre el proceso de autenticación.

- **Laravel Breeze**: Para una implementación rápida y sencilla.
- **Laravel Fortify**: Para control completo sobre el backend de autenticación.
- **Laravel Jetstream**: Para una solución completa con funcionalidades avanzadas.
- **Laravel Sanctum**: Para autenticación de API sencilla.
- **Laravel Socialite**: Para autenticación social.
- **Laravel Passport**: Para autenticación de API robusta y segura.


