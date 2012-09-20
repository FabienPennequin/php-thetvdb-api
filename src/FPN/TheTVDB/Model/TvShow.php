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

class TvShow extends AbstractModel
{
    protected $id;
    protected $name;
    protected $overview;
    protected $firstAired;
    protected $network;
    protected $language;

    protected $theTvDbId;
    protected $imdbId;
    protected $zap2itId;

    protected $bannerUrl;
    protected $posterUrl;
    protected $fanartUrl;


    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getFirstAired()
    {
        return $this->firstAired;
    }

    public function getOverview()
    {
        return $this->overview;
    }

    public function getNetwork()
    {
        return $this->network;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function getTheTvDbId()
    {
        return $this->theTvDbId;
    }

    public function getImdbId()
    {
        return $this->imdbId;
    }

    public function getZap2itId()
    {
        return $this->zap2itId;
    }

    public function getBannerUrl()
    {
        return $this->bannerUrl;
    }

    public function getPosterUrl()
    {
        return $this->posterUrl;
    }

    public function getFanartUrl()
    {
        return $this->fanartUrl;
    }
}
