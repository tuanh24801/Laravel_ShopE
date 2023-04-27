<?php

namespace App\Http\Livewire\Admin\Category;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Illuminate\Support\Facades\File;
use PhpParser\Node\Expr\FuncCall;
use App\Models\ProductImage;

class Index extends Component
{
    use WithPagination;
    // protected $paginationTheme = 'bootstrap';
    protected $paginationTheme = 'bootstrap';

    public $category_id;

    public function deleteCategory($category_id){
        // dd($category_id);
        $this->category_id = $category_id;
        // dd($category_id) ;

    }

    public function destroyCategory(){
        $category = Category::find($this->category_id);
        $images = $category->productImages;
        foreach ($images as $image) {
            if(File::exists($image->image)){
                File::delete($image->image);
            }
        }
        $path = 'uploads/category/'.$category->image;
        if(File::exists($path)){
            File::delete($path);
        }
        $category->delete();
        session()->flash('message','Category Deleted');
        $this->dispatchBrowserEvent('close-modal');
    }


    public function render()
    {
        $categories = Category::orderBy('id', 'DESC')->paginate(7);

        return view('livewire.admin.category.index', ['categories' => $categories]);
    }
}
