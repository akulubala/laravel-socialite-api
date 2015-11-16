<?php

namespace LaravelSocialiteApi\ExtendSocialite;

use SocialiteProviders\Manager\SocialiteWasCalled;

class WeixinWebExtendSocialite
{
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite(snake_case('WeixinWeb', '-'), __NAMESPACE__.'\SocialiteProvider\WeixinWeb');
    }
}

