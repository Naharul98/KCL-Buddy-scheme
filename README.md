# KCL Buddy Scheme

A web-based application which connects/pairs freshers with senior students, based on common interests. Also automate aspects of the administration of the buddy scheme, such as signup, verification of participants, allocation and, monitoring and evaluation of the scheme.

## API and Frameworks used
* [Bootstrap 4](https://getbootstrap.com)
* [Laravel](https://laravel.com)
* [Bootstrap select picker](https://developer.snapappointments.com/bootstrap-select/)
* [Codeception](https://codeception.com)

## Deployed version for demo

A version was deployed for demonstration purposes, which can be accessed from the following link:

> http://kclbuddyscheme.000webhostapp.com/

## About the project

In 2018/19, the Department introduced a student-led buddy scheme. This is an informal support scheme to help students in the department network across the different years. New first-year students who sign up to the scheme are allocated a more senior student as their buddy so that the former can benefit from the experience of the latter. The scheme was administered manually by students using microsoft excel spreadsheet, and students were allocated manually which was very cumbersome, which brings us to the aim of the project which is to produce a system to automate aspects of the administration of the buddy scheme, such as signup, verification of participants, allocation/pairing based on interests and monitoring and evaluation of the scheme.

### Running the website from source
To run the development version of the application, you must have composer installed. After this, ensure you are in the project directory and run:

> composer install

After this, simply run the following command, and keep the terminal running: 

> php artisan serve

To run the tests, again ensure you have composer installed and php artisan serve running, then execute:
 
> vendor\bin\codecept run

## API and Frameworks used
* [Bootstrap 4](https://getbootstrap.com)
* [Laravel](https://laravel.com)
* [Bootstrap select picker](https://developer.snapappointments.com/bootstrap-select/)
* [Codeception](https://codeception.com)
