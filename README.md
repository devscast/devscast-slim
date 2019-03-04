# Backend (Slim Framework 3)

## Before all
hey the devs, here are some rules to respect when you work on this project ...
as a project manager, I am very meticulous about the code you write :)

before doing a **commit** make sure that you have **linted** your code in psr2 and psr12 format. to do that, start the command

```
./vendor/bin/phpcs -s
./vendor/bin/phpcbf
```

fix typos errors if possible, for advanced configuration **phpcs.xml** contains linter configuration

# Get started
for the development I recommend you to use the internal php server by launching the command
```
php -S localhost:8081 -t public
```

# Documentation
read the documentation of the project
```
php -S localhost:8082 -t docs
```

assets compilation using sass

```
sass --watch resources/sass/main.scss:public/assets/app.css --style=compressed
```

assets compilation using webpack

```
yarn install
yarn build / yarn dev
```


# Questions ?
for any questions, please read the documentation or submit an issue