---
title: "API OpenAI"
date: 2025-07-27T12:30:00+02:00
draft: true
weight: 80
---

# 📚 Course
**Chatbots personalizados con Laravel & OpenAI**
https://aprendible.com/series/chatbots-personalizados-con-laravel-openai

# 📘 Curso: Chatbots personalizados con Laravel & OpenAI

44 lecciones • 3h 08m  
Tecnologías: Laravel, Inertia.js, Vue 3, OpenAI

---

## 🔹 Módulo 1: Introducción

- Qué es OpenAI y su API
- Qué son los tokens y cómo se calculan los precios
- Casos de uso reales en Laravel

---

## 🔹 Módulo 2: Preparación del entorno

- Requisitos previos (PHP, Laravel, Composer, Node)
- Instalación paso a paso con Jetstream e Inertia
- Herramientas de calidad: Pint, PHPStan, Laravel DebugBar

---

## 🔹 Módulo 3: CRUD de Chatbots

- Modelo Chatbot con UUID
- Listado y detalle de chatbots
- Formularios de edición y validación
- Reutilización de componentes con Inertia

---

## 🔹 Módulo 4: Fuentes de conocimiento

- Subida de archivos (PDFs) con Inertia
- Extraer texto desde PDF y webs con DomCrawler
- Diseño de componentes (botón eliminar, listas con Tailwind)

---

## 🔹 Módulo 5: Chats en vivo

- Crear modelo `Chat` y `Message`
- Mostrar conversaciones y enviar mensajes
- Manejo de Shift+Enter, validación, textarea personalizado
- Inline editing de título de chat

---

## 🔹 Módulo 6: Integración con OpenAI

- Configurar API Key y librería
  {{< highlight php >}}
  OpenAI::chat()->create([
  'model' => 'gpt-4o',
  'messages' => [['role' => 'user', 'content' => 'Hola']],
  ]);
  {{</ highlight >}}

- Mostrar respuestas del modelo
- Calcular tokens usados y precios

---

## 📊 Tokens y precios

- Un *token* ≈ 4 caracteres o 0.75 palabras
- Precio depende del modelo (ej. GPT-4o es más caro que GPT-3.5)
- Se cobra por input y output tokens

---

## 📦 Recursos técnicos

- Laravel Jetstream + Inertia
- Tailwind CSS y Tailwind Merge
- DomCrawler de Symfony
- openai-php/laravel

---

## 🧠 Conocimientos clave adquiridos

- SPA con Laravel + Vue 3
- Componentes reutilizables
- Comunicación entre backend y frontend
- Procesamiento de lenguaje natural (NLP)

---


44 lecciones • 3h 08m

## 📌 Temas del curso
- Introducción al curso de Chatbots personalizados con Laravel & OpenAI – 05:03
- Prerequisitos para el Curso de Chatbots con Laravel y OpenAI – 00:42
- Instalación de una App Laravel con Inertia y Jetstream: Paso a Paso – 02:52
- Herramientas de Calidad – 05:29
- Cuándo y porqué utilizar UUIDs – 04:19
- Modelo Chatbot – 03:21
- Links de Navegación para los Chatbots – 02:26
- Listado de Chatbots – 06:34
- Formatear fechas en Javascript – 03:13
- Qué es y cómo utiliza Tailwind Merge – 03:46
- Restructurando los botones de Jetstream Vue – 04:52
- Uso de iconos con Vue3 – 02:54
- Detalle de un Chatbot – 03:03
- Página para editar Chatbots – 03:17
- Formulario para editar Chatbots – 06:08
- Validación del Chatbot – 02:45
- Actualizar Chatbot – 02:46
- Crear Chatbots – 02:56
- Cómo reutilizar formularios de inertia – 04:59
- Componente Textarea – 02:22
- Componente Select – 02:46
- Fuentes de conocimiento para los chatbots – 03:00
- Cómo crear ventanas modales – 05:00
- Formulario para crear fuentes de conocimientos – 04:10
- Formulario para crear fuentes de conocimientos - Parte 2 – 02:49
- Validación de las fuentes de conocimiento – 04:15
- Cómo subir archivos con Inertia – 05:57
- Diseñando el campo para seleccionar PDFs – 01:50
- Botón para quitar archivo – 04:05
- Listado de fuentes de conocimientos – 02:46
- Diseñando una Lista de elementos con Tailwind CSS – 07:22
- Mostrando Fuentes de Conocimiento en Laravel: PDFs y URLs en el Chatbot – 03:43
- Cómo eliminar una fuente de conocimiento con confirmación en Laravel (UX segura paso a paso) – 07:18
- Inertia v2 y Polling con Vue.js en Laravel – 03:02
- Extracción de texto desde un PDF en Laravel – 03:12
- Extrae Texto de Cualquier Web con Laravel y Symfony DomCrawler – 04:38
- Crear el Modelo Chat en Laravel: Relaciones, UUID y Estructura – 05:48
- Cómo editar el título de un chat en línea con Laravel e Inertia – 08:45
- Listado de conversaciones de un Chatbot – 11:05
- Componente Textarea para enviar mensajes – 07:09
- Integrar el componente ChatInput en la interfaz de chat con Vue y Laravel – 02:59
- Manejo de Shift+Enter en textareas con Vue 3 – 02:16
- Modelo Message y Rutas Anidadas – 07:22
- Introducción a la API de OpenAI: Qué es, cómo funciona, precios y tokens – 03:07

