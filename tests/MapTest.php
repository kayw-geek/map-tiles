<?php

namespace KaywGeek\Map\Test;

use KaywGeek\Map\MapTraits;
use PHPUnit\Framework\TestCase;

class MapTest extends TestCase
{
    use MapTriaits;
    public function testComputeRangeByLonLat()
    {
        $range = $this->computeRangeByLonLat(116.4074,39.9042);
        $this->assertSame(['116.20740','39.70420','116.60740','40.10420'],$range);
    }

    public function testLonLat2Tile()
    {
        $tile = $this->lonLat2Tile(116.4074,39.9042,11);
        $this->assertSame([1686,776],$tile);

    }

    public function testGetTileImgPath()
    {
        $path = $this->getTileImgPath([1686,776],11);
        $this->assertSame('https://tile.openstreetmap.org/11/1686/776.png',$path);
    }

    public function testGetImgName()
    {
        $imaName = $this->getImgName([1686,776],11);
        $this->assertSame('11_1686_776.png',$imaName);
    }

    public function testDonwnload()
    {
        $this->download('https://tile.openstreetmap.org/11/1686/776.png','./data/11_1686_776.png');
        $this->fileExists('./data/11_1686_776.png');
    }

    public function testGetAllImgPath()
    {
        $res = $this->getAllImgPath(['116.20740','39.70420','116.60740','40.10420'],10);
        $this->assertSame([
            'path'=>[
                'https://tile.openstreetmap.org/9/421/193.png',
                'https://tile.openstreetmap.org/9/421/194.png',
                'https://tile.openstreetmap.org/9/422/193.png',
                'https://tile.openstreetmap.org/9/422/194.png',
                'https://tile.openstreetmap.org/10/843/387.png',
                'https://tile.openstreetmap.org/10/843/388.png',
                'https://tile.openstreetmap.org/10/844/387.png',
                'https://tile.openstreetmap.org/10/844/388.png'
            ],
            'filename'=>[
                '9_421_193.png',
                '9_421_194.png',
                '9_422_193.png',
                '9_422_194.png',
                '10_843_387.png',
                '10_843_388.png',
                '10_844_387.png',
                '10_844_388.png',
            ]
        ],$res);
    }
}