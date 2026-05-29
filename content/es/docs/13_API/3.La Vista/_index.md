---
title: "3.La Vista unitarios"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 30
---
## Tipos de test en laravel
Realizar test, es **muy importante**. Muchas veces pensamos que como no los necesitamos para que la apliación funcione lo dejamos para el final, o simplemente no lo hacemos (para ejemplo yo mismo :cold_face: )

Laravel ya aporta una estructura de test, que podemos ver en la carpeta correspondiente.
En ella vemos que tenemos dos tipos de test:
* Feature
>   Test de características dónde se testean diferentes componentes interactuando entre ellos
* Unit
>  Que testean métodos concretos del código

*El funcionamiento de los métodos creados es el muy parecido. Para esta api, vamos a realizar los test usando los FeatureText
## Ejecutando los test en laravel
En el terminal escribimos 
{{< highlight bash "linenos=table,anclorlinenos=true, hl_lines=" >}}
    php artisan test
{{< / highlight >}}
Vamos a crear métodos para validar cada uno de los 5 métodos que tenemos en el controlador
{{% pageinfo color="primary" %}}
Un test es un método que nos va a permitir validar otro método
En el método del test, básicamente vamos a hacer 3 acciones
*Invocar al método que queremos testear pasándole los valores que consideremos
*Comprobar que lo que devuelve ese método que validamos es lo que esperamos que devuelva
*Informar de ello
{{% /pageinfo %}}
Los test no son infalibles, es decir, nosotros validamos lo que consideramos, por ejemplo si valido un método de fecha, si le paso una fecha incorrecta, espero que me lo diga, y si es correcta igual, eso me permitiría validar el método.
Veamos cómo se realizan estas acciones
**1.-  Creamos una clase para el test del api. **
El método de test, se espera que termine con la palabra Test. Creamos una clase llamada **BookApiTest** para nuestro ejemplo
{{< highlight shell "linenos=table,anclorlinenos=true, hl_lines=" >}}
    php artisan make:test BookApiTest
{{< / highlight >}}
Empezamos validando el método **index** para ello vamos a crear un método
Importante que el método empiece por la palabra test
{{< highlight php "linenos=table,anclorlinenos=true, hl_lines=" >}}
public function test_can_get_all_books(): void{

    }

{{< / highlight >}}

Pero claro, necesitamos tener la base de datos poblada y comprobar que cuando consultamos obtenemos todos los registros
Pero no queremos tocar la base de datos original, si no que vamos a craar una base de datos para los test, para lo cual vamos a usar la clase (traid) **RefreshDatabase** que nos ofrece Laravel
Creamos una nueva base de datos (también podríamos usar sqlite en memoria)
Para configurar la base de datos de test, primero la creamos en nuestro gestor
{{< imgproc base_datos_test Fit "100000x700000 center" >}}
creamos la base de datos api_test
{{< /imgproc >}}
Ahora lo configuramos en el fichero **phpunit.xml**
{{< highlight xml "linenos=table,anclorlinenos=true, hl_lines=" >}}
<php>
<env name="APP_ENV" value="testing"/>
<env name="BCRYPT_ROUNDS" value="4"/>
<env name="CACHE_DRIVER" value="array"/>
<!-- <env name="DB_CONNECTION" value="sqlite"/> -->
<env name="DB_DATABASE" value="api_test"/>
{{< / highlight >}}
Para poblar la base de datos de pruebas, vamos a usar el factory que creamos cuando construimos el modelo

Una vez creado, lo invocamos desde el método credado
Vamos simplemente a crear un libro y visualizarlo
{{< highlight php "linenos=table,anclorlinenos=true, hl_lines=" >}}
//En el factory
public function definition(): array{
    return [
            'titulo'=>fake()->sentence(),
            ];
}

//En el test
public function test_can_get_all_books(): void{
        $book = Book::factory()->create();
        dd($book);
    }
{{< / highlight >}}
Por ejemplo vamos a creaer 4 libros y verificamos que haya 4 libros
{{< highlight php "linenos=table,anclorlinenos=true, hl_lines=" >}}
public function test_can_get_all_books(): void
{
    $book = Book::factory()->count(4)->create();
    dd($book->count());

}
{{< / highlight >}}
Ahora vamos a ver lo que retorno si hacemos una solicitud **get**
{{< highlight php "linenos=table,anclorlinenos=true, hl_lines=" >}}
public function test_can_get_all_books(): void
{
    $book = Book::factory()->count(4)->create();
    $this->get("/api/books")->dump();
}

