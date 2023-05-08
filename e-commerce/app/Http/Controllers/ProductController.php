<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Category;
use App\Models\sub_Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function add_product(Request $request){

        $validator =validator::make($request->all(),[
         'product_name' => 'required|string|between:2,100',
         'price_product'=>'required|numeric',
         'category_name'=>'required|string',
         'sub_category'=>'required|string',
//
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 422);
        }

        $photo = $request->image;
        $newphoto = time() . '.' . $request->image->getClientOriginalExtension();
        $request->image->move(public_path('uploads/photo'), $newphoto);
        // $consults = Consult::all();
        // $isExist = false;
        // foreach ($consults as $consult) {
        //     if ($consult->consult == $request->consult) {
        //         $consultId = $consult->id;
        //         $expert = Expert::create([
        //             'image' => '/uploads/photo/' . $newphoto,
        //             'cost' => $request->cost,
        //             'consult_id' => $consultId,
        //             'user_id' => $user->id,
        //         ]);
        //         $isExist = true;
        //     }
        // }
        // if ($isExist == false) {
        //     $consult = Consult::create([
        //         'consult' => $request->consult,
        //     ]);
        //     $expert = Expert::create([
        //         'image' => '/uploads/photo/' . $newphoto,
        //         'cost' => $request->cost,
        //         'consult_id' => $consult->id,
        //         'user_id' => $user->id,
        //     ]);
        // }

        #############################################################
        $user = User::where('id',Auth::id())->firstOrFail();
        $categories=Category::all();
        $categ_isExist = false;
        //return $categories;
        $sub_categories=sub_Category::all();
        $sub_isExist=false;
        //return $sub_categories;
        foreach($categories as $category){
           // return $category;
            if($category->category_name==$request->category_name){
                $old_categoryId=$category->id;
                foreach($sub_categories as $sub_category){
                    if($sub_category->sub_category==$request->sub_category){
                        $old_sub_category_id=$sub_category->id;
                         $product=Product::create([
                            'product_name'=>$request->product_name,
                            'price_product'=>$request->price_product,
                            'user_id'=>$user->id,
                            'subcategory_id'=>$old_sub_category_id,
                            'image' => '/uploads/photo/' . $newphoto,
                         ]);

                         $sub_isExist=true;
                    }}

                    //if( $sub_isExist=false){
                        $new_sub_category=sub_Category::create([
                            'sub_category'=>$request->sub_category,
                            'category_id'=>$old_categoryId,
                        ]);
                       // return $new_sub_category;
                        $product=Product::create([
                            'product_name'=>$request->product_name,
                            'price_product'=>$request->price_product,
                            'user_id'=> $user->id,
                            'subcategory_id'=>$new_sub_category->id,
                            'image' => '/uploads/photo/' . $newphoto,
                         ]);
                         return 'done';
                  //  }

               // }
                $categ_isExist = true;
            }

           // $categ_isExist = true;

        }
        #################################################################
        if($categ_isExist==false){
            $new_category=Category::create([
                'category_name'=>$request->category_name,
            ]);
            $new_category_id=$new_category->id;
            $new_sub_category=sub_Category::create([
                'sub_category'=>$request->sub_category,
                'category_id'=> $new_category_id,
            ]);
            //$user=User::where('id', Auth::id())->firstOrFail();
            //$user = User::where('id',Auth::id())->firstOrFail();
            $product=Product::create([
                'product_name'=>$request->product_name,
                'price_product'=>$request->price_product,
                'user_id'=>$user->id,
                'subcategory_id'=>$new_sub_category->id,
                'image' => '/uploads/photo/' . $newphoto,
             ]);

             return response()->json([


                'message' => 'success store',
             ]);

        }
    }


    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
