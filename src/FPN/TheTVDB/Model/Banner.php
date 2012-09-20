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

namespace FPN\TheTVDB\Model;

class Banner extends AbstractModel
{
    protected $id;
    protected $language;

    protected $bannerType;
    protected $bannerSize;
    protected $bannerUrl;

    protected $thumbnailUrl;


    public function getId()
    {
        return $this->id;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function getBannerType()
    {
        return $this->bannerType;
    }

    public function getBannerSize()
    {
        return $this->bannerSize;
    }

    public function getBannerUrl()
    {
        return $this->bannerUrl;
    }

    public function getThumbnailUrl()
    {
        return $this->thumbnailUrl;
    }
}
