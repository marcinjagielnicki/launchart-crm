#LaunchCart contacts management panel

##Installation

###Laravel valet:

* Link page via valet link command
* `composer install`
* `cp .env.example .env`
* `php artisan key:generate`
* `yarn install && yarn run dev`
* Change db access credentials in .env to match your config
* Change `KLAVIYO_API_TOKEN` to match yours API token
* run `php artisan migrate`
* Open site (hint: you can run `valet open`)


###Docker compose

* Make sure that you have latest docker and docker-compose
* Run `make warmup-project`
* Open in your browser: `http://localhost:8088/'


##Usage

Create account via Register link. Feel free to add contacts that you need :) 
