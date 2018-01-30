<?php

/**
 * Item of each stem
 */
class Item
{

	protected $word;
	protected $total_occurrences;
	protected $sentence_indexes;

	function __construct($word)
	{
		$this->word = $word;
		$this->total_occurrences = 0;
		$this->sentence_indexes = [];
	}

    /**
     * Increase counter of ocurrences
     */
	public function increaseOcurrencesCounter(){
        $this->total_occurrences++;
	}

    /**
     * Add sentence index to the Item
     */
	public function addSentenceIndex($index){
		if (!in_array($index, $this->sentence_indexes)) {
			$this->sentence_indexes[] = $index;
		}
	}

    /**
     * Get array of items properties
     */
	public function getItemArray(){
		return array(
					'word'				=>	$this->word,
					'total-occurrences'	=>	$this->total_occurrences,
					'sentence-indexes'	=>	$this->sentence_indexes
				);
	}

}
 ?>
