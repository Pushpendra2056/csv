<?php

// helper file
if(!function_exists('add')){
	function add($fval,$sval){
		return $fval+$sval;
	}
}

if(!function_exists('re')){
	function re($data){
		return $data['email'];
	}
}