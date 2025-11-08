---
title: 'Pinia'
date: 2024-08-08T18:23:50+02:00
draft: false
tags: ['Laravel', 'Pinia', 'Vue', 'Inertia']
categories: ['Laravel']
weight: 300
icon: fas fa-database
---
# 📦 ¿Qué es Pinia?

**Pinia** es una **librería de gestión de estado** para aplicaciones creadas con Vue.js (especialmente Vue 3). Permite **almacenar y compartir datos** de forma centralizada entre diferentes componentes.

Es el **reemplazo oficial** de Vuex, más sencilla y moderna, compatible con la **Composition API** y con soporte para TypeScript, devtools, SSR y más.

---

# 🧩 ¿Cuándo usar Pinia?

Usa Pinia cuando:

- Varios componentes necesitan **acceder o modificar el mismo estado**.
- Quieres tener **una fuente central de datos reactivos**.
- Necesitas **persistir datos**, como autenticación o configuración de usuario.
- Quieres **organizar tu lógica de negocio** fuera de los componentes.

---

# 🚀 Instalación básica

```bash
npm install pinia
```

Luego, en tu aplicación Vue 3:

{{< highlight js "linenos=table" >}}
import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'

const app = createApp(App)
app.use(createPinia()) // 👉 Instalamos Pinia como plugin
app.mount('#app')
{{< /highlight >}}

---

# 🛠️ Crear un store básico

```bash
mkdir stores
```

Creamos un archivo por store, por ejemplo: `stores/counter.js`

{{< highlight js "linenos=table" >}}
import { defineStore } from 'pinia'

export const useCounterStore = defineStore('counter', {
state: () => ({
count: 0
}),
actions: {
increment() {
this.count++
}
}
})
{{< /highlight >}}

---

# 🧑‍💻 Usar el store en un componente

{{< highlight vue "linenos=table" >}}
<script setup>
import { useCounterStore } from '@/stores/counter'

const counter = useCounterStore()

function aumentar() {
  counter.increment()
}
</script>

<template>
  <div>
    <p>Contador: {{ counter.count }}</p>
    <button @click="aumentar">+1</button>
  </div>
</template>
{{< /highlight >}}

---

# ✅ Ventajas de usar Pinia

- ✅ Sintaxis simple (Composition API friendly)
- ✅ Tipado automático (con TypeScript)
- ✅ Acceso directo a las propiedades sin `.value`
- ✅ Integración fácil con devtools
- ✅ Soporta módulos dinámicos, SSR, plugins, etc.

---

