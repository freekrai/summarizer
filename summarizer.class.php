<?php
class Summarizer{
	public $sentences_dic = array();
	public $orginal;
	public $summary;
	
	public function __constructor(){
		return true;		
	}
	public function split_content_to_sentences($content){
        $content = str_replace("\n",". ",$content);
        return explode(". ",$content);
	}

    public function split_content_to_paragraphs($content){
		return explode("\n\n",$content);
	}

	public function sentences_intersection($sent1, $sent2){
		$s1 = explode(" ",$sent1);
		$s2 = explode(" ",$sent2);
		$cs1 = count($s1);
		$cs2 = count($s2);
		if( ($cs1 + $cs2) == 0 )	return 0;

		$i = count( array_intersect($s1,$s2) );
		$avg = $i / (($cs1+$cs2) / 2);
		return $avg;
	}
	public function format_sentence($sentence){
//		$sentence = preg_replace('/[^a-z\d ]/i', '', $sentence);
		$sentence = preg_replace("/[^a-zA-Z0-9\s]/", "", $sentence);
		$sentence = str_replace(" ","",$sentence);
        return $sentence;
	}
	public function get_sentences_ranks($content){
		$sentences = $this->split_content_to_sentences($content);
		$n = count( $sentences );
		$values = array();
		for($i = 0;$i <= $n;$i++){
			$s1 = $sentences[$i];
			for($j = 0;$j <= $n;$j++){
				$s2 = $sentences[$j];
				$values[$i][$j] = $this->sentences_intersection($s1, $s2);
			}
		}
		$sentences_dic = array();
		for($i = 0;$i <= $n;$i++){
			$score = 0;		
			for($j = 0;$j <= $n;$j++){
					if( $i == $j)	continue;
					$score = $score + $values[$i][$j];
			}
			$sentences_dic[ $this->format_sentence( $sentences[$i] ) ] = $score;
		}
		$this->sentences_dic = $sentences_dic;
		return $sentences_dic;
	}

	public function get_best_sentence($paragraph){
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

    public function get_summary($content){
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
	function how_we_did(){
	    print "<hr />";
	    print "Original Length ". strlen($this->original);
		echo "<br />";
	    print "Summary Length ".strlen($this->summary);
		echo "<br />";
	    print "Summary Ratio: ".(100 - (100 * (strlen($this->summary) / (strlen($this->original)))));
		echo "<br />";
	}

}
