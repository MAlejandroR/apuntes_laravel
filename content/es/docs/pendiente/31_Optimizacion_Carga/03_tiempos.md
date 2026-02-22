---
title: 'tiempos de carga'
date: 2024-08-08T18:24:10+02:00
draft: false
tags: ['Vue', 'Inertia', 'Performance']
categories: ['Optimización']
weight: 420
icon: fas fa-code-split
---


## 🧰 3. Usar Laravel Debugbar

Para ver tiempos del backend: consultas, render Blade, controladores, etc.

### Instalación (solo en local)

{{< highlight bash "linenos=table" >}}
composer require barryvdh/laravel-debugbar --dev
{{< /highlight >}}

Actívalo en `.env`:

{{< highlight dotenv "linenos=table" >}}
APP_DEBUG=true
DEBUGBAR_ENABLED=true
{{< /highlight >}}

Te muestra:

- Tiempo total de ejecución
- Consultas SQL lentas
- Props de Inertia y su tamaño
- Eventos del ciclo de vida

---

## 🌐 4. Herramientas externas

- [Google Lighthouse](https://developers.google.com/web/tools/lighthouse)
- [GTmetrix](https://gtmetrix.com/)
- [WebPageTest](https://webpagetest.org/)

### Lighthouse en Chrome

1. F12 → pestaña **Lighthouse**
2. Selecciona tipo de análisis (Mobile/Desktop)
3. Ejecuta
4. Revisa: First Contentful Paint, JS Execution Time, etc.

---

## 📌 Recomendaciones

- Mide siempre en modo producción (`APP_ENV=production`)
- Usa `npm run build` para tener JS optimizado
- Usa `php artisan optimize` y `config:cache`
- Usa lazy loading donde puedas
- Reduce props innecesarias en `Inertia::share()`

---

¿Quieres que prepare también una guía para detectar **props pesadas en Inertia** y cómo optimizarlas?
