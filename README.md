<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Description

This project is made with Laravel framework, to show some details of how TDD (Test-Driven Development) would work inside a Laravel application.
This project is algo using Docker to orchastrate the containers and run the application without having to install anything but the docker itself.

## Installation

To install all the packages used in this Laravel application you must Clone this repository and use these commands.

Inside the cloned repository project, run docker dependencies to get php, composer and laravel installations. (You must download and configure docker in your setup for this to work.
```bash
$ docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

```bash
$ duplicate the .env_example file and name it .env
```
## Creating an alias for sail

```bash
$ alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

## Running migrations

If you are going to make use of the code for something beside the tests, you should run the migrations, to create all the base tables you need, plus books table inside your mysql

```bash
$ sail artisan migrate
```

## Running the container

```bash
$ sail up
```

## Stopping the container

```bash
$ sail down
```


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
