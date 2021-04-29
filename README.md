This is version 2.0 of eCamp

Contact:
Pirmin Mattmann <forte@musegg.ch>
Urban Suppiger <smiley@pfadiluzern.ch>


# Setup development environment

## Prerequisites
- Git [CLI](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git) or [GUI](https://desktop.github.com/)
- [Docker Desktop](https://www.docker.com/products/docker-desktop) (Windows/Mac) or [Docker compose](https://docs.docker.com/compose/install/) (Linux)

## Installation steps

1. git clone https://github.com/ecamp/ecamp.git
2. cd ecamp && cd dev
3. docker-compose up
4. Visit https://localhost:2002 to open PhpMyAdmin  
   login with user `ecamp2` and password `ecamp2`  
   import  `.database/ecamp_full_db.sql` into `ecamp2_dev` database
5. Visit https://localhost:2000. Happy developing! :smile:

# Install Guide (Webhosting, self-hosted)

## Prerequisites
- PHP
- Mysql
- composer with gd extension (on your machine)
- SMTP Server (send email)
- Google reCAPTCHA Account (v2, I'm not a robot checkbox): https://www.google.com/recaptcha/admin/create

## Installation steps
1. git clone https://github.com/ecamp/ecamp.git
2. cd ecamp
3. composer install
4. copy the ecamp folder on your webhost
5. set the root of your website to src/public
6. create a mysql database with a user
7. import the file database/ecamp_full_db.sql into your database
8. edit database settings in src/config/config.php: $GLOBALS['host'], $GLOBALS['db'], $GLOBALS['us'], $GLOBALS['pw'], $GLOBALS['db_port']
9. edit mail settings in src/config/config.php: $GLOBALS['smtp-config']
10. edit feedback and support mail settings in src/config/config.php: $GLOBALS['feedback_mail'], $GLOBALS['support_mail']
11. edit site and secret key for recaptcha in src/config/config.php: $GLOBALS['captcha_pub'], $GLOBALS['captcha_prv']
12. visit the webpage, register a new user