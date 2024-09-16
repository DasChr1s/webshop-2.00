<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function index()
    {
        $imageDirectory = 'images';

        $images = glob(public_path($imageDirectory) . '/*.{jpg,png,jpeg,gif}', GLOB_BRACE);

        $images = array_map(function ($imagePath) use ($imageDirectory) {
            return asset($imageDirectory . '/' . basename($imagePath));
        }, $images);

        return view('welcome', compact('images'));
    }
}
