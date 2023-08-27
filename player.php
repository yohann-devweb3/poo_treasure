<?php
class Player
{
    private $x;
    private $level;
    private $experience;
    private $y;

    public function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
        $this->level=1;
        $this->experience=0;
    }

	/**
	 * @return mixed
	 */
	public function getExperience() {
		return $this->experience;
	}
	
	/**
	 * @param mixed $experience 
	 * @return self
	 */
	public function setExperience($experience): self {
		$this->experience = $experience;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getLevel() {
		return $this->level;
	}

	/**
	 * @return mixed
	 */
	public function getX() {
		return $this->x;
	}
	
	/**
	 * @param mixed $x 
	 * @return self
	 */
	public function setX($x): self {
		$this->x = $x;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getY() {
		return $this->y;
	}
	
	/**
	 * @param mixed $y 
	 * @return self
	 */
	public function setY($y): self {
		$this->y = $y;
		return $this;
	}
}