---

# 🧠 Introducción a la API de OpenAI: qué es, cómo funciona, precios y tokens

En esta clase aprenderás los conceptos esenciales para trabajar con OpenAI en un proyecto Laravel + Inertia.js + Vue.

## ✅ ¿Qué es OpenAI?
OpenAI es una empresa que desarrolla modelos de inteligencia artificial como **GPT**, que pueden generar texto, resumir, traducir, etc.

Con su API puedes construir chatbots, asistentes virtuales y muchas más aplicaciones.

---

## ⚙️ ¿Cómo funciona su API?
OpenAI ofrece una API REST a la que puedes enviar peticiones HTTP.

En Laravel puedes usar el cliente HTTP (`Http::post()`) para enviar prompts y recibir las respuestas del modelo.

Ejemplo:

{{< highlight php >}}
$response = Http::withToken(env('OPENAI_API_KEY'))
->post('https://api.openai.com/v1/chat/completions', [
'model' => 'gpt-4o',
'messages' => [
['role' => 'user', 'content' => 'Hola, ¿qué tal?'],
],
]);
$text = $response->json('choices.0.message.content');
{{</ highlight >}}

En tu app con Inertia.js y Vue:
- Laravel hace la petición a OpenAI.
- Vue muestra el texto generado al usuario.
- Inertia mantiene todo sincronizado sin recargar la página.

---

## 🧩 ¿Qué son los tokens?
Los modelos de OpenAI no trabajan directamente con palabras, sino con **tokens** (que pueden ser palabras, partes de palabras o signos de puntuación).

Ejemplo:
- `"Hola, ¿qué tal?"` ≈ 5 tokens.

El número de tokens determina cuánto te costará cada petición:
- Tokens que envías (prompt)
- Tokens que devuelve el modelo (respuesta)

---

## 💰 ¿Cómo se calculan los precios?
El coste depende de:
- El modelo que elijas (ejemplo: `gpt-4o` es más caro que `gpt-3.5-turbo`).
- Cuántos tokens usas en total.

El precio se indica como **precio por 1.000 tokens**.

Ejemplo: si el modelo cuesta $0.01 por 1.000 tokens, y usas 500 tokens en total (entrada + salida), pagas $0.005.

---

✨ Con esto tienes una visión general para empezar a crear tu chatbot personalizado con Laravel, Inertia.js y Vue usando la API de OpenAI.
# 🖼 Uso de iconos con Vue3 – 02:54

### 📌 ¿Por qué usar iconos?
Los iconos mejoran la interfaz: guían visualmente y hacen más intuitiva la navegación.

### ✅ Paso a paso

