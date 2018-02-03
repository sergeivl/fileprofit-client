<?php
class UniquelizerService
{
	private $uniqPressing;
	private $uniqPressingLevel;
	private $uniqMashupParagraph;
	private $uniqMashupSentence;
	private $uniqRuslat;
	private $uniqRuslatLevel;
	private $uniqSynonymizer;
	private $uniqSynonymizerLevel;

	public function __construct($config = [])
	{
		$this->uniqPressing = true;
		$this->uniqPressingLevel = 5;

		$this->uniqMashupParagraph = true;
		$this->uniqMashupSentence = true;

		$this->uniqRuslat = false;
		$this->uniqRuslatLevel = 5;

		$this->uniqSynonymizer = true;
		$this->uniqSynonymizerLevel = 1;
	}

	public function doUniquelize($text){
		App::log('Начинаем уникализировать тектс');
		/*
		if ($this->uniqPressing) {
			App::log('Сокращаем текст');
			$text = $this->uniqTextPressing($text, $this->uniqPressingLevel);
		}
		if ($this->uniqMashupParagraph || $this->uniqMashupSentence) {
			App::log('Перемешиваем параграфы');
			$text = $this->uniqMashupParagraphSentence($text, $this->uniqMashupParagraph, $this->uniqMashupSentence, "\r\n");
		}
		if ($this->uniqRuslat) {
			App::log('Заменяем русские символы английскими');
			$text = $this->uniqReplaceRuslat($text, $this->uniqRuslatLevel);
		}
		*/
		if ($this->uniqSynonymizer) {
			App::log('Синоминизируем текст');
			$text = $this->uniqSynonymizerRu($text, $this->uniqSynonymizerLevel);
		}
		return $text;
	}

	private function uniqMashupParagraphSentence($text, $mashup_paragraph = false, $mashup_sentence = false, $paragraph_symbol = "</p>") {
		$paragraphs = preg_split("/".str_replace("/", "\/", $paragraph_symbol)."+?/uims", $text, -1, PREG_SPLIT_DELIM_CAPTURE|PREG_SPLIT_NO_EMPTY);
		if ($mashup_paragraph) {
			srand((float) microtime() * 10000000);
			shuffle($paragraphs);
		}
		if ($mashup_sentence) {
			foreach ($paragraphs as $key => $paragraph) {
				$paragraph = strip_tags($paragraph);
				if ($paragraph_symbol == "</p>")
					$paragraphs[$key] = "<p>";
				else
					$paragraphs[$key] = "";
				$paragraphs[$key] .= $this->uniqMashupSentence($paragraph);
			}
		}
		return join($paragraph_symbol, $paragraphs) . $paragraph_symbol;
	}

	private function uniqMashupSentence($text) {
		$sentences = $this->uniqSplitSentence($text);
		srand((float) microtime() * 10000000);
		shuffle($sentences);
		return join(" ", $sentences);
	}

	private function uniqSplitSentence($text) {
		$sentences = preg_split("/([\.\!\?])\s/u", trim($text), -1, PREG_SPLIT_DELIM_CAPTURE|PREG_SPLIT_NO_EMPTY);
		$sentences2 = array();
		$num = 0;
		foreach($sentences as $key => $sentence) {
			if ($sentence == "." || $sentence == "!" || $sentence == "?") {
				$sentences2[$num - 1] .= $sentence;
				continue;
			}
			if (!isset($sentences2[$num])) {
				$sentences2[$num] = '';
			}

			$sentences2[$num] .= trim($sentence);
			$num++;
		}
		return $sentences2;
	}

	private function uniqTextPressing($text, $pressingLevel) {
		if ($pressingLevel >= 100)
			return $text;
		$text = strip_tags($text);
		$sentences = $this->uniqSplitSentence($text);
		$press = round((count($sentences)*$pressingLevel)/100);
		$rand_keys = array_rand($sentences, count($sentences) - $press);
		if (!is_array($rand_keys))
			return $text;
		foreach ($rand_keys as $rand_key) {
			unset($sentences[$rand_key]);
		}
		return join(" ", $sentences);
	}

