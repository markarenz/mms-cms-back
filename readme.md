# MMS BACKEND HEADLESS README

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

## Moving from dev to live

> Note: by default SSH is not enabled on the DV server. In Plesk, Go into Web Hosting Access > Allow SSH over Bash

- Migration setup in Plesk
  - In Plesk, Make a backup of the live site & archive to Web Archive on local Deli server
  - Back up live db & store on Web Archive on Deli server
  - Make a new db for the live site & db user.
  - Import dev site SQL
- Copy the dev ENV file and update it with the above db info
- Set up git push on live site
  - SSH into the production server (LastPass)
  - cd httpdocs
  - mkdir project.git
  - cd project.git
  - git init --bare
  - nano hooks/post-receive
    #!/bin/bash
    GIT_WORK_TREE=/var/www/vhosts/matchbookcreative.com/test.matchbookcreative.com git checkout -f
  - chmod +x hooks/post-receive
  - On local machine, add a remote with this URL:
    ssh://mbadmin@matchbookcreative.com/var/www/vhosts/matchbookcreative.com/test.matchbookcreative.com/project.git

  - Push the master to this remote
- Add ENV to live site
- SSH into live site again
  - php composer update
  - php artisan dump-autoload
  - php artisan migrate:reset
  - php artisan migrate
  - php artisan db:seed
- Migrate storage files manually (/public/storage)
- Test live site


## Migrating SQL from local to dev/live
- On your local vagrant instance, vagrant ssh
  - mysqldump --databases matchbook > tmp.sql
  - scp tmp.sql mbadmin@72.10.48.220:/var/www/vhosts/matchbookcreative.com
  - rm tmp.sql
- ssh mbadmin@72.10.48.220
  - sed -i 's/matchbook/mbc2019_dev/g' tmp.sql
  - mysql -u mbc_2019_mysql -p mbc2019_dev < tmp.sql
  - rm tmp.sql

## Migrating SQL from DV to local
- ssh mbadmin@72.10.48.220
  - mysqldump -u mbc_2019_mysql --databases mbc2019_dev -p > tmp2.sql
- On your local vagrant instance, vagrant ssh
  - scp mbadmin@72.10.48.220:/var/www/vhosts/matchbookcreative.com/tmp2.sql tmp2.sql
  - sed -i 's/mbc2019_dev/matchbook/g' tmp2.sql
  - mysql matchbook < tmp2.sql
  - rm tmp2.sql
- on the remote SSH
- rm tmp2.sql

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
