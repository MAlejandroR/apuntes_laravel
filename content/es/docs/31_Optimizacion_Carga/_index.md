---
title: 'Optimización de carga con Laravel + Inertia + Vue'
date: 2024-08-08T18:23:50+02:00
draft: false
tags: ['Laravel', 'Inertia', 'Vue', 'Filament']
categories: ['Optimización']
weight: 400
icon: fas fa-tachometer-alt
---

# ⚡ Optimización de carga con Laravel + Inertia + Vue

Este documento resume cómo **mejorar el tiempo de carga inicial** de una aplicación construida con Laravel, Inertia.js, Vue 3 y Filament.

---

## ⏱️ ¿Qué es un buen tiempo de carga?

- **< 1 segundo:** Ideal (SPA ya montada, datos mínimos).
- **1–2 segundos:** Aceptable (primera carga, dashboard simple).
- **> 3 segundos:** Puede sentirse lento.

Puedes medirlo desde DevTools → pestaña **Network**, o con código:

{{< highlight js "linenos=table" >}}
// resources/js/app.js
console.time('Inertia Initial Load')

createInertiaApp({
// ...
setup({ el, App, props, plugin }) {
const app = createApp({ render: () => h(App, props) })
app.use(plugin).mount(el)
console.timeEnd('Inertia Initial Load')
}
})
{{< /highlight >}}

---

## 🧪 Herramientas para medir rendimiento

- **Chrome DevTools → Network + Performance**
- **Laravel Debugbar** (en local)
- **Google Lighthouse**
- [GTmetrix](https://gtmetrix.com/)
- [WebPageTest](https://webpagetest.org/)

---

## 🧠 Backend (Laravel)

Optimiza el backend:

| Acción | Mejora |
|--------|--------|
| `with()` en relaciones | Evita consultas N+1 |
| Props mínimas | No enviar estructuras pesadas |
| Caching (`response`, `config`, `view`) | Mejora general |
| `php artisan optimize` | Compila rutas, config, etc. |
| OPcache activo | Aumenta rendimiento en producción |

---

## 🌐 Inertia.js

Evita pasar props innecesarias o demasiado grandes:

| Acción | Mejora |
|--------|--------|
| Props con datos esenciales | Reducir JSON y render |
| Lazy loading (async components) | Menor JS inicial |
| `Inertia::share()` solo para globales necesarios | Reducir bundle |
| `router.visit` después del login | Transiciones más limpias |

---

## 🧩 Vue 3 + Vite

Si usas Vite:

- ✅ `npm run build` en producción
- ✅ Imágenes en `.webp` o `.avif`
- ✅ `defineAsyncComponent` para componentes pesados

Ejemplo:

{{< highlight js "linenos=table" >}}
import { defineAsyncComponent } from 'vue'

const Dashboard = defineAsyncComponent(() =>
import('@/Pages/Dashboard.vue')
)
{{< /highlight >}}

---

## 🛠️ Filament

Filament es excelente como panel de administración, pero:

- Aumenta tamaño de assets (JS, CSS)
- Puede añadir scripts innecesarios si se carga en páginas Inertia

🔸 Recomendaciones:

- Usa layouts distintos (`admin.blade.php` vs `app.blade.php`)
- No mezcles Inertia y Filament en el mismo layout

---

## ✅ Checklist de optimización

- [ ] Modo producción (`APP_ENV=production`)
- [ ] `npm run build` ejecutado
- [ ] `php artisan optimize` y `config:cache` activado
- [ ] Assets minificados y en caché
- [ ] `Inertia::share()` no sobrecargado
- [ ] Lazy loading en componentes Vue
- [ ] Filament solo en panel admin

---

¿Quieres añadir una sección para **lazy loading de componentes o rutas**? Puedo generar esa parte también.
