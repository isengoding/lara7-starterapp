## About Laravel 7 Starter APP

Laravel 7 Starter App & admin LTE 3

## Demo

- <a href="http://demo.isengoding.my.id" target="blank">Demo</a>

## Installasi
- Download repository dan ekstrak atau clone repository
	```sh
	$ git clone https://github.com/isengoding/lara7-starterapp.git
	```
- Masuk ke direktori aplikasi dan jalankan composer
	```sh
	$ cd lara7-starterapp
	$ composer install
	```
 - Copy file .env.example menjadi .env
	```sh
	$ cp .env.example .env
	```
- Generate key application
	```sh
	$ php artisan key:generate
	```
- Buat Database
- Edit database name, database username dan database password di file .env
    ```sh
	DB_DATABASE=your_db.
    DB_USERNAME=your_mysql_username.
    DB_PASSWORD=your_mysql_password.
	```
- Migrate table
	```sh
	$ php artisan migrate
	```
- Seed table
	```sh
	$ php artisan db:seed
	```
- Jalankan lokal development server
    ```sh
	$ php artisan serve
	```
- Buka di browser http://localhost:8000
- Login
    ```sh
	Username :  admin@admin.com
    Password :  password
	```
 ## Author
Isengoding – isengoding@gmail.com

[https://github.com/isengoding/](https://github.com/isengoding/)

## License

[![License](http://img.shields.io/:license-mit-blue.svg?style=flat-square)](http://badges.mit-license.org)

- **[MIT license](http://opensource.org/licenses/mit-license.php)**
- <a href="http://isengoding.my.id" target="_blank">isengoding.my.id</a>.

