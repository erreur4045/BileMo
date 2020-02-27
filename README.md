# Symfony
[![Maintainability](https://api.codeclimate.com/v1/badges/770472da3b7b6b6cbbab/maintainability)](https://codeclimate.com/github/erreur4045/BileMo/maintainability)

Créez un web service exposant une API
==================================
### *Project 7 OpenClassRooms*

![symfony](https://d1pwix07io15pr.cloudfront.net/vd3200fdf32/images/logos/header-logo.svg)

* Developped with the Symfony 4.4.4 framework

## Prérequisites
* **Php 7.3.5**
* **Mysql 5.7**

## Tested with:
- PHPUnit [more infos](https://phpunit.de/)

## Install application:
clone or download the repository into your environment. https://github.com/erreur4045/BileMo

```
$ composer install
```
enter your parameters database in .env file
```
$ php bin/console doctrine:database:create
```
```
$ php bin/console doctrine:migrations:migrate
```
```
$ php bin/console doctrine:fixtures:load
```

Run application in your favorite browser
For test to retrieve a valid token call the url /login_check method POST with the following identifiers :
```
{
	"username": "darty",
	"password": "testpass"
}
```

doc : /api/doc

#General

GET
​/api​/doc.json
Return documentation on json format
POST
​/api​/login_check
Allows to retrieve a valid token

#About Phones

###GET
​/api​/phones
Return all phones

###GET
​/api​/phones​/{id}
Find phone by ID

#About Users

###GET
​/api​/clients​/{client_id}​/users
Allows you to retrieve all users.

###POST
​/api​/clients​/{client_id}​/users
Allows you to post a new user.

###GET
​/api​/clients​/{client_id}​/users​/{id}
Allows you to retrieve a single user.

###DELETE
​/api​/clients​/{client_id}​/users​/{id}
Allows you to delete a user.

# *Enjoy !!*