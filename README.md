# Games Store (Backend)

Backend project for IPP/ESTG Class "Segurança em Aplicações Web"

## Objectives

* The app was created to maintain a list of games sold by users.
* The main purpose is to avoid security problems in application, specially about validation, sanitization, unauthorized access of files and resources, password cracking etc.

## Built With

* [Composer](https://getcomposer.org/) - Dependency manager for PHP.
* [Dotenv](https://symfony.com/doc/current/components/dotenv.html) - Symfony 4 component to enable enviroment variables.
* [Php](http://php.net/) - Programming language.
* [PHPMailer](https://github.com/PHPMailer/PHPMailer) - Library to send email in PHP.
* [Php-Jwt](https://github.com/firebase/php-jwt) - Library to encode and decode JSON Web Tokens in PHP.

## Implemented Architecture and Design Patterns

* **MVC** - Basic Model-View-Controller architectural pattern.
* **Web Service** - Application as a web service with JSON responses.
* **REST** - Uses Representational State Transfer pattern to access server resources.

## Main Components and Features

* **DAO** - Data Access Object component implemented with PDO (PHP Data Objects).
* **File Handling** - Handle file store request and return it.
* **JSON Web Token** - Handle backend and frontend communication.
* **Middlewares** - Run self-services to application, like Authentication Middleware and CORS Middleware.
* **Resources** - Defines model transformation before sending in response.

## Security Artefacts

* **JSON Web Token** - It is blacklisted on logout and an user can have only one active per time.
* **Sanitization** - Sanitizes all request parameters before proceeding in controllers methods.
* **Validation** - Validate all request parameters before proceeding in controllers methods.
* **Request Parameters** - Parameters are sanitized again with PDO, to prevent code/sql injection.
* **Registration** - Require email confirmation to avoid spamming user creation.
* **Passwords** - Require medium to strong passwords on registering and stores it in database using hashing algorithms with salt.
* **Authentication & Authorization** - Uses a middleware to prevent users (anonymous or authenticated) to manipulate unauthorized resources.
* **Server Exceptions** - Handle exceptions and return JSON response with friendly and secure HTTP code, message and payload (optional).
* **CORS** - Explicitly defines allowed origins to make cross-origin resource sharing.

## Live

Live version is not available yet.

## Authors

* **Célio Ighour** - *Owner* - [Ighour](https://github.com/ighour)
* **Simona Alecs** - *Developer*