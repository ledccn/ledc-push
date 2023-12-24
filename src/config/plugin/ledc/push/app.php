<?php

use Ledc\Push\Pipelines\UniqidPipeline;
use Ledc\Push\Pipelines\WebmanAdmin;

return [
    'enable'       => true,
    'websocket'    => 'websocket://0.0.0.0:3131',
    'api'          => 'http://0.0.0.0:3232',
    'app_key'      => 'APP_KEY_TO_REPLACE',
    'app_secret'   => 'APP_SECRET_TO_REPLACE',
    'channel_hook' => 'http://127.0.0.1:8787/plugin/ledc/push/hook',
    'auth'         => '/plugin/ledc/push/auth',
    'pipeline' => [
        [WebmanAdmin::class, 'process'],
        [UniqidPipeline::class, 'process'],
    ],
];
