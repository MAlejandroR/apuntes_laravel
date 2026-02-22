---
title: 'Cargar datos desde Vue con Fetch o Axios (Inertia)'
date: 2024-08-08T18:27:00+02:00
draft: false
tags: ['Vue', 'Inertia', 'Laravel', 'Axios']
categories: ['Optimización']
weight: 440
icon: fas fa-cloud-download-alt
---

# 🌐 Cargar datos desde Vue con Fetch o Axios (Inertia.js)

Cuando los datos son **muy grandes** o cambian frecuentemente, es mejor **no enviarlos como props** con Inertia y en su lugar, **consultarlos desde el frontend** usando `fetch` o `axios`.

---

## ❓ ¿Por qué hacerlo así?

Enviar grandes cantidades de datos como props (por ejemplo, `Project::all()`) hace que:

- El tiempo de carga aumente
- La respuesta JSON de Inertia sea pesada
- Sea difícil hacer filtros/paginación en frontend

---

## ✅ Solución: usar `fetch()` o `axios` desde Vue

En lugar de pasar los datos con Inertia:

### 1. Crea una ruta API en Laravel

{{< highlight php "linenos=table" >}}
// routes/api.php

use App\Models\Project;
use Illuminate\Support\Facades\Route;

Route::get('/projects', function () {
return Project::select('id', 'name')->limit(10)->get();
});
{{< /highlight >}}

---

### 2. En tu componente Vue, carga los datos

#### Opción A: usando `fetch`

{{< highlight js "linenos=table" >}}
import { ref, onMounted } from 'vue'

const projects = ref([])

onMounted(async () => {
const res = await fetch('/api/projects')
projects.value = await res.json()
})
{{< /highlight >}}

#### Opción B: usando `axios`

Primero instálalo:

{{< highlight bash "linenos=table" >}}
npm install axios
{{< /highlight >}}

Luego:

{{< highlight js "linenos=table" >}}
import { ref, onMounted } from 'vue'
import axios from 'axios'

const projects = ref([])

onMounted(async () => {
const res = await axios.get('/api/projects')
projects.value = res.data
})
{{< /highlight >}}

---

### 3. Mostrar los datos en el `<template>`

{{< highlight vue "linenos=table" >}}
<template>
  <ul>
    <li v-for="project in projects" :key="project.id">
      {{ project.name }}
    </li>
  </ul>
</template>
{{< /highlight >}}

---

## 🔐 ¿Problemas con autenticación?

Si la API requiere que el usuario esté autenticado:

- Las rutas de `api.php` usan el middleware `api` (sin sesión)
- Puedes mover la ruta a `routes/web.php` y protegerla con `auth`

{{< highlight php "linenos=table" >}}
// routes/web.php

Route::middleware('auth')->get('/api/projects', function () {
return Project::select('id', 'name')->limit(10)->get();
});
{{< /highlight >}}

---

## ✅ Ventajas

- ⚡ Menos peso inicial al montar Inertia
- 🔄 Más fácil hacer filtros, scroll infinito, paginación...
- ♻️ Puedes reutilizar la misma API para otras interfaces (ej. móvil)

---

¿Te gustaría una página extra sobre cómo usar esta técnica junto a paginación o scroll infinito?
