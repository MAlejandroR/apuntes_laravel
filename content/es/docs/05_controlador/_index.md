---
title: "Controlador"
date: 2023-04-08T18:21:47+02:00
draft: false
weight: 40
icon: fas fa-cogs
---
## Ejecutar la migración
Debemos de crear la base de datos y poderla cargar

##  métodos de get
Para ello escribimos el código de index y show con las respectivas rutas
{{< highlight bash "linenos=table,anclorlinenos=true, hl_lines=" >}}
http://localhost:8000/api/books => obtener todos los libros
http://localhost:8000/api/books/1 => obtener el libro de id 1
{{< / highlight >}}

Como lo que nos retorna es un Json, podemos instalar algún plugin para verlo de forma mas legible en el navegador, por ejemplo **[jsonview](https://chrome.google.com/webstore/detail/jsonview/gmegofmjomhknnokphhckolhcffdaihd?hl=es)**

## metodos PATCH DELETE y POST
Ahora queremos probar estas otras rutas
Para ello debemos de tener una herramienta que nos permita realizar llamadas de este tipo, con el navegador no podemos y estamos haciendo un api, no la parte de uso, sino de servicio
Podemos instalar **[postman](https://www.postman.com/)**
{{< highlight bash "linenos=table,anclorlinenos=true, hl_lines=" >}}
sudo apt install snapd
sudo apt update
sudo snap install postman
{{< / highlight >}}
*Podemos probar una solicitud por  **post** y hacer que el método **store** me retorne un texto, lo mismo con **patch** y con **delete**  y ver qué es
### post
Vemos que con el post, en la parte del body del mensaje hay que aportar algún valor
Para ello vamos al body y usamo el form-data para pasar valores

{{< imgproc post_man1 Fit "100000x700000 center" >}}
Pasar parámetros para el post
{{< /imgproc >}}
Escribmos el código del método **store** añadiendo un nuevo libro

Podemos ver qué ocurre si ponemos otro parámetro o no pasamos ningún libro

Para poder ver los errores debemos habilitar los hedear para en formato json aceptar los errores
{{< imgproc post_header Fit "100000x700000 center" >}}
Añadir la opción de ver los errores en el navegador
{{< /imgproc >}}

Podemos establecer en el servidor el control del error indicando lo que queramos que se muestre si no aparece el error
{{< highlight php "linenos=table,anclorlinenos=true, hl_lines=" >}}
    public function store(Request $request)
    {
        $request->validate([
            'titulo'=>['required']
        ]);

        $book = new Book();
        $book->titulo=$request->input('titulo');
        $book->save();
        return $book;
        //
    }
{{< / highlight >}}

### PATH
La actualización es muy similar al storage, con la diferencia que solo queremos actualizar, no agregar
En el postman, para pasar los nuevos datos usamos 
{{< imgproc post_patch_form_endocode Fit "100000x700000 center" >}}
modo de pasar datos al método patch
{{< /imgproc >}}
{{< highlight php "linenos=table,anclorlinenos=true, hl_lines=" >}}
public function update(Request $request, Book $book){
        $request->validate([
                    'titulo'=>['required']
        ]);
        $book->titulo=$request->input('titulo');
        $book->update();
        return $book;
    }
{{< / highlight >}}

## DELETE
En este caso el método **delete** es muy sencillo. Podemos retornar un mensaje

{{< highlight php "linenos=table,anclorlinenos=true, hl_lines=" >}}
public function destroy(Book $book)
{
$book->delete();
return "Se ha borrado ".$book->titulo;
}

{{< / highlight >}}