<?php

use Illuminate\Support\Facades\Route;
use Task\Package\Helpers\Movie;

Route::prefix('/api')->group(function () {
    Route::prefix('/movies')->group(function () {
        Route::get('/moviesdatabase', function () {
            return Movie::moviesdatabase();
        });

        Route::get('/advanced-movie-search', function () {
            return Movie::advanced_movie_search();
        });

        Route::get('/all', function () {
            return array_merge(Movie::moviesdatabase(), Movie::advanced_movie_search());
        });
    });
});
