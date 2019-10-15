<?php

namespace App\Providers;

use App\Auth\CustomTokenResponse;
use Laravel\Passport\Bridge;
use League\OAuth2\Server\AuthorizationServer;

class PassportServiceProvider extends \Laravel\Passport\PassportServiceProvider
{
    public function makeAuthorizationServer()
    {
        return new AuthorizationServer(
            $this->app->make(Bridge\ClientRepository::class),
            $this->app->make(Bridge\AccessTokenRepository::class),
            $this->app->make(Bridge\ScopeRepository::class),
            $this->makeCryptKey('private'),
            app('encrypter')->getKey(),
            new CustomTokenResponse()
        );
    }
}