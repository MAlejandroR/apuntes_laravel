
---
title: 'Blueprint'
date: 2024-08-08T18:23:50+02:00
draft: true
tags: ['Laravel', 'Blueprint', 'YAML', 'Herramientas', 'Generación de componentes']
categories: ['Laravel']
weight: 130
icon: fas fa-database
---

## Blueprint
{{<definicion  title="Blueprint">}}
Blueprint es una herramienta que permite {{< color >}} generar componentes {{< /color >}} rápidamente en Laravel {{< color >}} a partir de un archivo de configuración YAML {{< /color >}}: {{< color >}} `draft.yaml` {{< /color >}}.
{{</definicion>}}


{{< line >}}


{{< color >}} Sus comandos principales son: {{< /color >}}

* `blueprint:build`

**Descripción:**  
Genera componentes (modelos, controladores, migraciones, etc.) según lo definido en `draft.yaml`.

**Uso:**
{{< highlight bash "linenos=table" >}}
php artisan blueprint:build {draft_file?}
{{< /highlight >}}

- `draft_file` (opcional): Ruta del archivo YAML con la configuración. Si no se especifica, usa `draft.yaml`.
---

### 1. `blueprint:new`
**Descripción:**  
Inicializa Blueprint creando el archivo `draft.yaml` con plantillas básicas y ejecuta `trace` para cachear modelos existentes.

**Uso:**
{{< highlight bash "linenos=table" >}}
php artisan blueprint:new {--config} {--stubs}
{{< /highlight >}}

- `--config` (`-c`): Publica el archivo de configuración de Blueprint.
- `--stubs` (`-s`): Publica los archivos stub para personalización.

**Ejemplo:**
{{< highlight bash "linenos=table" >}}
php artisan blueprint:new --config --stubs
{{< /highlight >}}

{{% line %}}
---

### 3. `blueprint:erase`

**Descripción:**  
Elimina los archivos generados en la última ejecución de `blueprint:build`. Usa un caché interno para rastrear los archivos creados.

**Uso:**
{{< highlight bash "linenos=table" >}}
php artisan blueprint:erase
{{< /highlight >}}

**Ejemplo:**
{{< highlight bash "linenos=table" >}}
php artisan blueprint:erase
{{< /highlight >}}

---

### 4. `blueprint:stubs`

**Descripción:**  
Publica los archivos *stub* de Blueprint en tu proyecto para personalizar la estructura del código generado.

**Uso:**
{{< highlight bash "linenos=table" >}}
php artisan blueprint:stubs
{{< /highlight >}}

**Ejemplo:**
{{< highlight bash "linenos=table" >}}
php artisan blueprint:stubs
{{< /highlight >}}

---

### 5. `blueprint:trace`

**Descripción:**  
Analiza el código existente de tu aplicación y guarda en caché los modelos encontrados. Esto ayuda a Blueprint a trabajar con proyectos ya iniciados.

**Uso:**
{{< highlight bash "linenos=table" >}}
php artisan blueprint:trace
{{< /highlight >}}

**Ejemplo:**
{{< highlight bash "linenos=table" >}}
php artisan blueprint:trace
{{< /highlight >}}

---

Para más detalles, consulta la [documentación oficial de Blueprint](https://blueprint.laravelshift.com/docs/available-commands/).

