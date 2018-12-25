# Vote-machine-api (Slim Framework 3)

the intelligence behind an election application is not always easy to set up, especially if you have to manage all possible cases, this small project is the implementation of the application that could make the machine turn vote that may be used in my country for the 2018 elections

## startup the Application

Run this command from the directory in which you want to install your new Slim Framework application.

    php -S localhost:8080 -t public

create a database named "vote-machine" after run **migrations** and **seeds

    ./vendor/bin/phinx migrate
    ./vendor/bin/phinx seed:run
