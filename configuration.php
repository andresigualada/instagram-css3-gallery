<?php
	session_start();
	
	function fetchData($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}

	function fetchImg($res) {
	
		$array = array();
		
		for ($i = 0; $i < sizeof($res->data); $i++) {
			if($i == 0) {
				$prev = array(
					"img" => $res->data[$i]->images->standard_resolution->url,
					"low" => $res->data[$i]->images->low_resolution->url
				);
			}
			else {
				$prev = array(
					"img" => $res->data[$i-1]->images->standard_resolution->url,
					"low" => $res->data[$i-1]->images->low_resolution->url
				);
			}
			
			if($i == $numImgs-1) {
				$next = array(
					"img" => $res->data[$i]->images->standard_resolution->url,
					"low" => $res->data[$i]->images->low_resolution->url
				);
			}
			else {
				$next = array(
					"img" => $res->data[$i+1]->images->standard_resolution->url,
					"low" => $res->data[$i+1]->images->low_resolution->url
				);
			}
			
			
			array_push($array, 
				array(
					"next" => $next,
					"prev" => $prev,
					"img" => $res->data[$i]->images->standard_resolution->url,
					"low" => $res->data[$i]->images->low_resolution->url,
					"caption" => empty($res->data[$i]->caption->text) ? "No caption" : $res->data[$i]->caption->text,
					"time" => date("d/m/Y @ h:i:s",$res->data[$i]->created_time)
				)
			);
		}
		
		return $array;
	}
	
?>