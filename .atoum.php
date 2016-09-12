<?php

require_once __DIR__.'/vendor/autoload.php';

$runner->addExtension(new \mageekguy\atoum\visibility\extension($script));

$runner->addTestsFromDirectory(__DIR__.'/Tests');

$script->excludeDirectoriesFromCoverage([
    __DIR__.'/vendor',
]);
