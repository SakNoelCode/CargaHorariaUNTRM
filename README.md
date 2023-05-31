<p align="center"><a href="#" target="_blank"><img src="https://avatars.githubusercontent.com/u/51960834?s=100"></a></p>

# Gestión de carga horaria UNTRM
![Img](https://github.com/SakNoelCode/Imagenes_Proyectos/blob/master/Captura%20de%20pantalla%20(5).png)

------------

## Sobre el proyecto
El siguiente proyecto tiene como finalidad administrar y gestionar todos los procesos que se encargan de asignar un horario a los docentes de la universidad UNTRM. Se construyo usando [laravel 10](https://laravel.com/docs/10.x "laravel 9") y [livewire](https://laravel-livewire.com/docs/2.x/quickstart "livewire").

## Instalar en local
### Dependencias
- Se debe tener instalado [XAMPP](https://www.apachefriends.org/es/download.html "XAMPP") (versión **PHP** **8.1.12** o superior)  
- Se debe tener instalado [Composer](https://getcomposer.org/download/ "Composer")

### Como instalar
1. Clone o descargue el repositorio a una carpeta en local

1. Abra el proyecto en su editor favorito (**Visual Studio Code**)

1. Ejecute la aplicación **XAMPP** e inice los módulos de **Apache** y **MySQL**

1. Abra una nueva terminal en su editor ( **Visual Studio Code**)

1. Compruebe de que tiene instalado todas dependencias correctamente, ejecute los siguientes comandos: **(Ambos comandos deberán ejecutarse correctamente)**
```bash
php -v
```
```bash
composer -v
```

1. Ahora ejecute los comandos para la configuración del proyecto:

- Este comando nos va a instalar todas la dependencias de composer, lee el archivo **composer.json** y crea la carpeta **vendor**
```bash
composer install
```
- Duplique el archivo **.env.example**, al archivo duplicado cambiar de nombre como **.env**, este archivo se debe modificar según las configuraciones de nuestro proyecto, en nuestro caso se deben modificar las conexiones para nuestra base de datos y el nombre de la aplicación (opcional)
```bash
APP_NAME=Carga_Horaria

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dbcargahoraria
DB_USERNAME=root
DB_PASSWORD=
```
- Este comando nos generará una nueva key, lo agregará el archivo **.env** automáticamente
```bash
php artisan key:generate 
```
### Ultimos pasos
1. Entrar a la configuración de **[phpMyAdmin](http://localhost/phpmyadmin/ "phpMyAdmin")**
2. Crear una nueva base de datos, deberá tener el nombre que se ha puesto en el archivo **.env**
3. Correr la migraciones del proyecto, para eso debemos ejecutar el comando:
```bash
php artisan migrate
```
4. Ejecute los seeders **(aquí se crearán datos de prueba, incluyendo a los usuarios, aquí puede consultar las credenciales para que ingrse a la aplicación)**:
```bash
php artisan db:seed
```
5. Ejecute el proyecto con el comando:
```bash
php artisan serve
```

## Documentación
Encuentré la documentación del sistema [aquí](https://universityproyectx.blogspot.com/2023/05/proyecto-de-carga-horaria-para-la-untrm.html "aquí")

## Consideraciones
- El proyecto trabaja con la versión **8.1.12** de PHP
- El proyecto trabaja con [Jetstream](https://jetstream.laravel.com/3.x/introduction.html)
- Al trabajar con Jetstream, automaticamente usa los estilos de [TailwindCSS](https://tailwindcss.com/docs/installation) 

------------
![Img](https://github.com/SakNoelCode/Imagenes_Proyectos/blob/master/Captura%20de%20pantalla%20(6).png)

## Licencia
- Este proyecto está licenciado bajo la Licencia MIT. Para más información, consulta el archivo [LICENSE](LICENSE).





