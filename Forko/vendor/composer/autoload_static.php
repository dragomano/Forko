<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3fa2c704c2c1189ca2a9757538534de5
{
    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'Bugo\\Forko\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Bugo\\Forko\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3fa2c704c2c1189ca2a9757538534de5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3fa2c704c2c1189ca2a9757538534de5::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}