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
    
        // Génère aléatoirement entre 10 et 50 monstres
        $minMonsters = 10;
        $maxMonsters = 50;
        $numberOfMonsters = mt_rand($minMonsters, $maxMonsters);
    
        $this->monsters = [];
        for ($i = 0; $i < $numberOfMonsters; $i++) {
            $this->monsters[] = new Monster($width, $height);
        }
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
