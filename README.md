[![Codacy Badge](https://api.codacy.com/project/badge/Grade/d8556932193648629c4e7df449e7289d)](https://app.codacy.com/gh/iBast/BastienMunck_P7_20210826?utm_source=github.com&utm_medium=referral&utm_content=iBast/BastienMunck_P7_20210826&utm_campaign=Badge_Grade_Settings)


# Bilemo API

## Context

_This project was made during my OpenClassrooms training path PHP/Symfony_

[https://openclassrooms.com/fr/paths/59-developpeur-dapplication-php-symfony](More informations here)

## Project Installation

* copy repository git clone [https://github.com/iBast/BastienMunck_P7_20210826.git](https://github.com/iBast/BastienMunck_P7_20210826.git)
* run 
```console
$ composer install
```
* update the following lines in the .env file with your informations:
```env
APP_ENV=dev
APP_SECRET=$$$YOUR*SECRET$$$
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7"
OR
DATABASE_URL="postgresql://db_user:db_password@127.0.0.1:5432/bilemo?serverVersion=13&charset=utf8"
JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
JWT_PASSPHRASE=$$$passphrase$$$
```
* Create the database with 
```console
$ php bin/console doctrine:database:create
```
* Create your migrations with  
```console
$ php bin/console make:migration
```
* Migrate your migrations to the database with 
```console
$ php bin/console doctrine:migrations:migrate
```
* If you need to procced tests load fixtures into the database with  
```console
$ php bin/console doctrine:fixtures:load
```
*  Generate the SSL keys
```console
$ php bin/console lexik:jwt:generate-keypair
```

## Usage

All documentation can be found at youdomain.com/api/doc

You should first generate your Bearer Token posting your credentials at route youdomain.com/api/login_check
```json
{
    "username": "your@email.com",
    "password": "yourpassword"
}
```

you will get your token like this
```json
{
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MzIyMjY3ODYsImV4cCI6MTYzMjIzMDM4Niwicm9sZXMiOlsiUk9MRV9BRE1JTiIsIlJPTEVfVVNFUiJdLCJ1c2VybmFtZSI6ImJhc3RpZW4ubXVuY2tAbWUuY29tIn0.QzSO4IWizkzPpWC7fTTPMOpeqtfb4AgzmfmyJ-n510QYtg5OTkGNHBHcIYTKxujXRIKwAI9JK4vy3x74cK0az4ndbg4Xq8TZUhqtxrCxBz241BhEamQQQ3WEcvKExUAWyVmLUf6TDFN4d10YQSnZLbRy5BBUpNlnMeDMTNSM7ni6r9Annjxn-C03FpEYdEwKw0LTsMYWBzXdCgvlNOiUa929X8Q86rsP4AXzofMAMShx9ITawEYo3XwYMJU-jPTHjkuT8Kx7J3NuzsI8JGkMhngaBbllyyPrcMSFVBEssevtEV4SyBLfQlOcM-4TjB2yUHglAzmoWpoxoIDmpaeTXw"
}
```

Now you can send your request with header : 
```
Authorization = Bearer {your token}
```

Routes are :

Method | Route | Description
--- | --- | ---
GET | /api/products/{id} | The details of the product {id}
GET | /api/products | The list of all products
GET | /api/users | The list of the users for the customer company
GET | /api/users/{id} | The details of the user {id} (should be own by the customer)
POST | /api/users | Create a new user for the company
PUT | /api/users{id} | Update the user {id} (should be own by the customer)
DELETE | /api/users/{id} | Delete the user {id} (should be own by the customer)
 