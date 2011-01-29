<?php

/*
 * This file is part of the TheTVDB.
 * (c) 2010 Fabien Pennequin <fabien@pennequin.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (!class_exists('TheTVDB\\UniversalClassLoader')) {
    require __DIR__.'/src/TheTVDB/UniversalClassLoader.php';
}

$loader = new TheTVDB\UniversalClassLoader();
$loader->registerNamespaces(array(
    'TheTVDB'    => __DIR__.'/src',
));
$loader->register();
