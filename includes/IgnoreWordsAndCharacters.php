<?php
use TextAnalysis\Documents\TokensDocument;
use TextAnalysis\Stemmers\LookupStemmer;
use TextAnalysis\Adapters\JsonDataAdapter;
use TextAnalysis\Filters\StopWordsFilter;

/**
 * Filter to ignore some words
 */
class IgnoreWordsAndCharacters
{
	private $toIgnore;
	private $lookUpStemmer;

    /**
     * @param Array $toIgnore: array with words to ignore
     * @return Json String $customSteems contains the stems of particular words
     */
	function __construct($toIgnore, $customSteems)
	{
		$this->toIgnore = $toIgnore;

		$jsonReader = new JsonDataAdapter($customSteems);
		$this->lookUpStemmer = new LookupStemmer($jsonReader);
	}

    /**
     * Apply lookUpStemmer and then the Filter to ignore words of the property $this->toIgnore
     * @param TokensDocument $tokenDoc
     * @return TokensDocument
     */
	public function applyFilters(TokensDocument $tokenDoc){
	    $tokenDoc->applyStemmer($this->lookUpStemmer, true);
	    $tokenDoc->applyTransformation(new StopWordsFilter($this->toIgnore), true);
		return $tokenDoc;
	}
}

 ?>
