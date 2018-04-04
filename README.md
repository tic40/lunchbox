# Lunchbox

![lunchbox image](https://github.com/tic40/lunchbox/blob/master/public/images/lunch_bg.jpg)

## Overview
This APP encourages having lunch between employees in your office!

## Features

* CRUD employees
* CRUD department
* CRUD employee's position
* Create lunch group by matching algorithm.

## Requirement
* PHP >= 7.0
* Node.js v6.x
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension
* Framework
    * server side FW: Laravel v5.4
    * frontend FW: Vue.js v2.1

## Getting started for dev

create container via docker
```
$ docker-compose up
```

```
# setup dev env
$ docker exec -it lunchbox_web_1 /app/setup-dev.sh
# start dev server
$ docker exec -it lunchbox_web_1 /app/start-dev-server.sh
```

check app via browser
```
http://localhost:8080
```

set test data
```
$ docker exec lunchbox_web_1 php artisan db:seed
```

running Mix tasks
```
// Run all Mix tasks...
$ npm run dev

// Run all Mix tasks and minify output...
$ npm run production
```

## Learning Laravel
* [Laravel documentation](https://laravel.com/docs)
* [Laracasts](https://laracasts.com)

## Learning Vue.js
* [Vue.js v2 Guide](https://vuejs.org/v2/guide/)
