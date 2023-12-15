<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Http;

class ProductoController extends Controller
{
    public function index()
    {
        $user = Auth::user()->user;
        $rol = Auth::user()->rol;
        $products = [];
        $products = ($rol == 1) ? (Producto::all()) : (Producto::where('description', 'like', '%' . $user . '%')->get());
        return view('stock', compact('products'));
    }
}
