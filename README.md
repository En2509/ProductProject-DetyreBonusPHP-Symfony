# Product Project - Symfony 6

**Product listing Project built with [Symfony 6](https://symfony.com) web framework.**

**`Scenario: Create a project to store, edit, list or delete products.`**

## Getting Started

1. Clone this repository in the webserver & enter inside the folder.
2. Run on cli `composer install` to install symfony dependencies.
4. Run on cli `symfony console doctrine:schema:create` to create the database.
5. Run on cli `symfony console doctrine:migrations:migrate` to create the tables.
5. Open `https://localhost` in your favorite web browser and accept the auto-generated TLS certificate.

* Helper terminal command to create database schema: `symfony console doctrine:schema:create`
* Helper terminal command to create database tables: `symfony console doctrine:migrations:migrate`
* Helper terminal command to generate new migrations from entity: `symfony console doctrine:migrations:diff`


## Requirements

* Composer CLI
* Symfony CLI
* Webserver (PHP-FPM, Apache2 or Nginx, Mysql Db, Redis Cache, Mailcatcher)

**Wish you enjoy!**

## License

MIT License.

## Credits

Created by [Enea Rushiti](https://www.linkedin.com/in/enea-rushiti/).
