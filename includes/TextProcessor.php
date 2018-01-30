<?php
use TextAnalysis\Tokenizers\GeneralTokenizer;
use TextAnalysis\Documents\TokensDocument;

require_once("includes/RslvtTokensDocument.php");
require_once("includes/Results.php");
require 'vendor/autoload.php';

/**
 * A Processor that takes a paragraph of text and return an alphabetized list of ALL unique words.
 */
class TextProcessor
{
	private $tokenizer;

	function __construct(){
		$this->tokenizer = new GeneralTokenizer();
	}

    /**
     * Takes a paragraph of text and return an alphabetized list of ALL unique words with the amount of ocurrences and sentence indexes.
     * @param Paragraph $paragraph
     * @return Json
     */
	public function getUniqueWordsJson(Paragraph $paragraph){

		$results = new Results();

		foreach ($paragraph->getSentences() as $index => $sentence) {

		    $tokensInSentence = $this->tokenizer->tokenize($sentence);

		    $rslvtTokenDoc = new RslvtTokensDocument($tokensInSentence);
		    $rslvtTokenDoc->applyFistTransformation();
		    $allWords = $rslvtTokenDoc->getDocumentData();

		    $rslvtTokenDoc->applySecondTransformation();
		    $filteredWords = $rslvtTokenDoc->getDocumentData();

		    $rslvtTokenDoc->applySnowballStemmer();

		    foreach ($rslvtTokenDoc->getDocumentData() as $stemIndex => $stem) {
		        if (!$results->existStemItem($stem)) {
					$results->addNewStem($stem, $this->_getFirstWordAppearance($stemIndex, $allWords, $filteredWords));
		        }
				$results->increaseOcurrencesCounter($stem);
				$results->addSentenceIndex($stem,$index);
		    }
		}
		return $results->getJson();
	}

    /**
     * Get First Word Appearance of the array allWords. To get the word without applying the lower case.
     * @param Paragraph $index
     * @param Paragraph $allWords
     * @param Paragraph $filteredWords contains the word to find in $allWords
     * @return String
     */
	private function _getFirstWordAppearance($index, $allWords, $filteredWords){
		return $allWords[array_search(strtolower($filteredWords[$index]),array_map('strtolower',$allWords))];
	}

}

 ?>
