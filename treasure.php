<?php
class Treasure
{
    private $x;
    private $y;

    public function __construct($maxX, $maxY)
    {
        $this->x = rand(0, $maxX - 1);
        $this->y = rand(0, $maxY - 1);
    }

    public function gettreasureX()
    {
        return $this->x;
    }

    public function gettreasureY()
    {
        return $this->y;
    }
}
