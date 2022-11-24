<?php


namespace App\Traits;

use App\Classes\Responses\InvalidResponse;
use App\Classes\Responses\ResponseStrings;
use App\Classes\Responses\ValidResponse;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Token;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Kunnu\RabbitMQ\RabbitMQExchange;
use Kunnu\RabbitMQ\RabbitMQMessage;

trait AuthTrait
{
    public static function registerToken($token)
    {
        $newToken = new Token([
            'token' => $token['token'],
            'user_id' => $token['user_id'],
            'abilities' => json_encode($token['abilities']),
        ]);

        $newToken->save();
    }

    public static function deleteTokens($user_id)
    {
        $tokens = Token::where('user_id', $user_id)->get();
        foreach ($tokens as $token)
        {
            $token->delete();
        }
    }

    public static function checkToken($token)
    {
        $token = Token::where('token', $token)->first();
        if ($token)
        {
            return $token->user_id;
        }
        return false;
    }

    public static function checkAbility($ability, $token)
    {
        $token = Token::where('token', $token)->first();
        if ($token)
        {
            $abilities = json_decode($token->abilities, true);
            if (in_array($ability, $abilities))
            {
                return true;
            }
        }
        return false;
    }
}
