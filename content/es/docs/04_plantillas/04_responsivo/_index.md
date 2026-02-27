---
title: "Diseño responsivo"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 50
icon: fa-solid fa-mobile-screen-button
---

# Diseño responsivo

{{<color color="accent" size="1.8">}}
El diseño responsivo permite que una aplicación web se adapte dinámicamente al tamaño del dispositivo desde el que se visualiza.
{{</color>}}

Hoy en día una misma aplicación debe funcionar correctamente en:

- 📱 Móviles
- 📲 Tablets
- 💻 Portátiles
- 🖥️ Escritorio

La clave no es hacer varias webs, sino una única interfaz flexible.

---

## Diferencias entre responsivo y adaptativo

### 🔹 Diseño Responsivo (Responsive Web Design)

- Usa CSS flexible.
- Se basa en media queries.
- El layout se adapta de forma fluida.
- No depende de dispositivos concretos.
- Es el enfoque moderno.

 Cambia progresivamente según el ancho del viewport.

---

### 🔹 Diseño Adaptativo (Adaptive Design)

- Se crean varios layouts fijos.
- Cada layout está pensado para un rango de dispositivos.
- El servidor o el navegador decide cuál cargar.
- Es menos flexible.
- Mayor mantenimiento.

 No es fluido, salta entre versiones predefinidas.

---

## ¿Qué es y en qué consiste el diseño responsivo?

El diseño responsivo se basa en tres pilares:

### 1️⃣ Layout flexible
Uso de porcentajes, flexbox o grid en lugar de medidas fijas.

### 2️⃣ Imágenes flexibles
Las imágenes deben escalar con el contenedor.

{{<highlight css "linenos=table">}}
img {
max-width: 100%;
height: auto;
}
{{</highlight>}}

### 3️⃣ Media Queries
Permiten aplicar estilos según el ancho del dispositivo.

{{<highlight css "linenos=table">}}
@media (min-width: 768px) {
.contenedor {
display: flex;
}
}
{{</highlight>}}

---

## Tailwind y sistema mobile-first

Tailwind trabaja con enfoque **mobile-first**.

* Primero se diseñan estilos para móvil.  
* Después se añaden variantes para pantallas mayores.

Ejemplo:

{{<highlight html "linenos=table">}}
<div class="text-base md:text-xl lg:text-3xl">
    Texto adaptable
</div>
{{</highlight>}}

Explicación:

- text-base → móvil
- md:text-xl → desde 768px
- lg:text-3xl → desde 1024px

La clase sin prefijo siempre corresponde al tamaño más pequeño.

---

## Puntos de ruptura (Breakpoints)

En Tailwind por defecto:

- sm → 640px
- md → 768px
- lg → 1024px
- xl → 1280px
- 2xl → 1536px

Ejemplo práctico:

{{<highlight html "linenos=table">}}
<div class="flex flex-col md:flex-row">
    <aside class="w-full md:w-1/3">Sidebar</aside>
    <main class="w-full md:w-2/3">Contenido</main>
</div>
{{</highlight>}}

En móvil:
- Se muestran en columna.

En escritorio:
- Se muestran en fila.

---

## Ejemplo en nuestra aplicación

Caso típico en nuestro proyecto:

Header con logo + título + botones login/register.

En escritorio:
- Todo en horizontal.

En móvil:
- Se ocultan los botones.
- Aparece botón hamburguesa.
- Quitamos el título
- Lo ponemos en una columa
{{< imgproc  header_responsive Fill "747x345" >}}
  
{{< /imgproc >}}
- Ejemplo simplificado:


---

## Botón hamburguesa

El botón hamburguesa se utiliza para:

- Ahorrar espacio en móvil.
- Mostrar/ocultar navegación.
- Mantener la interfaz limpia.

Estructura básica:

{{<highlight html "linenos=table">}}
<button class="md:hidden p-2">
<span class="block w-6 h-0.5 bg-black mb-1"></span>
<span class="block w-6 h-0.5 bg-black mb-1"></span>
<span class="block w-6 h-0.5 bg-black"></span>
</button>
{{</highlight>}}

Puede combinarse con:

- hidden / block
- flex / absolute
- peer / peer-checked
- Alpine o Vue para control dinámico

---

{{<color color="accent" size="1.6">}}
Importante: el diseño responsivo no es opcional. Es un requisito estructural en cualquier aplicación web moderna.
{{</color>}}
### 1. Proceso de creación: clase {{<color>}}peer peer-checked{{</color>}} mantener hermanos con el id


Permite que un input controle el estado visual de sus hermanos posteriores.

 **Código mínimo**

{{<highlight html "linenos=table">}}
<input type="checkbox" class="peer sr-only" id="menu">

<div class="opacity-0 peer-checked:opacity-100">
    Contenido visible cuando está checked
</div>
{{</highlight>}}

 **Clases imprescindibles**

- `peer` → convierte al input en referencia.
- `peer-checked:*` → aplica estilos cuando el checkbox está marcado.
- `sr-only` → oculta visualmente el input pero mantiene accesibilidad.

Regla técnica: el elemento afectado debe ser **hermano posterior** del peer.

---.
### 2. menu oculto y controlado visible con {{<color>}}peer-checked {{</color>}} 
   **El menú existe en el DOM pero se muestra dinámicamente.**
{{<highlight html "linenos=table">}}
<div class="opacity-0 
            peer-checked:opacity-100
            transition-opacity duration-300">
    Menú
</div>
{{</highlight>}}

**Clases clave**

