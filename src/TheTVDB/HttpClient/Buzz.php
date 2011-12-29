<?php

/*
 * This file is part of the TheTVDB PHP API package.
 * (c) 2010-2011 Fabien Pennequin <fabien@pennequin.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TheTVDB\HttpClient;

use Buzz\Browser;

class Buzz implements HttpClientInterface
{
    public function get($url)
    {
        $browser = new Browser();
        return $browser->get($url)->getContent();
    }
}
