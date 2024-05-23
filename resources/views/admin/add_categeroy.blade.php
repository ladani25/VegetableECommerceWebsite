@include('admin.header')

<div class="page-content" style="padding-bottom: 70px;">
<div>
{{-- <div class="block"> --}}
    
    <div class="block-body" style="padding-top:5%">
     
     
    <div class="card mb-4 container">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Add categeroy</h6>
        </div>
        <div class="card-body container">
            <form method="POST" enctype="multipart/form-data" action="{{url('get_categeroy')}}">
                @method('post')
                @csrf
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="c_name" class="form-control" id="exampleInputEmail1"  placeholder="Enter Category" >
                </div>
                <div class="form-group">
                    <div class="custom-file">
                        <input type="file" name="images" class="custom-file-input" id="customFile" multiple>
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                </div>
                <button type="submit" name="submit" class="btn btn-primary" >Add categeroy</button>
            </form>
        </div>
    </div>
     </div>
  </div>
</div>
</div>

@include('admin.footer')