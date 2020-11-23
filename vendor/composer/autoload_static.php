<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit801d6556a629b2521f6d0350a0ca4d12
{
    public static $prefixesPsr0 = array (
        'c' => 
        array (
            'classmap' => 
            array (
                0 => __DIR__ . '/../..' . '/_uploads',
                1 => __DIR__ . '/../..' . '/app',
                2 => __DIR__ . '/../..' . '/config',
                3 => __DIR__ . '/../..' . '/core',
                4 => __DIR__ . '/../..' . '/install',
                5 => __DIR__ . '/../..' . '/lib',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Verot\\Upload\\Upload' => __DIR__ . '/..' . '/verot/class.upload.php/src/class.upload.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInit801d6556a629b2521f6d0350a0ca4d12::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit801d6556a629b2521f6d0350a0ca4d12::$classMap;

        }, null, ClassLoader::class);
    }
}