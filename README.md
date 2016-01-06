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
            'LaravelSocialiteApi\ExtendSocialite\Weibo@handle',
            'LaravelSocialiteApi\ExtendSocialite\Weixin@handle',
        ]

## test

        $userInfo = Socialite::with('weibo')->stateless->user($accessToken);
        some oauth server like weixin need both $token and  $openid to get userinfos, so we need pass openid also.
        $userInfo = Socialite::with('weixin')->stateless->user($accessToken, $openId);
