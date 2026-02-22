---
title: 'Cómo detectar y optimizar props pesadas en Inertia.js'
date: 2024-08-08T18:26:00+02:00
draft: false
tags: ['Inertia', 'Laravel', 'Performance']
categories: ['Optimización']
weight: 430
icon: fas fa-box-open
---

# 📦 Cómo detectar y optimizar props pesadas en Inertia.js

Inertia permite compartir datos desde Laravel al frontend, pero enviar **demasiada información** como props puede **ralentizar** tu aplicación.

---

## ❗ Problema común

En el middleware o en cada controlador puedes estar haciendo:

{{< highlight php "linenos=table" >}}
Inertia::share([
'auth' => [
'user' => Auth::user(),
'roles' => Auth::user()?->roles,
'permissions' => Auth::user()?->permissions,
],
'config' => Config::all(), // ❌ Cuidado con esto
'projects' => Project::all(), // ❌ Puede ser muy pesado
]);
{{< /highlight >}}

Eso puede generar respuestas enormes que se envían en **cada visita**.

---

## 🧪 1. Inspecciona las props en el navegador

En Chrome DevTools:

1. F12 → pestaña **Network**
2. Selecciona una petición de tipo `XHR` a tu app
3. Mira la respuesta → sección `props`
4. Verifica si estás enviando muchos datos (arrays, relaciones, textos largos...)

---

## 🧠 2. Usar Laravel Debugbar para ver tamaño de props

Instala Debugbar si no lo tienes:

{{< highlight bash "linenos=table" >}}
composer require barryvdh/laravel-debugbar --dev
{{< /highlight >}}

Activa:

{{< highlight dotenv "linenos=table" >}}
APP_DEBUG=true
DEBUGBAR_ENABLED=true
{{< /highlight >}}

Abre tu app y mira la pestaña **Inertia** de Debugbar. Te muestra:

- Tamaño total de los props
- Props compartidas vs props locales
- Tiempo en recopilar cada prop

---

## 🧰 3. Soluciones para optimizar

| Problema | Solución recomendada |
|---------|-----------------------|
| Estás usando `Project::all()` | Usa `paginate()`, `limit()` o `only(['id', 'name'])` |
| Envío de relaciones pesadas | Usa `with()` + `select()` para evitar campos innecesarios |
| Datos globales muy grandes | No uses `Inertia::share()`, pásalos solo donde se necesiten |

### Ejemplo correcto:

{{< highlight php "linenos=table" >}}
return Inertia::render('Dashboard', [
'projects' => Project::select('id', 'name')->limit(10)->get(),
]);
{{< /highlight >}}

---

## 📁 4. Alternativa: AJAX después del mount

Para datos grandes o dinámicos, lo mejor es **no enviarlos con Inertia** y cargarlos después con un `fetch` o `axios`.

### Ejemplo en Vue:

{{< highlight js "linenos=table" >}}
onMounted(async () => {
const res = await fetch('/api/projects')
projects.value = await res.json()
})
{{< /highlight >}}

---

## ✅ Buenas prácticas

- Usa `Inertia::share()` solo para datos realmente globales (idioma, usuario, CSRF...)
- Evita `::all()` y relaciones profundas por defecto
- Limita la cantidad de props que pasas por cada página
- Considera pasar datos con AJAX cuando sean pesados o se actualicen frecuentemente

---

¿Quieres que prepare una página específica sobre cómo **cargar datos con axios/fetch** desde Vue en una app con Inertia?
