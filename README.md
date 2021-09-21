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
* Generate SSH key for JWT
```
$ mkdir -p config/jwt 
$ openssl genrsa -out config/jwt/private.pem -aes256 4096
$ openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```

## Usage

All documentation can be found at youdomain.com/api/doc

You should first generate your Bearer Token posting your credentials at route youdomain.com/api/login_check
```
{
    "username": "your@email.com",
    "password": "yourpassword"
}
```

you will get your token like this
```
{
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MzIyMjY3ODYsImV4cCI6MTYzMjIzMDM4Niwicm9sZXMiOlsiUk9MRV9BRE1JTiIsIlJPTEVfVVNFUiJdLCJ1c2VybmFtZSI6ImJhc3RpZW4ubXVuY2tAbWUuY29tIn0.QzSO4IWizkzPpWC7fTTPMOpeqtfb4AgzmfmyJ-n510QYtg5OTkGNHBHcIYTKxujXRIKwAI9JK4vy3x74cK0az4ndbg4Xq8TZUhqtxrCxBz241BhEamQQQ3WEcvKExUAWyVmLUf6TDFN4d10YQSnZLbRy5BBUpNlnMeDMTNSM7ni6r9Annjxn-C03FpEYdEwKw0LTsMYWBzXdCgvlNOiUa929X8Q86rsP4AXzofMAMShx9ITawEYo3XwYMJU-jPTHjkuT8Kx7J3NuzsI8JGkMhngaBbllyyPrcMSFVBEssevtEV4SyBLfQlOcM-4TjB2yUHglAzmoWpoxoIDmpaeTXw"
}
```


Routes are :
    * 

Header : Accept : application/json;version="1.0"