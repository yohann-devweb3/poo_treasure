<?php
class GameMap
{
    private $width;
    private $height;
    private $player;
    private $treasure;
    private $monsters;

    public function __construct($width, $height)
    {
        $this->width = $width;
        $this->height = $height;
        $this->player = new Player(1, 1);
        $this->treasure = new Treasure($width, $height);
        $this->monsters = [
            new Monster($width, $height),
            new Monster($width, $height),
            new Monster($width, $height),
            new Monster($width, $height),
            new Monster($width, $height),
            new Monster($width, $height),
            new Monster($width, $height),
            new Monster($width, $height)
        ];
    }

    public function getPlayer()
    {
        return $this->player;
    }

    public function getTreasure()
    {
        return $this->treasure;
    }

    public function getMonsters()
    {
        return $this->monsters;
    }
}
