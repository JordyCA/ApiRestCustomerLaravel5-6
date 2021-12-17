El presente API rest esta realizado en Laravel 5.6 

################# INSTALACIÓN DE LIBRERÍAS #################
Se requiere installar este proyecto se necesita lo siguiente:

1.- Mysql server
2.- Las siguientes libreriras:
        PHP >= 7.1.3
        BCMath PHP Extension
        Ctype PHP Extension
        JSON PHP Extension
        Mbstring PHP Extension
        OpenSSL PHP Extension
        PDO PHP Extension
        Tokenizer PHP Extension
        XML PHP Extension
3.- Composer
4.- Laravel
    
################# PROCESO PARA INICIAR EL PROYECTO #################

1.- Descargar el proyecto y entrar por medio de consola de sistema al proyecto.

2.- Generar el archivo .dev tomando como copia el contenido del archivo .env.example en el mismo lugar donde se
encuentra ese archivo. Y se cambian los accesos de la base de datos de mysql en este caso son los siguientes 
parametros:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret

2.- Por medio de una terminal se instalan los módulos necesarios con composer 
con el siguiente comando: composer install

3.- Cuando esten los complementos del proyecto instalados se podŕa iniciar el proyecto 
con el siguiente comando por medio de terminal: php artisan serve

################# LISTA DE PETICIONES PARA EL API REST #################

1.- api/v1/addCustomer - con esta petición se agregan los customers 

Para esta petición sera necesario los siguientes parametros:
dni, region, commun, email, name, lastName, address(opcional), status

2.- api/v1/showCustomer/ - con esta petición se muestra un customer por dni o email

Para esta petición será necesario uno siguientes parametros:
email, dni

3.- api/v1/deleteCustomer - con esta petición se elimina un customer por dni

Para esta petición será necesario el siguiente parametro: dni
