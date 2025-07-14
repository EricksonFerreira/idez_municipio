<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MunicipioController;

Route::get('/municipios/{uf}', [MunicipioController::class, 'index']);

