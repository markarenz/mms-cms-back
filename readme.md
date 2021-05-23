# MMS BACKEND HEADLESS README

## About MMS CMS Backend
- This is the CMS for a headless website. It is not an API.
- For added security and reliability, the frontend consumes the product of this app and not the API itself.
- This is a Laravel app, so you'll need to get familiar with artisan commands, etc.
- Since the structure is decoupled, you can run the backend on a local machine (with Docker or Vagrant) for increased security and simplicity

## Installing the app

- Clone the repo
- SSH into the server; cd into the domain's root
- composer update
- php artisan migrate:reset
- php artisan migrate
- php artisan db:seed
    - If you run into errors related to a missing seeder class, run this:
        - composer dump-autoload
- Link the storage to public
  php artisan storage:link

## Syncing storage between local & DV
- From DV to local:
rsync -zaP mbadmin@72.10.48.220:/var/www/vhosts/matchbookcreative.com/test.matchbookcreative.com/storage/app/public storage/app/

- From local to DV (from root of project directory):
rsync -zaP storage/app/public mbadmin@72.10.48.220:/var/www/vhosts/matchbookcreative.com/test.matchbookcreative.com/storage/app/



## Gulp
- Run these commands from the project directory and not within vagrant ssh
- Running through vagrant (homestead) takes a very long time
- Also, it's ideal to run your gulp watch through a separate terminal

cd ~/projects/mblaravel
npm install gulp -g
npm install gulp --save-dev
npm install gulp-sass --save-dev
npm install gulp-cssnano --save-dev
npm install gulp-concat --save-dev
npm install gulp-uglify --save-dev

gulp watch

Compiles Frontend CSS
    SRC: public/css/scss/style.scss
    DEST: public/css/style.css
Compiles Frontend JS
    SRC: public/js/partials/*.js
    DEST: public/js/frontend.css
