# IIM A4 IWM Symfony 4 E-Commerce (Class)

## Dependencies

- Curl
- Composer
- PHP (At least 7.1)

## Install the project

- `git clone https://github.com/kevinhuang78/iim-2019-symfony-ecommerce.git`
- `composer install`

## Configure

- Change `.env` to connect database
- Create database with this command `php bin/console doctrine:database:create`
- Create columns with this command `php bin/console doctrine:schema:update --force`

## Run the project

- `php bin/console server:run`