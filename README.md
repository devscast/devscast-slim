# Backend-api workflow (Slim Framework 3)

## Before all
hey the devs, here are some rules to respect when you work on this project ...
as a project manager, I am very meticulous about the code you write :)

before doing a **commit** make sure that you have **inter** your code in psr2 and psr12 format. to do that, start the command

```
./vendor/bin/phpcs -s
./vendor/bin/phpcbf
```

fix typos errors if possible, for advanced configuration **phpcs.xml** contains linter configuration

# Server
for the development I recommend you to use the internal php server by launching the command
```
php -S localhost:8081 -t public
```
port 8081 is important in our case because it is used in the frontend application of the same project

# Questions ?
for any questions, please read the documentation of the libraries used in the project
our slim app uses **PHPDI** bridge