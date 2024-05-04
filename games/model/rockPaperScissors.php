<?php

class RockPaperScissors {
	public $options = ['rock', 'paper', 'scissors'];
	public $numPlays = 0;
	public $score = [0, 0]; // comp, user
	public $history = array();
	public $state = '';
	
	public function battle($u_choice){
		$this->numPlays++;
		
		$comp = rand(0, 2); $c_choice = $this->options[$comp];
		$user = array_search($u_choice, $this->options);

		if($comp == $user) {
			$this->state='draw'; // state 1: 'draw' 
		} elseif($comp > $user && $comp - $user == 1 || $comp < $user && $user - $comp == 2) {
			$this->state='I beat you!'; // state 2: 'I beat you!'
			$this->score[0]++;
		} else {
			$this->state='you beat me...'; // state 3: 'you beat me...'
			$this->score[1]++;
		}
		$this->history[] = "Round $this->numPlays: You chose $u_choice, I chose $c_choice, $this->state";
		if($this->score[0] == 5) {
			$this->state='I won!'; // state 4: 'I won!'
		} elseif ($this->score[1] == 5) {
			$this->state='You won...'; // state 5: 'You won...'
		}
	}
	public function getState(){
		return $this->state; 
	}
	public function getScore(){
		return $this->score;
	}
	public function getPlays() {
		return $this->numPlays;
	}
}
?>
