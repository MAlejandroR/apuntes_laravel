---
title: "Laravel: Uso de la Facade File"
date: 2025-03-02
draft: true
weight: 50
categories: ["Laravel", "Facades", "Archivos"]
tags: ["File", "Laravel", "Facades"]
---

# Laravel: Uso de la Facade File

La **facade `File`** en Laravel permite manipular archivos de manera sencilla sin necesidad de utilizar directamente funciones de PHP como `fopen`, `fwrite`, o `unlink`.

## Importación de la Facade

Antes de usarla, es necesario importar la clase:

{{< highlight php "linenos=table, hl_lines=1" >}}
use Illuminate\Support\Facades\File;
{{< /highlight >}}

## Escribir en un Archivo

Para escribir en un archivo, usamos `File::put()`:

{{< highlight php "linenos=table, hl_lines=1" >}}
File::put(storage_path('logs/laravel.log'), 'Este es un nuevo contenido.');
{{< /highlight >}}

Esto sobrescribe el contenido del archivo con el nuevo texto.

## Añadir Contenido a un Archivo

Si queremos **añadir** contenido en lugar de sobrescribirlo, usamos `File::append()`:

{{< highlight php "linenos=table, hl_lines=1" >}}
File::append(storage_path('logs/laravel.log'), "\nNueva línea de log.");
{{< /highlight >}}

## Leer el Contenido de un Archivo

Podemos leer el contenido de un archivo con `File::get()`:

{{< highlight php "linenos=table, hl_lines=1" >}}
$contenido = File::get(storage_path('logs/laravel.log'));
echo $contenido;
{{< /highlight >}}

## Comprobar si un Archivo Existe

Para verificar si un archivo existe:

{{< highlight php "linenos=table, hl_lines=1" >}}
if (File::exists(storage_path('logs/laravel.log'))) {
echo "El archivo existe.";
}
{{< /highlight >}}

## Eliminar un Archivo

Si queremos eliminar un archivo:

{{< highlight php "linenos=table, hl_lines=1" >}}
File::delete(storage_path('logs/laravel.log'));
{{< /highlight >}}

## Conclusión

La facade `File` facilita la manipulación de archivos en Laravel, proporcionando una interfaz simple y elegante en comparación con las funciones nativas de PHP.

> 📌 **Nota:** Para operaciones avanzadas, Laravel también ofrece la facade `Storage`, que permite interactuar con sistemas de archivos locales y en la nube (como Amazon S3).

---
