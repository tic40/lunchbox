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
```
$ composer install
```

change permission
```
$ chmod -R 777 storage
$ chmod -R 777 bootstrap/cache
```

npm install
```
$ npm install
```

create .env file and setup the .env file
```
$ cp .env.example .env
```

generate APP_KEY
```
$ php artisan key:generate
```

db migrate
```
$ php artisan migrate
```

running Mix tasks
```
// Run all Mix tasks...
npm run dev

// Run all Mix tasks and minify output...
npm run production
```

run server
```
$ php artisan serve
```

refer to the [Laravel 5.4 Installation](https://laravel.com/docs/5.4/installation)


## Learning Laravel
* [Laravel documentation](https://laravel.com/docs)
* [Laracasts](https://laracasts.com)

## Learning Vue.js
* [Vue.js v2 Guide](https://vuejs.org/v2/guide/)
