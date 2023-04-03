<?php

namespace Laravel\Vapor\Runtime\Handlers;

use Illuminate\Support\Facades\App;
use Laravel\Reverb\Servers\ApiGateway\Request;
use Laravel\Reverb\Servers\ApiGateway\Server;
use Laravel\Vapor\Contracts\LambdaEventHandler;
use Laravel\Vapor\Runtime\SocketResponse;

class SocketHandler implements LambdaEventHandler
{
    /**
     * Handle an incoming Lambda event.
     *
     * @return \Laravel\Vapor\Contracts\LambdaResponse
     */
    public function handle(array $event)
    {
        App::make(Server::class)
            ->handle(
                $this->request($event)
            );

        return new SocketResponse();
    }

    /**
     * Create a new fpm request from the incoming event.
     *
     * @param  array  $event
     * @return \App\Socket\SocketRequest
     */
    public function request($event)
    {
        return Request::fromLambdaEvent($event);
    }
}