**1️⃣ Elegir una librería**  
Por ejemplo, [Heroicons](https://heroicons.com/) o [Lucide](https://lucide.dev/). Ambas tienen soporte oficial para Vue 3.

**2️⃣ Instalar con npm**  
Ejemplo con Heroicons:
{{< highlight bash >}}
npm install @heroicons/vue
{{</ highlight >}}

**3️⃣ Importar el icono que necesitas**  
En tu componente Vue:
{{< highlight vue >}}
<script setup>
import { PlusIcon } from '@heroicons/vue/24/solid';
</script>
{{</ highlight >}}

**4️⃣ Usarlo en la plantilla**  
{{< highlight vue >}}
<template>
<button class="flex items-center space-x-1 text-blue-500">
<PlusIcon class="w-5 h-5" />
<span>Nuevo</span>
</button>
</template>
{{</ highlight >}}

### 🎨 Consejo
- Puedes controlar el tamaño con clases Tailwind (`w-4 h-4`, `w-6 h-6`).
- Cambiar color con `text-blue-500`, `text-gray-600`, etc.

Así tendrás iconos consistentes, escalables y fáciles de mantener.

---

# 📋 Detalle de un Chatbot – 03:03

### 🎯 Objetivo
Mostrar información detallada de un chatbot seleccionado:
- Nombre
- Descripción
- Fecha de creación
- Opcional: botones para editar o eliminar

### ✅ Paso a paso

**1️⃣ Crear ruta en Laravel**
{{< highlight php >}}
Route::get('/chatbots/{chatbot}', [ChatbotController::class, 'show'])
->name('chatbots.show');
{{</ highlight >}}

**2️⃣ Controlador**
{{< highlight php >}}
public function show(Chatbot $chatbot)
{
return Inertia::render('Chatbots/Show', [
'chatbot' => $chatbot,
]);
}
{{</ highlight >}}

**3️⃣ Componente Vue `Show.vue`**
{{< highlight vue >}}
<template>
  <div>
    <h1 class="text-xl font-bold mb-2">{{ chatbot.name }}</h1>
    <p class="text-gray-700">{{ chatbot.description }}</p>
    <p class="text-xs text-gray-500">Creado el: {{ formatDate(chatbot.created_at) }}</p>

    <div class="mt-4 space-x-2">
      <inertia-link :href="route('chatbots.edit', chatbot.id)" class="btn">Editar</inertia-link>
    </div>
  </div>
</template>

<script setup>
const props = defineProps(['chatbot']);
function formatDate(date) {
  return new Date(date).toLocaleDateString('es-ES');
}
</script>
{{</ highlight >}}

### 🔍 Resultado
Página detallada clara, mostrando datos y permitiendo navegar a editar.

---

# 📝 Página para editar Chatbots – 03:17

### 🎯 Objetivo
Tener una vista para editar los datos de un chatbot existente.

### ✅ Paso a paso

**1️⃣ Ruta en Laravel**
{{< highlight php >}}
Route::get('/chatbots/{chatbot}/edit', [ChatbotController::class, 'edit'])
->name('chatbots.edit');
{{</ highlight >}}

**2️⃣ Método `edit` en el controlador**
{{< highlight php >}}
public function edit(Chatbot $chatbot)
{
return Inertia::render('Chatbots/Edit', [
'chatbot' => $chatbot,
]);
}
{{</ highlight >}}

**3️⃣ Componente Vue `Edit.vue`**
{{< highlight vue >}}
<template>
  <div>
    <h1 class="text-xl font-bold mb-4">Editar Chatbot</h1>
    <ChatbotForm :initialData="chatbot" @submit="updateChatbot" />
  </div>
</template>

<script setup>
import ChatbotForm from './Partials/ChatbotForm.vue';
const props = defineProps(['chatbot']);

function updateChatbot(data) {
  router.put(route('chatbots.update', props.chatbot.id), data);
}
</script>
{{</ highlight >}}

### 🔄 Nota
Se usa un formulario reutilizable `ChatbotForm` que recibe datos iniciales.

---

# 🧰 Formulario para editar Chatbots – 06:08

### 🎯 Objetivo
Crear un formulario reutilizable para crear y editar chatbots.

### ✅ Paso a paso

**1️⃣ Crear componente `ChatbotForm.vue`**
{{< highlight vue >}}
<template>
  <form @submit.prevent="submit">
    <div class="mb-4">
      <label class="block">Nombre</label>
      <input v-model="form.name" class="input" />
    </div>

    <div class="mb-4">
      <label class="block">Descripción</label>
      <textarea v-model="form.description" class="input"></textarea>
    </div>

    <button type="submit" class="btn-primary">Guardar</button>
  </form>
</template>

<script setup>
import { reactive } from 'vue';
const props = defineProps(['initialData']);
const emit = defineEmits(['submit']);

const form = reactive({
  name: props.initialData?.name || '',
  description: props.initialData?.description || '',
});

function submit() {
  emit('submit', { ...form });
}
</script>
{{</ highlight >}}

**2️⃣ Reutilizar el formulario**
- En `Edit.vue`: para editar
- En `Create.vue`: para crear

---

# ✅ Validación del Chatbot – 02:45

### 🎯 Objetivo
Validar los datos antes de guardar.

**En Laravel**
{{< highlight php >}}
$request->validate([
'name' => 'required|string|max:255',
'description' => 'nullable|string',
]);
{{</ highlight >}}

**En Vue**
Puedes mostrar errores:
{{< highlight vue >}}
<p v-if="errors.name" class="text-red-500">{{ errors.name }}</p>
{{</ highlight >}}

---

# 🔄 Actualizar Chatbot – 02:46

### 🎯 Objetivo
Guardar cambios del chatbot.

**En el controlador**
{{< highlight php >}}
public function update(Request $request, Chatbot $chatbot)
{
$validated = $request->validate([
'name' => 'required|string|max:255',
'description' => 'nullable|string',
]);

    $chatbot->update($validated);

    return redirect()->route('chatbots.index')
                     ->with('success', 'Chatbot actualizado');
}
{{</ highlight >}}

---

# ➕ Crear Chatbots – 02:56

### 🎯 Objetivo
Permitir crear nuevos chatbots.

**1️⃣ Ruta**
{{< highlight php >}}
Route::get('/chatbots/create', [ChatbotController::class, 'create'])
->name('chatbots.create');
{{</ highlight >}}

**2️⃣ Método `create`**
{{< highlight php >}}
public function create()
{
return Inertia::render('Chatbots/Create');
}
{{</ highlight >}}

**3️⃣ En Vue**
Reutilizas `ChatbotForm` y envías los datos:
{{< highlight js >}}
function createChatbot(data) {
router.post(route('chatbots.store'), data);
}
{{</ highlight >}}

---

# ♻️ Cómo reutilizar formularios de Inertia – 04:59

### ✅ Crear `ChatbotForm.vue` (como vimos antes)
- Recibe `initialData` para editar.
- Si no hay datos, es crear.

**Beneficio**:
- Mantienes mismo diseño y validación.
- Cambia solo la lógica al guardar.

---

# 📝 Componente Textarea – 02:22

### 🎯 Objetivo
Tener un textarea reutilizable con `v-model` para usar en cualquier formulario.

---

## ✅ Paso a paso

**1️⃣ Crear el componente `Textarea.vue`**
{{< highlight vue >}}
<template>
<textarea
class="border rounded w-full p-2"
:value="modelValue"
@input="$emit('update:modelValue', $event.target.value)"
></textarea>
</template>

<script setup>
defineProps(['modelValue']);
</script>
{{</ highlight >}}

---

**2️⃣ Usarlo**
{{< highlight vue >}}
<Textarea v-model="form.description" />
{{</ highlight >}}

Así puedes usarlo igual que un `<textarea>` normal, pero centralizando estilos y lógica.

---

# 🔽 Componente Select – 02:46

### 🎯 Objetivo
Un componente reutilizable para `<select>`.

---

## ✅ Paso a paso

**1️⃣ Crear `Select.vue`**
{{< highlight vue >}}
<template>
<select
class="border rounded w-full p-2"
:value="modelValue"
@change="$emit('update:modelValue', $event.target.value)"
>
    <option v-for="option in options" :key="option.value" :value="option.value">
      {{ option.label }}
    </option>
  </select>
</template>

<script setup>
defineProps(['modelValue', 'options']);
</script>
{{</ highlight >}}

---

**2️⃣ Usarlo**
{{< highlight vue >}}
<Select v-model="form.type" :options="[
{ value: 'pdf', label: 'PDF' },
{ value: 'url', label: 'URL' }
]" />
{{</ highlight >}}

