<?php

namespace Database\Factories;

class FactoryHelper {
	
	public static function getFakeHTMLText($faker, $countParagraphs){
		$paragraphs = $faker->paragraphs($countParagraphs);
		$text = '';
		foreach ($paragraphs as $p) { //генерация блоков текста
			$text .= "<p>$p</p>";
		}
		return $text;
	 }
}