<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use DataTables;
use App\Models\Product;
use App\Models\User;

class ProductController extends Controller
{
    public function homePage() {
        try{
            return view('admin.index');
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }
    public function returnAjaxData()
    {
        $products = Product::get();
        return DataTables::of($products)
            ->addIndexColumn()
            ->editColumn('name', function($item) {
                return $item->name;
            })
            ->editColumn('description', function ($item) {
                return $item->description;
            })
            ->editColumn('image', function($item) {
                return $item->image;
            })
            ->addColumn('user', function($item) {
                if($item->user){
                    return $item->user->name;
                } else {
                    return 'null';
                }

            })
            ->addColumn('action', function($data){
                $button = '
                <form action="'.route('products.destroy', $data->id ).'" method="POST">
                    <a href="'.route('products.edit',$data->id).'" class="btn btn-primary btn-sm">Edit</a>

                    '.csrf_field().'
                    '.method_field("DELETE").'
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                ';


                return $button;
            })
            ->rawColumns(['name','description', 'image','user','action'])
            ->make(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index()
    {
        try{
            $products = Product::all();

            return view('admin.product.index',compact('products'));

        } catch (\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return string
     */
    public function create()
    {
        try {
            $users = User::query()->where('role', '!=', '1')->get();

            return view('admin.product.add',compact('users'));
        } catch (\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
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
                return redirect()->back()
                    ->with('error', $data->errors());
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

            return redirect()->route('products.index')
                ->with('success','Product created successfully.');

        } catch (\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return string
     */
    public function show($id)
    {
        try{
            $product = Product::findOrFail($id);

            if(is_null($product)){
                return redirect()->back()
                    ->with('error', 'Product not found');
            }

            return view('admin.product.edit',compact('product'));

        } catch (\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return string
     */
    public function edit($id)
    {
        try{
            $product = Product::findOrFail($id);

            $users = User::query()->where('role', '!=', '1')->get();

            return view('admin.product.edit',compact('product', 'users'));

        } catch (\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return string
     */
    public function update(Request $request, $id)
    {
        try{
            $data = Validator::make($request->all(),[
                'name' => 'required|string',
                'image' => 'mimes:jpeg,png,jpg,gif',
                'description' => 'required',
                'user_id' => 'exists:users,id',
            ]);

            if($data->fails()){
                return redirect()->back()
                    ->with('error', $data->errors());
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
            return redirect()->route('products.index')
                ->with('success','Product updated successfully');

        } catch (\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return string
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

            return redirect()->route('products.index')
                ->with('success','Product deleted successfully');

        } catch (\Exception $e){
            return $e->getMessage();
        }
    }
}
