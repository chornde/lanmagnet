<?php

	function pre($var){
		echo '<pre>', print_r($var,1), '</pre>';
	}

	function vre($var){
		echo '<pre>';
		var_dump($var);
		echo '</pre>';
	}
	
	function compose($map, $data, $arrayofobjects = true){
		$results = [];
		foreach($data as $ridx => $row){
			$result = []; // init fresh keymap
			foreach($map as $kidx => $key){
				$result[$key] = (isset($row[$kidx])) ? $row[$kidx] : null ; // preset with null values on inexistent keys
			}
			$results[$ridx] = ($arrayofobjects) ? (object)$result : $result ;
		}
		return $results;
	}
	
	function foosort(&$array, $column, $direction = true){
		usort($array, function($a, $b) use($column) {
			return $a[$column] <=> $b[$column] ;
		});
	}
	
	function fooflag(&$array){
		array_walk($array, function(&$item){
			$item[] = (new DateTime($item[3])) >= (new DateTime()) ? true : false ;
			$item[] = (new DateTime($item[3]))->format('Y') ;
		});
	}
	
	function foogroup($array){
		foreach($array as $item){}
	}