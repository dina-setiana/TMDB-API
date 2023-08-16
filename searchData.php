<?php

$key = ''; // todo use env


function getSearchResult($key, $title, $page, $year, $adult)
{
	$url = 'https://api.themoviedb.org/3/search/movie?api_key='.$key.'&language=en-US&query='.$title.'&page='.$page.'&include_adult='.$adult.'&year='.$year;

	$content = file_get_contents($url);
	$json = json_decode($content);

	return $json;
}

function get_http_response_code($url) {
    $headers = get_headers($url);
    return substr($headers[0], 9, 3);
}

function getSearchDetail($key, $id)
{
	$url = 'https://api.themoviedb.org/3/movie/'.$id.'?api_key='.$key.'&language=en-US&append_to_response=credits';

	if(get_http_response_code($url) == "404")
		return false;

	$content = file_get_contents($url, true);
	$json = json_decode($content);

	return $json;
}



?>
