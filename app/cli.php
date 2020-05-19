<?php
declare(strict_types = 1);

chdir(__DIR__);

require __DIR__ . '/bootstrap.php';

$parser = new \App\Cli\Parser(getenv('RSS_FEED'));

$parser->parse();
