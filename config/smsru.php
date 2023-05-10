<?php

    return [
        'active' => true, // указать true или false, работает ли отправка в целом, или отключена
        'api_id' => '66728D1A-A8F7-2997-288E-AFBF405E90AE',
        'message_password_before' => 'Ваш пароль для agtender.com — ',
        'message_password_after' => ' (смените его после входа)',
// Chernyshkov 20210805 for phone check in reg form
		'message_smscode_before' => '',
		'message_smscode_after' => ' — код для регистрации поставщика на сайте agtender.com',
// Chernyshkov 20210812
        'message_supplier_password_before' => 'Проверка на agtender.com пройдена, ваш пароль для входа — ',
		'message_supplier_reject' => 'Ваш регистрация на agtender.com отклонена.',
		'message_supplier_before_reject_reason' => ' Причина: ',
    ];