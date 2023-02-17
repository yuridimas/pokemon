# LARAVEL POKE API

take the poke API then save it into MongoDB with a rate limit of 5x in 1 minute and use a bearer token

## Requirement

- php 8.1
- php mongo extension
- mongodb
- postgresql / mysql

## Install

``` php
composer install
```

``` text
cp .env.example .env
```

## Configuration

```php
php artisan key:generate
```

```env
DB_MONGO_CONNECTION=mongodb
DB_MONGO_HOST=127.0.0.1
DB_MONGO_PORT=27017
DB_MONGO_DATABASE=pokemon
DB_MONGO_USERNAME=
DB_MONGO_PASSWORD=
```

## Run Project

Command Terminal

```php
php artisan serve
```

Laragon / Valet

```php
{folder-project}.test
```
