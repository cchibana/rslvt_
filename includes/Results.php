<?php
require_once("includes/Item.php");

/**
 * Results for applying the rslvt text processor
 */
class Results
{
	protected $results = array();

    /**
     * Check if a Stem exist in the results array
     * @param String $stem
     * @return boolean
     */
	public function existStemItem($stem){
        return (isset($this->results[$stem])) ? true : false;
	}

    /**
     * Add new Item to the Results Array
     * @param String $stem
     * @param String $word the original word
     */
	public function addNewStem($stem, $word){
	    $this->results[$stem] = new Item($word);
	}

    /**
     * Increase counter of ocurrences
     * @param String $stem
     */
	public function increaseOcurrencesCounter($stem){
	    $this->results[$stem]->increaseOcurrencesCounter();
	}

    /**
     * Add sentence index to the Item
     * @param String $stem
     * @param Integer $index
     */
	public function addSentenceIndex($stem, $index){
	    $this->results[$stem]->addSentenceIndex($index);
	}

    /**
     * Return Results as a Json
     * @return Json
     */
	public function getJson(){

		ksort($this->results);
		$results = array();
		foreach ($this->results as $key => $value) {
			$results[] = $value->getItemArray();
		}

		return json_encode(['results' => $results]);
	}
}

 ?>
