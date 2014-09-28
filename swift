#!/usr/bin/env php
<?php

$_SERVER['argv'][] = './vendor/swiftmailer/swiftmailer';

require_once __DIR__ . '/php-renamespacer';

# fix composer.json

$file = __DIR__ . '/dst/swiftmailer/composer.json';
$fs->dumpFile($file, str_replace(
    '"autoload": {
        "files": ["lib/swift_required.php"]
    }',
    '"autoload": {
        "files": ["lib/swift_required.php"],
        "psr-0": {
            "Swift\\\\" : "lib/classes"
        }
    }',
    file_get_contents($file)
));

# fix dependency maps

foreach (array('cache', 'message', 'mime', 'transport') as $deps) {
    $file = __DIR__ . "/dst/swiftmailer/lib/dependency_maps/${deps}_deps.php";
    $fs->dumpFile($file, preg_replace_callback(
        "#'Swift_[^']+'#",
        function ($match) {
            return str_replace('_', '\\\\', $match[0]);
        },
        file_get_contents($file)
    ));
}

# fix swift

$file = __DIR__ . '/dst/swiftmailer/lib/classes/Swift.php';
$fs->dumpFile($file, str_replace(
    'require $path',
    'require_once $path',
    file_get_contents($file)
));

# install vendors and run tests

chdir(__DIR__ . '/dst/swiftmailer');

passthru('composer install');

passthru('phpunit .');
