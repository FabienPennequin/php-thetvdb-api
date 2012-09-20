<?php

/*
 * This file is part of the TheTVDB.
 *
 * (c) 2010-2012 Fabien Pennequin <fabien@pennequin.me>
 * (c) 2012 Tobias Sjösten <tobias.sjosten@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FPN\TheTVDB\HttpClient;

interface HttpClientInterface
{
    function get($url);
}
