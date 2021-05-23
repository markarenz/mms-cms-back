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

## Gulp
- Run these commands from the project directory and not within vagrant ssh
- Running through vagrant (homestead) takes a very long time
- Also, it's ideal to run your gulp watch through a separate terminal

