<?php


namespace KaywGeek\Map;



use KaywGeek\Map\Exceptions\InvalidArgumentException;

trait MapTraits
{

    public $rangeValue = 0.2;
    public $s = '/';
    public $suffix = '.png';
    private $path = 'https://tile.openstreetmap.org/';
    public $minLevel = 9;


    /**
     * Returns 2 pairs of latitude and longitude from a given latitude and longitude calculation range
     * @param float $x
     * @param float $y
     * @return array[]
     */
    public function computeRangeByLonLat(float $lat,float $lon) :array
    {
        return [
                number_format($lat - $this->rangeValue,5),
                number_format($lon - $this->rangeValue,5),
                number_format($lat + $this->rangeValue,5),
                number_format($lon + $this->rangeValue,5)
               ];
    }

    /**
     * Longitude and latitude are converted to tile coordinates
     * @param float $lon
     * @param float $lat
     * @param int $level
     * @return array
     */
    public function lonLat2Tile(float $lat,float $lon,int $level):array
    {
        return [$this->lon2TileX($lat,$level),$this->lat2TileY($lon,$level)];
    }

    /**
     * Longitude to tile coordinate X
     * @param float $lat
     * @param int $level
     * @return int
     */
    public function lon2TileX(float $lat,int $level) :int
    {
        return round((($lat+180)/360) * pow(2,$level));
    }

    /**
     * Latitude to tile coordinate Y
     * @param float $lot
     * @param int $level
     * @return int
     */
    public function lat2TileY(float $lot,int $level) :int
    {
        $n = pow(2,$level);
        $lat_rad = $lot/180.0*M_PI;
        return (1.0 - log(tan($lat_rad) + $this->sec($lat_rad)) / M_PI) / 2.0 * $n;
    }

    /**
     * Get the path of the Open Strrt Map tile resource image by tile coordinates and zoom
     * @param array $tileArr
     * @param int $level
     * @return string
     */
    public function getTileImgPath(array $tileArr,int $level) :string
    {
        return $this->path.$level.$this->s.$tileArr[0].$this->s.$tileArr[1].$this->suffix;
    }

    /**
     *  Get image name by tile coordinates and zoom
     * @param array $tileArr
     * @param int $level
     * @return string
     */
    public function getImgName(array $tileArr,int $level) :string
    {
        return $level.'_'.$tileArr[0].'_'.$tileArr[1].$this->suffix;
    }

    /**
     * Sec mathematical function
     * @param $val
     * @return float|int
     */
    private function sec($val)
    {
        return 1/cos($val);
    }

    /**
     * Download file to local
     * @param $url
     * @param $filePath
     */
    public function download($url,$filePath)
    {
        ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 6.0)');
        $output = file_get_contents($url);
        $downloaded_file = fopen($filePath, 'w');
        fwrite($downloaded_file, $output);
        fclose($downloaded_file);
    }

    /**
     * Get all tile coordinates from the tile coordinate range value
     * @param $tileArrStart
     * @param $tileArrEnd
     * @return array
     */
    public function getAllTile($tileArrStart,$tileArrEnd)
    {
        $tileArr = [];
        for($i = min($tileArrStart[0],$tileArrEnd[0]);$i <= max($tileArrStart[0],$tileArrEnd[0]);$i++){
            for ($y = min($tileArrStart[1],$tileArrEnd[1]);$y <= max($tileArrStart[1],$tileArrEnd[1]);$y++){
                $tileArr[] = [$i,$y];
            }
        }
        return $tileArr;
    }


    /**
     * Get the full tile image path of OpenStreetMap with the latitude and longitude range value zoom level
     * @param $bbox
     * @param int $maxLevel
     * @return array
     */
    public function getAllImgPath($bbox,$maxLevel = 19)
    {
        $imgName = [];
        for ($l= $this->minLevel;$l<=$maxLevel;$l++){
            $res = $this->getAllTile($this->lonLat2Tile($bbox[0],$bbox[1],$l),$this->lonLat2Tile($bbox[2],$bbox[3],$l));
            foreach ($res as $item){
                $imgName['path'][] = $this->getTileImgPath($item,$l);
                $imgName['filename'][] = $this->getImgName($item,$l);
            }
        }
        return $imgName;
    }

}