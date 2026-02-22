---
title: 'Ficheros CSV en Laravel'
date: 2024-08-08T18:23:50+02:00
draft: true
tags: ['Laravel', 'Inertia', 'CSV', 'files']
categories: ['Ficheros']
weight: 400
icon: 
---

# Gestionando ficheros CSV con Laravel

Este documento resume cómo trabajar con archivos CSV en proyectos Laravel, especialmente si utilizas Inertia.js y Vue. Cuando los campos de un CSV contienen saltos de línea (`\n`), es importante usar una librería que respete correctamente el formato del archivo. Una de las mejores opciones es `league/csv`.

## 📦 Instalación de la librería

Para instalar la librería oficial:

{{< highlight bash >}}
composer require league/csv
{{< /highlight >}}

## ▶️ Lectura básica de un archivo CSV

Este es un ejemplo básico de cómo leer un archivo CSV desde el directorio `storage/app` usando `league/csv`:

{{< highlight php >}}
use League\Csv\Reader;

$csv = Reader::createFromPath(storage_path('app/archivo.csv'), 'r');
$csv->setHeaderOffset(0); // Usa la primera fila como cabecera

$registros = $csv->getRecords();

foreach ($registros as $registro) {
// Cada $registro es un array asociativo con claves de columna
// Los saltos de línea (\n) se conservan si los campos están entre comillas
}
{{< /highlight >}}

## ✅ Recomendaciones

- Asegúrate de que los campos con saltos de línea o comas estén entrecomillados con `"` en el CSV.
- Esta librería también puede utilizarse para escribir archivos CSV de forma segura.
- Es compatible con UTF-8 y funciona correctamente con grandes volúmenes de datos.

## 🔗 Enlaces útiles

- [Documentación oficial de league/csv](https://csv.thephpleague.com/)
