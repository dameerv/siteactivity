<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use \Symfony\Contracts\HttpClient\ResponseInterface;

class ActivityHttpClient
{
    public function __construct(
        private HttpClientInterface $client,
        private string              $activationApiToken,
        private string              $activationHost,
        private string              $activationUrl,
    )
    {
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function send(string $method, array $data): ResponseInterface
    {
        return $this->client->request(
            'POST',
            $this->activationHost . $this->activationUrl,
            [
                'headers' => [
                    'X-AUTH-TOKEN' => $this->activationApiToken,
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode([
                    [
                        "jsonrpc" => "2.0",
                        "method" => $method,
                        "params" => $data,
                        'id' => 1
                    ]])
            ]
        );
    }


    public function testRequest()
    {
        return $this->client->request(
            'POST',
            $this->activationHost . $this->activationUrl,
            [
                'headers' => [
                    'X-AUTH-TOKEN' => $this->activationApiToken,
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode([
                    [
                        "jsonrpc" => "2.0",
                        "method" => 'ping',
                        "params" => [],
                        'id' => 1
                    ]])
            ]
        );
    }

}