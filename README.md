# map-tiles
--- 
👍This package provides map latitude and longitude conversion to tile coordinates, calculation of the latitude and longitude range, conversion of the tile coordinate range, downloading the map tile image within the specified range through the latitude and longitude (image resources from openstreetmap)
---
![GitHub](https://img.shields.io/github/license/kayw-geek/map-tiles)
![Packagist Downloads](https://img.shields.io/packagist/dm/kayw-geek/map-tiles)
![GitHub top language](https://img.shields.io/github/languages/top/kayw-geek/map-tiles)

## Application scenario
Can be used to convert map latitude and longitude into tile coordinates, develop offline maps, use Open Street Map map data, etc.
## Installing

```shell
$ composer require kayw-geek/map-tiles -vvv
```

## Usage

### Traits

#### `KaywGeek\Map\MapTraits`

```php

use KaywGeek\Map;

class Map
{
    use MapTraits;
    
    <...>
}
```
### API

```php
//Returns 2 pairs of latitude and longitude from a given latitude and longitude calculation range
$m = new Map();
$m->rangeValue  = 0.5;
$range = $m->computeRangeByLonLat(116.4074,39.9042);

//Longitude and latitude are converted to tile coordinates
$m->lonLat2Tile(116.4074,39.9042,11);

//Get the path of the Open Strrt Map tile resource image by tile coordinates and zoom
$m->getTileImgPath([1686,776],11);

//Get image name by tile coordinates and zoom
$m->getImgName([1686,776],11);

//Download file to local
$m->download('https://tile.openstreetmap.org/11/1686/776.png','./data/11_1686_776.png');

//Get the full tile image path of OpenStreetMap with the latitude and longitude range value zoom level
$m->getAllImgPath(['116.20740','39.70420','116.60740','40.10420'],10);
```
## License

MIT
