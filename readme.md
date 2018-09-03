# Order application

...

## Assumptions

...

## How to install

Requirements:

* PHP ≥ 7.1.3
* MySQL ≥ 5.5; PostrgeSQL should suit too but I haven't tested 
* [Composer](https://getcomposer.org) (only during installation)

Installation:

1. Download this source code.
2. Copy the configuration file from `.env.example` to `.env`, open `.env` in an editor and set the options up.
3. Go the the code directory in a terminal and execute:
    ```bash
    composer install # Add --no-dev to skip the dependencies not required on production
    php artisan key:generate
    ```

To start the application in the development mode, simply execute `php artisan serve` in a console and open http://localhost:8000 in a browser.

In a production environment, setup a web server to serve the application:

1. Make the following directories and their subdirectories be writable by the web server:
    - `bootstrap/cache`
    - `storage`
2. Make the `public` directory be the document root of the server or a virtual host and make the server redirect all the
    missing file requests to `public/index.php`. More information: https://laravel.com/docs/5.6/installation#web-server-configuration
