---
title: "Vue"
date: 2023-04-08T18:21:47+02:00
draft: true
weight: 0
---

## Empezando
*Vue tiene dos maneras de ser utilizado:
1 Composition Api
2 Options Api

### Options Api
* Más antigua
* Mejor para empezar
* Mas legible
* Si el código crece, más difícil de mantener
* Organizas el código por el tipo de código (métodos, datos, ...)
{{< highlight javascript tabla_alumnos "linenos=table, hl_lines=" >}}
* <script>
export default {
data() {
return {
contador: 0,
};
},
methods: {
incrementar() {
this.contador++;
},
},
mounted() {
console.log("Componente montado");
},
};
</script>

<template>
  <button @click="incrementar">Contador: {{ contador }}</button>
</template>

{{< /highlight>}}
### Composition API
* Usaré esta
* Más moderna, mas expresiva, menos legible ....
* Se organiza el código por funcionalidad o por lógica
* El código  es más limpio y más fácil de mantener
* Va todo en <script setup> </script>
{{< highlight php tabla_alumnos "linenos=table, hl_lines=" >}}
<script>
export default {
data() {
return {
contador: 0,
};
},
methods: {
incrementar() {
this.contador++;
},
},
mounted() {
console.log("Componente montado");
},
};
</script>

<template>
  <button @click="incrementar">Contador: {{ contador }}</button>
</template>

{{< /highlight>}}
| Concepto                | Options API                               | Composition API                              |
|--------------------------|--------------------------------------------|----------------------------------------------|
| **Estilo**               | Clásico, estructurado por secciones        | Moderno, estructurado por lógica             |
| **Reutilización de código** | Difícil (mixins)                         | Fácil (composables)                          |
| **Soporte en Vue 3**     | Da soporte total (se puede usar)                                   | Es el modo Recomendado                               |
| **Ideal para**           | Proyectos pequeños o migraciones de Vue 2  | Proyectos nuevos, Inertia, Vite              |
| **Performance**          | Similar                                   | Similar (ligeramente mejor en algunos casos) |
