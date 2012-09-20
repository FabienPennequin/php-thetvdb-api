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

class Episode extends AbstractModel
{
    protected $id;
    protected $seasonId;
    protected $tvshowId;

    protected $episodeNumber;
    protected $seasonNumber;

    protected $name;
    protected $firstAired;
    protected $overview;
    protected $language;


    public function getId()
    {
        return $this->id;
    }

    public function getTvShowId()
    {
        return $this->tvshowId;
    }

    public function getSeasonId()
    {
        return $this->seasonId;
    }

    public function getEpisodeNumber()
    {
        return $this->episodeNumber;
    }

    public function getSeasonNumber()
    {
        return $this->seasonNumber;
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

    public function getLanguage()
    {
        return $this->language;
    }
}
