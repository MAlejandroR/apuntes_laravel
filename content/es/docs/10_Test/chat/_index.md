---
title: "10_Test unitarios del chat"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 30
---

# PHPUnit en Laravel

{{% line %}}

{{< alert title="Introducción" color="info" >}}
En este tema aprenderemos cómo integrar y utilizar PHPUnit para realizar pruebas automatizadas en Laravel, siguiendo las mejores prácticas y adaptándolo al desarrollo de aplicaciones web.
{{< /alert >}}

## 1. Introducción a PHPUnit
{{% line %}}

{{< definicion title="PHPUnit" icon="fas fa-book" >}}
PHPUnit es un framework de pruebas para PHP diseñado para ayudar a los desarrolladores a verificar que sus aplicaciones funcionen correctamente a través de pruebas unitarias y funcionales.
{{</definicion>}}

## 2. Configuración inicial
{{% line %}}

### Instalación de PHPUnit en un proyecto Laravel
{{< color >}}composer require --dev phpunit/phpunit{{< /color >}}

### Configuración del archivo `phpunit.xml`
{{< highlight dockerfile "linenos=table, hl_lines=3" >}}
<phpunit bootstrap="vendor/autoload.php">
<testsuites>
<testsuite name="Unit Tests">
<directory>./tests/Unit</directory>
</testsuite>
<testsuite name="Feature Tests">
<directory>./tests/Feature</directory>
</testsuite>
</testsuites>
</phpunit>
{{< /highlight >}}

## 3. Estructura de carpetas de pruebas en Laravel
{{% line %}}

{{< alert title="Nota" color="warning" >}}
Laravel organiza las pruebas en dos carpetas principales: `tests/Unit` para pruebas unitarias y `tests/Feature` para pruebas funcionales.
{{< /alert >}}


## 4. Escribiendo la primera prueba
{{% line %}}

### Ejemplo de prueba unitaria
{{< highlight dockerfile "linenos=table, hl_lines=2 4" >}}
<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    public function test_example()
    {
        $this->assertTrue(true);
    }
}
{{< /highlight >}}

## 5. Ejecutando pruebas
{{% line %}}

Para ejecutar las pruebas, utiliza el siguiente comando:

{{< highlight dockerfile "linenos=table" >}}
php artisan test
{{< /highlight >}}

## 6. Ventajas de usar PHPUnit en Laravel
{{% line %}}

{{< desplegable title="Ventajas principales" >}}
1. Mejora la calidad del código.
2. Ayuda a detectar errores temprano.
3. Facilita el mantenimiento del proyecto.

{{</desplegable>}}

## Referencias
{{% line %}}

{{< referencias title="PHPUnit en Laravel" sub_title="Documentación oficial y recursos adicionales" icon_image="fas fa-book" >}}
1. [PHPUnit Documentation](https://phpunit.de/documentation.html)
2. [Laravel Testing Documentation](https://laravel.com/docs/testing)
{{</referencias>}}
