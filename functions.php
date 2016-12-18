<?php

	function pre($var){
		echo '<pre>', print_r($var,1), '</pre>';
	}

	function vre($var){
		echo '<pre>';
		var_dump($var);
		echo '</pre>';
	}