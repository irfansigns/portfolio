<?php

namespace App\Http\Controllers;
use Image;
use Inertia\Inertia;
use App\Models\Pimage;
use App\Models\Category;
use App\Models\Odetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Admin;

class AdminController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return Inertia::render('AdminDash', [
            'products' => $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->pname,
                    'price'=> $product->price,
                    'quantity'=> $product->qty,
                    'ipath' => $product->i_path,
                    'edit_url' => route('product.watch',$product->id),
                    'detail_url' => route('products.show',$product->id),
                    'add_cart' => route('product.addCart',$product->id)
                ];
            }),

        ]);
    }

    public function login(Request $request){
        $credentials = $request->only('email','password');

        if(Auth::guard('admin')->attempt($credentials, $request->remember)){
            $user = Admin::where('email',$request->email)->first();
            Auth::guard('admin')->login($user);
            return redirect()->route('admin');
        }
        return redirect()->route('admin.login');
    }

    public function showLogin()
    {
        return Inertia::render('admin/AdminLogin');
    }
}
