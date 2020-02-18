<?php

namespace App\Reddit;

use Requests;

class RedditAPI {

    protected static $tokenURL = "https://www.reddit.com/api/v1/access_token";

    public static function getToken(string $username = null, string $password = null) {
        $username = $username ? $username : env('X_REDDIT_USERNAME') ;
        $password = $password ? $password : env('X_REDDIT_PASSWORD') ;
        $headers = [
            // 'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'auth' => [env('X_REDDIT_APP_ID'), env('X_REDDIT_APP_SECRET')]
        ];
        $body = [
            'grant_type' => 'password',
            'username' => $username,
            'password' => $password
        ];
        $response = Requests::post(self::$tokenURL, $headers, $body, $options);
        return (array) json_decode($response->body);
    }
}