Permite usarlo para elegir tipo de fuente de conocimiento, etc.

---

# 📚 Fuentes de conocimiento para los chatbots – 03:00

### 🎯 ¿Qué son?
Documentos o enlaces que alimentan de contexto al chatbot para responder mejor.

---

## ✅ Paso a paso

**1️⃣ Crear modelo `Source`**
{{< highlight bash >}}
php artisan make:model Source -m
{{</ highlight >}}

---

**2️⃣ Migración**
{{< highlight php >}}
$table->uuid('id')->primary();
$table->foreignUuid('chatbot_id');
$table->string('title');
$table->enum('type', ['pdf', 'url']);
$table->string('file_path')->nullable();
$table->string('url')->nullable();
{{</ highlight >}}

---

**3️⃣ Relación en `Chatbot`**
{{< highlight php >}}
public function sources()
{
return $this->hasMany(Source::class);
}
{{</ highlight >}}

---

# 🪟 Cómo crear ventanas modales – 05:00

### 🎯 Objetivo
Mostrar formularios o confirmaciones sin recargar.

---

## ✅ Paso a paso

**1️⃣ Crear `Modal.vue`**
{{< highlight vue >}}
<template>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center">
    <div class="bg-white p-4 rounded shadow max-w-md w-full">
      <slot />
    </div>
  </div>
