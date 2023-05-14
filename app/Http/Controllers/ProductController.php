<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Category;
use App\Models\sub_Category;
use App\Models\Product;
use App\Models\Image;
use App\Http\Controllers\ImageController;
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
        // 'images'=>'required|file',
          ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 422);
        }

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
                            //'image' => '/uploads/photo/' . $newphoto,
                         ]);

                         $images=$request->list_images;
                         $input=[];
                         $i1=0;$i2=0;
                         foreach ($images as $image2) {
                             $image1=$image2['image'];
                             $image_name=time().$image1->getClientOriginalName();
                             $image1->move(public_path('upload'),$image_name);
                             $path="public/upload/$image_name";
                             $input[$i1]=$path;

                             $image=Image::Create([
                                 'image'=>$input[$i1],
                                 'Product_id'=>$product->id,

                             ]);
                             $i1++;

                         }


                         $sub_isExist=true;
                         return response()->json([
                            'message' => 'success store',
                         ]);
                    }}

                   // if( $sub_isExist=false){
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
                            //'image' => '/uploads/photo/' . $newphoto,
                         ]);

                         $images=$request->list_images;

                         $images=$request->list_images;
                         $input=[];
                         $i1=0;$i2=0;
                         foreach ($images as $image2) {
                             $image1=$image2['image'];
                             $image_name=time().$image1->getClientOriginalName();
                             $image1->move(public_path('upload'),$image_name);
                             $path="public/upload/$image_name";
                             $input[$i1]=$path;

                             $image=Image::Create([
                                 'image'=>$input[$i1],
                                 'Product_id'=>$product->id,

                             ]);
                             $i1++;

                         }
                         return response()->json([
                            'message' => 'success store',
                         ]);
                      // }

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
            $product=Product::create([
                'product_name'=>$request->product_name,
                'price_product'=>$request->price_product,
                'user_id'=>$user->id,
                'subcategory_id'=>$new_sub_category->id,
                //'image' => '/uploads/photo/' . $newphoto,
             ]);
             $images=$request->list_images;
             $input=[];
             $i1=0;$i2=0;
             foreach ($images as $image2) {
                 $image1=$image2['image'];
                 $image_name=time().$image1->getClientOriginalName();
                 $image1->move(public_path('upload'),$image_name);
                 $path="public/upload/$image_name";
                 $input[$i1]=$path;

                 $image=Image::Create([
                     'image'=>$input[$i1],
                     'Product_id'=>$product->id,

                 ]);
                 $i1++;

             }
             return response()->json([
                'message' => 'success store',
             ]);

        }
    }


    public function getAllProduct()
    {
        $product=Product::all();
         return response()->json($product);
    }

    /**
     * Display the specified resource.
     */
    public function searshProduct($name)
    {
        $product=Product::where('product_name',$name)->get();
        return response()->json($product);
        //with('subcategory.category','subcategory.products')->
    }

    public function product_Id_searsh($productId)
    {
        $product = Product::where('id',$productId)->get();
        return response()->json($product);
        //with('product.image')->
    }

    public function UpdateProduct(Request $request,$productId)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|between:2,100',
            'price_product'=>'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $data= Product::find($productId)->update([
            'product_name' => $request->product_name,
            'price_product'=>$request->price_product,

        ]);
        $images=$request->list_images;
        $input=[];
        $i1=0;$i2=0;
        foreach ($images as $image2) {
            $image1=$image2['image'];
            $image_name=time().$image1->getClientOriginalName();
            $image1->move(public_path('upload'),$image_name);
            $path="public/upload/$image_name";
            $input[$i1]=$path;

            $data= Product::find($productId)->Image()->update([
                'image'=>$input[$i1],
                'Product_id'=>$productId,

            ]);
            $i1++;

        }
        return response()->json(['message'=> 'done']);

    }
    public function deleteProduct($productId)
    {
        $data =Product::find($productId)->Image()->delete();
        $data =Product::find($productId)->delete();
        return response()->json(['message' => 'true']);

    }
    public function getImage($productId){
    $image=Product::find($productId)->Image;
    return response()->json($image);
    }

}
