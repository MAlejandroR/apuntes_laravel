---
title: "Diagrama de flujo"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 60
icon: fa-solid fa-sitemap
---

# Idea del Diagrama

## 1. Configuración Inicial
- **Archivo de Configuración `fortify.php`**
    - Ruta: `config/fortify.php`
    - Elementos configurables: 
      - `features`,
      - `views`,
      - `guard`,
      - `passwords`, etc.
      - `username`,
      - `email`,
      - `lowercase_username`,
      - `home`,
      - `prefix`,
      - `domain`,
      - `middleware`,
      - `limiters`
## 2. Proceso de Autenticación
- **Solicitudes de Autenticación**
    - **Rutas de Fortify**
        - Registro 
          - `/register`
        - Inicio de sesión 
          - `/login`
        - Restablecimiento de contraseña 
          - `/forgot-password`,
          - `/reset-password`
    - **Controladores de Fortify**
        - `RegistersUsers`, 
        - `AuthenticatesUsers`, 
        - `ResetsPasswords`, 
        - `ConfirmsPasswords`, 
        - `VerifiesEmails`, 
        - `UpdatesPasswords`, 
        - `TwoFactorAuthenticatesUsers`, 
        - `LogoutUsers`
       - **Eventos y Acciones**
          - Registro exitoso
          - Inicio de sesión exitoso
          - Restablecimiento de contraseña exitoso

## 3. Personalización
- **Controladores Personalizados**
    - Sobrescribir los controladores de Fortify
    - Ubicación: `app/Http/Controllers/Auth`
- **Vistas Personalizadas**
    - Sobrescribir las vistas de Fortify
    - Ubicación: `resources/views/auth`

## 4. Funcionalidades Adicionales
- **Verificación de Dos Factores (2FA)**
    - Configuración en `fortify.php`
    - Clases: `TwoFactorAuthenticationController`
- **Verificación de Correo Electrónico**
    - Configuración en `fortify.php`
    - Clases: `EmailVerificationController`

## 5. Interacción con Modelos
- **User Model**
    - Métodos personalizados
    - Relaciones con otras entidades

## 6. Diagrama General
- **Componentes Principales**
    - Configuración Inicial
    - Proceso de Autenticación
    - Personalización
    - Funcionalidades Adicionales
    - Interacción con Modelos

# Detalles del Diagrama

## A. Configuración Inicial
- **Archivo de Configuración `fortify.php`**
    - Diagrama detallando las configuraciones clave y su impacto.

## B. Proceso de Autenticación
- **Solicitudes de Autenticación**
    - Flujo desde la solicitud del usuario hasta la respuesta del servidor.
    - Incluye rutas, controladores y vistas.

## C. Personalización
- **Controladores y Vistas Personalizadas**
    - Cómo sobrescribir y extender las funcionalidades de Fortify.

## D. Funcionalidades Adicionales
- **2FA y Verificación de Correo**
    - Flujo y clases involucradas.

## E. Interacción con Modelos
- **User Model**
    - Métodos importantes y relaciones.

# Ejemplo de Esquema del Diagrama

- **Nodo Central**: Laravel Fortify
- **Subnodos**:
    - Configuración Inicial
        - Archivo `fortify.php`
    - Proceso de Autenticación
        - Rutas
        - Controladores
        - Eventos
    - Personalización
        - Controladores Personalizados
        - Vistas Personalizadas
    - Funcionalidades Adicionales
        - 2FA
        - Verificación de Correo
    - Interacción con Modelos
        - User Model

# Conexiones

- Conexiones entre nodos mostrando el flujo de datos.
- Anotaciones en cada conexión para describir el propósito y funcionalidad.

Con esta estructura, podrás crear un diagrama en Draw.io que ilustre claramente cómo funciona Fortify, cómo se configura y cómo se puede personalizar para ajustarse a las necesidades específicas de tu aplicación Laravel.
