---
title: "Controlar componentes Vue desde Shepherd"
date: 2025-01-05T10:00:00+01:00
draft: false
weight: 1100
---

## Introducción

Cuando se utiliza **Shepherd** para crear tours guiados en una aplicación **Vue 3**, no es recomendable simular clics sobre el DOM. En su lugar, lo correcto es **controlar el estado interno de los componentes de forma reactiva**.

En este ejemplo se muestra cómo abrir programáticamente la primera unidad de una lista (como si el usuario hubiese hecho clic), manteniendo una arquitectura limpia y coherente con Vue.

---

## El problema

El estado que controla la apertura de una unidad vive dentro del componente hijo (`UnitItem`):

{{< highlight js "linenos=table" >}}
const isOpen = ref(false);
{{< /highlight >}}

Este estado **no debe modificarse desde fuera** manipulando el DOM, ya que se rompería el modelo reactivo de Vue.

---

## Exponer acciones desde el componente hijo

Vue 3 permite exponer métodos de un componente usando `defineExpose`.  
El componente `UnitItem` expone un método `open()` que modifica su estado interno:

{{< highlight js "linenos=table" >}}
const open = () => {
isOpen.value = true;
};

defineExpose({
open,
});
{{< /highlight >}}

De este modo, el componente mantiene el control de su propio estado y solo permite acciones explícitas desde el exterior.

---

## Referenciar el primer componente desde el padre

El componente padre (`UnitList`) crea un `ref` al **primer `UnitItem`** renderizado:

{{< highlight js "linenos=table" >}}
const firstUnitRef = ref(null);
{{< /highlight >}}

Y lo asigna de forma condicional en el template:

{{< highlight vue "linenos=table" >}}
<UnitItem
:ref="index === 0 ? firstUnitRef : undefined"
:unit="unit"
/>
{{< /highlight >}}

Este `ref` apunta a la **instancia del componente**, no a un elemento del DOM.

---

## Exponer una acción de alto nivel desde el componente padre

Para mantener una arquitectura limpia, el componente padre expone una acción clara que encapsula la lógica:

{{< highlight js "linenos=table" >}}
const openFirstUnit = () => {
firstUnitRef.value?.open();
};

defineExpose({
openFirstUnit,
});
{{< /highlight >}}

Esto evita que componentes externos conozcan detalles internos de los hijos.

---

## Uso desde Shepherd

Desde un paso del tour de Shepherd se puede llamar directamente a esta acción:

{{< highlight js "linenos=table" >}}
sidebarExercisesRef.value?.openFirstUnit();
{{< /highlight >}}

El resultado es la apertura reactiva de la unidad, sin simular clics ni manipular el DOM.

---

{{% pageinfo color="primary" %}}
**Idea clave:**  
Shepherd no debe interactuar directamente con el DOM. Su función es **orquestar acciones** sobre los componentes, no sustituir la lógica de Vue.
{{% /pageinfo %}}

---

## Modelo mental clave

- El **estado** vive en el componente hijo
- El **control** lo ejerce el componente padre
- Shepherd solo **coordina acciones**, no toca el DOM

El patrón **ref + defineExpose** es la forma correcta y escalable de integrar tours guiados en Vue 3.
