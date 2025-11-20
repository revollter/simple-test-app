## Quick start:

* Build project:
```
docker compose up --build -d
```
* Install dependencies:
```
docker compose exec php-apache composer install
```
* Run migrations:
```
docker compose exec php-apache php bin/console doctrine:migrations:migrate
```
* Load testing data:
```
docker compose exec php-apache php bin/console doctrine:fixtures:load
```

* Open http://localhost:8080/login

* Login with one of loaded test account:
```
['firstName' => 'admin',     'lastName' => 'admin',      'login' => 'admin',       'password' => 'test123'],
['firstName' => 'Mariusz',   'lastName' => 'Nowak',      'login' => 'm.nowak',     'password' => 'test123'],
['firstName' => 'Zdzisław',  'lastName' => 'Kowalski',   'login' => 'z.kowalski',  'password' => 'test123'],
['firstName' => 'Karolina',  'lastName' => 'Źdźbło',     'login' => 'k.zdzblo',    'password' => 'test123'],
['firstName' => 'Michał',    'lastName' => 'Wabik',      'login' => 'm.wabik',     'password' => 'test123'],
```