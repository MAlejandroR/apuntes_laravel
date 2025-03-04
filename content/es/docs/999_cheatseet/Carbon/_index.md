---
title: "Carbon (fechas"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 40
---

# Introducción a Carbon

{{< color >}} Carbon {{< /color >}} es una clase en _Laravel_ que nos permite trabajar con fechas de forma sencilla e intuitiva.

A continuación mostramos un **cheatsheet** de sus principales usos.

Para referencia completa: [Documentación Oficial de Carbon](https://laravel.com/docs/11.x/helpers#date-and-time)

---
## Crear un objeto de la clase

{{< highlight php "linenos=table, hl_lines=1" >}}
// Crear una fecha con la fecha y hora actual
$fecha = new Carbon();
echo $fecha; // Fecha actual en formato YYYY-MM-DD HH:MM:SS

// Crear una fecha específica
$fecha = new Carbon('1969-12-27');
echo $fecha; // 1969-12-27 00:00:00
{{< /highlight >}}

{{<desplegable title="Otras formas de crear fechas">}}

### **Usando `Carbon::create()`**
Este método permite definir una fecha con mayor precisión:

{{< highlight php "linenos=table" >}}
// Crear una fecha específica (Año, Mes, Día, Hora, Minuto, Segundo)
$fecha = Carbon::create(2024, 12, 25, 15, 30, 45);
echo $fecha; // 2024-12-25 15:30:45
{{< /highlight >}}

---

### **Usando `Carbon::createFromFormat()`**
Permite crear fechas desde un formato específico:

{{< highlight php "linenos=table" >}}
$fecha = Carbon::createFromFormat('d/m/Y H:i:s', '31/01/2025 14:00:00');
echo $fecha; // 2025-01-31 14:00:00
{{< /highlight >}}

---

### **Usando `Carbon::parse()`**
Convierte una cadena de texto en una fecha:

{{< highlight php "linenos=table" >}}
// Convertir texto en fecha
$fecha = Carbon::parse('next Monday');
echo $fecha; // 2025-02-03 (si hoy es domingo)

// Desde un timestamp
$fecha = Carbon::createFromTimestamp(1700000000);
echo $fecha; // Fecha correspondiente al timestamp
{{< /highlight >}}

---

### **Usando `CarbonImmutable` (Fechas inmutables)**
Si necesitas fechas inmutables que no cambien con `add()` o `sub()`, usa **CarbonImmutable**:

{{< highlight php "linenos=table" >}}
use Carbon\CarbonImmutable;

$fecha = CarbonImmutable::now();
echo $fecha->addDays(5); // Nueva fecha sin modificar la original
{{< /highlight >}}

{{</desplegable>}}

---

## Obtener la fecha actual

{{< highlight php "linenos=table" >}}
$now = Carbon::now();
echo $now; // 2025-02-02 15:30:45
{{< /highlight >}}

---

## Formatear fechas

{{< highlight php "linenos=table" >}}
// Formatos comunes
echo $fecha->toDateString();     // 2025-02-02
echo $fecha->toTimeString();     // 15:30:45
echo $fecha->toDateTimeString(); // 2025-02-02 15:30:45

// Formato personalizado
echo $fecha->format('d/m/Y');    // 02/02/2025
echo $fecha->format('l, d F Y'); // Sunday, 02 February 2025
{{< /highlight >}}

---

## Operaciones con Fechas

{{<desplegable title="Operaciones con fechas">}}

### Sumar Fechas
{{< highlight php "linenos=table" >}}
$fecha = Carbon::now()->addDays(10);
echo $fecha; // Fecha +10 días
{{< /highlight >}}

### Restar Fechas
{{< highlight php "linenos=table" >}}
$fecha = Carbon::now()->subMonths(1);
echo $fecha; // Fecha -1 mes
{{< /highlight >}}

### Diferencia entre Fechas
{{< highlight php "linenos=table" >}}
$fecha1 = Carbon::create(2025, 5, 1);
$fecha2 = Carbon::create(2025, 6, 1);

echo $fecha1->diffInDays($fecha2); // Diferencia en días
echo $fecha1->diffForHumans(); // "hace 1 mes"
{{< /highlight >}}

{{</desplegable>}}

---

## Comparación de Fechas

{{< highlight php "linenos=table" >}}
$fecha1 = Carbon::create(2025, 5, 1);
$fecha2 = Carbon::create(2025, 6, 1);

if ($fecha1->equalTo($fecha2)) {
echo "Son iguales";
}

if ($fecha1->isToday()) {
echo "La fecha es hoy";
}

if ($fecha1->isFuture()) {
echo "La fecha está en el futuro";
}
{{< /highlight >}}

---

## Manejo de Zonas Horarias

{{< highlight php "linenos=table" >}}
$fecha = Carbon::now('Europe/Madrid');
echo $fecha; // 2025-02-02 16:30:45 (hora de Madrid)

// Convertir a UTC
$fechaUtc = $fecha->timezone('UTC');
echo $fechaUtc; // 2025-02-02 15:30:45 (UTC)
{{< /highlight >}}

---

## Fechas en Español

{{< alert title="Tip" color="success" >}}
Para obtener fechas en español, cambia la configuración de **Carbon**:
{{< /alert >}}

{{< highlight php "linenos=table" >}}
setlocale(LC_TIME, 'es_ES.UTF-8');
Carbon::setLocale('es');

$fecha = Carbon::now();
echo $fecha->translatedFormat('l, d F Y'); // domingo, 02 febrero 2025
echo $fecha->diffForHumans(); // "hace 1 segundo"
{{< /highlight >}}

--
## **Helpers de fechas en Laravel**

### **1. `now()` → Equivalente a `Carbon::now()`**
Devuelve la fecha y hora actual:

{{< highlight php "linenos=table" >}}
$fecha = now();
echo $fecha; // 2025-02-02 15:30:45
{{< /highlight >}}

---

### **2. `today()` → Equivalente a `Carbon::today()`**
Devuelve la fecha actual con hora **00:00:00**:

{{< highlight php "linenos=table" >}}
$fecha = today();
echo $fecha; // 2025-02-02 00:00:00
{{< /highlight >}}

---

### **3. `tomorrow()` → Equivalente a `Carbon::tomorrow()`**
Devuelve la fecha de mañana con hora **00:00:00**:

{{< highlight php "linenos=table" >}}
$fecha = tomorrow();
echo $fecha; // 2025-02-03 00:00:00
{{< /highlight >}}

---

### **4. `yesterday()` → Equivalente a `Carbon::yesterday()`**
Devuelve la fecha de ayer con hora **00:00:00**:

{{< highlight php "linenos=table" >}}
$fecha = yesterday();
echo $fecha; // 2025-02-01 00:00:00
{{< /highlight >}}

---

### **5. `carbon()` → Instancia de Carbon desde un valor**
Convierte un **timestamp, string o DateTime** en un objeto Carbon:

{{< highlight php "linenos=table" >}}
// Desde una fecha en string
$fecha = carbon('2025-05-10');
echo $fecha; // 2025-05-10 00:00:00

// Desde un timestamp
$fecha = carbon(1700000000);
echo $fecha; // Fecha correspondiente al timestamp

// Desde un DateTime
$fecha = carbon(new DateTime());
echo $fecha; // Fecha actual
{{< /highlight >}}

---

## **Comparación rápida de helpers**
| **Helper**   | **Descripción**                  | **Equivalente Carbon**         |
|-------------|--------------------------------|--------------------------------|
| `now()`     | Fecha y hora actual            | `Carbon::now()`               |
| `today()`   | Fecha actual a las 00:00:00    | `Carbon::today()`             |
| `tomorrow()`| Fecha de mañana a las 00:00:00| `Carbon::tomorrow()`          |
| `yesterday()`| Fecha de ayer a las 00:00:00 | `Carbon::yesterday()`         |
| `carbon()`  | Convierte cualquier valor en Carbon | `Carbon::parse()` o `Carbon::createFromFormat()` |

---

Estos **helpers** simplifican el uso de fechas en **Laravel** sin necesidad de escribir `Carbon::now()`, haciéndolo más limpio y elegante. 🚀

{{% line %}}
-

## 📌 Referencias

{{< referencias title="Documentación Oficial" subtitle="Laravel & Carbon" icon-image="icon-docs" >}}
[Carbon en Laravel](https://laravel.com/docs/11.x/helpers#date-and-time)
[Carbon PHP Library](https://carbon.nesbot.com/docs/)
[Helper de fechas](https://laravel.com/docs/11.x/helpers#dates)
[Helper, buscar el Miscellaneous las funciones de fechas](https://laravel.com/docs/11.x/helpers#available-methods)
{{< /referencias >}}