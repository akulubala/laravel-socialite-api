<?php
namespace LaravelSocialiteApi\SocialiteProvider;

use SocialiteProviders\WeixinWeb\Provider;

class WeixinWeb extends Provider
{
    public function retrieveUserByToken($token)
    {
        return $this->getUserByToken($token);
    }
}
