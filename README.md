##Laravel Socialite api
This package is aim to retrive user data by access token when use OAuth2 Login, base on Laravel Socialite, useful for client side OAuth login


##Install
    composer require ray-cheng/laravel-socialite-api

open config/app.php
add 

    LaravelSocialiteApi\SocialiteApiServiceProvider::class

 to 'providers' array
 
 
## check installed

php artisan list

##commands

  laravel-socialite-api:clear  providerName    
  laravel-socialite-api:make   providerName    
   
** providerName must follow http://socialiteproviders.github.io/#providers principle

##add event handler and listener to App\Providers\EventServiceProvider $listen property


        'SocialiteProviders\Manager\SocialiteWasCalled' => [
            'LaravelSocialiteApi\ExtendSocialite\WeixinWeb@handle',
        ]

## test
		$token is passed by client app 
        $weixinUserInfo = Socialite::with('weixinweb')->stateless->user($token);
