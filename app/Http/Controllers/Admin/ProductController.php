<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFormRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Color;
use App\Models\ProductColor;
use App\Models\ProductImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function create(){
        $categories = Category::all();
        $brands = Brand::all();
        $colors = Color::where('status','0')->get();
        return view('admin.products.create', compact(['categories', 'brands','colors']));
    }

    public function store(ProductFormRequest $request){
        $validateData = $request->validated();

        $category = Category::findOrFail($validateData['category_id']);

        $product = $category->products()->create([
            'category_id' => $validateData['category_id'],
            'name' => $validateData['name'],
            'slug' => Str::slug($validateData['slug']),
            'brand' => $validateData['brand'],
            'small_description' => $validateData['small_description'],
            'description' => $validateData['description'],
            'original_price' => $validateData['original_price'],
            'selling_price' => $validateData['selling_price'],
            'quantity' => $validateData['quantity'],
            'trending' => $request->trending == true ? 1 : 0,
            'status' => $request->status == true ? 1 : 0,
            'meta_title' => $validateData['meta_title'],
            'meta_keyword' => $validateData['meta_keyword'],
            'meta_description' => $validateData['meta_description'],
        ]);

        if($request->hasFile('image')){
            // $file = $request->hasFile('image');
            $uploadPath = 'uploads/products/';
            $i = 0;
            foreach ($request->file('image') as $imageFile) {
                $extention = $imageFile->getClientOriginalExtension();
                $fileName = time().$i++.'.'.$extention;
                $imageFile->move($uploadPath, $fileName);
                $finalImagePathName = $uploadPath.$fileName;

                $product->productImages()->create([
                    'product_id' => $product->id,
                    'image' => $finalImagePathName,
                ]);
            }
        }
        if($request->colors){
            foreach ($request->colors as $key => $color) {
                $product->productColors()->create([
                    'product_id' => $product->id,
                    'color_id' => $key,
                    'quantity' => $request->quantitys[$key] ?? 0
                ]);
            }
        }

        return redirect('/admin/products')->with('message','Product Added successfully');
    }

    public function edit(int $product_id){
        $product = Product::findOrFail($product_id);
        $categories = Category::all();
        $brands = Brand::all();
        $product_colors = $product->productColors->pluck('color_id')->toArray();
        $colors = Color::whereNotIn('id', $product_colors)->get();
        return view('admin.products.edit', compact('product', 'categories', 'brands', 'colors'));
    }

    public function update(ProductFormRequest $request, int $product_id){
        $validateData = $request->validated();
        $product = Product::findOrFail($product_id);
        // dd($product);
        if($product){
            $product->update([
                'category_id' => $validateData['category_id'],
                'name' => $validateData['name'],
                'slug' => Str::slug($validateData['slug']),
                'brand' => $validateData['brand'],
                'small_description' => $validateData['small_description'],
                'description' => $validateData['description'],
                'original_price' => $validateData['original_price'],
                'selling_price' => $validateData['selling_price'],
                'quantity' => $validateData['quantity'],
                'trending' => $request->trending == true ? 1 : 0,
                'status' => $request->status == true ? 1 : 0,
                'meta_title' => $validateData['meta_title'],
                'meta_keyword' => $validateData['meta_keyword'],
                'meta_description' => $validateData['meta_description'],
            ]);

            if($request->hasFile('image')){
                // $file = $request->hasFile('image');
                $uploadPath = 'uploads/products/';
                $i = 0;
                foreach ($request->file('image') as $imageFile) {
                    $extention = $imageFile->getClientOriginalExtension();
                    $fileName = time().$i++.'.'.$extention;
                    $imageFile->move($uploadPath, $fileName);
                    $finalImagePathName = $uploadPath.$fileName;

                    $product->productImages()->create([
                        'product_id' => $product->id,
                        'image' => $finalImagePathName,
                    ]);
                }
            }

            if($request->colors){
                foreach ($request->colors as $key => $color) {
                    $product->productColors()->create([
                        'product_id' => $product->id,
                        'color_id' => $key,
                        'quantity' => $request->quantitys[$key] ?? 0
                    ]);
                }
            }

            return redirect('/admin/products')->with('message','Product Updated successfully');
        }else{
            return redirect('admin/products')->with('message', 'No Such Product Id Found');
        }
    }

    public function destroyImage(int $product_image_id){
        $productImage = ProductImage::findOrFail($product_image_id);
        if(File::exists($productImage->image)){
            File::delete($productImage->image);
        }
        $productImage->delete();
        return redirect()->back()->with('message', 'Product Image Deleted');
    }

    public function destroy(int $product_id){
        $product = Product::findOrFail($product_id);
        if($product->productImages()){
            foreach($product->productImages() as $image){
                if(File::exists($image->image)){
                    File::delete($image->image);
                }
            }
        }
        $product->delete();
        return redirect()->back()->with('message', 'Product Deleted with all its images');
    }

    public function updateProColorQty(Request $request, $product_color_id){
        $productColorData = Product::findOrFail($request->product_id)->productColors()->where('id', $product_color_id)->first();
        $productColorData->update([
            'quantity' => $request->qty
        ]);
        return response()->json(['message' => 'Product Color Quantity Updated']);
    }

    public function deleteProColorQty(Request $request, $product_color_id){
        $productColor = ProductColor::findOrFail($product_color_id);
        $productColor->delete();

    }
}
