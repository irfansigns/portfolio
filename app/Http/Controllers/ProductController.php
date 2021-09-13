<?php

namespace App\Http\Controllers;
use Image;
use Session;
use App\Models\Cart;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Order;
use App\Http\Requests;
use App\Models\Pimage;
use App\Models\Product;
use App\Models\Category;
use App\Models\Odetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $products = Category::find(1)->products;
        $products = Product::all();
        return Inertia::render('Welcome', [
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

        //return response()->json(['products' =>$fproducts , 'response' => 200]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $category = Category::all();
        return Inertia::render('NewApp/Product', [
            'category' => $category->map(function ($category) {
                return [
                    'id' => $category->id,
                    'catname' => $category->cname,
                ];
            }),
            'product'=> new Product,
            'submitUrl'=> '/products'
            
        ]);
    }

    public function watch(Product $product)
    {
        if($file = fopen(base_path().'/storage/app/'.$product->id.'.txt','r')){
            // dd('fileopened');
           $desc = fread($file,"500");
           fclose($file);

        } else { $desc = null; }
        $category = Category::all();
        return Inertia::render('NewApp/Product', [
            'category' => $category->map(function ($category) {
                return [
                    'id' => $category->id,
                    'catname' => $category->cname,
                ];
            }),
            'description'=>$desc,
            'product'=>$product,
            'submitUrl'=>'/products/'.$product->id,
            'method'=>'PUT'
        ]);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request ,[
            'name' => ['required'],
            'quantity' => ['required' , 'integer'],
            'price' => 'required|numeric|gt:4500',
            'category' =>['required'],
            'thumbnail' => ['image'],
        ]);    
        $product = new Product();

        if($request->hasFile('thumbnail')){
            // $thumbnail = $request->thumbnail->store('img','public');  New Method
            $allowedfileExtension=['pdf','jpg','png'];
            $mfile = $request->file('thumbnail');
            $mfilename = $mfile->getClientOriginalName();
            $mextension = $mfile->getClientOriginalExtension();
            $check=in_array($mextension,$allowedfileExtension);

            if($check){
                $location = public_path('img/'.$mfilename);
                Image::make($mfile)->save($location);
            }
        }

        
        
        // Product::create([
        //     'pname'=>$request->name,
        //     'qty'=>$request->quantity,
        //     'price'=>$request->price,
        //     'category_id'=>$request->category,
        //     'i_path' => $mfilename,
        // ]);
        $product->pname = $request->name;
        $product->qty = $request->quantity;
        $product->price = $request->price;
        $product->category_id = $request->category;
        $product->i_path = $mfilename;

        $product->save();
        Storage::disk('local')->put($product->id.'.txt', $request->description);

        if($request->IoFiles){
            $files = $request->IoFiles;
            foreach($files as $file){
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $location = public_path('img\\'.$filename);
                Image::make($file)->save($location);
                $check=in_array($extension,$allowedfileExtension);
                if($check){
                    $pimage = new Pimage;
                    $pimage->name = $filename;
                    $pimage->product()->associate($product);
                    $pimage->save();
                }
            }
        }
        // return redirect()->route('products.index');
        return "New Product Saved Successfully";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Storage::disk('local')->put('file.txt', 'Your content here');
        // This will be stored in storage/app/

        //Reading a txt file
        // $myfile = fopen( $id.'.txt', "r") or die("Unable to open file!");
        if($file = fopen(base_path().'/storage/app/'.$id.'.txt','r')){
            // dd('fileopened');
           $desc = fread($file,"500");
           fclose($file);

        }
        //dd($desc);
        // echo fread($myfile,filesize("webdictionary.txt"));
        // fclose($myfile); 

        $product = Product::find($id);
        // $pimage = DB::table('pimages')->where('product_id', $id)->count();
        // $pimage = DB::table('pimages')->count();
        $pimage = Pimage::all()->where('product_id', $id);
        // if(!$pimage){
        //     dd('no product found');
        // }
        // else{
        //     dd(count($pimage));        
        // }
        return Inertia::render('Detail', [
                'id' => $product->id,
                'name' => $product->pname,
                'price'=> $product->price,
                'quantity'=> $product->qty,
                'ipath' => $product->i_path,
                'add_cart' => route('product.addCart',$product->id),
                'detimage' => $pimage->map(function ($dimg) {
                    return [
                        'name' => $dimg->name,
                    ];
                }),
                'description'=>$desc,
            ]
         );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return Inertia::render('Product', [
                'id' => $product->id,
                'name' => $product->pname,
                'price'=> $product->price,
                'quantity'=> $product->qty,
                'ipath' => $product->i_path
            ]
         );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request ,[
            'name' => ['required'],
            'quantity' => ['required' , 'integer'],
            // 'price' => 'required|numeric|gt:4500',
            'price' => 'required|numeric|gt:4500',
            'category' =>['required'],
            

            
        ]);    
        $product = Product::find($id);
        
        if($request->hasFile('thumbnail')){
            // $thumbnail = $request->thumbnail->store('img','public');  New Method
            $allowedfileExtension=['pdf','jpg','png'];
            $mfile = $request->file('thumbnail');
            $mfilename = $mfile->getClientOriginalName();
            $mextension = $mfile->getClientOriginalExtension();
            $check=in_array($mextension,$allowedfileExtension);

            if($check){
                $location = public_path('img/'.$mfilename);
                Image::make($mfile)->save($location);
            }
            $product->i_path = $mfilename;
        }
        
        // Product::create([
        //     'pname'=>$request->name,
        //     'qty'=>$request->quantity,
        //     'price'=>$request->price,
        //     'category_id'=>$request->category,
        //     'i_path' => $mfilename,
        // ]);
        $product->pname = $request->name;
        $product->qty = $request->quantity;
        $product->price = $request->price;
        $product->category_id = $request->category;
        
        
        

        $product->save();
        Storage::disk('local')->put($product->id.'.txt', $request->description);    
        if($request->IoFiles){
            $files = $request->IoFiles;
            foreach($files as $file){
                $filename = $file->getClientOriginalName();
                $allowedfileExtension=['pdf','jpg','png'];
                $extension = $file->getClientOriginalExtension();
                $location = public_path('img\\'.$filename);
                Image::make($file)->save($location);
                $check=in_array($extension,$allowedfileExtension);
                if($check){
                    $pimage = new Pimage;
                    $pimage->name = $filename;
                    $pimage->product()->associate($product);
                    $pimage->save();
                }
            }
        }
        return redirect()->route('products.index');
        // return "New Product Saved Successfully";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
    }

    public function delProduct(Request $request,$id)
    {
        $product = Product::find($id);
        $product->delete();
        return $id;
    }

    public function addToCart(Request $request,$id){
        $product = Product::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product,$product->id);
        $temp = $cart->totalqty;
    
        
        $request->session()->put('cart',$cart);
        return $temp;
    }

    public function lessOne($id){
        $oldCart = Session::has('cart')? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->reduceByOne($id);

        Session::put('cart',$cart);
        return redirect()->back();
    }

    public function showCart(){
        return Inertia::render('Cart', [
            'id' => "5000",
            'name' => "Irfan Asim", 
            'order_confirm' => route('product.sorder'),
            // 'add_One' => route('product.addOne')

        ]);
        
    }

    public function storeOrder(){
        $oldCart = Session::has('cart')? Session::get('cart'):null;
        $cart = new Cart($oldCart);
        $product_names = array();
        $temp = $cart->items;
        $keys = array_keys($temp);//[12 10 11]

        $order = Order::create([
            'payment_id' => 'COD',
            'user_id'=> Auth::user()->id
        ]);

        // $order->product()->attach($keys);
        // Session::forget('key');

        foreach($temp as $orderItem){
            $pqty = $orderItem['qty'];
            // dd($pqty);
            // $pname = $orderItem['item']['pname'];
            $id = $orderItem['item']['id'];
            for ($i = 1; $i <= $pqty; $i++) {
                $order->product()->attach($id);
            }
            // $price = $orderItem['price'];
            Product::find($id)->decrement('qty', $pqty);
            // $order = new Order;
            // $order->save();
            // $od = new Odetail;
            // $od->product_id = $id;
            // $od->qty = $pqty;
            // $od->order()->associate($order);
            // $od->save();
        }
        Session::forget('cart');

        // foreach($keys as $ki){
        //     $unit = 10;
        //     Product::where('id', $ki)->update(array('qty' => $unit));
        //     Product::where('id', $ki)->update(array('qty' => (DB::raw('qty - 1')) ));
        // }
        return redirect()->route('basePath')->with('message', 'Thanks for placing order. Please check your email for confirmation!');
    }

    public function testEffect(){
        return Inertia::render('TestComponent', [
            'id' => "25",
            'name' => "3 Piece Embroidered",
            'price'=> "12000",
        ]);
    }

    public function description($id){
        

        // Storage::disk('local')->put('file.txt', 'Your content here');
        // This will be stored in storage/app/

        //Reading a txt file
        // $myfile = fopen("webdictionary.txt", "r") or die("Unable to open file!");
        // echo fread($myfile,filesize("webdictionary.txt"));
        // fclose($myfile);      
        
        
        return "about product";
    }

    public function shop(){
        $products = Product::all();
        $category = Category::all();
        
        return view('shop.shopmain',['products'=>$products,'category'=>$category]);
    }

    public function shopCategory($id){
        $category = Category::all();
        $products = Product::where('category_id',$id)->get();
        return view('shop.shopmain',['products'=>$products,'category'=>$category]);
    }

    public function testFunction($id){
        return "OKKK Its ".$id;
    }

    public function updateUser(Request $request){
        $request->validate([
            'name' =>'required|min:4|string|max:255',
            'email'=>'required|email|string|max:255',
            'contact' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
        ]);
        $user =Auth::user();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->contact = $request['contact'];
        $user->address = $request['address'];
        $user->save();
        // return back()->with('message','Profile Updated');
        return response()->json(['name'=>$request->name, 'status' => 200]);
        // return "OK";
    }
}
