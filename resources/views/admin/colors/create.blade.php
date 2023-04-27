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
                        Add Color
                        <a href="{{ url('admin/colors') }}" class="btn btn-sm btn-danger float-end text-white">
                            BACK
                        </a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/colors') }}" method="POST">
                        @csrf
                        @method("POST")
                        <div class="mb-3">
                            <label for="">Color Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="">Color Code</label>
                            <input type="text" name="code" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="">Status</label>
                            <input type="checkbox" name="status"> Checked=Hidden, UnChecked=Visible
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection
