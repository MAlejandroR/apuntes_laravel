---
title: "Ejemplo de nuestro proyecto "
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 30
icon: fa-solid fa-diagram-project
---

# Landing autenticada en Laravel con Tailwind (Sin JavaScript)

## Objetivos

- Crear un grid reutilizable (máximo 3 columnas).
- Crear un componente card reutilizable.
- Implementar un menú principal con botón hamburguesa.
- Implementar un menú de usuario independiente.
- Usar solo Tailwind (sin JS).

---

# 1. Componente Grid

Ubicación:
resources/views/components/concept-grid.blade.php

```blade
<div class="grid 
            grid-cols-1 
            sm:grid-cols-2 
            lg:grid-cols-3 
            gap-6 
            auto-rows-fr">
    {{ $slot }}
</div>
```

## Explicación

- `grid` → activa CSS Grid.
- `grid-cols-1` → 1 columna en móvil.
- `sm:grid-cols-2` → 2 columnas en tablet.
- `lg:grid-cols-3` → máximo 3 columnas en desktop.
- `gap-6` → separación uniforme.
- `auto-rows-fr` → tarjetas misma altura.

---

# 2. Componente Card

Ubicación:
resources/views/components/concept-card.blade.php

```blade
@props([
    'title',
    'image',
    'url',
    'buttonText' => 'Ver más'
])

<div class="flex flex-col bg-white rounded-xl shadow-md 
            hover:shadow-lg transition 
            overflow-hidden h-full">

    <div class="flex justify-center items-center p-6 bg-gray-50">
        <img src="{{ $image }}" 
             alt="{{ $title }}" 
             class="h-16 object-contain">
    </div>

    <div class="flex flex-col flex-1 p-6 text-center">

        <h3 class="text-lg font-semibold mb-2">
            {{ $title }}
        </h3>

        <div class="text-sm text-gray-600 flex-1">
            {{ $slot }}
        </div>

        <div class="mt-4">
            <a href="{{ $url }}"
               class="inline-block px-4 py-2 rounded-lg 
                      border border-indigo-600 
                      text-indigo-600 
                      hover:bg-indigo-600 
                      hover:text-white transition">
                {{ $buttonText }}
            </a>
        </div>

    </div>
</div>
```

---

# 3. Navbar con dos toggles (sin JS)

## Concepto importante

No usamos dos hamburguesas iguales.

Separación clara:

- ☰ → Menú principal (navegación global)
- Usuario ▼ → Menú contextual del usuario

Ambos usan `peer`, pero son independientes.

---

# 3.1 Toggle del menú principal (Hamburguesa)

```blade
<div class="relative">

    <input type="checkbox" id="menu-toggle" class="hidden peer">

    <label for="menu-toggle"
           class="lg:hidden cursor-pointer text-2xl">
        ☰
    </label>

    <ul class="hidden 
               peer-checked:flex 
               flex-col 
               absolute 
               top-full left-0 
               w-full 
               bg-slate-800 
               text-white 
               lg:static 
               lg:flex 
               lg:flex-row 
               lg:w-auto 
               gap-6 
               p-4 lg:p-0">

        <li><a href="#">Inicio</a></li>
        <li><a href="#">Proyectos</a></li>
        <li><a href="#">Documentación</a></li>

    </ul>

</div>
```

### Funcionamiento

- `peer` → permite reaccionar al estado checked.
- `peer-checked:flex` → muestra el menú.
- En desktop (`lg:`) siempre visible.

---

# 3.2 Toggle del usuario (Dropdown independiente)

```blade
<div class="relative">

    <input type="checkbox" id="user-toggle" class="hidden peer">

    <label for="user-toggle"
           class="cursor-pointer px-3 py-1 
                  bg-slate-700 text-white 
                  rounded flex items-center gap-1">
        {{ auth()->user()->name }}
        <span class="text-xs">▼</span>
    </label>

    <div class="hidden 
                peer-checked:block 
                absolute 
                right-0 
                mt-2 
                w-44 
                bg-white 
                text-gray-800 
                rounded-lg 
                shadow-lg 
                border">

        <a href="/profile" 
           class="block px-4 py-2 hover:bg-gray-100">
            Perfil
        </a>

        <form method="POST" action="/logout">
            @csrf
            <button type="submit"
                    class="w-full text-left px-4 py-2 hover:bg-gray-100">
                Logout
            </button>
        </form>

    </div>

</div>
```

---

# 4. Conceptos que el alumnado debe entender

## 1. Separación de responsabilidades

- Grid → layout.
- Card → contenido.
- Navbar → navegación.
- Usuario → contexto de sesión.

## 2. Responsive design

Uso de prefijos:

- `sm:`
- `lg:`

## 3. Interactividad sin JS

Uso de:

- `peer`
- `peer-checked:*`
- `hidden`
- `absolute`

## 4. Limitaciones del enfoque sin JS

- No se cierra al hacer click fuera.
- No hay control de estado global.
- No hay animaciones complejas.

Es válido para aprendizaje y proyectos simples.

---

# Conclusión

Es posible crear:

- Landing autenticada.
- Grid responsive.
- Componentes reutilizables.
- Menú principal responsive.
- Dropdown de usuario.

Todo usando únicamente:

- Blade Components
- Tailwind CSS
- Sin JavaScript adicional.