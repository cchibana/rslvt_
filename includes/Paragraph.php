<?php
/**
 * A Paragraph that contains sentences
 */
class Paragraph
{
	protected $paragraph;

	function __construct($paragraph = ''){
		$this->paragraph = $paragraph;
	}

    /**
     * Get Sentences of the paragraph
     * @return Array
     */
	public function getSentences(){
		return explode('.', $this->paragraph);
	}
}

 ?>
