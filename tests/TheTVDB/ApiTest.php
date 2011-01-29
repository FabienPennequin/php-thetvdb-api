<?php

/*
 * This file is part of the TheTVDB.
 * (c) 2010 Fabien Pennequin <fabien@pennequin.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use TheTVDB\Api;
use TheTVDB\Model\TvShow;
use TheTVDB\Model\Episode;
use TheTVDB\Model\Banner;

class MockApi extends Api
{
    public $requestUrl;
    public $requestBody;

    protected function getUrlContent($url)
    {
        $this->requestUrl = $url;
        return $this->requestBody;
    }
}

class ApiTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $api = new Api(uniqid());
        $this->assertInstanceOf('TheTVDB\Api', $api);

        $key = uniqid();
        $api = new Api($key, 'http://www.test.com/');
        $this->assertInstanceOf('TheTVDB\Api', $api);
        $this->assertEquals('http://www.test.com/', $api->getMirrorUrl());
        $this->assertEquals('http://www.test.com/api/', $api->getBaseUrl());
        $this->assertEquals('http://www.test.com/api/'.$key.'/', $api->getBaseUrlWithKey());
    }

    public function testSearchTvShow()
    {
        $api = $this->getMockApi();
        $api->requestBody = file_get_contents(__DIR__.'/Fixtures/searchTvShow_1.xml');

        $tvshow1 = new TvShow();
        $tvshow1->fromArray(array(
            'id'            => 72218,
            'name'          => 'Smallville',
            'bannerUrl'     => $api->getMirrorUrl().'banners/graphical/72218-g22.jpg',
            'overview'      => 'Smallville is an american tv serie.',
            'firstAired'    => new \DateTime('2001-10-16'),
            'language'      => 'en',
            'theTvDbId'     => 72218,
            'imdbId'        => 'tt0279600',
            'zap2itId'      => 'SH462144',
        ));
        $this->assertEquals(array($tvshow1), $api->searchTvShow('Smallville'));
        $this->assertEquals('http://www.test.com/api/GetSeries.php?seriesname=Smallville', $api->requestUrl);


        $api->requestBody = file_get_contents(__DIR__.'/Fixtures/searchTvShow_2.xml');
        $tvshow2 = new TvShow();
        $tvshow2->fromArray(array(
            'id'            => 71394,
            'language'      => 'en',
            'name'          => 'The Cape',
            'bannerUrl'     => $api->getMirrorUrl().'banners/graphical/71394-g.jpg',
            'firstAired'    => new \DateTime('1996-09-01'),
            'theTvDbId'     => 71394,
            'zap2itId'      => 'SH189638',
        ));
        $tvshow3 = new TvShow();
        $tvshow3->fromArray(array(
            'id'            => 160671,
            'name'          => 'The Cape (2011)',
            'bannerUrl'     => $api->getMirrorUrl().'banners/graphical/160671-g.jpg',
            'overview'      => 'The Cape follows an innocent cop who has been framed for a crime he did not commit...',
            'firstAired'    => new \DateTime('2011-01-09'),
            'language'      => 'en',
            'theTvDbId'     => 160671,
            'imdbId'        => 'tt1593823',
            'zap2itId'      => 'SH01279165',
        ));
        $this->assertEquals(array($tvshow2,$tvshow3), $api->searchTvShow('The Cape'));
        $this->assertEquals('http://www.test.com/api/GetSeries.php?seriesname='.urlencode('The Cape'), $api->requestUrl);
    }

    public function testGetTvShow()
    {
        $api = $this->getMockApi();
        $api->requestBody = file_get_contents(__DIR__.'/Fixtures/getTvShow_1.xml');

        $tvshow = new TvShow();
        $tvshow->fromArray(array(
            'id'            => 72218,
            'name'          => 'Smallville',
            'firstAired'    => new \DateTime('2001-10-16'),
            'overview'      => 'Smallville revolves around Clark Kent...',
            'network'       => 'The CW',
            'language'      => 'en',

            'bannerUrl'     => $api->getMirrorUrl().'banners/graphical/72218-g22.jpg',
            'fanartUrl'     => $api->getMirrorUrl().'banners/fanart/original/72218-82.jpg',
            'posterUrl'     => $api->getMirrorUrl().'banners/posters/72218-16.jpg',

            'theTvDbId'     => 72218,
            'imdbId'        => 'tt0279600',
            'zap2itId'      => 'SH462144',
        ));

        $this->assertEquals($tvshow, $api->getTvShow(72218));
        $this->assertEquals('http://www.test.com/api/123/series/72218/en.xml', $api->requestUrl);
    }

    public function testGetEpisode()
    {
        $api = $this->getMockApi();
        $api->requestBody = file_get_contents(__DIR__.'/Fixtures/getEpisode_1.xml');

        $episode = new Episode();
        $episode->fromArray(array(
            'id'            => 77817,
            'tvshowId'      => 72218,
            'seasonId'      => 3707,
            'episodeNumber' => 1,
            'seasonNumber'  => 1,
            'name'          => 'Pilot',
            'firstAired'    => new \DateTime('2001-10-16'),
            'overview'      => 'The first episode tells the story of the meteor shower that hit Smallville and changed life in the Kansas town forever.',
            'language'      => 'en',
        ));

        $this->assertEquals($episode, $api->getEpisode(77817));
        $this->assertEquals('http://www.test.com/api/123/episodes/77817/en.xml', $api->requestUrl);
    }

    public function testGetTvShowAndEpisodes()
    {
        $api = $this->getMockApi();
        $api->requestBody = file_get_contents(__DIR__.'/Fixtures/getTvShowAndEpisodes_1.xml');

        $tvshow = new TvShow();
        $tvshow->fromArray(array(
            'id'            => 72218,
            'name'          => 'Smallville',
            'firstAired'    => new \DateTime('2001-10-16'),
            'overview'      => 'Smallville revolves around Clark Kent...',
            'network'       => 'The CW',
            'language'      => 'en',

            'bannerUrl'     => $api->getMirrorUrl().'banners/graphical/72218-g22.jpg',
            'fanartUrl'     => $api->getMirrorUrl().'banners/fanart/original/72218-82.jpg',
            'posterUrl'     => $api->getMirrorUrl().'banners/posters/72218-16.jpg',

            'theTvDbId'     => 72218,
            'imdbId'        => 'tt0279600',
            'zap2itId'      => 'SH462144',
        ));

        $episode = new Episode();
        $episode->fromArray(array(
            'id'            => 77817,
            'tvshowId'      => 72218,
            'seasonId'      => 3707,
            'episodeNumber' => 1,
            'seasonNumber'  => 1,
            'name'          => 'Pilot',
            'firstAired'    => new \DateTime('2001-10-16'),
            'overview'      => 'The first episode tells the story of the meteor shower that hit Smallville and changed life in the Kansas town forever...',
            'language'      => 'en',
        ));

        $data = array(
            'tvshow'    => $tvshow,
            'episodes'  => array($episode),
        );
        $this->assertEquals($data, $api->getTvShowAndEpisodes(72218));
        $this->assertEquals('http://www.test.com/api/123/series/72218/all/en.xml', $api->requestUrl);


        $api->requestBody = file_get_contents(__DIR__.'/Fixtures/getTvShowAndEpisodes_2.xml');
        $data = $api->getTvShowAndEpisodes(72218);
        $this->assertInstanceOf('TheTVDB\Model\TvShow', $data['tvshow']);
        $this->assertEquals(5, sizeof($data['episodes']));
    }

    public function testGetBanners()
    {
        $api = $this->getMockApi();
        $api->requestBody = file_get_contents(__DIR__.'/Fixtures/getBanners_1.xml');

        $banner_1 = new Banner();
        $banner_1->fromArray(array(
            'id'            => 490471,
            'bannerUrl'     => $api->getMirrorUrl().'banners/fanart/original/72218-82.jpg',
            'bannerType'    => 'fanart',
            'bannerSize'    => '1280x720',
            'language'      => 'en',
            'thumbnailUrl'  => $api->getMirrorUrl().'banners/_cache/fanart/original/72218-82.jpg',
        ));

        $banner_2 = new Banner();
        $banner_2->fromArray(array(
            'id'            => 489821,
            'bannerUrl'     => $api->getMirrorUrl().'banners/posters/72218-16.jpg',
            'bannerType'    => 'poster',
            'bannerSize'    => '680x1000',
            'language'      => 'en',
        ));

        $banner_3 = new Banner();
        $banner_3->fromArray(array(
            'id'            => 487411,
            'bannerUrl'     => $api->getMirrorUrl().'banners/seasons/72218-9-5.jpg',
            'bannerType'    => 'season',
            'language'      =>  'en',
        ));

        $banner_4 = new Banner();
        $banner_4->fromArray(array(
            'id'            => 619931,
            'bannerUrl'     => $api->getMirrorUrl().'banners/graphical/72218-g22.jpg',
            'bannerType'    => 'series',
            'language'      => 'en',
        ));

        $this->assertEquals(array($banner_1,$banner_2,$banner_3,$banner_4), $api->getBanners(71394));
        $this->assertEquals('http://www.test.com/api/123/series/71394/banners.xml', $api->requestUrl);
    }

    protected function getMockApi()
    {
        return new MockApi('123', 'http://www.test.com/');
    }
}