---
title: "Seeders en Laravel"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 20
icon: fa-solid fa-seedling
description: "Inserción de datos iniciales o de prueba mediante Seeders en Laravel."
---
{{< line >}}

## 🏭 Factory vs 🌱 Seeder (Esquema conceptual)

### 🎯 Idea sencilla

- **Factory → fabrica datos**
- **Seeder → inserta datos en la base de datos**

---

## 🏗 Esquema como “flujo de fabricación”

```
[ Factory ]
     ↓
  Genera objetos con datos falsos
     ↓
[ Seeder ]
     ↓
 Inserta esos datos en la tabla
     ↓
[ Base de Datos ]
```

---

## 🏭 Factory

{{< definicion title="Factory" >}}

Es una clase que define **cómo se construyen datos de prueba** para un modelo.

No inserta nada en la base de datos.  
Solo define qué valores tendrá cada campo.

Ejemplo mental:

- name → nombre aleatorio
- email → email único
- age → número aleatorio

Es como una **máquina que fabrica registros**.

{{< /definicion >}}

📁 Ubicación:
database/factories/StudentFactory.php

Ejemplo básico:

{{< highlight php "linenos=table" >}}
class StudentFactory extends Factory
{
public function definition(): array
{
return [
'name' => fake()->name(),
'email' => fake()->unique()->safeEmail(),
'age' => fake()->numberBetween(18, 30),
];
}
}
{{< /highlight >}}

---

## 🌱 Seeder

{{< definicion title="Seeder" >}}

Es una clase que se encarga de **insertar datos en la base de datos**.

Puede usar una Factory para generar los datos automáticamente.

Es como la persona que **coge lo fabricado y lo planta en la tabla**.

{{< /definicion >}}

📁 Ubicación:
database/seeders/StudentSeeder.php

Ejemplo básico:

{{< highlight php "linenos=table" >}}
class StudentSeeder extends Seeder
{
public function run(): void
{
Student::factory()->count(10)->create();
}
}
{{< /highlight >}}

---

## 🧠 Diferencia clara para alumnos

| Concepto | Qué hace | Inserta en BD |
|----------|----------|--------------|
| Factory  | Define cómo se crean los datos | ❌ No |
| Seeder   | Ejecuta la inserción | ✅ Sí |

---

## 🔄 Relación práctica real

Cuando ejecutamos:

{{< highlight bash "linenos=table" >}}
php artisan db:seed
{{< /highlight >}}

El flujo real es:

Seeder → usa Factory → genera datos → los guarda en la tabla

---

## 🎓 Frase clave para recordar

> Factory fabrica los datos.  
> Seeder los siembra en la base de datos.

{{< line >}}