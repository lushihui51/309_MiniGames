<?php
class FrogsGame {
    public $positions = [];
    public $empty_i = -1;
    public $state = '';
    public $numJumps = -1;
    public function __construct() {
        $this->positions = [1, 1, 1, 0, -1, -1, -1];
        $this->empty_i = 3;
        $this->state = 'In Game'; 
        $this->numJumps = 0;
    }
    public function getValidPositions() {
        $valid_pos = [];
        for ($i=$this->empty_i-2; $i<$this->empty_i+3 && $i<count($this->positions); $i++) {
            if ($i < 0 || $i == $this->empty_i) {
                continue;
            } elseif ($i < $this->empty_i && $this->positions[$i] > 0){
                $valid_pos[] = $i;
            } elseif ($i > $this->empty_i && $this->positions[$i] < 0){
                $valid_pos[] = $i;
            }
        }
        return $valid_pos;
    }
    public function move($pos) {
        $this->positions[$this->empty_i] += $this->positions[$pos];
        $this->positions[$pos] -= $this->positions[$pos];
        $this->empty_i = $pos;
    }
    public function updateState() {
        if ($this->positions == [-1, -1, -1, 0, 1, 1, 1]){
            $this->state = 'You Won!';
        } else if (empty($this->getValidPositions())){
            $this->state = 'You Lost!';
        } else {
            $this->state = 'In Game';
        }
    }
	public function jump($frog_pos) {
        $valid_pos = $this->getValidPositions();
        if (in_array($frog_pos, $valid_pos)) {
            $this->move($frog_pos);
            $this->numJumps += 1;
        }
        $this->updateState();
    }
    public function getState() {
        return $this->state;
    }
    public function getPositions() {
        return $this->positions;
    }

    public function getJumps() {
        return $this->numJumps;
    }
}
?>