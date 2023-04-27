<?php

namespace App\Http\Livewire\Admin\Brand;

use Livewire\Component;
use App\Models\Brand;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $name,$slug,$status, $brand_id;

    protected $rules = [
        'name' => 'required | string',
        'slug' => 'required | string',
        'status' => 'nullable'
    ];

    protected $paginationTheme = 'bootstrap';

    public function resetInput(){
        $this->name = null;
        $this->slug = null;
        $this->status = null;
        $this->brand_id = null;
    }

    public function storeBrand(){
        $validateData = $this->validate();
        Brand::create([
            'name' => $this->name,
            'slug' => Str::slug($this->slug),
            'status' => $this->status == true ? '1' : '0',
        ]);
        session()->flash('message','Brand Created');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function closeModal(){
        $this->resetInput();
    }

    public function openModal(){
        $this->resetInput();
    }


    public function editBrand(int $brand_id){
        $this->brand_id = $brand_id;
        $brand = Brand::findOrFail($brand_id);
        $this->name = $brand->name;
        $this->slug = $brand->slug;
        $this->status = $brand->status;

    }

    public function updateBrand(){
        $validateData = $this->validate();
        Brand::findOrFail($this->brand_id)->update([
            'name' => $this->name,
            'slug' => Str::slug($this->slug),
            'status' => $this->status == true ? '1' : '0',
        ]);
        session()->flash('message','Brand Updated');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }


    public function deleteBrand(int $brand_id){
        $this->brand_id = $brand_id;
    }

    public function destroyBrand(){
        Brand::findOrFail($this->brand_id)->delete();
        session()->flash('message','Brand Deleted');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function render()
    {
        $brands = Brand::orderBy('id', "DESC")->paginate(7);
        return view('livewire.admin.brand.index', ['brands' => $brands])
                                ->extends('layouts.admin')
                                ->section('content');
    }
}