- `opacity-0` → estado inicial oculto.
- `peer-checked:opacity-100` → visible cuando está activo.
- `transition-opacity duration-300` → animación suave.

---



 
### 3. contenedor {{<color>}}relative{{</color>}} y menu {{<color>}}absolute{{</color>}} para colocar el menu 

Permite posicionar el menú respecto a su botón.

{{<highlight html "linenos=table">}}
<div class="relative">

    <label for="menu">Abrir</label>

    <div class="absolute left-full top-0 ml-2">
        Menú
    </div>

</div>
{{</highlight>}}

{{<color>}}Clases imprescindibles{{</color>}}

- `relative` → referencia de posicionamiento.
- `absolute` → saca el menú del flujo normal.
- `left-full` → lo coloca a la derecha.
- `top-0` → alineación vertical.

Sin `relative`, el menú se posiciona respecto al viewport.

---

### 4. {{<color>}}Overlay {{</color>}} para cerrar al hacer click fuera

Un segundo label con el mismo id permite cerrar el menú sin JavaScript.

{{<highlight html "linenos=table">}}
<label for="menu"
class="fixed inset-0 bg-black/40
opacity-0 pointer-events-none
peer-checked:opacity-100
peer-checked:pointer-events-auto
transition-opacity duration-300">
</label>
{{</highlight>}}

{{<color>}}Clases imprescindibles{{</color>}}

- `fixed` → posición respecto al viewport.
- `inset-0` → ocupa toda la pantalla.
- `bg-black/40` → oscurece el fondo.
- `pointer-events-none` → no bloquea cuando está oculto.
- `peer-checked:pointer-events-auto` → activa interacción.

Al hacer click en el overlay, el checkbox se desmarca.

### Resumen:  Estructura final

1. `peer` controla estado.
2. `peer-checked` modifica hermanos.
3. `relative + absolute` posiciona el menú.
4. Overlay con `fixed inset-0` permite cerrar sin JS.
5. Cada dropdown usa su propio checkbox.


### 5. {{<color>}}Otro peer para logout sin javascript{{</color>}}


Cada desplegable necesita su propio checkbox independiente para no interferir con el menú hamburguesa.

*Código:

{{<highlight html "linenos=table">}}
<div class="relative">
    <input type="checkbox" class="peer sr-only" id="user_menu">

    <label for="user_menu" class="cursor-pointer flex items-center gap-1">
        {{ auth()->user()->name }}

        <svg class="w-4 h-4 transition-transform duration-300
                    peer-checked:rotate-180"
             fill="none" stroke="currentColor"
             viewBox="0 0 24 24">
            <path stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M19 9l-7 7-7-7" />
        </svg>
    </label>

    <div class="absolute top-full mt-2
                opacity-0 scale-95
                peer-checked:opacity-100
                peer-checked:scale-100
                transition-all duration-300">
        Logout
    </div>

</div>
{{</highlight>}}

{{<color>}}Clases imprescindibles{{</color>}}

- `peer` → controla el estado del dropdown.
- `peer-checked:*` → activa visibilidad y animación.
- `relative` → referencia para posicionamiento.
- `absolute top-full` → menú aparece debajo.
- `transition-all` → anima opacity y transform.
- `peer-checked:rotate-180` → rota la flecha al abrir.

**Importante:**  
Cada menú (burger y logout) debe tener un `id` distinto y su propio `peer`, ya que cada checkbox controla únicamente a sus hermanos posteriores.


### Posible código final

{{< highlight php tabla_alumnos "linenos=table, hl_lines=" >}}
   <!--Para el buttron burguer, usaremos este checkbox-->
        {{-- 3) Panel desplegable --}}
        @guest
            <div class="relative">
            <input type="checkbox" class="peer sr-only"  id="burguer_button">
            <label for="burguer_button">
                <img class="w-8 h-8 object-containt" src="{{asset("/images/burguer.png")}}" alt="">
            </label>
                <label for="burguer_button"
                       class="fixed inset-0 bg-black/40
                  opacity-0 pointer-events-none
                  peer-checked:opacity-100
                  peer-checked:pointer-events-auto
                  transition-opacity duration-300">
                </label>
            <div class="opacity-0
                        peer-checked:opacity-100
                        transition-all duration-300 ease-out


             peer-checked:flex absolute bg-white p-2 flex-col left-9 top-4  transition rounded rounded-sm space-y-2">
                <a class="flex-1" href="{{ route('login') }}">
                    <button class="btn btn-sm btn-primary w-full" type="button">
                        Login
                    </button>
                </a>
                <a class="flex-1" href="{{ route('register') }}">
                    <button class="btn btn-sm btn-primary w-full" type="button">
                        Register
                    </button>
                </a>
            </div>
            </div>
        @endguest

        @auth
            <div class="relative">

                <input type="checkbox" class="peer sr-only" id="user_menu">

                <label for="user_menu"
                       class="cursor-pointer text-green-800 text-xl font-semibold">
                    {{ auth()->user()->name }}
                    <!-- Flecha -->
                    <svg class="w-4 h-4 transition-transform duration-300
                    peer-checked:rotate-180"
                         fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-width="2"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M19 9l-7 7-7-7" />
                    </svg>
                </label>

                <div class="absolute left-0 top-full mt-2
                bg-white p-3 rounded shadow flex flex-col

                opacity-0 scale-95
                peer-checked:opacity-100
                peer-checked:scale-100

                transition-all duration-300 ease-out">

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-primary w-full" type="submit">
                            Logout
                        </button>
                    </form>

                </div>

            </div>
        @endauth
{{< /highlight>}}