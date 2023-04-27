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
                        Colors List
                        <a href="{{ url('admin/colors/create') }}" class="btn btn-sm btn-primary float-end text-white">
                            Add color
                        </a>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bodered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Color Name</th>
                                <th>Color Code</th>
                                <th>Status</th>
                                <th>ACtion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($colors as $color)
                                <tr>
                                    <th>{{ $color->id }}</th>
                                    <th>{{ $color->name }}</th>
                                    <th>{{ $color->code }}</th>
                                    <th>{{ $color->status ? 'Hidden' : 'Visible' }}</th>
                                    <th>
                                        <a href="{{ url('admin/colors/'.$color->id.'/edit') }}" class="btn btn-sm btn-success">Edit</a>
                                        <a href="{{ url('admin/colors/'.$color->id.'/delete') }}" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this')">Delete</a>
                                    </th>
                                </tr>
                            @empty
                                <tr>
                                    <th colspan="5">No record</th>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    @endsection
