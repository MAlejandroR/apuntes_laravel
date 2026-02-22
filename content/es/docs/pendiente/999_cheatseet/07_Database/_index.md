---
title: "Desplegar en hosgint"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 40
---

# Uso práctico de bases de datos: Facade Schema

* Permite ver la estructura de una tabla
```php
use Iluminate\Schema\Facade
Schema::getColumnListing("nombre_tabla");
```
* P.e. tabla specializatios:
 ```php
Schema::getColumnListing("specializations");
= [
"id",
"name",
"families_id",
"created_at",
"updated_at",
]

```



> 
