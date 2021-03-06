<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
if (file_exists(__DIR__ . '/db-local.php')) {
    $db_local = require __DIR__ . '/db-local.php';
    $db = array_merge($db, $db_local);
}

$mailer = require __DIR__ . '/mailer.php';
if (file_exists(__DIR__ . '/mailer-local.php')) {
    $mailer_local = require __DIR__ . '/mailer-local.php';
    $mailer = array_merge($mailer, $mailer_local);
}

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [ 'log' ],
    'defaultRoute' => 'main/default/index',
    'language' => 'ru-RU',
    'timezone' => 'Europe/Kiev',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
            'layout' => 'admin',
        ],
        'main' => [
            'class' => 'app\modules\main\Module',
        ],
        'user' => [
            'class' => 'app\modules\user\Module',
        ],
        'treemanager' => [
            'class' => '\kartik\tree\Module',
        ],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'iCofXVNqilUXo8kRETA3hZ8TnxOReAaG',
            'baseUrl' => '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\modules\user\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => [ 'user/default/login' ],
        ],
        'assetManager' => [
            'appendTimestamp' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            //            'defaultRoles' => [ 'guest' ],
        ],
        'errorHandler' => [
            'errorAction' => 'main/default/error',
        ],
        'mailer' => $mailer,
        'cart' => [
            'class' => 'app\components\cart\Cart',
            'storageClass' => 'app\components\cart\storage\CookieStorage',
            'calculatorClass' => 'app\components\cart\calculator\SimpleCalculator',
            'params' => [
                'key' => 'cart',
                'expire' => 604800,
                'productClass' => 'app\models\ItemColorSize',
                'productFieldId' => 'id',
                'productFieldPrice' => 'sell_price',
                'productFieldSale' => 'sale_price',
            ],
        ],
        'novaposhta' => [
            'class' => 'app\components\novaposhta\NovaPoshta',
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'medium',
            'datetimeFormat' => 'medium',
            'decimalSeparator' => '.',
            'thousandSeparator' => ' ',
            'currencyCode' => 'EUR',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => [ 'error', 'warning' ],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => require __DIR__ . '/urls.php',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => [ '*' ],
    ];
    
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => [ '*' ],
    ];
}

return $config;
