<?php
class Monster
{
    private $x;
    private $y;
    private $force;
    private $health;

    public function __construct($maxX, $maxY)
    {
        $this->x = rand(0, $maxX - 1);
        $this->y = rand(0, $maxY - 1);
    }

    public function getmonsterX()
    {
        return $this->x;
    }

    public function getmonsterY()
    {
        return $this->y;
    }

	/**
	 * @return mixed
	 */
	public function getForce() {
		return $this->force;
	}
	
	/**
	 * @param mixed $force 
	 * @return self
	 */
	public function setForce($force): self {
		$this->force = $force;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getHealth() {
		return $this->health;
	}
	
	/**
	 * @param mixed $health 
	 * @return self
	 */
	public function setHealth($health): self {
		$this->health = $health;
		return $this;
	}
}
