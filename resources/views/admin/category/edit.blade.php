@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                @if (session('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif
                <div class="card-header">
                    <h4>
                        Edit category
                        <a href="{{ route('admin.category') }}" class="btn btn-sm btn-danger float-end text-white">BACK</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/category/'.$category->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="">Name</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') ? old('name') :  $category->name }}"/>
                                @error('name') <small class="text text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Slug</label>
                                <input type="text" class="form-control" name="slug" value="{{ old('slug') ? old('slug') :  $category->slug }}"/>
                                @error('slug') <small class="text text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Description</label>
                                <textarea name="description" class="form-control" rows='3'>{{ old('description') ? old('description') :  $category->description }}</textarea>
                                @error('description') <small class="text text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Image</label>
                                <input type="file" class="form-control" name="image" value="{{ old('image') }}"/>
                                <img src="{{ asset('/uploads/category/'.$category->image) }}" width="100px" alt="">
                                @error('image') <small class="text text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Status</label><br>
                                <input type="checkbox" name="status" {{ $category->status == '1' ? 'checked' : ''  }}/>
                            </div>
                            <div class="col-md-12 mb-3">
                                <h4>SEO Tag</h4>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Meta Title</label>
                                <input type="text" class="form-control" name="meta_title" value="{{ old('meta_title') ? old('meta_title') :  $category->meta_title }}"/>
                                @error('meta_title') <small class="text text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Meta Keyword</label>
                                <textarea name="meta_keyword" class="form-control" rows='3'>{{ old('meta_keyword') ? old('meta_keyword') :  $category->meta_keyword }}</textarea>
                                @error('meta_keyword') <small class="text text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Meta Description</label>
                                <textarea name="meta_description" class="form-control" rows='3'>{{ old('meta_description') ? old('meta_description') :  $category->meta_description }}</textarea>
                                @error('meta_description') <small class="text text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                               <button class="btn btn-primary float-end" type="submit">Save</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
