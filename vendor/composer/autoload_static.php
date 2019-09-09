<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite056f66ec8f1429aa19f1bf5d489f815
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SpamDetector\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SpamDetector\\' => 
        array (
            0 => __DIR__ . '/..' . '/morrelinko/spam-detector/src',
            1 => __DIR__ . '/..' . '/morrelinko/spam-detector/tests',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite056f66ec8f1429aa19f1bf5d489f815::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite056f66ec8f1429aa19f1bf5d489f815::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}