Project setup

git clone https://github.com/JomelIsidro/exam-laravel-upload-video.git

composer install

copy .env.example .env
php artisan key:generate

php artisan storage:link


============= Run the project =============
php artisan serve


============= Testing =============
php artisan test
