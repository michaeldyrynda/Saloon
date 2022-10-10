<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Set\ValueObject\DowngradeLevelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    // define sets of rules
    $rectorConfig->sets([
        DowngradeLevelSetList::DOWN_TO_PHP_74,
    ]);

    $rectorConfig->phpVersion(PhpVersion::PHP_74);

    $rectorConfig->importNames();
};
