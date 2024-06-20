Project setup

git clone https://github.com/JomelIsidro/exam-laravel-upload-video.git

composer install

copy .env.example .env
php artisan key:generate

php artisan storage:link


============= Testing =============

php artisan test


============= Run the project =============

php artisan serve

open browser then run
http://127.0.0.1:8000/upload

You can check the video file in the project after successfully uploaded
the video file will be save in local directory
path: storage/app/public/uploads



