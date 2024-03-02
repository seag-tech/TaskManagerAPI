<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Library\Constants;

/**
 * Class ApiService
 * 
 * This class contains the logic to interact with the external API
 * @package App\Services
 */
class ApiService
{

    /**
     * Get all todos from the external API
     * 
     * @return array
     */
    public function getExternalTodos(): array
    {
        $request    = (new Client())->request('GET', Constants::JSON_PLACEHOLDER_API . '/todos');
        $data       = $request->getBody()->getContents();
        $code       = $request->getStatusCode();

        return [
            'data' => json_decode($data),
            'code' => $code
        ];
    }
}
