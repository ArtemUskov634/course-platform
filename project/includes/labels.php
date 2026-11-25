<?php
// Ключ (слева) хранится в базе, подпись (справа) видит пользователь.
// Чтобы добавить новую тему или специализацию, нужно изменить ENUM в базе
// и добавить строку здесь.
$topicLabels = [
    'bhp'                 => 'BHP',
    'rodo'                => 'RODO',
    'sygnalisci'          => 'Sygnaliści',
    'ochrona_maloletnich' => 'Ochrona małoletnich',
];

$specLabels = [
    'ogolne'   => 'Ogólne (podstawowe)',
    'medyczna' => 'Branża medyczna',
    'hotele'   => 'Hotele',
    'szkoly'   => 'Szkoły',
    'firmy'    => 'Firmy prywatne',
];