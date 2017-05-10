# Lunchbox

## Overview
This APP encourages having lunch between employees in your office!

## Features

* CRUD employees
* CRUD department
* CRUD employee's position
* Create lunch group by matching algorithm.

## Requirement
* PHP >= 7.0
* Node.js
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension
* Framework
    * server side FW: Laravel v5.4
    * frontend FW: Vue.js v2.1

## Installation

composer install
```bash
$ composer install
```

change permission
```bash
$ chmod -R 777 storage
$ chmod -R 777 bootstrat/cache
```

npm install
```bash
$ npm install
```

create .env file and setup the .env file
```bash
$ cp .env.example .env
```

generate APP_KEY
```bash
$ php artisan key:generate
```

db migrate
```bash
$ php artisan migrate
```

run server
```bash
$ php artisan serve
```

refer to the [Laravel 5.4 Installation](https://laravel.com/docs/5.4/installation)


## Learning Laravel
* [Laravel documentation](https://laravel.com/docs)
* [Laracasts](https://laracasts.com)

## Learning Vue.js
* [Vue.js v2 Guide](https://vuejs.org/v2/guide/)
