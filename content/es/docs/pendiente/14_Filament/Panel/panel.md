---
title: 'Navegación'
date: 2024-08-08T18:23:50+02:00
draft: false
tags: [Laravel', 'Filament', 'Dashboard', 'Herramientas','Panel','Navegación']
categories: ['Laravel','Filament']
weight: 0
icon: fas fa-bars
---

# Navegación en el panel

En el panel de administración de Filament, la **navegación** es el conjunto de menús y botones que nos permiten acceder a los **recursos**, **páginas** o **clústeres** que hemos creado.

Filament nos permite **organizar y personalizar** cómo se muestran estos elementos en el panel.

---

## Agrupar recursos con $navigationGroup

La forma más sencilla de agrupar recursos es mediante el atributo:

{{< highlight php >}}
protected static ?string $navigationGroup = 'Usuarios';
{{< /highlight >}}

O bien, con un método dinámico que incluso se puede traducir:

{{< highlight php >}}
public static function getNavigationGroup(): ?string
{
return __('Gestión de Datos');
}
{{< /highlight >}}

De esta forma, los recursos aparecen agrupados en el menú lateral bajo la etiqueta indicada.

---

## Uso de Clusters

A partir de **Filament 4** existe una forma más avanzada de organizar la navegación: los **Clusters**.

Un **Cluster** es un **módulo separado** dentro del panel, que agrupa varios recursos y páginas bajo un mismo menú principal.  
Se diferencia de `$navigationGroup` porque:

- `$navigationGroup` solo organiza visualmente recursos dentro del mismo panel.
- Un **Cluster** crea un **espacio modular independiente**, ideal cuando se tienen varios conjuntos grandes de recursos (ej: Usuarios, Pedidos, Configuración).
- Permite añadir recursos, páginas e incluso dashboards personalizados dentro del mismo módulo.

Ejemplo de Cluster:

{{< highlight php >}}
class UserCluster extends Cluster
{
protected static ?string $navigationIcon = 'heroicon-o-users';
protected static ?string $navigationLabel = 'Usuarios';
}
{{< /highlight >}}

Y en un recurso dentro de ese clúster:

{{< highlight php >}}
protected static ?string $cluster = \App\Filament\Clusters\UserCluster::class;
{{< /highlight >}}

Convención recomendada:
- Nombre de la clase en inglés, singular y terminado en `Cluster` (ej: `UserCluster`).
- Etiqueta visible traducida (`Usuarios`).

---

## Personalización de la navegación

Cada recurso o cluster puede modificar cómo aparece en el menú con varios atributos:

- **Icono del recurso**  
  {{< highlight php >}}
  protected static ?string $navigationIcon = 'heroicon-o-user';
  {{< /highlight >}}

- **Etiqueta personalizada**  
  {{< highlight php >}}
  protected static ?string $navigationLabel = 'Estudiantes';
  {{< /highlight >}}

- **Orden dentro del menú**  
  {{< highlight php >}}
  protected static ?int $navigationSort = 1;
  {{< /highlight >}}

- **Control de visibilidad**  
  {{< highlight php >}}
  public static function canViewNavigation(): bool
  {
  return auth()->user()->hasRole('admin');
  }
  {{< /highlight >}}

---

## Posición de la navegación en el panel

En el `AdminPanelProvider`, podemos decidir **dónde se ubica el menú de navegación**:

- **Menú lateral izquierdo (por defecto):**

{{< highlight php >}}
$panel->sidebarCollapsibleOnDesktop();
{{< /highlight >}}

- **Menú lateral derecho:**

{{< highlight php >}}
$panel->sidebarPosition('right');
{{< /highlight >}}

- **Navegación en la parte superior (horizontal):**

{{< highlight php >}}
$panel->topNavigation();
{{< /highlight >}}

---

## Resumen

- **$navigationGroup** → agrupa recursos dentro de la misma navegación.
- **Clusters** → crean módulos separados, más potentes para grandes aplicaciones.
- **Atributos útiles**:
    - `navigationIcon`, `navigationLabel`, `navigationSort`, `canViewNavigation`.
- **Posición del menú**:
    - Lateral izquierdo (default).
    - Lateral derecho (`sidebarPosition('right')`).
    - Superior horizontal (`topNavigation()`).

De esta manera podemos construir una navegación **organizada, modular y adaptable** a las necesidades de cada proyecto en Filament.
---

### Diferencias principales

- **$navigationGroup**
    - Agrupa solo a nivel visual.
    - Todos los recursos conviven en el mismo "espacio".
    - Menú más sencillo, útil para proyectos pequeños/medianos.

- **Cluster**
    - Crea módulos separados con sus propios recursos y páginas.
    - Útil para proyectos grandes con muchas secciones.
    - Más escalable y organizado, similar a módulos de un CMS.