</template>
{{</ highlight >}}

---

**2️⃣ Controlar visibilidad**
{{< highlight vue >}}
<Modal v-if="showModal">
  <p>Contenido del modal</p>
</Modal>
{{</ highlight >}}

---

# 📤 Cómo subir archivos con Inertia – 05:57

### 🎯 Objetivo
Permitir que el usuario cargue PDFs como fuentes.

---

## ✅ Paso a paso

**1️⃣ Formulario**
{{< highlight vue >}}
<input type="file" @change="handleFile" />
{{</ highlight >}}

---

**2️⃣ Crear `FormData` y enviar**
{{< highlight js >}}
function handleFile(event) {
const file = event.target.files[0];
const formData = new FormData();
formData.append('file', file);
formData.append('title', form.title);
formData.append('type', form.type);

router.post(route('sources.store', chatbot.id), formData);
}
{{</ highlight >}}

---

**3️⃣ En Laravel**
{{< highlight php >}}
$file = $request->file('file');
$path = $file->store('sources');
{{</ highlight >}}

---

# 📁 Diseñando el campo para seleccionar PDFs – 01:50

Usar clases Tailwind:
{{< highlight vue >}}
<input type="file" class="border p-2 rounded w-full" />
{{</ highlight >}}

---

# ❌ Botón para quitar archivo – 04:05

Permite quitar archivo antes de enviar:
{{< highlight vue >}}
<button @click="form.file = null" class="text-red-500">Quitar</button>
{{</ highlight >}}

---

# 📄 Listado de fuentes de conocimientos – 02:46

En Laravel:
{{< highlight php >}}
$chatbot->load('sources');
{{</ highlight >}}

---

En Vue:
{{< highlight vue >}}
<ul>
  <li v-for="source in chatbot.sources" :key="source.id">
    {{ source.title }} ({{ source.type }})
  </li>
</ul>
{{</ highlight >}}

---

# 🎨 Diseñando lista con Tailwind CSS – 07:22

Tarjetas con sombra, padding, borde:
{{< highlight vue >}}
<div v-for="source in chatbot.sources" class="p-4 border rounded shadow mb-2">
  <p class="font-semibold">{{ source.title }}</p>
</div>
{{</ highlight >}}

---

# 📄 Mostrar PDFs y URLs en el Chatbot – 03:43

