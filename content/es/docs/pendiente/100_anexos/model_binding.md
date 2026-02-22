---
title: "Anexos"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 20
---
# Route Model Binding — Summary

## ¿Qué es?
El **Route Model Binding** es un mecanismo de Laravel que transforma automáticamente
un parámetro de una ruta en una **instancia de un modelo Eloquent** antes de que
el controlador sea ejecutado.

Ejemplo conceptual:
`/alumnos/5` → `Alumno::findOrFail(5)`

---

## Binding implícito
Laravel lo aplica automáticamente si:
- El nombre del parámetro de la ruta coincide con el argumento
- El argumento del controlador está tipado con el modelo

{{< highlight php >}}
Route::get('/alumnos/{alumno}', [AlumnoController::class, 'show']);

public function show(Alumno $alumno)
{
// $alumno es una instancia de Alumno
}
{{< /highlight >}}

Si el modelo no existe → **404 automático**

---

## Binding explícito (opcional)
Se utiliza cuando se necesita **control total** sobre cómo se resuelve
un parámetro de ruta.  
Se define normalmente en `RouteServiceProvider`.

### Binding simple por modelo
Asocia un parámetro de ruta directamente a un modelo Eloquent.

{{< highlight php >}}
Route::model('alumno', Alumno::class);
{{< /highlight >}}

Internamente equivale a buscar por `id` y lanzar 404 si no existe.

---

### Binding con lógica personalizada
Permite resolver el modelo usando **otra clave** o **reglas adicionales**.

{{< highlight php >}}
Route::bind('alumno', function ($value) {
return Alumno::where('codigo', $value)->firstOrFail();
});
{{< /highlight >}}

El binding explícito **tiene prioridad** sobre el binding implícito.

---

## Usar una clave distinta de `id`
Por defecto Laravel resuelve modelos por la columna `id`.  
Puede cambiarse globalmente desde el modelo:

{{< highlight php >}}
class Alumno extends Model
{
public function getRouteKeyName()
{
return 'slug';
}
}
{{< /highlight >}}

---

## Características clave
- No es un middleware
- Forma parte del sistema de routing
- Se ejecuta antes del controlador
- Reduce código repetitivo
- Garantiza tipado fuerte y errores 404 coherentes
