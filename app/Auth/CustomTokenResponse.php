<?php

namespace App\Auth;

use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use \League\OAuth2\Server\ResponseTypes\BearerTokenResponse;
use App\Models\User;

class CustomTokenResponse extends BearerTokenResponse
{
    protected function getExtraParams(AccessTokenEntityInterface $accessToken): array
    {
        try {
            $userId = $this->accessToken->getUserIdentifier();
            $user = User::where('id', '=', $userId)->first();
        } catch(ModelNotFoundException $e) {
            return response(["message" => "User not found"], 500);
        }
        return [
            'user' => $user
        ];
    }
}