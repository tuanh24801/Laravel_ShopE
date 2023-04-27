<div>
    @include('livewire.admin.brand.modal-form')
    {{-- content --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="">
                        Brand List
                        <a href="#" class="float-end btn btn-sm btn-primary" data-bs-toggle="modal"
                            data-bs-target="#AddBrandModal">Add Brands</a>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($brands as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->slug }}</td>
                                    <td>{{ $item->status == '1' ? 'hidden' : 'visible' }}</td>
                                    <td>
                                        <a href="" wire:click="editBrand({{ $item->id }})" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#UpdateBrandModal">Edit</a>

                                        <a href="" wire:click="deleteBrand({{ $item->id }})" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#DeleteBrandModal">Delete</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5"> No Brands Found </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div>
                        {{ $brands->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('script')
    <script>
        window.addEventListener('close-modal', event => {
            $('#AddBrandModal').modal('hide');
            $('#UpdateBrandModal').modal('hide');
            $('#DeleteBrandModal').modal('hide');
        });
    </script>

@endpush

