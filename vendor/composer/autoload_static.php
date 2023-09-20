<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf50a296f6d58bc3284ef1566db9b9118
{
    public static $prefixLengthsPsr4 = array (
        'x' => 
        array (
            'xGrz\\LaraGus\\' => 13,
        ),
        'G' => 
        array (
            'GusApi\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'xGrz\\LaraGus\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'GusApi\\' => 
        array (
            0 => __DIR__ . '/..' . '/gusapi/gusapi/src/GusApi',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf50a296f6d58bc3284ef1566db9b9118::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf50a296f6d58bc3284ef1566db9b9118::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitf50a296f6d58bc3284ef1566db9b9118::$classMap;

        }, null, ClassLoader::class);
    }
}