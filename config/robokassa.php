<?php return [

	'login' => env('ROBOKASSA_LOGIN', 'agro-auction'),
//	'password1' => env('ROBOKASSA_PASSWORD1', 'SBY38XmpEL4TWRs5LZo8'),
//	'password2' => env('ROBOKASSA_PASSWORD2', 'xgVv4gHDE7vn65B2kaeh'),
	'endpoint' => env('ROBOKASSA_ENDPOINT', 'https://merchant.roboxchange.com/Index.aspx'),

	// включить для тестов, выключить при боевом режиме
	'password1' => env('ROBOKASSA_PASSWORD1', 'Q6kTPj6sPep7v1qAptu3'), // тестовый пароль
	'password2' => env('ROBOKASSA_PASSWORD2', 'T8OIZ3QKOPg1bQ3UM4MS'), // тестовый пароль
	'IsTest' => env('ROBOKASSA_ISTEST', 1),
];
