---
title: 'Panel '
date: 2024-08-08T18:23:50+02:00
draft: false
tags: ['Laravel', 'Filament', 'Dashboard', 'Herramientas', 'Panel']
categories: ['Laravel', 'Panel', 'Filament']
weight: 10
icon: fas fa-rectangle-group
---

# El panel del admin

La parte visual de la administración en **Filament** se centra en uno o varios **paneles**, que son el núcleo desde donde un administrador o los roles autorizados pueden ver y gestionar los recursos de la aplicación.

Cuando instalamos Filament, se crea automáticamente un **panel de administración por defecto**, al cual se accede directamente desde la URL:


{{< highlight php "linenos=table">}}
/admin
{{</highlight>}}

Además de este panel inicial, se pueden **crear más paneles según las necesidades del proyecto**.  
Por ejemplo:
- Un panel para administradores internos (`/admin`).
- Un panel separado para clientes o usuarios externos (`/client`).
- Incluso un panel para profesores y otro para estudiantes en una plataforma educativa.

Sin embargo, en muchos casos un único panel es suficiente para centralizar toda la gestión.  
Dentro de cada panel se pueden añadir y organizar diferentes elementos que Filament pone a disposición, como:
- **Widgets** para mostrar gráficos, estadísticas y métricas.
- **Recursos (Resources)** para gestionar modelos de base de datos con formularios y tablas.
- **Clusters** para agrupar secciones de administración.
- **Pages** para pantallas personalizadas.
- **Navegación** configurable para organizar menús y accesos.

En resumen, **el panel es el punto de entrada y la interfaz principal de Filament** para administrar y visualizar recursos de la aplicación de manera estructurada y personalizable.

---

## Ejemplo mínimo de `PanelProvider`

Un ejemplo básico de cómo definir un **panel de administración** en Filament mediante un `AdminPanelProvider`.  
En este archivo se configura el ID del panel, la ruta de acceso (`/admin`) y los métodos `discover...` para cargar automáticamente recursos, páginas y widgets:

{{< highlight php >}}
<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default() // Define este panel como el principal
            ->id('admin') // Identificador único del panel
            ->path('admin') // Ruta de acceso al panel (/admin)
            ->discoverResources(
                in: app_path('Filament/Resources'),
                for: 'App\\Filament\\Resources'
            )
            ->discoverPages(
                in: app_path('Filament/Pages'),
                for: 'App\\Filament\\Pages'
            )
            ->discoverWidgets(
                in: app_path('Filament/Widgets'),
                for: 'App\\Filament\\Widgets'
            );
    }
}
{{< /highlight >}}

---

## Ejemplo con múltiples paneles

Filament permite tener **varios paneles** en la misma aplicación.  
Esto resulta útil cuando distintos tipos de usuarios necesitan interfaces separadas.  
Por ejemplo:
- Un **panel de administración** (`/admin`) para gestionar todos los recursos.
- Un **panel de clientes** (`/client`) con acceso restringido a ciertos recursos o páginas.

{{< highlight php >}}
<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->discoverResources(
                in: app_path('Filament/Admin/Resources'),
                for: 'App\\Filament\\Admin\\Resources'
            )
            ->discoverPages(
                in: app_path('Filament/Admin/Pages'),
                for: 'App\\Filament\\Admin\\Pages'
            );
    }
}

class ClientPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('client')
            ->path('client')
            ->discoverResources(
                in: app_path('Filament/Client/Resources'),
                for: 'App\\Filament\\Client\\Resources'
            )
            ->discoverPages(
                in: app_path('Filament/Client/Pages'),
                for: 'App\\Filament\\Client\\Pages'
            );
    }
}
{{< /highlight >}}

En este caso:
- El **panel admin** se accede desde `/admin`.  
- El **panel cliente** se accede desde `/client`.  

Cada uno carga sus propios **Resources**, **Pages** y **Widgets** según la carpeta y namespace definidos.

---

# Configurar el path de Filament en el panel

Cuando instalamos **Filament 4**, automáticamente se crea un provider en  
{{<color>}}app/Providers/Filament/AdminPanelProvider.php{{</color>}}.  

Este archivo define las rutas, el nombre del panel, colores y la URL base donde se monta el panel de administración.

Dentro del método {{<color>}}panel(){{</color>}} encontramos la definición:

{{< highlight php >}}
use Filament\Panel;
use Filament\PanelProvider;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin') // Aquí definimos el path base
            ->login()
            ->colors([
                'primary' => '#4f46e5',
            ]);
    }
}
{{< /highlight >}}

En este ejemplo, el panel está disponible en la URL:

{{<color>}}http://tusitio.com/admin{{</color>}}

Si modificamos {{<color>}}->path('admin'){{</color>}} a {{<color>}}->path('dashboard'){{</color>}}, el panel pasará a estar en:

{{<color>}}http://tusitio.com/dashboard{{</color>}}

---

## Cambiar la página inicial del panel

Por defecto, cuando accedemos a {{<color>}}/admin{{</color>}}, Filament muestra su página **Dashboard**.  
Si queremos que cargue una página personalizada (por ejemplo, **AdminHome**), tenemos que crearla primero:

{{< highlight php >}}
namespace App\Filament\Pages;

use Filament\Pages\Page;

class AdminHome extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'filament.pages.admin-home';
    protected static ?string $title = 'Inicio del panel';
    protected static ?string $navigationLabel = 'Inicio';
}
{{< /highlight >}}

Y su vista Blade:

{{< highlight html >}}
<x-filament-panels::page>
    <h1 class="text-2xl font-bold">¡Bienvenido, {{ auth()->user()->name }}!</h1>
    <p class="text-gray-500">Este es tu panel de administración.</p>
</x-filament-panels::page>
{{< /highlight >}}

Luego, en el {{<color>}}AdminPanelProvider{{</color>}}, añadimos:

{{< highlight php >}}
->homeUrl(fn () => route('filament.admin.pages.admin-home'))
{{< /highlight >}}

De esta forma, cuando un usuario entre a {{<color>}}/admin{{</color>}}, la página que verá primero será **AdminHome** y no el Dashboard por defecto.

---

## Resumen

- El path del panel se define con {{<color>}}->path('admin'){{</color>}}.  
- La página inicial se puede personalizar con {{<color>}}->homeUrl(){{</color>}}.  
- Filament carga sus rutas automáticamente, no hace falta definirlas en {{<color>}}web.php{{</color>}}.  