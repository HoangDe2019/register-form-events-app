# register-form-events-app

# step 1
- install xampp to use for project
- install composer
- use terminal to run cmd 'composer install' in project
# step 2
- use mysql with version laravel 8.x
- php artisan migrate #generate db
- seeding data "php artisan migrate:fresh --seed"
- download postman to test api
- (domain)/api/(url of each controller)
# API
- get list user events when register: https://event-users-form.herokuapp.com/api/get-info-join-events
- get detail user info: https://event-users-form.herokuapp.com/api/get-info-join-event/{id_user}