Si es PDF, mostrar enlace para descargar:
{{< highlight vue >}}
<a :href="`/storage/${source.file_path}`" target="_blank">Ver PDF</a>
{{</ highlight >}}

Si es URL, mostrar enlace:
{{< highlight vue >}}
<a :href="source.url" target="_blank">{{ source.url }}</a>
{{</ highlight >}}

---

# 🗑 Eliminar fuente de conocimiento con confirmación – 07:18

**1️⃣ Botón abre modal**
{{< highlight vue >}}
<button @click="showConfirm = true">Eliminar</button>
<Modal v-if="showConfirm">
  <p>¿Seguro?</p>
  <button @click="deleteSource(source.id)">Sí</button>
</Modal>
{{</ highlight >}}

---

**2️⃣ Enviar petición**
{{< highlight js >}}
function deleteSource(id) {
router.delete(route('sources.destroy', [chatbot.id, id]));
}
{{</ highlight >}}

---

# 🔄 Inertia v2 y Polling con Vue.js – 03:02

Petición cada x segundos:
{{< highlight js >}}
setInterval(() => {
router.reload();
}, 5000);
{{</ highlight >}}

---

# 📄 Extraer texto desde PDF en Laravel – 03:12

Instalar parser:
{{< highlight bash >}}
composer require smalot/pdfparser
{{</ highlight >}}

---

{{< highlight php >}}
$parser = new \Smalot\PdfParser\Parser();
$pdf = $parser->parseFile(storage_path('app/' . $source->file_path));
$text = $pdf->getText();
{{</ highlight >}}

---

# 🌐 Extraer texto de webs con DomCrawler – 04:38

{{< highlight bash >}}
composer require symfony/dom-crawler
{{</ highlight >}}

---

{{< highlight php >}}
$crawler = new \Symfony\Component\DomCrawler\Crawler($html);
$text = $crawler->filter('body')->text();
{{</ highlight >}}

---

# 💬 Crear el Modelo Chat – 05:48

{{< highlight bash >}}
php artisan make:model Chat -m
{{</ highlight >}}

---

Migración:
{{< highlight php >}}
$table->uuid('id')->primary();
$table->foreignUuid('chatbot_id');
$table->string('title');
{{</ highlight >}}

---

Relación:
{{< highlight php >}}
public function messages()
{
return $this->hasMany(Message::class);
}
{{</ highlight >}}

---
# ✏️ Cómo editar el título de un chat en línea con Laravel e Inertia – 08:45

### 🎯 Objetivo
Permitir al usuario cambiar el título del chat directamente en la interfaz (inline editing).

---

## ✅ Paso a paso

**1️⃣ Mostrar título editable**
{{< highlight vue >}}
<template>
  <div>
    <input
      v-model="title"
      @blur="updateTitle"
      class="border rounded px-2"
    />
  </div>
</template>
{{</ highlight >}}

---

**2️⃣ Enviar petición a backend**
{{< highlight js >}}
function updateTitle() {
router.put(route('chats.update', chat.id), { title });
}
{{</ highlight >}}

---

**3️⃣ En Laravel**
{{< highlight php >}}
public function update(Request $request, Chat $chat)
{
$chat->update($request->validate([
'title' => 'required|string|max:255',
]));
return back();
}
{{</ highlight >}}

---

# 📃 Listado de conversaciones de un Chatbot – 11:05

### 🎯 Mostrar todos los chats que un chatbot tiene.

---

## ✅ Paso a paso

**1️⃣ Relación en modelo `Chatbot`**
{{< highlight php >}}
public function chats()
{
return $this->hasMany(Chat::class);
}
{{</ highlight >}}

---

**2️⃣ Ruta en Laravel**
{{< highlight php >}}
Route::get('/chatbots/{chatbot}/chats', [ChatController::class, 'index'])
->name('chatbots.chats.index');
{{</ highlight >}}

---

**3️⃣ Controlador**
{{< highlight php >}}
public function index(Chatbot $chatbot)
{
return Inertia::render('Chats/Index', [
'chats' => $chatbot->chats,
]);
}
{{</ highlight >}}

---

