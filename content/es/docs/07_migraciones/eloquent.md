---
title: "Migracioens"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 10
icon: fa-solid fa-database
---
# Eloquent ORM en Laravel

Eloquent ORM en Laravel ofrece una variedad de métodos para interactuar con la base de datos de forma eficiente y elegante. Aquí tienes un resumen escueto de algunos de los métodos más comunes que puedes usar para consultas, inserciones, actualizaciones y borrados:

## Métodos para Consultas
- `all()`: Recupera todas las filas de la tabla.
- `find($id)`: Encuentra un registro por su clave primaria.
- `where('column', 'value')`: Aplica una condición SQL WHERE.
- `orderBy('column', 'direction')`: Ordena los resultados.
- `take($limit)`: Limita el número de resultados.
- `get()`: Obtiene los resultados de una consulta.

## Métodos para Inserciones y Actualizaciones
- `save()`: Guarda un nuevo modelo o actualiza un modelo existente.
- `create($attributes)`: Crea un nuevo registro con los atributos proporcionados.
- `update($attributes)`: Actualiza un modelo con los atributos proporcionados.

## Métodos para Borrados
- `delete()`: Elimina un modelo de la base de datos.
- `destroy($ids)`: Elimina modelos por su clave primaria.
- `softDeletes()`: Hace un borrado suave (no elimina los registros de la base de datos, solo los marca como borrados).

## Métodos para Relaciones
- `hasMany()`, `belongsTo()`, `belongsToMany()`, etc.: Define las relaciones entre modelos.

## Otros Métodos Útiles
- `firstOrCreate($attributes)`: Obtiene el primer registro encontrado o crea uno nuevo.
- `findOrFail($id)`: Encuentra un registro por su clave primaria o falla.
- `whereHas('relation', $callback)`: Aplica condiciones a las consultas de relaciones.

Este resumen proporciona una vista rápida de los métodos más usados en Eloquent para realizar operaciones comunes de base de datos en Laravel. Estos métodos facilitan la realización de consultas, inserciones, actualizaciones y borrados, así como el manejo de relaciones entre modelos, de una manera más legible y menos propensa a errores en comparación con las consultas SQL crudas.
