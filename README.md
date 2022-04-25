# README #

This is a code challenge API Restfull

## Database structure ##


* Table Order:
    - Description: it a main table to store all Order
    - Field:
        - range_deli: range delivery
        - deadline : time to delive
        - time_end_deli: time to delive finish
        - time_end_downtime: time finish delivery minus with time downtime of Pigone
        - cost: total money when delivery
        - pigeonId: primary key of table Pigone
* Table Pigone
    - Description: it a table to store pigone
    - Field:
        - name: Name of Pigone
        - speed: speed delivery of Pigone
        - max_range: maximun ranger pig can delivery
        - cost: money to delivery
        - downtime: time need to rest
        - status: it has two status : STATUS_AVAILABLE, STATUS_BUSY

### How do I get set up? ###

* Envirenment: 
    - php8, mysql, redis

* Database configuration
    - Change DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD, REDIS_CLIENT, REDIS_HOST, REDIS_PASSWORD, REDIS_PORT in .env file
* How to run tests
    - Step 1 run install with command `composer install`
    - Step 2 run `php artisan key:generate` to set  APP_KEY in .env file
    - Step 3 run mirgate database `php artisan migrate:fresh` in the first runtime.
    - Step 4 run mirgate database `php artisan db:seed` in the first runtime.

#### API ####
    - CURD for table Order
    - CURD for table Pigone
    - Has use one cronjob to update status of Pigeone when finish deliery

#### Unit test ####
    - Current I only test some function 
        - testRequiredFieldsForRegistration: required field when register
        - testSuccessfulRegistration: test register success
        - testSuccessfulLogin: login success

    - With this structure, I have write with Service container, Dependency injection to prepare write advance mock data to test. I will complete in nexttime.


#### Conclution ####
    - Maybe I will use docker to setup with this project. It's easy to preview.
    - API I will improve with l5-swagger, It's easy to client when use.
    - Process create Order  we have to use transaction.
    