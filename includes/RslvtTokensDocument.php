<?php

use TextAnalysis\Documents\TokensDocument;
use TextAnalysis\Filters\PunctuationFilter;
use TextAnalysis\Filters\QuotesFilter;
use TextAnalysis\Filters\LowerCaseFilter;
use TextAnalysis\Stemmers\SnowballStemmer;

require 'vendor/autoload.php';
require_once("includes/IgnoreWordsAndCharacters.php");

/**
 * Rslvt Token Documents Filters
 */
class RslvtTokensDocument extends TokensDocument
{
    protected $tokenDoc;
    protected $snowballStemmer;

	function __construct($tokens)
	{
	    $this->tokenDoc = new TokensDocument($tokens);
	    $this->snowballStemmer = new SnowballStemmer();
	}

    /**
     * Remove Quotes and Punctuation characters using the filters QuotesFilter, PunctuationFilter
     */
	public function applyFistTransformation(){
	    $this->tokenDoc->applyTransformation(new QuotesFilter(), false);
	    $this->tokenDoc->applyTransformation(new PunctuationFilter(), false);
	}

    /**
     * Convert tokens to lower case and filter words and characters to ignore
     */
	public function applySecondTransformation(){
	    $this->tokenDoc->applyTransformation(new LowerCaseFilter(), false);

		$ignoreWordsAndCharactersFilter = new IgnoreWordsAndCharacters(['a', 'the', 'and', 'of', 'in', 'be', 'also', 'as'], '{"an":"a"}');
		$this->tokenDoc = $ignoreWordsAndCharactersFilter->applyFilters($this->tokenDoc);
	}

    /**
     * Apply Snowball Stemmer - Demo: http://snowballstem.org/demo.html
     */
	public function applySnowballStemmer(){
	    $this->tokenDoc->applyStemmer($this->snowballStemmer, true);
	}

    /**
    * Returns the set of tokens in this document, most of the time
    *  @return mixed
    */
	public function getDocumentData(){
		return $this->tokenDoc->getDocumentData();
	}
}
 ?>
