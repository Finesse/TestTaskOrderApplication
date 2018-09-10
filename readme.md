# Order application

The task was to make an application with an order form. To make an order, the user must:

1. Specify his/her name, phone number and address
2. Choose a tariff
3. Choose a start day (from the days possible for the tariff)

When the order is made, all the client and the order data is stored in the database.

All the orders with the same phone number are associated with the same client.
There mustn't be multiple clients with the same phone number in the database.

The tariffs are added to the database during the installation.
Each tariff has a name, a price and possible days.

The application is made on top of [Laravel](http://laravel.com), [Vue](http://vuejs.org) and [Bootstrap](http://getbootstrap.com).
All the client-server data transmissions is implemented with AJAX without page reloading.

## Assumptions

* «Days» are considered as the days of week (Sunday, Monday, etc.).
* There are few tariffs so they all can be loaded to the form at once.
* A separate view layout is not required because there is only one page.
* All the tariffs are publicly available so a simple `exists:tariffs,id` request validation can be used.
* The business logic is in the controller and not in a separate class because it's simple and doesn't repeat.
* Automatic tests are not required in the task.
* The application should run on multiple instances so using a file (or any other single-instance resource) is not an option to prevent race condition.

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
    php artisan db:seed
    ```

To start the application in the development mode, simply execute `php artisan serve` in a console and open http://localhost:8000 in a browser.

In a production environment, setup a web server to serve the application:

1. Make the following directories and their subdirectories be writable by the web server:
    - `bootstrap/cache`
    - `storage`
2. Make the `public` directory be the document root of the server or a virtual host and make the server redirect all the
    missing file requests to `public/index.php`. More information: https://laravel.com/docs/5.6/installation#web-server-configuration
3. Cache the stuff by running in a console:
    ```bash
    php artisan config:cache
    php artisan route:cache
    ```

## How to update

1. Download the fresh version of the source code or execute `git pull` if you installed the code using Git.
2. Go to the code directory in a terminal and execute:
    ```bash
    composer install # Add --no-dev to skip the dependencies not required on production
    php artisan migrate
    ```
3. If you cached the stuff before, update the cache:
    ```bash
    php artisan config:cache
    php artisan route:cache
    ```

## How to build frontend assets

The frontend assets source code is located in the `resources/assets` directory.
The compiled assets are located in the `public` directory.

After you made a change in the source code, you need to compile it:

1. Install [Node.js](http://nodejs.org/)
2. Open the project root directory in a console and execute `npm install` (required only once)
3. Execute `npm run watch`
4. Before commiting the code, execute `npm run prod` to have production-ready assets in the repository

## Caveats

* Don't add or remove rows from the `locks` table unless you know how they are used.
