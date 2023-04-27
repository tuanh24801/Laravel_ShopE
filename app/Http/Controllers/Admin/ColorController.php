<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ColorFormRequest;
use App\Models\Color;

class ColorController extends Controller
{
    public function index(){
        $colors = Color::all();
        return view('admin.colors.index', compact('colors'));
    }

    public function create(){
        return view('admin.colors.create');
    }

    public function store(ColorFormRequest $request){
        $validiatedData = $request->validated();
        $validiatedData['status'] = $request->status ? 1 : 0;
        Color::create($validiatedData);
        return redirect('admin/colors')->with('message','Color Added Successfully');
    }

    public function edit(int $color_id) {
        $color = Color::findOrFail($color_id);
        return view('admin.colors.edit', compact('color'));
    }

    public function update(ColorFormRequest $request, int $color_id) {
        $validiatedData = $request->validated();
        $color = Color::findOrFail($color_id);
        $validiatedData['status'] = $request->status ? 1 : 0;
        $color->update([
            'name' => $validiatedData['name'],
            'code' => $validiatedData['code'],
            'status' => $validiatedData['status'],
        ]);

        return redirect('admin/colors')->with('message','Color Updated Successfully');
    }

    public function destroy(int $color_id) {
        $color = Color::findOrFail($color_id);
        $color->delete();
        return redirect()->back()->with('message','Color Deleted');
    }

}
