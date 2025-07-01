<?php

namespace App\Http\Controllers\user;

use App\Models\Flower;
use App\Models\Product;
use App\Models\ListColor;
use Illuminate\Http\Request;
use App\Models\BackgroundColor;
use App\Http\Controllers\Controller;

class KatalogController extends Controller
{
    public function index(){
         $products = Product::with('images')->get();
    $flowers = Flower::with(['variants.color'])->get(); // semua bunga dan warnanya
    $backgroundColors = BackgroundColor::with('color')->get();
    $listColors = ListColor::with('color')->get();
    $colorMap = [
    'Merah' => 'red',
    'Hijau' => 'green',
    'Biru' => 'blue',
    'Kuning' => 'yellow',
    'Hitam' => 'black',
    'Putih' => 'white',
];

    return view('user.katalog', compact('products', 'flowers', 'backgroundColors', 'listColors','colorMap'));
    }

    
}
