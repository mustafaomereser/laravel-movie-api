<?php

namespace Task\Package\Helpers;

use Illuminate\Support\Facades\Request;

class Movie
{
    static $api_key = "8e5e8a2691msh6dd11c2068c03d9p11ff0ejsnac8be144ced4";

    public static function request($type, $query = "")
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://$type.p.rapidapi.com$query",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: $type.p.rapidapi.com",
                "X-RapidAPI-Key: " . self::$api_key
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) throw new \Exception($err);
        return json_decode($response, true);
    }

    public static function moviesdatabase()
    {
        $title    = Request::validate(['title' => ['required']])['title'];
        $movies   = Movie::request("moviesdatabase", "/titles/search/title/$title?exact=true&titleType=movie")['results'];
        $response = [];

        foreach ($movies as $movie) $response[] = [
            'title' => $movie['titleText']['text'],
            'image' => $movie['primaryImage'],
            'year'  => $movie['releaseYear']['year']
        ];

        return $response;
    }

    public static function advanced_movie_search()
    {
        $title    = Request::validate(['title' => ['required']])['title'];
        $movies   = Movie::request("advanced-movie-search", "/search/movie?query=$title")['results'];
        $response = [];

        foreach ($movies as $movie) $response[] = [
            'title' => $movie['original_title'],
            'image' => $movie['backdrop_path'],
            'year'  => date('Y', strtotime($movie['release_date']))
        ];

        return $response;
    }
}
