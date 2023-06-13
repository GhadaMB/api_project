<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

use App\Models\Product;
use App\Models\User;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try{
            $products = Product::all();

            return response()->json([
                'Products' => $products
            ]);

        } catch (\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try{
            $data = Validator::make($request->all(),[
                'name' => 'required|string',
                'image' => 'required|mimes:jpeg,png,jpg,gif',
                'description' => 'required',
                'user_id' => 'exists:users,id',
            ]);

            if($data->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'error' => $data->errors(),
                ], 401);
            }
            $product = new Product();

            $product->name = $request->name;
            $product->description = $request->description;
            $product->user_id = $request->user_id;

            if($request->hasFile('image'))
            {
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = time().'.'.$ext;
                $file->move('assets/products/',$filename);
                $product->image = $filename;
            }

            $product->save();

            return response()->json([
                'status' => true,
                'message' => 'Product Created Successfully',
                'Product' => $product,
            ], 200);

        } catch (\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try{
            $product = Product::findOrFail($id);

            if(is_null($product)){
                return response()->json([
                    'status' => false,
                    'message' => 'Product not found'
                ]);
            }

            return response()->json([
                'status' => true,
                'Product' => $product
            ]);
        } catch (\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\jsonResponse
     */
    public function update(Request $request, $id)
    {
        try{
            $data = Validator::make($request->all(),[
                'name' => 'required|string',
                'image' => 'required|mimes:jpeg,png,jpg,gif',
                'description' => 'required',
                'user_id' => 'exists:users,id',
            ]);

            if($data->fails()){
                return response()->json([
                    'status' => false,
                    'message' => $data->errors()
                ]);
            }

            $product = Product::findOrFail($id);

            $product->name = $request->name;
            $product->description = $request->description;
            $product->user_id = $request->user_id;

            if($request->hasFile('image'))
            {
                $path = 'assets/products/'.$product->image;
                if(File::exists($path))
                {
                    File::delete($path);
                }
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = time().'.'.$ext;
                $file->move('assets/products/',$filename);
                $product->image = $filename;
            }

            $product->save();

            return response()->json([
                'status' => true,
                'messaage' => 'Product Updated Successfully'
            ]);

        } catch (\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\jsonResponse
     */
    public function destroy($id)
    {
        try{
            $product = Product::findOrFail($id);
            if($product->image)
            {
                $path = 'assets/products/'.$product->image;
                if(File::exists($path))
                {
                    File::delete($path);
                }
            }
            $product->delete();

            return response()->json([
                'status' => true,
                'message'  => 'Product deleted successfully'
            ]);

        } catch (\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    // Assign Product to User
    public function assignToUser(Request $request, $id){
        try{
            $data = Validator::make($request->all(),[
                'user_id' => 'exists:users,id'
            ]);

            if($data->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'The user is not exist'
                ]);
            }

            $product = Product::findOrFail($id);
            $product->update(['user_id',$request->user_id]);

            return response()->json([
               'status' => true,
               'message' => 'Product assigned to user successfully'
            ]);

        } catch (\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    // Get User Products
    public function getUserProducts($user_id){
        try{
            $products = Product::query()->where('user_id',$user_id)->get();

            if(count($products) == 0){
                return response()->json([
                    'status' => false,
                    'message' => 'There is no product assigned to the user'
                ]);
            }

            return response()->json([
                'status' => true,
                'user' => $user_id,
                'products' => $products
            ]);

        } catch (\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
