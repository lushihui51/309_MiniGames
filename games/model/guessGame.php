<?php

class GuessGame {
	public $secretNumber = 5;
	public $numGuesses = 0;
	public $history = array();
	public $state = "GuessGameStartingState";

	public function __construct() {
        	$this->secretNumber = rand(1,100);
    	}
	
	public function makeGuess($guess){
		$this->numGuesses++;
		if($guess>$this->secretNumber){
			$this->state="too high";
		} else if($guess<$this->secretNumber){
			$this->state="too low";
		} else {
			$this->state="correct";
		}
		$this->history[] = "Guess #$this->numGuesses was $guess and was $this->state.";
	}

	public function getState(){
		return $this->state;
	}

	public function getGuesses(){
		return $this->numGuesses;
	}
}
?>
