<?php
namespace App\Http\Controllers;
use App\Models\Pimage;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use Auth;
use Mail;
use App\Mail\ForgetMail;

class ProductController extends Controller
{
    public function ProductList(Request $request){
        $productlist = Product::where('featured','true')->get();
        
        // try{
            
        //     Mail::to('irfansigns@gmail.com')->send(new ForgetMail("The Token"));

        //     return response([
        //         'message' => 'Mail Sent'
        //     ],200);

        // }catch(Exception $exception){
        //     return response([
        //         'message' => $exception->getMessage()
        //     ],400);
        // }
        return $productlist;
    }

    public function ProductCat(Request $request){
        $productlist = Product::all();
        $catList = Category::all();

        return $shopDet = ['products' => $productlist ,'categories' => $catList];
    }

    public function ProductDetails(Request $request){

        $id = $request->id;
        // $productDetails = Product::all()->where('id',$id);
        // $productDetails = Product::find($id)->category;//select * from category where id = product_id of this specfic product
        $productDetails = Product::find($id);
        $category = Category::where('id', $id)->first()->cname;//will return single value
        // $category = Category::where('id', $id)->pluck('cname')->all(); will return in array
        $pimage = Pimage::all()->where('product_id', $id);
        // $pimage = Pimage::all();
        $images = array();
        $pDetail = array();
        foreach($pimage as $image){
            array_push($images,$image->name);
        }

        // foreach($productDetails as $detail){
        //     array_push($pDetail,$detail);
        // }
        
        if($file = fopen(base_path().'/storage/app/'.$id.'.txt','r')){
            // dd('fileopened');
           $desc = fread($file,"500");
           fclose($file);
        } else { $desc = "No Description Found"; }

        $item=[
            'productDetail'=>$productDetails,
            'imageDetail'=>$images,
            'desc' => $desc,
            'category'=> $category,
            'catId' => $productDetails->category_id
        ];

        return $item;
    } // End Method

    public function relatedProducts(Request $request){
        $rProducts = Product::where('category_id',$request->id)->get();
        return $rProducts;
    }
    
    public function storeOrder(Request $request){
        // print_r($request->all());
        // print_r($request->guest);
        // $nuser = $request->guest;
        // print $nuser['gsname'];
        $order = $request->cartData;

        if($request->guest){
            try{

            $nuser = $request->guest;
            $user = User::create([
                'name' => $nuser['gsname'],
                'email' => $nuser['gsmail'],
                'contact' => $nuser['gscontact'],
                'address' => $nuser['gsaddress'],
                'password' => \bcrypt('password') 
            ]);

            

            }catch(Exception $exception){
                return response([
                    'message' => $exception->getMessage()
                ],400);
            } 
        }

        $ord = Order::create([
            'payment_id' => 'COD',
            'user_id'=> $user->id
        ]);
        $cartlist = array();
        foreach($order as $orders){
            // return "AAAA";
            $pqty = $orders['qty'];
            $id = $orders['id'];
            // array_push($cartlist,$id);
            for ($i = 1; $i <= $pqty; $i++) {
                $ord->product()->attach($id);
            }
            Product::find($id)->decrement('qty', $pqty);
        }

        

        // $pram = $request->path(); returns route from where request is received
        // $cartlist = array();
        // foreach($order as $orders){
        //     array_push($cartlist,$orders['price']);
        // }
        // return $cartlist;
        // return $pram;
        // array_push($cartlist,$order[0]);
        // print_r($order);
        return "Record Entered Successfully";
        // return Auth::user();
    }

    public function shopCategory($id){
        $category = Category::all();
        $products = Product::where('category_id',$id)->get();
        // return view('shop.shopmain',['products'=>$products,'category'=>$category]);
        return $products;
    }
}
