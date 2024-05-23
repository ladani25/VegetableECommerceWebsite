@include('admin.header')

<div class="page-content" style="padding-bottom: 70px;">
    <div class="block-body" style="padding-top:5%">
        <div class="card mb-4 container">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Edit Category</h6>
            </div>
            
            <div class="container">
                <form id="edit-category-form" method="POST" action="{{ route('update_category', ['id' => $category->id]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
    
                    <div class="form-group">
                        <label for="c_name">Category Name:</label>
                        <input type="text" name="c_name" id="c_name" class="form-control" value="{{ $category->c_name }}">
                    </div>
    
                    <!-- Other fields if needed -->
    
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </form>
            </div>
        </div>
    </div>
</div>

@include('admin.footer')
