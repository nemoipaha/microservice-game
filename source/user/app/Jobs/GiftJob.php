<?php

declare(strict_types=1);

namespace App\Jobs;

use GuzzleHttp\Client;
use Illuminate\Contracts\Config\Repository;

final class GiftJob extends Job
{
    public function handle(Client $client, Repository $config)
    {
        $data = $client->get(
            sprintf("{$config->get('app.secrets_api_url')}/%s", '0402b520-9873-4abb-a83d-d1c8e612be1c')
        );

        // dump content to stdout
        var_dump($data->getBody()->getContents());
    }
}
