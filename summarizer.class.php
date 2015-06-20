<?php
/**
 * @class Summarizer
 * @author Roger Stringer <roger@freekrai.net>
 * @author Alexander Jank <himself@alexanderjank.de>
 */
class Summarizer{

	/**
	 * Array containgin the sentences of a given document
	 * @var array
	 */
	public $sentences_dic = [];

	/**
	 * the original document
	 * @var string
	 */
	public $orginal;

	/**
	 * the generated summary of a given document
	 * @var string
	 */
	public $summary;
	
	/**
	 * split a given document to sentcnces
	 * @param string $content
	 * @return array snatences
	 */
	public function split_content_to_sentences($content) {
		$content = preg_split('/[.?!]/', $content, NULL ,PREG_SPLIT_DELIM_CAPTURE );
		$strcontent = '';
		foreach($content as $key => $value) {
			$strcontent .= str_replace("\n", ". ", $value);
		}
		return explode(". ", $strcontent);
	}

	/**
	 * split given content to paragraphs
	 * @param string $content
	 * @return array paragraphs
	 */
	public function split_content_to_paragraphs($content) {
		return explode("\n\n", $content);
	}

	/**
	 * intersect between two given sentences
	 * @param  string $sent1 sentence one
	 * @param  string $sent2 sentence two
	 * @return float
	 */
	public function sentences_intersection($sent1, $sent2) {
		$s1  = explode(" ",$sent1);
		$s2  = explode(" ",$sent2);
		$cs1 = count($s1);
		$cs2 = count($s2);
		if (($cs1 + $cs2) == 0) {
			return 0;
		}

		$i   = count(array_intersect($s1,$s2));
		$avg = $i / (($cs1+$cs2) / 2);
		return $avg;
	}

	/**
	 * format a sentence
	 * @param string $sentence
	 * @return string
	 */
	public function format_sentence($sentence) {
		//$sentence = preg_replace('/[^a-z\d ]/i', '', $sentence);
		$sentence = preg_replace("/[^a-zA-Z0-9\s]/", "", $sentence);
		$sentence = str_replace(" ","",$sentence);
		return $sentence;
	}

	/**
	 * get the rank for each sentence in the content
	 * @param string $content
	 * @return array
	 */
	public function get_sentences_ranks($content) {
		$sentences = $this->split_content_to_sentences($content);
		$n = count( $sentences );
		$values = array();
		for($i = 0;$i < $n;$i++){
			$s1 = $sentences[$i];
			for($j = 0;$j < $n;$j++){
				$s2 = $sentences[$j];
				$values[$i][$j] = $this->sentences_intersection($s1, $s2);
			}
		}
		$sentences_dic = array();
		for($i = 0;$i < $n;$i++){
			$score = 0;		
			for($j = 0;$j < $n;$j++){
					if( $i == $j)	continue;
					$score = $score + $values[$i][$j];
			}
			$sentences_dic[ $this->format_sentence( $sentences[$i] ) ] = $score;
		}
		$this->sentences_dic = $sentences_dic;
		return $sentences_dic;
	}

	/**
	 * get the best sentence of one paragraph
	 * @param  string $paragraph
	 * @return string the best sentence
	 */
	public function get_best_sentence($paragraph) {
		$sentences = $this->split_content_to_sentences($paragraph);
		if( count($sentences) < 2 )	return "";
		$best_sentence = "";
		$max_value = 0;
		foreach( $sentences as $s){
			$strip_s = $this->format_sentence($s);
			if( !empty($strip_s) ){
				$me = $this->sentences_dic[$strip_s];
				if( $me > $max_value ){
					$max_value = $me;
					$best_sentence = $s;
				}
			}
		}
		return $best_sentence;
	}

	/**
	 * get teh summary of given content or document
	 * @param string $content
	 * @return string the summary
	 */
	public function get_summary($content) {
		$sentences_dic = $this->get_sentences_ranks($content);
		$paragraphs = $this->split_content_to_paragraphs($content);

		$this->original = $content;

		$summary = array();
		foreach( $paragraphs as $p ){
			$sentence = $this->get_best_sentence($p);
			if( !empty($sentence) ){
				$summary[$sentence] = $sentence;	
			}
		}
		$this->summary = implode("\n",$summary);
		return $this->summary;
	}

	/**
	 * get statistics data
	 * @return array
	 */
	public function how_we_did() {
		return [
			'length' => [
				'original' => strlen($this->original),
				'summary' => strlen($this->summary),
				'differnence' => strlen($this->original) - strlen($this->summary)
			],
				'ratio' => (100 - (100 * (strlen($this->summary) / (strlen($this->original)))))
			];
	}
}