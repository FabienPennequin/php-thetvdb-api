<?php

/*
 * This file is part of the TheTVDB.
 * (c) 2010-2011 Fabien Pennequin <fabien@pennequin.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TheTVDB\HttpClient;

class FileGetContents implements HttpClientInterface
{
    public function get($url)
    {
        return file_get_contents($url);
    }
}
