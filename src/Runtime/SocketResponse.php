<?php

namespace Laravel\Vapor\Runtime;

use Laravel\Vapor\Contracts\LambdaResponse;

class SocketResponse implements LambdaResponse
{
    /**
     * The response status code.
     *
     * @var int
     */
    protected $status = 200;

    /**
     * Create a new Lambda response from an FPM response.
     *
     * @param  array  $headers
     * @param  string  $body
     * @return void
     */
    public function __construct(int $status = 200)
    {
        $this->status = $status;
    }

    /**
     * Convert the response to API Gateway's supported format.
     *
     * @return array
     */
    public function toApiGatewayFormat()
    {
        return [
            'statusCode' => $this->status,
        ];
    }
}
