<div>

    <div  wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:submit.prevent = "destroyCategory()">
                <div class="modal-body">
                <h6>Are you sure you want to delete this data ?</h6>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Yes, Delete</button>
                </div>
            </form>
          </div>
        </div>
      </div>
      <div class="row">


          <div class="col-md-12">
              @if (session('message'))
                  <h2 class="alert alert-success">{{ session('message') }}</h2>
              @endif
              <div class="card">
                  <div class="card-header">
                      <h4>
                          <a href="{{ url('admin/category/add') }}" class="btn btn-sm btn-primary float-end">Add category</a>
                      </h4>
                  </div>
                  <div class="card-body">
                      <table class="table table-bordered table-striped">
                          <thead>
                              <tr>
                                  <th>ID</th>
                                  <th>Name</th>
                                  <th>Status</th>
                                  <th>Action</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach ($categories as $category)
                              <tr>
                                  <td>{{ $category->id }}</td>
                                  <td>{{ $category->name }}</td>
                                  <td>{{ $category->status == '1' ? 'Visible' : 'Hidden' }}</td>
                                  <td>
                                      <a href="{{ route('admin.category.edit', [$category]) }}" class="btn btn-success">Edit</a>
                                      <a href="#" wire:click="deleteCategory({{ $category->id }})" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</a>
                                  </td>
                              </tr>
                              @endforeach
                          </tbody>
                      </table>
                      <div>
                          {{ $categories->links() }}
                      </div>
                  </div>
              </div>
          </div>
      </div>
</div>

@push('script')
    <script>
        window.addEventListener('close-modal', event => {
            $('#deleteModal').modal('hide');
        });
    </script>
@endpush
