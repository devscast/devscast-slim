# devs-cast.com
devs-cast.com, the idea behind it is to have a platform of podcasts in web devs 
and articles on web devs (javascript) and algorithm in general, 
the platform also provides quotes in the fields of software programming and algorithm challenge to improve your own level in programming

## Get Started
devscast is open source under a license that prevents commercial use of the source code, 
the application is made with PHP based on the mini-framework slim in its version 3 

* Slim (http: //www.slimframework.com/)
* PSR-7 (https://www.php-fig.org/psr/psr-7) 

#### requirements
* PHP >= 7.2 (composer >= 1.8)
* nodejs >= 12.0
* npm >= 6.11 or yarn >= 1.19
* mysql or mariaDB

#### Installation
```bash
$ git clone https://github.com/itotafrica/devscast-backend devscast
$ cd devscast
$ composer install
```

#### App and Database configuration
create an empty database then configure the connection to it in the ```.env``` file (do not version it) that you create based on the ```.env.example```

it is also important to define the IDs of a default administrator who will be created when seeding the database

```dotenv
DEFAULT_ADMIN_NAME='admin'
DEFAULT_ADMIN_EMAIL='admin@example.org'
DEFAULT_ADMIN_PASS='123456'

DATABASE_NAME = 'devcast'
DATABASE_HOST = 'localhost'
DATABASE_USERNAME = 'root'
DATABASE_PASSWORD = 'root'
DATABASE_PORT = '3306'
DATABASE_CHARSET = 'utf8'
DATABASE_ADAPTER = 'mysql'
DATABASE_MIGRATION_TABLE = 'phinxlog'
```
after configuring the database, make sure that the application is in development mode, 
this will allow you to see and understand potential launch errors
```dotenv
APP_ENV = 'dev'
APP_DEBUG = 'true'
```
**App Error #01**, when you have this error when starting the application your first reflex would be to look at the log file
corresponding to the current date.
```/data/log/[current_date].log```

#### Database Migration and Seeding
after configuring the application and database, you can run migrations and seedings, 
make sure you have provided default IDs for the default administrator

```bash
$ ./vendor/bin/phinx migrate
$ ./vendor/bin/phinx seed:run
```

for more information on the migration process here is a link to the phinx documentation :
[phinx docs](http://docs.phinx.org/en/latest/commands.html)

#### Running the application
you can use an apache or nginx server, the production application (devs-cast.com) uses apache as server, you can also use the internal PHP server

```bash
$ php -S localhost:8080 -t public router.php
```
open your browser and access to http://localhost:8080

you should see a very ugly page because we haven't compiled the assets yet for that, make sure you have installed the **nodejs**

to compile the assets:
```dotenv
$ npm install
$ npx gulp  # or node gulpfile.js
```

**And here we go...**

**from here you have enough information to figure out how to get around on your own.**
