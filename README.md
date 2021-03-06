## Install for Linux (~Ubuntu 18.04)

First of all go to the project folder.
Open putty with main project folder. (if u under root, else don't forget to write 'sudo'):

~~~
docker-compose up --build -d
~~~
Open in browser: {your-server}:6080, then create table with the same name as in the config file (default = swim, utf-8 
general_ci);
Comeback to terminal. When services started, write in putty these commands:
~~~
sudo docker-compose exec web bash
~~~
~~~
chmod -R 777 ./runtime
chmod -R 777 ./web/assets
chmod -R 777 ./web/files
composer install
php yii migrate --migrationPath=@yii/rbac/migrations
php yii migrate
~~~
If u need to install ssl-certificate:
~~~
certbot --apache -d {YOUR_DOMAIN} -n --email {YOUR_EMAIL} --agree-tos
~~~
That's all. U can close your terminal and it will work.

## Install for Windows (without Docker)

First of all go to the project folder.
Open cmd.
~~~
cd your/project/path/src
~~~

Install vendor packages:
~~~
composer install
~~~

Try to update it to last version:
~~~
composer update
~~~

Find folder config/ and create there db-local.php:
~~~
cd config
xcopy db.php db-local.php
~~~

Configure your db-local.php like this:
```php
<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=127.0.0.1;dbname=swim',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];
```

Come back to the main project folder and apply migrations:
~~~
cd ..
yii migrate --migrationPath=@yii/rbac/migrations
yii migrate
~~~

------
**Notes:**

1. If you want to enable yii debugger:
#### Windows 10:
~~~
cd {your/project/path}/src/web
echo.>.debug
~~~

#### Linux (~Ubuntu 18.04) or Mac
~~~
cd {your/project/path}/src/web
touch .debug
~~~

2. If you want to config your php, create file in ./etc/myphp.ini and change it as you want:
#### Windows 10:
~~~
cd {your/project/path}/etc
echo.>myphp.ini
~~~

#### Linux (~Ubuntu 18.04) or Mac
~~~
cd {your/project/path}/etc
touch myphp.ini
~~~