**4️⃣ Vista en Vue**
{{< highlight vue >}}
<ul>
  <li v-for="chat in chats" :key="chat.id">
    {{ chat.title }}
  </li>
</ul>
{{</ highlight >}}

---

# 💬 Componente Textarea para enviar mensajes – 07:09

Textarea donde el usuario escribe mensajes.

---

## ✅ Paso a paso

**1️⃣ Crear `ChatInput.vue`**
{{< highlight vue >}}
<template>
  <form @submit.prevent="sendMessage">
    <textarea
      v-model="message"
      class="border rounded w-full p-2"
      placeholder="Escribe tu mensaje..."
    ></textarea>
    <button type="submit" class="btn-primary mt-2">Enviar</button>
  </form>
</template>

<script setup>
import { ref } from 'vue';
const message = ref('');
function sendMessage() {
  router.post(route('messages.store', chat.id), { content: message.value });
  message.value = '';
}
</script>
{{</ highlight >}}

---

# 🔗 Integrar ChatInput en la interfaz – 02:59

En vista `Chats/Show.vue`:
{{< highlight vue >}}
<template>
  <div>
    <div class="messages">
      <!-- Aquí listamos mensajes -->
    </div>
    <ChatInput />
  </div>
</template>
{{</ highlight >}}

---

# ↩️ Manejo de Shift+Enter en textareas – 02:16

Permitir salto de línea con Shift+Enter:
{{< highlight vue >}}
<textarea
@keydown.enter.exact.prevent="sendMessage"
@keydown.enter.shift.exact
></textarea>
{{</ highlight >}}

---

# 📦 Modelo Message y rutas anidadas – 07:22

### 🎯 Guardar los mensajes que se envían en el chat.

---

## ✅ Paso a paso

**1️⃣ Crear modelo**
{{< highlight bash >}}
php artisan make:model Message -m
{{</ highlight >}}

---

**2️⃣ Migración**
{{< highlight php >}}
$table->uuid('id')->primary();
$table->foreignUuid('chat_id');
$table->text('content');
{{</ highlight >}}

---

**3️⃣ Relación**
- En `Chat`: `$this->hasMany(Message::class)`
- En `Message`: `$this->belongsTo(Chat::class)`

---

**4️⃣ Rutas anidadas**
{{< highlight php >}}
Route::resource('chats.messages', MessageController::class);
{{</ highlight >}}

---

# 🧠 Introducción a la API de OpenAI – 03:07

### 🎯 Explicación clave

- **Qué es OpenAI**: compañía de IA creadora de modelos como GPT.
- **API**: permite enviar texto/preguntas y recibir respuestas.
- **Tokens**: unidad que mide el texto enviado + recibido.
- **Precio**: depende de la cantidad de tokens usados.

---

## 📦 En Laravel

**1️⃣ Instalar cliente oficial**
{{< highlight bash >}}
composer require openai-php/laravel
{{</ highlight >}}

---

**2️⃣ Configurar clave en `.env`**
{{< highlight env >}}
OPENAI_API_KEY=sk-xxxxxxxx
{{</ highlight >}}

---

**3️⃣ Llamar a la API**
{{< highlight php >}}
$response = OpenAI::chat()->create([
'model' => 'gpt-4o',
'messages' => [
['role' => 'user', 'content' => 'Hola!'],
],
]);
{{</ highlight >}}

---

**4️⃣ Leer respuesta**
{{< highlight php >}}
$text = $response->choices[0]->message->content;
{{</ highlight >}}

---

# 📊 Tokens y precios

- Cuantos más tokens, más caro.
- Precio = (tokens usados / 1000) × precio del modelo.

---

✨ **¡FIN DEL CURSO!** 🎉

---

# ✅ Resumen final
Has aprendido:
- Laravel + Inertia + Vue 3
- Componentes reutilizables (Textarea, Select, Modal)
- Subir archivos, manejar fuentes de conocimiento
- Crear modelos Chat, Message, Source
- Integración real con OpenAI

---

🚀 ¿Quieres que ahora te haga:
- un *índice resumen*
- un *PDF*
- o diagramas del flujo de la app?

👉 Solo dímelo y lo preparo.
