<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb3b4f0a1fddae005ae72738e676896a2
{
    public static $prefixLengthsPsr4 = array (
        'Q' => 
        array (
            'Quetab\\QuetabPanel\\' => 19,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Quetab\\QuetabPanel\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb3b4f0a1fddae005ae72738e676896a2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb3b4f0a1fddae005ae72738e676896a2::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb3b4f0a1fddae005ae72738e676896a2::$classMap;

        }, null, ClassLoader::class);
    }
}