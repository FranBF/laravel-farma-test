## *Clonning Github Repository*
- First thing, go to [GITHUB](https://github.com/FranBF/laravel-farma-test) and clone this repository into your php projects folder.

## *Installing dependencies*
Since I have used Laravel to ease the development, you will need to install dependencies via composer.
- Run: *"composer install"* in a cmd inside you clonned repository.

## *Prepare the environment*
Now it it time to prepare the environment. Inside the folder structure of the Laravel project, you will find a .env.example file. 
- Create a new .env file at the same level as the example, copy all of the example information into the real .env file and configure the variables needed to run the project, such as DB_NAME, DB_PORT and so on.
- Run *"php artisan serve"*- only if  you are not using an app like Laragon, XAMPP...
- Run *"php artisan migrate"*

Now you can run the app and test the endpoints.

In order to see the docs, go to: [API DOCS](https://app.swaggerhub.com/apis-docs/FRANBENAGES/FranAPI/1.0.0#/ "API DOCS")