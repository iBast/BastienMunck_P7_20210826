# Bilemo API

## Context

_This project was made during my OpenClassrooms training path PHP/Symfony_

[https://openclassrooms.com/fr/paths/59-developpeur-dapplication-php-symfony](More informations here)

## Project Installation

* copy repository git clone [https://github.com/iBast/BastienMunck_P7_20210826.git](https://github.com/iBast/BastienMunck_P7_20210826.git)
* run 
```
$ composer install
```
* update .env file with your informations and define environnment dev or prod
* Create the database with 
```
$ php bin/console doctrine:database:create
```
* Create your migrations with  
```
$ php bin/console make:migration
```
* Migrate your migrations to the database with 
```
$ php bin/console doctrine:migrations:migrate
```
* If you need to procced tests load fixtures into the database with  
```
$ php bin/console doctrine:fixtures:load
```

## Usage

Documentation can be found at youdomain.com/api/doc


Header : Accept : application/json;version="1.0"