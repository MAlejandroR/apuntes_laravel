---
title: 'Storage'
date: 2024-08-08T18:23:50+02:00
draft: false
tags: ['Laravel', 'Storage', 'Files']
categories: ['Laravel']
weight: 150
icon: fas fa-sliders-h
---

# Uso de la facade Storage en Laravel

## ¿Qué es Storage?

Storage es una Facade de Laravel que proporciona una interfaz unificada para gestionar archivos y directorios en distintos sistemas de almacenamiento (local, público, S3, FTP, etc.).  
Internamente Laravel utiliza la librería Flysystem, que abstrae el acceso al sistema de ficheros.

En resumen:  
Storage = acceso simple, limpio y seguro al sistema de archivos.

---

## Configuración

El archivo principal de configuración es:

config/filesystems.php

Aquí se definen los discos (drivers) que Laravel puede usar.  
Por defecto encontrarás algo así:

'disks' => [
'local' => [
'driver' => 'local',
'root' => storage_path('app'),
],
'public' => [
'driver' => 'local',
'root' => storage_path('app/public'),
'url' => env('APP_URL').'/storage',
'visibility' => 'public',
],
's3' => [
'driver' => 's3',
'key' => env('AWS_ACCESS_KEY_ID'),
'secret' => env('AWS_SECRET_ACCESS_KEY'),
'region' => env('AWS_DEFAULT_REGION'),
'bucket' => env('AWS_BUCKET'),
],
],

El disco por defecto se define con:

'default' => env('FILESYSTEM_DISK', 'local')

Y en el archivo .env puedes establecer:

FILESYSTEM_DISK=public

---

## Referencia de directorios útiles

Ruta lógica | Descripción | Ruta física aproximada  
-------------|--------------|-----------------------  
storage_path() | Devuelve la carpeta storage del proyecto | /project/storage  
public_path() | Carpeta pública del servidor | /project/public  
base_path() | Raíz del proyecto Laravel | /project  
app_path() | Carpeta app del framework | /project/app  

---

## Métodos concretos (CheatSheet)

use Illuminate\Support\Facades\Storage;

Storage::put('file.txt', 'Contenido') → Crea o sobrescribe un archivo con el contenido indicado.  
Storage::get('file.txt') → Lee y devuelve el contenido de un archivo.  
Storage::exists('file.txt') → Comprueba si el archivo existe en el disco.  
Storage::delete('file.txt') → Elimina el archivo especificado.  
Storage::files('carpeta') → Devuelve una lista de archivos del directorio indicado.  
Storage::allFiles('carpeta') → Devuelve todos los archivos incluyendo subcarpetas.  
Storage::directories('carpeta') → Lista solo los directorios dentro de la carpeta indicada.  
Storage::allDirectories('carpeta') → Lista todos los directorios y subdirectorios.  
Storage::makeDirectory('nueva') → Crea un nuevo directorio.  
Storage::deleteDirectory('vieja') → Elimina el directorio y su contenido.  
Storage::copy('old.txt', 'new.txt') → Copia un archivo a otra ubicación.  
Storage::move('old.txt', 'folder/new.txt') → Mueve o renombra un archivo.  
Storage::download('public/file.pdf') → Devuelve una respuesta para descargar el archivo (desde un controlador).  
Storage::url('file.jpg') → Devuelve la URL pública del archivo (solo en discos con visibilidad pública).  
Storage::size('file.txt') → Devuelve el tamaño del archivo en bytes.  
Storage::lastModified('file.txt') → Devuelve la fecha de la última modificación.  
Storage::disk('public')->put('demo.txt', 'Hola') → Permite operar en un disco concreto definido en config/filesystems.php.

---

## Helpers relacionados

storage_path('app/file.txt') → Ruta absoluta dentro de storage/app  
public_path('images/logo.png') → Ruta absoluta en /public  
asset('storage/file.txt') → URL accesible desde el navegador  
base_path() → Ruta raíz del proyecto

---

## ¿Storage es una Facade?

Sí. Storage es una Facade que apunta al servicio interno filesystem dentro del contenedor de Laravel.  
Esto permite usarla de forma estática o con inyección de dependencias.

use Illuminate\Contracts\Filesystem\Filesystem;  
public function show(Filesystem $storage) {  
return $storage->get('archivo.txt');  
}

o también:

use Illuminate\Support\Facades\Storage;  
$content = Storage::get('archivo.txt');

---

## Funciones de PHP que no están incluidas en Storage

Storage no cubre todas las operaciones posibles sobre ficheros.  
A veces es necesario usar funciones nativas de PHP para operaciones más específicas.

Función PHP | Descripción | Comentario  
-------------|-------------|-------------  
file_get_contents() | Leer el contenido de un fichero local | Similar a Storage::get(), pero sin disco  
parse_ini_file() | Leer ficheros .ini | No existe en Storage  
fopen(), fwrite(), fclose() | Apertura y escritura manual de archivos | No abstraído por Storage  
file_exists() | Comprobar existencia directa | Solo Storage::exists() dentro del disco  
is_dir(), is_file() | Comprobar tipo de ruta | No implementado  
scandir() | Listar directorios | Storage::files() es equivalente parcial  
realpath() | Obtener ruta absoluta del sistema | No implementado  
unlink() | Eliminar archivo | Storage::delete() lo hace, pero solo dentro del disco  
copy(), rename() | Copiar o mover archivos | Storage::copy() y move() son internos  
file_put_contents() | Escribir archivo directamente | Similar a Storage::put()

---

## Ejemplo especial: leer ficheros .ini

Laravel Storage no puede interpretar ficheros .ini, solo leer su contenido como texto.  
Para analizarlos se combina con funciones PHP nativas:

$path = storage_path('app/exercises/T1/T1.ini');  
if (file_exists($path)) {  
$data = parse_ini_file($path, true);  
}

O si deseas obtenerlo desde un disco de Laravel:

$content = Storage::disk('public')->get('exercises/T1/T1.ini');  
$temp = tempnam(sys_get_temp_dir(), 'ini');  
file_put_contents($temp, $content);  
$data = parse_ini_file($temp, true);

---

## En resumen

Concepto | Storage | PHP nativo  
----------|----------|------------  
Acceso a ficheros en discos configurados | ✅ | ❌  
Lectura avanzada (parse_ini, streams, etc.) | ❌ | ✅  
Portabilidad entre sistemas (S3, FTP, etc.) | ✅ | ❌  
Control total sobre el sistema local | ❌ | ✅  

---

Conclusión:  
Usa Storage para la gestión general de archivos dentro de Laravel (lectura, escritura, copiado, eliminación)  
y usa funciones nativas de PHP cuando necesites analizar formatos específicos o acceder fuera del sistema de discos configurados (por ejemplo .ini, .csv, .json, etc.).
