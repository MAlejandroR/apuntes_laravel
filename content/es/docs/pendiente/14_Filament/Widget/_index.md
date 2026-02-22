---
title: 'Widgets en el Panel'
date: 2024-08-26T18:45:00+02:00
draft: false
tags: ['Laravel', 'Filament', 'Dashboard', 'Herramientas', 'Panel','Widgets']
categories: ['Laravel', 'Panel', 'Filament','Widgets']
weight: 10
icon: fas
---

# Qué es un widget en Filament

Un **widget** es un componente reutilizable que se muestra dentro del panel de administración.  
Sirve para aportar información rápida, estadísticas, accesos directos o mensajes de bienvenida al usuario.

---

# Tipos de widget que puedo usar

En Filament existen varios tipos de widgets, por ejemplo:

- **Stats Overview** → muestra métricas y estadísticas rápidas.
- **Charts** → gráficos para visualizar datos.
- **Tables** → listados o tablas interactivas.
- **Custom Widgets** → creados por el desarrollador con contenido libre.

---

# Crear un widget de presentación multilenguaje en Filament

Una idea muy útil 👌 es añadir un widget personalizado que muestre un texto de introducción o presentación en el panel principal de Filament.  
Además, podemos aprovechar las traducciones de Laravel (`__('...')`) para hacerlo **multilenguaje**.

## Paso 1. Crear la clase del widget

En la terminal ejecutamos:

{{< highlight php tabla_alumnos "linenos=table, hl_lines=" >}}
php artisan make:filament-widget WelcomeWidget
{{< /highlight>}}
Entonces el propio entorno va a realizar unas preguntas para crear el widget

![img.png](img.png)
    
![img_1.png](img_1.png)

![img_2.png](img_2.png)

Esto generará los siguientes  archivos:
1. El controlador: **app/Filament/Widgets/WelcomeWidget.php**
2. La vista ** /resources/views**

Ejemplo de implementación:
{{< highlight php tabla_alumnos "linenos=table, hl_lines=" >}}

<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class WelcomeWidget extends Widget
{
    protected static string $view = 'filament.widgets.welcome-widget';

    // Lo colocamos en la parte superior del dashboard
    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = -2; // se renderiza antes de las estadísticas
}

{{< /highlight>}}


## Paso 2. Crear la vista Blade multilenguaje

Creamos el archivo:

resources/views/filament/widgets/welcome-widget.blade.php
{{< highlight php tabla_alumnos "linenos=table, hl_lines=" >}}

<x-filament-widgets::widget>
    <x-filament::section>
        <div class="p-6 text-center">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                👋 {{ __('dashboard.welcome_title') }}
            </h2>
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                {!! __('dashboard.welcome_message') !!}
            </p>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>

{{< /highlight>}}


## Paso 3. Añadir las traducciones

Creamos las claves en los archivos de idioma, por ejemplo en:

{{< highlight php "linenos=table, hl_lines=" >}}
<?php
return [
    'welcome_title' => 'Welcome to the Admin Panel',
    'welcome_message' => 'This dashboard lets you manage <strong>teachers, students, projects, centers, enrollments, and cycles</strong>. Use the navigation on the left to get started.',
];

lang/es/dashboard.php

<?php
return [
    'welcome_title' => 'Bienvenido al Panel de Administración',
    'welcome_message' => 'Este panel te permite gestionar <strong>profesores, estudiantes, proyectos, centros, matrículas y ciclos</strong>. Usa la navegación de la izquierda para empezar.',
];
{{< /highlight>}}
---

## Paso 4. Registrar el widget en tu Dashboard

En tu página de Dashboard personalizada (por ejemplo, AdminHome), añade el widget:
{{< highlight php tabla_alumnos "linenos=table, hl_lines=" >}}
public function getWidgets(): array
{
    return [
        \App\Filament\Widgets\WelcomeWidget::class,
        \App\Filament\Widgets\StatsOverview::class,
    ];
}
{{< /highlight>}}

---

# Resultado

Al abrir el panel de administración, verás en la parte superior una tarjeta elegante de bienvenida en el idioma actual del usuario,  
seguida de las estadísticas y otros widgets que hayas configurado.

