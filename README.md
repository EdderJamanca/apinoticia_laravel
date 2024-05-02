# API Noticia

Este proyecto se generó con Laravel versión 10.10

## Configuración

1. Para configurar y ejecutar la aplicación Angular, sigue estos pasos
```bash
git clone https://github.com/EdderJamanca/apinoticia_laravel.git
````
2. Instala las dependencias del proyecto:
```bash
    composer install

````
3. Configurar la conexión a la base de datos  en el archivos de entorno: ,
```bash
    .env
   .env.develop
   .env.production
````

4. Migrar los tablas a la bse de datos sql server
```bash
   php artisan make : migrate
````

5. Ejecuta la aplicación en modo de desarrollo:
```bash
   php artisan serve
````
## Lista de Endpoint
1. Categoría
```bash
    GET
   http://127.0.0.1:8000/api/categoria/listado
````
2. Noticia
```bash
    GET
   http://127.0.0.1:8000/api/noticia/listnoticia?idcategoria=${di categoría},2&calificacion=${valo de la valificación}
   DELETE
   http://127.0.0.1:8000/api/noticia/eliminar/${ID de la noticia}
   Post
   http://127.0.0.1:8000/api/noticia/registrar
    body:
    {
    "CategoriaId": number,
    "Titulo": string,
    "Resumen": string,
    "Img": string,
    "Contenido": string,
    "Calificacion": number,
    "Nom_Autor": string
    }

````
