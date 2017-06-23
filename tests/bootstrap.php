<?php

require_once __DIR__ . '/../vendor/autoload.php';

$container = new League\Container\Container;

$container->add(
    \Phramework\ValidateFiller\IObjectValidatorFiller::class,
    \Phramework\ValidateFiller\ObjectValidatorFiller::class
);

$container->add(
    \Phramework\ValidateFiller\IArrayValidatorFiller::class,
    \Phramework\ValidateFiller\ArrayValidatorFiller::class
);

$container->add(
    \Phramework\ValidateFiller\EnumValidatorFiller::class,
    \Phramework\ValidateFiller\EnumValidatorFiller::class
);

// register the reflection container as a delegate to enable auto wiring
$container->delegate(
    new League\Container\ReflectionContainer
);
