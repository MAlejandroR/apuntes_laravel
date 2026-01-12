---
title: "Extracción de texto"
date: 2026-01-12T08:00:00+02:00
draft: false
weight: 20
icon: fa-solid fa-language
---

## Extracción de cadenas de traducción en Laravel + Vue

En proyectos **Laravel + Vue**, es habitual envolver los textos traducibles con el helper:

{{< highlight php >}}
{{ __("Texto a traducir") }}
{{< /highlight >}}

El objetivo es **recorrer recursivamente el proyecto** (Blade, PHP, JS, Vue) y generar un único fichero de traducción con el formato:

{{< highlight json >}}
{
"Texto 1 a traducir": "",
"Texto 2 a traducir": ""
}
{{< /highlight >}}

---

### Opción recomendada: laravel-json-translation-helper

Este paquete permite **escanear automáticamente** el proyecto y generar/actualizar los archivos JSON de traducción.

#### Instalación

{{< highlight bash >}}
composer require subotkevic/laravel-json-translation-helper
{{< /highlight >}}

#### Publicar configuración

{{< highlight bash >}}
php artisan vendor:publish --provider="JsonTranslationHelper\TranslationHelperServiceProvider"
{{< /highlight >}}

#### Configuración típica
Se puede personalizar a ficheros {{<color>}}vue{{</color>}}, {{<color>}}jsx{{</color>}} y otros formatos

Archivo `config/translation-helper.php`:

{{< highlight php >}}
return [
'scan_directories' => [
app_path(),
resource_path('views'),
resource_path('js'),
],

    'file_extensions' => [
        'php',
        'js',
        'vue',
        'jsx'
    ],

    'translation_methods' => [
        '__',
        'lang',
    ],
];
{{< /highlight >}}

### Ejecución del escaneo

{{< highlight bash >}}
php artisan translation:scan
{{< /highlight >}}

Este comando:
- Recorre los directorios configurados
- Detecta llamadas a `__()`, `lang()`, `@lang`
- Añade automáticamente las claves faltantes al JSON
- Evita duplicados

---

## Resultado generado

Si en el proyecto existen textos como:

{{< highlight php >}}
{{ __("Enviar") }}
{{ __("Cancelar") }}
{{< /highlight >}}

El archivo de traducción quedará así:

{{< highlight json >}}
{
"Enviar": "",
"Cancelar": ""
}
{{< /highlight >}}

---

## Conclusión

✔ Para la mayoría de proyectos Laravel + Vue, **`laravel-json-translation-helper` es la solución óptima**  
✔ Soporta fichero de tipo {{<color>}}.vue, .js. .blade.php, ts, jsx, tsx {{</color>}}  
✔ Genera exactamente el formato `"texto": ""` requerido

Ideal para flujos de trabajo educativos y proyectos multi-idioma.
