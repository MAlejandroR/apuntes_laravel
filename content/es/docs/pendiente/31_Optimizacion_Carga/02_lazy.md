---
title: 'Lazy Loading con Vue + Inertia'
date: 2024-08-08T18:24:10+02:00
draft: false
tags: ['Vue', 'Inertia', 'Performance']
categories: ['Optimización']
weight: 410
icon: fas fa-code-split
---

# 💤 Lazy Loading en Vue 3 + Inertia.js

**Lazy loading (carga diferida)** permite dividir tu frontend en partes pequeñas que se cargan **sólo cuando se necesitan**, mejorando mucho el rendimiento.

---

## ⚙️ Lazy loading de componentes Vue

Evita esto:

{{< highlight js "linenos=table" >}}
// ❌ Carga directa del componente
import Dashboard from '@/Pages/Dashboard.vue'
{{< /highlight >}}

Haz esto:

{{< highlight js "linenos=table" >}}
import { defineAsyncComponent } from 'vue'

const Dashboard = defineAsyncComponent(() =>
import('@/Pages/Dashboard.vue')
)
{{< /highlight >}}

Usado en el template:

{{< highlight vue "linenos=table" >}}
<template>
<Dashboard />
</template>
{{< /highlight >}}

---

## 📁 Lazy loading de vistas Inertia

### app.js (carga dinámica por nombre)

Esta configuración es estándar y muy eficiente:

{{< highlight js "linenos=table" >}}
// resources/js/app.js

createInertiaApp({
resolve: name =>
import(`./Pages/${name}.vue`).then(module => module.default),
setup({ el, App, props, plugin }) {
const app = createApp({ render: () => h(App, props) })
app.use(plugin).mount(el)
}
})
{{< /highlight >}}

Inertia cargará automáticamente **solo** el componente Vue que corresponda a la ruta Laravel.

---

## 🧩 Lazy loading con layouts

Puedes hacer que cada layout se cargue de forma diferida. Ejemplo:

### LayoutGuest.vue

{{< highlight js "linenos=table" >}}
export default {
name: 'LayoutGuest',
setup(_, { slots }) {
return () => h('div', { class: 'guest-layout' }, slots.default?.())
}
}
{{< /highlight >}}

### Página con layout asíncrono

{{< highlight js "linenos=table" >}}
<script setup>
import { defineAsyncComponent } from 'vue'

const Layout = defineAsyncComponent(() =>
  import('@/Layouts/LayoutGuest.vue')
)

defineOptions({ layout: Layout })
</script>
{{< /highlight >}}

Esto divide tu layout y evita que se cargue en páginas donde no es necesario (ej. admin).

---

## 📂 Lazy loading por secciones

Supón esta estructura de carpetas:

Pages/
├── Auth/
│ └── Login.vue
├── Admin/
│ └── Dashboard.vue

yaml
Copiar
Editar

Puedes modificar `resolve:` para detectar carpetas distintas:

{{< highlight js "linenos=table" >}}
resolve: name => {
if (name.startsWith('Admin/')) {
return import(`./Pages/Admin/${name.replace('Admin/', '')}.vue`).then(m => m.default)
}
return import(`./Pages/${name}.vue`).then(m => m.default)
}
{{< /highlight >}}

Esto te permite organizar mejor grandes áreas (como admin).

---

## 🧪 Medir rendimiento en DevTools

1. Abre Chrome DevTools → Network
2. Activa **Disable cache**
3. Navega entre páginas
4. Verás cómo los archivos `.js` sólo se descargan cuando hacen falta

---

## ✅ Ventajas del Lazy Loading

- ⚡ Reduce el **bundle inicial**
- 🧠 Mejora el **First Load** para usuarios
- 🔁 Compatible con layouts, rutas y secciones enteras
- 🔧 Sin configuración extra (funciona con Vite por defecto)

---

## 📌 Recomendaciones finales

- Usa lazy loading para vistas no críticas (admin, ajustes, estadísticas...)
- Siempre combina con `npm run build` en producción
- Agrupa layouts por sección si tu app tiene frontend + backend