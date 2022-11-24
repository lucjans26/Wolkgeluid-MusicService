<?php


namespace App\Traits;

use App\Classes\Responses\InvalidResponse;
use App\Classes\Responses\ResponseStrings;
use App\Classes\Responses\ValidResponse;
use App\Models\Album;
use App\Models\Artist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Kunnu\RabbitMQ\RabbitMQExchange;
use Kunnu\RabbitMQ\RabbitMQMessage;

trait MessageTrait
{
    public static function publish($topic, $pload)
    {
        //php artisan rabbitmq:my-consumer --queue='user_queue' --exchange='main_exchange'
        $rabbitMQ = app('rabbitmq');
        $routingKey = $topic; // The key used by the consumer

        // The exchange (name) used by the consumer
        $exchange = new RabbitMQExchange('main_exchange', ['declare' => true]);

        $contents = $pload;

        $message = new RabbitMQMessage($contents);
        $message->setExchange($exchange);

        $rabbitMQ->publisher()->publish(
            $message,
            $routingKey
        );

        return ['message' => "Published {$contents}"];
    }
}
