<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite30233999135f221674d2f1a4388b156
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'AmoCRM\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'AmoCRM\\' => 
        array (
            0 => __DIR__ . '/..' . '/dotzero/amocrm/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite30233999135f221674d2f1a4388b156::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite30233999135f221674d2f1a4388b156::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
