# KCL Buddy Scheme

A web-based application which connects/pairs freshers with senior students, based on common interests. Also automate aspects of the administration of the buddy scheme, such as signup, verification of participants, allocation and, monitoring and evaluation of the scheme.

## API and Frameworks used
* Bootstrap 4
* Laravel
* Bootstrap select picker - https://developer.snapappointments.com/bootstrap-select/
* jQuery 3.3.1
* Codeception

## Deployed version

The deployed version of the website is located at: http://kclbuddyscheme.000webhostapp.com/

## Background and purpose

In 2018/19, the Department introduced a student-led buddy scheme. This is an informal support scheme to help students in the department network across the different years. New first-year students who sign up to the scheme are allocated a more senior student as their buddy so that the former can benefit from the experience of the latter. The scheme was administered manually by students using microsoft excel spreadsheet, and students were allocated manually which was very cumbersome, which brings us to the aim of the project which is to produce a system to automate aspects of the administration of the buddy scheme, such as signup, verification of participants, allocation/pairing based on interests and monitoring and evaluation of the scheme.

## Basic directory structure
* All the front end HTML pages can be found in resources/views
* All core javascript components can be found in public/js
* The primary web route is contained in routes/web.php
* All the controllers are located in app/Http/Controllers/
* Security middleware is located in app/Http/Middleware/
* The majority of connection configurations are defined in the root .env file

### Running the website from source
To run the development version of the application, you must have composer installed. After this, ensure you are in the project directory and run:

* composer install

After this, simply run the following command, and keep the terminal running: php artisan serve
This will give an url, usually http://localhost:8000, which you can copy and paste into the browser to start the application.



### Running the tests from source
To run the development version of the application, you must have composer installed. After this, ensure you are in the project directory and run: composer install
 
After this, simply run the following command, and keep the terminal running: php artisan serve
 
This will give an url, usually http://localhost:8000, which you can copy and paste into the browser to start the application.
 
To run the tests, again ensure you have composer installed and php artisan serve running, then execute:
 
vendor\bin\codecept run
 
This will run all the tests we have available, including all: unit, functional and acceptance tests. Bear in mind this can be quite time consuming and can last up to 5 minutes.

Please note that the acceptance tests will fail unless you have another copy of command prompt running php artisan serve in the back-ground.


