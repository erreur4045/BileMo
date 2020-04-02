# Symfony
[![Maintainability](https://api.codeclimate.com/v1/badges/770472da3b7b6b6cbbab/maintainability)](https://codeclimate.com/github/erreur4045/BileMo/maintainability)

Créez un web service exposant une API
==================================
### *Project 7 OpenClassRooms*

![symfony](https://symfony.com/images/logos/header-logo.svg)

* Developped with the Symfony 4.4.4 framework

## Prérequisites
* **Php 7.3.5**
* **Mysql 5.7**

## Tested with:
- PHPUnit [more infos](https://phpunit.de/)
# General
### GET​
/api​/doc.json 

*Return documentation on json format*

### POST​
/api​/login_check 

*Allows to retrieve a valid token*

# About Phones

### GET
​/api​/phones 

*Return all phones*

### GET
​/api​/phones​/{id} 

*Find phone by ID*

# About Users

### GET
​/api​/clients​/{client_id}​/users 

*Allows you to retrieve all users.*

### POST
​/api​/clients​/{client_id}​/users 

*Allows you to post a new user.*

### GET
​/api​/clients​/{client_id}​/users​/{id} 

*Allows you to retrieve a single user.*

### DELETE
​/api​/clients​/{client_id}​/users​/{id} 

*Allows you to delete a user.*

## Install application:
clone or download the repository into your environment. https://github.com/erreur4045/BileMo

```
$ composer install
```
## enter your parameters database in .env file
```
$ php bin/console doctrine:database:create
```
```
$ php bin/console doctrine:migrations:migrate
```
```
$ php bin/console doctrine:fixtures:load
```
## Generate the SSH keys:
````
$ mkdir -p config/jwt
$ openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
$ openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
````
#### According to the lexik_jwt_authentication.yaml file,you have to fill in the following fields in your .env file at the root of the folder.
````
###> lexik/jwt-authentication-bundle ###
JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
JWT_PASSPHRASE=Your pass phrase used for generate key
JWT_TOKEN_TTL=The validity time of the generated token expressed in seconds.(e.g 2000)
###< lexik/jwt-authentication-bundle ###
````
For test to retrieve a valid token call the url /login_check method POST with the following identifiers :

```
{
	"username": "darty",
	"password": "testpass"
}
```

# *Enjoy !!*