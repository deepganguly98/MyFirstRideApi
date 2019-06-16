<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),    
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'
        ]
    ],
    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParsers', 
            ]
        ],        
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => ['v1/country','v1/state','v1/car'],
                    'extraPatterns' => ['POST getcardetails'=>'getcardetails','POST getcarinfo' => 'getcarinfo', 'POST getcarmodels' => 'getcarmodels', 'POST getsellerdetails' => 'getsellerdetails', 'POST makecarfavorite' => 'makecarfavorite', 'POST initiatechat' => 'initiatechat','POST getcars' => 'getcars'],
                    'pluralize' => false,
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ]
                    
                ]
            ],        
        ]
    ],
    'params' => $params,
];



