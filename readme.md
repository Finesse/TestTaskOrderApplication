# Order application

The application is an order form. In order to make an order, the user must:

1. Specify his name and phone number
2. Choose a tariff
3. Choose the first day (from the days possible for the tariff) and an address

When the order is made, all the client and the order data is stored in the database.

All the orders with the same phone number are associated with the same client.
There mustn't be multiple clients with the same phone number in the database.

The tariffs are added to the database during the installation.
Each tariff has a name, a price and possible days.

The application is made on top of [Laravel](http://laravel.com), [Vue](http://vuejs.org) and [Bootstrap](http://getbootstrap.com).
All the client-server data transmissions is implemented with AJAX without page reloading.

## Assumptions

«Days» are considered as the days of week (Sunday, Monday, etc.).

## How to install

Requirements:

* PHP ≥ 7.1.3
* MySQL ≥ 5.5; PostrgeSQL may suit too but I haven't tested 
* [Composer](https://getcomposer.org) (only during installation)

Installation:

1. Download this source code.
2. Create an empty database with the `utf8mb4` encoding.
3. Copy the configuration file from `.env.example` to `.env`, open `.env` in an editor and set the options up.
4. Go the the code directory in a terminal and execute:
    ```bash
    composer install # Add --no-dev to skip the dependencies not required on production
    php artisan key:generate
    php artisan migrate
    ```

To start the application in the development mode, simply execute `php artisan serve` in a console and open http://localhost:8000 in a browser.

In a production environment, setup a web server to serve the application:

1. Make the following directories and their subdirectories be writable by the web server:
    - `bootstrap/cache`
    - `storage`
2. Make the `public` directory be the document root of the server or a virtual host and make the server redirect all the
    missing file requests to `public/index.php`. More information: https://laravel.com/docs/5.6/installation#web-server-configuration
