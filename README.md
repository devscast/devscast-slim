# devs-cast.com

the goal of the project is to create a new way to learn and stay informed about the evolution of technology ...
and this thanks to the audio support, which starts to take the air because listen is less work than read then devscast will be an application or in other words an online radio where will speak only development and technology

the challenge we have is to give this radio intelligence to a website

## Get Started
devscast is opensource and is programmed in PHP 
we decided to implement the PSR-7 (https://www.php-fig.org/psr/psr-7) 
based on the mini-framework Slim (http: //www.slimframework.com/)

## 1 installation
#### 1.1 fork or clone the project
```bash
$ git clone https://github.com/itotafrica/devscast-backend devscast
```

#### 1.2 install dependencies
```bash
$ cd devscast
$ composer install
```

#### 1.3 Create a database configuration and run migrations and seeding
create your own database configuration by creating a ``settings.local.php`` in the ``config/``
your configuration should match the ``settings.local.php.exemple`` then run migrations and seeding
```bash
$ ./vendor/bin/phinx migrate -e development
$ ./vendor/bin/phinx seed:run -e development
```

#### 1.4 Assets compilation
you can use the webpack devserver to compile assets resources or directly use the sass compliator
```bash
$ yarn install
$ yarn dev
```
or
```bash
$ sass resources/sass/style.scss:public/assets/app.css --watch --style=compressed
```

#### 1.5 Run the project
you can use the php internal server or an ``apache`` server. the devs-cast.com host is an apache server
```bash
$ php -S localhost:8080 -t public
```

## 2 Contributing

fork the project and send us pull requests, or request to join the devscast internal team to : coderngandu@gmail.com

#### 2.1 contributing process
actually you don't write **unit tests**, 
* you should test your code manually before pulling a request
* you should lint your code with ``$ ./vendor/bin/phpcs`` and fix error before a commit
* you should generate a docs for all change you've done in a separate commit

#### 2.2 development tools
lint your code and fix errors the linter configuration is ``phpcs.xml``
```bash
$ ./vendor/bin/phpcs -s
$ ./vendor/bin/phpcbf
```

generate API documentation with sami (https://github.com/FriendsOfPHP/Sami)
```bash
$ php sami.phar update docs.config.php
```

generate API (OpenApi specification) with swagger (https://github.com/zircote/swagger-php)
```bash
$ composer swagger
```

## 3 Requirements
* PHP >= 7.2.*
* Nodejs >= 8.*
* Webpack >= 4.*
* sass 1.14.3 (dart2js 2.0.0)