{{< / highlight >}}
Ahora que vemos esto, se trataría de verficar los libros que nos devuelve son los que hemos creado
Para ello vamos a hacer uns aserción y verficar que esto funciona.
para ello vamos a recoger la respuesta y vamos a comparar por ejemplo los títulos de los dos primeros libros recibidos con los títulos de los dos primeros libros creados.
{{< highlight php "linenos=table,anclorlinenos=true, hl_lines=" >}}
public function test_can_get_all_books(): void
{
    $book = Book::factory()->count(4)->create();
    $response = $this->getJson(route("books.index"));
    $response->assertJsonFragment([
        'titulo'=>$book[0]->titulo
    ])
    ->assertJsonFragment([
                'titulo'=>$book[1]->titulo
    ]);

   }
 
{{< / highlight >}}
Ejecutamos el test y vemos que funciona
Probar por ejemplo a modificar el método index y ver que no funciona, por ejemplo si solo retornamos un libre en lugar de todos , o no devolvemos nada ...
**Verificar el método **show**
{{< highlight php "linenos=table,anclorlinenos=true, hl_lines=" >}}
/**
* @test
*/
public function can_get_one_book():void{
    $book=Book::factory()->create();
    $response = $this->getJson(route("books.index"));
    $response->assertJsonFragment([
            'titulo'=>$book->titulo
    ]);
}
* Observa que si ponemos la directiva **@test** ya no hay que hacer que el nombre del método empiece por la palabra **test**
  {{< / highlight >}}
**Verificar el método store**
{{< highlight php "linenos=table,anclorlinenos=true, hl_lines=" >}}
/**
* @test
*/
public function can_crate_book():void{

        $this->postJson(route('books.store'),[
            'titulo'=>"Mi libro de pruebas"
        ])->assertJsonFragment([
            'titulo'=>"Mi libro de pruebas"
        ]);
        $this->assertDatabaseHas('books',
            ['titulo'=>"Mi libro de pruebas"]
        );


}
{{< / highlight >}}
En este caso hacemos dos aserciones, podemos ver cómo tanto con solo una, como con dos, funciona correctamente
Vamos a ver cómo podemos también validar que si no le pasamos nada, nuestra aplicación esparemos que nos de un error. Por ejemplo si quitáramos la validación en el controlador,
{{< highlight php "linenos=table,anclorlinenos=true, hl_lines=" >}}
public function can_crate_book():void{
    $this->postJson(route('books.store'),[])
    ->assertJsonValidationErrors('titulo');
/....
{{< / highlight >}}
**Actualizar un libro**
{{< highlight php "linenos=table,anclorlinenos=true, hl_lines=" >}}
/**
* @test
*/
public function can_update_book():void{
$book=Book::factory()->create();
$this->patch(route("books.update",$book),[
            'titulo'=>"Libro editado"
            ])->assertJsonFragment([
                'titulo'=>'Libro editado'
            ]);
            //Verificamos también en la base de datos
        $this->assertDatabaseHas('books',[
                'titulo'=>"Libro editado"
            ]);

        }
{{< / highlight >}}
*Podemos (debemos) de verificar  también la validación
{{< highlight  php "linenos=table,anclorlinenos=true, hl_lines=" >}}
//Validamos también la validación
$this->patch(route("books.update",$book),[])
->assertJsonValidationErrors('titulo');

{{< / highlight >}}
**Borrar un libro**
*En este caso vamos a eliminar un libro y verificar que no existe
{{< highlight php "linenos=table,anclorlinenos=true, hl_lines=" >}}
/**
* @test
*/
public function can_delete_book(): void
{

        $book = Book::factory()->create();

        //Validamos también la validación
        $respuesta = $this->deleteJson(route("books.destroy", $book), [])
            ->assertContent("Se ha borrado ".$book->titulo);
//            ->assertNoContent();
}
{{< / highlight >}}






 