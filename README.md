##Laravel Socialite api
This package is aim to retrive user data by access token when use OAuth2 Login, base on Laravel Socialite, useful for App OAuth login


##Install
composer require Ray-Cheng/laravel-socialite-api

open config/app.php
add 

    LaravelSocialiteApi\SocialiteApiServiceProvider::class

 to 'providers' array
 
 
## check installed
php artisan list

##commands
  laravel-socialite-api:clear  provider name
  laravel-socialite-api:make   provider name
   
** provider name must follow http://socialiteproviders.github.io/#providers

##finily example for App\Providers\EventServiceProvider $listen property

    'SocialiteProviders\Manager\SocialiteWasCalled' => [
            'LaravelSocialiteApi\ExtendSocialite\WeixinWebExtendSocialite@handle',
     ]
## test
		$token is passed by client app 
        $weixinUserInfo = Socialite::with('douban')->retrieveUserByToken($token);
