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

namespace FPN\TheTVDB;

use FPN\TheTVDB\HttpClient\HttpClientInterface;
use FPN\TheTVDB\Model\TvShow;
use FPN\TheTVDB\Model\Episode;
use FPN\TheTVDB\Model\Banner;

class Api
{
    protected $httpClient;
    protected $apiKey;

    protected $mirrorUrl = 'http://www.thetvdb.com/';
    protected $baseUrl;
    protected $baseKeyUrl;
    protected $baseImagesUrl;

    public function __construct(HttpClientInterface $httpClient, $apiKey, $mirrorUrl=null)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = $apiKey;

        if ($mirrorUrl) {
            $this->mirrorUrl = $mirrorUrl;
        }

        $this->baseUrl = $this->mirrorUrl.'api/';
        $this->baseKeyUrl = $this->baseUrl.$this->apiKey.'/';
        $this->baseImagesUrl = $this->mirrorUrl.'banners/';
    }

    public function getMirrorUrl()
    {
        return $this->mirrorUrl;
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    public function getBaseUrlWithKey()
    {
        return $this->baseKeyUrl;
    }

    public function searchTvShow($name, $language=null)
    {
        $url = $this->baseUrl.'GetSeries.php?seriesname='.urlencode($name);
        if ($language) {
            $url .= '&language='.urlencode($language);
        }

        $xml = simplexml_load_string($this->httpClient->get($url));

        $data = array();
        foreach ($xml as $xmlSerie) {
            $data[] = $this->xmlToTvShow($xmlSerie);
        }

        return $data;
    }

    public function getTvShow($tvshowId, $language='en')
    {
        $url = $this->baseKeyUrl.'series/'.$tvshowId.'/'.$language.'.xml';
        $xml = simplexml_load_string($this->httpClient->get($url));

        return isset($xml->Series) ? $this->xmlToTvShow($xml->Series) : null;
    }

    public function getEpisode($episodeId, $language='en')
    {
        $url = $this->baseKeyUrl.'episodes/'.$episodeId.'/'.$language.'.xml';
        $xml = simplexml_load_string($this->httpClient->get($url));

        return isset($xml->Episode) ? $this->xmlToEpisode($xml->Episode) : null;
    }

    public function getTvShowAndEpisodes($tvshowId, $language='en')
    {
        $url = $this->baseKeyUrl.'series/'.$tvshowId.'/all/'.$language.'.xml';
        $xml = simplexml_load_string($this->httpClient->get($url));

        if (isset($xml->Series)) {
            $tvshow = $this->xmlToTvShow($xml->Series);

            $episodes = array();
            if (isset($xml->Episode)) {
                foreach ($xml->Episode as $xmlEpisode) {
                    $episodes[] = $this->xmlToEpisode($xmlEpisode);
                }
            }

            return array('tvshow' => $tvshow, 'episodes' => $episodes);
        }
    }

    public function getBanners($showId)
    {
        $url = $this->baseKeyUrl.'series/'.$showId.'/banners.xml';
        $xml = simplexml_load_string($this->httpClient->get($url));

        $data = array();
        foreach ($xml as $xmlBanner) {
            $data[] = $this->xmlToBanner($xmlBanner);
        }

        return $data;
    }

    protected function xmlToTvShow(\SimpleXmlElement $element)
    {
        $tvshow = new TvShow();
        $tvshow->fromArray(array(
            'id'            => (int)$element->id,
            'name'          => (string)$element->SeriesName,
            'overview'      => (string)$element->Overview,
            'firstAired'    => new \DateTime((string)$element->FirstAired),
            'network'       => isset($element->Network) ? (string)$element->Network : null,
            'language'      => isset($element->language) ? (string)$element->language : (isset($element->Language) ? (string)$element->Language : null),

            'theTvDbId'     => isset($element->seriesid) ? (int)$element->seriesid : (int)$element->id,
            'imdbId'        => (string)$element->IMDB_ID,
            'zap2itId'      => (string)$element->zap2it_id,

            'bannerUrl'     => isset($element->banner) ? $this->baseImagesUrl.$element->banner : null,
            'posterUrl'     => isset($element->poster) ? $this->baseImagesUrl.$element->poster : null,
            'fanartUrl'     => isset($element->fanart) ? $this->baseImagesUrl.$element->fanart : null,
        ));

        return $tvshow;
    }

    protected function xmlToEpisode(\SimpleXmlElement $element)
    {
        $episode = new Episode();
        $episode->fromArray(array(
            'id'            => (int)$element->id,

            'tvshowId'      => (int)$element->seriesid,
            'seasonId'      => (int)$element->seasonid,

            'episodeNumber' => (int)$element->EpisodeNumber,
            'seasonNumber'  => (int)$element->SeasonNumber,

            'name'          => (string)$element->EpisodeName,
            'firstAired'    => new \DateTime($element->FirstAired),
            'overview'      => (string)$element->Overview,
            'language'      => (string)$element->Language,
        ));

        return $episode;
    }

    protected function xmlToBanner(\SimpleXmlElement $element)
    {
        $banner = new Banner();
        $banner->fromArray(array(
            'id'            => (int)$element->id,
            'language'      => (string)$element->Language,

            'bannerType'    => (string)$element->BannerType,
            'bannerSize'    => strpos($element->BannerType2, 'x') > 0 ? (string)$element->BannerType2 : null,
            'bannerUrl'     => $this->baseImagesUrl.$element->BannerPath,

            'thumbnailUrl'  => isset($element->ThumbnailPath) ? $this->baseImagesUrl.$element->ThumbnailPath : null,
        ));

        return $banner;
    }
}