	private function uniqReplaceRuslat($text, $level = 100) {
		$words = preg_split("/(\s+)/uims", $text, -1, PREG_SPLIT_DELIM_CAPTURE);
		$words_count = 0;
		$not_empty_words = array();
		foreach ($words as $key => $word) {
			if (trim($word)) {
				$not_empty_words[$key] = $word;
				$words_count++;
			}elseif (!preg_match('/\n/ims', $word))
				unset($words[$key]);
		}
		if ($words_count == 0) $words_count = 1;
		if ($words_count > count($not_empty_words)) $words_count = count($not_empty_words);
		$replace_count = round(($words_count * $level) / 100);

		echo $not_empty_words . ' - ' . $words_count . '<br>';
		$rand_keys = array_rand($not_empty_words, $words_count);

		$count = 0;
		foreach($rand_keys as $key => $rand_key) {
			if ($rword = $this->uniqRuslat($words[$rand_key])) {
				$words[$rand_key] = $rword;
				$count++;
			}
			if ($count >= $replace_count)
				break;
		}
		$text = join(" ", $words);
		return $text;
	}

	private function uniqRuslat($str) {
		$ruslat = array("а"=>"a","А"=>"A","е"=>"e","Е"=>"E","о"=>"o","О"=>"O","х"=>"x","Х"=>"X");
		$news_str = strtr($str, $ruslat);
		if ($str !== $news_str ) {
			return $news_str;
		} else {
			return false;
		}

	}

	private function uniqSynonymizerRu($text, $depth = 0) {
		$words = preg_split('/([a-яА-Я]+)/is', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
		$bwords = array();
		$bloked_words = false;
		/*
		if ($bloked_words) {
			foreach ($bloked_words as $bw) {
				$tmp = preg_split("/\s+/", mb_strtolower($bw, "UTF-8"));
				$bwords = array_merge($bwords , $tmp);
			}
		}
		*/
		$new_text = "";
		$open_tag = false;
		$last_depth = 1000;
		foreach ($words as $word) {
			if ($open_tag) {
				$new_text .= $word;
				if ($this->uniqIsOpenedTag($word)) continue;
				if ($this->uniqIsClosedTag($word)) {
					$open_tag = false;
				}
				continue;
			}
			if ($this->uniqIsOpenedTag($word)) {
				$open_tag = true;
				$new_text .= $word;
				continue;
			}
			if ($word == ' ') {$new_text .= $word; continue;}
			if (strlen($word) < 4) {$new_text .= $word; continue;}
			if (in_array(mb_strtolower($word, "UTF-8"), $bwords)) {$new_text .= $word; continue;}
			/*
			if ($ignore_stop_words) {
				if (in_array(mb_strtolower($word, "UTF-8"), $stop_words)) {
					$new_text .= $word; continue;
				}
			}
			*/
			if ($last_depth < $depth) {
				$new_text .= $word;
				$last_depth++;
				continue;
			}
			if ($synonym = $this->uniqGetSynonym($word)) {
				if ($this->uniqMyMbUcfirst($word) == $word) {
					$synonym = $this->uniqMyMbUcfirst($synonym);
				}
				$new_text .= $synonym;
				$last_depth = 0;
			}else {
				$new_text .= $word;
			}
		}
		return $new_text;
	}

	private function uniqIsOpenedTag($str) {
		return (strpos($str, '<') !== false);
	}

	private function uniqIsClosedTag($str) {
		return (strpos($str, '>') !== false);
	}

	private function uniqGetSynonym ($word){
		//global $unik_syn_table, $wpdb;
		$keyword = mb_strtolower($word, "UTF-8");
		//$sql = "SELECT syn FROM synonyms WHERE keyword='$keyword' LIMIT 1";
		//$syns = $wpdb->get_var($sql);
		$syns = App::$db->from('synonyms')->select('syn')->where('keyword = ?', $keyword)->limit(1)->fetch('syn');
		if ($syns) {
			//print_r($syns);
//			App::log('');
//			App::log($word . ' - ' . $syns);
//			App::log('');

			$words = explode(',', $syns);
			srand((float) microtime() * 10000000);
			return $words[array_rand($words)];
		} else {
			return false;
		}
	}

	private function uniqMyMbUcfirst($str, $e='UTF-8') {
		if (function_exists('mb_strtoupper')) {
			$fc = mb_strtoupper(mb_substr($str, 0, 1, $e), $e);
			return $fc.mb_substr($str, 1, mb_strlen($str, $e), $e);
		} else {
			return ($str);
		}

	}


}