---
title: "Creando la tabla"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 80
icon: fa-solid fa-database
---

## Creamos los campos en la tabla

{{% pageinfo%}}

####   

****



Vamos a la migracion que hemos creado y añadimos los campos que consideremos

{{% imgproc tabla_alumnos Fill "200x100" %}}

{{% /imgproc %}}
Lo establecemos en el método {{<color_blue>}}Up(...){{</color_blue>}}

Aquí puedes ver todos los métodos que puedes
usar [Métodos para crear campos](https://laravel.com/docs/10.x/migrations#available-column-types)
{{< highlight php tabla_alumnos "linenos=table, hl_lines=4-8" >}}
public function up(): void {
  Schema::create('alumnos', function (Blueprint $table) {
    $table->id();
    $table->string("nombre");
    $table->string("direccion");
    $table->integer("edad");
    $table->string("email");
    $table->string("dni");
    $table->timestamps();
  });
}
{{< / highlight >}}
{{< alert title="id()-timestamps()" color="warning" >}}
Estos métodos crean campos en la tabla

* {{<color_blue>}}id{{</color_blue>}}
* {{<color_blue>}}create_at{{</color_blue>}}
* {{<color_blue>}}update_at{{</color_blue>}}

{{< /alert >}}

{{% /pageinfo%}}

## Poblamos la tabla

{{% pageinfo%}}

### Creamos la factoría de valores

En
{{< highlight php "linenos=table, hl_lines=4-8 15 17 18 20 21" >}}
public function definition(): array
{
return [
"nombre" => fake()->name(),
"direccion" => fake()->address(),
"edad" => fake()->numberBetween(15, 75),
"email"=>fake()->email(),
"dni" => $this->dni()
//
];
}
private function dni()
{
// Genera un número de 8 dígitos
$numero = fake()->numberBetween(10000000, 99999999);
// Calcula la letra del DNI
$letras = "TRWAGMYFPDXBNJZSQVHLCKE";
$letraDNI = $letras[$numero % 23];
// Combina ambos para obtener un DNI completo
$dniCompleto = "$numero-$letraDNI";
return $dniCompleto;

    }

{{< / highlight >}}
{{< alert title="Observa" color="warning" >}}
usamos fake() para generar valores aleatorios

Como el dni no está, crearmos un método para hacerlo

El orden de las letras la podemos ver
aquí [Orden de las 23 letras](https://www.interior.gob.es/opencms/ca/servicios-al-ciudadano/tramites-y-gestiones/dni/calculo-del-digito-de-control-del-nif-nie/)
{{< /alert >}}

### Creamos la llamada a las factorías desde el seeder

Para ello vamos al seeder AlumnoSeeder
{{% imgproc seeder Fill "200x100" %}}

{{% /imgproc %}}
E invocamos a la factoria
{{< highlight php "linenos=table, hl_lines=1" >}}
//...
use App\Models\Alumno;

class AlumnoSeeder extends Seeder
{
public function run(): void {
Alumno::factory()->count(100)->create();

    }

}
{{< / highlight >}}
{{< alert title="use App\Models\Alumno;" color="warning" >}}
factory() es un métod del modelo
Para poderlo usar debemos de especificar su uso con la instruccióno {{<color_blue>}}use App\Models\Alumno {{<
/color_blue>}}
{{< /alert >}}

Ahora queda llamar al seeder a partir de la clase DatabaseSeeder
{{% imgproc databaseseeder Fill "300x150" %}}

{{% /imgproc %}}
{{< highlight php "linenos=table, hl_lines=3 4" >}}
public function run(): void
{
$this->call([
AlumnoSeeder::class
]);
}
{{< / highlight >}}
{{% /pageinfo%}}

## Ejecutamos las accciones sobre la base de datos

{{% pageinfo%}}

#### Configuramos la base de datos

En el fihcero {{<color_blue>}}.env{{</color_blue>}} establecemos los parámetros de conexión con el servidor de base de
datos donde vaya a estar el servidor de base de datos
****
Esta sería una configuración típica si estás usando {{<color_blue>}}wammp o xammp{{</color_blue>}}
{{< highlight env "linenos=table, hl_lines=2 4 5" >}}
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=gestion_alumnos
    DB_USERNAME=root
    DB_PASSWORD=
{{< / highlight >}}
Yo uso un docker y tengo esta configuración
{{< highlight env "linenos=table, hl_lines=3 5 6 7" >}}
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=23306
    DB_PORT_PHPMYADMIN=8080
    DB_DATABASE=nett
    DB_USERNAME=nett
    DB_PASSWORD=nett12345
    DB_PASSWORD_ROOT=root12345
{{< / highlight >}}

Una vez configurado tenemos que {{<color_blue>}}ejecutar las migraciones{{</color_blue>}} para {{<color_blue>}}ºcrear las tablas{{</color_blue>}} y ejectar {{<color_blue>}}el seeder para que las pueble{{</color_blue>}}.
Lo podemos hacer con un único comando
{{< highlight bash "linenos=table, hl_lines=1" >}}
php artisan migrate --seed
{{< / highlight >}}
> {{< alert title="fresh " color="warning" >}}
> Si hubiera algún error o queremos modificar algo y volver a cargar la base de datos
> {{< /alert >}}

{{< highlight php "linenos=table, hl_lines=1" >}}
php artisan migrate:fresh --seed
{{< / highlight >}}

{{% /pageinfo%}}

