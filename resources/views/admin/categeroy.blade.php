@include('admin.header')
<div class="page-content" style="padding-bottom: 70px;">
    <div class="page-header">
      <div class="container-fluid">
        <h2 class="h5 no-margin-bottom">Dashboard</h2>
      </div>
    </div>
  <div style="padding-left:2%">
    <a href="{{url('add_categeroy')}}" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
            {{-- <i class="fas fa-plus"></i> --}}
        </span>
        <span class="text">Add categeroy</span>
</a>
  </div>  
    <div class="table-responsive p-3">
        <h1>Category List</h1>
      <table class="table align-items-center table-flush dataTable" id="dataTable" role="grid"
          aria-describedby="dataTable_info">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Images</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categeroy as $category)
                <tr>
                    <td>{{ $category->c_id }}</td>
                    <td>{{ $category->c_name }}</td>
                    <td>
                        <!-- Assuming 'images' is a comma-separated string of filenames -->
                        @foreach(explode(',', $category->images) as $image)
                            <img src="{{ asset('images/' . $image) }}" alt="{{ $image }}" style="width: 100px; height: auto;">
                        @endforeach
                    </td>
                    <td><button class="btn btn-primary btn-lg"><a href="{{url('c_edit/'.$category->c_id )}}"> <span class="text-white">Edit</span></a></button>
                    <button class="btn btn-primary btn-lg"  data-toggle="modal" data-target="#myModal"><a href="{{url('c_delete/'.$category->c_id )}}"><span class="text-white">Delete</span></a></button></td>
                </tr>
            @endforeach
        </tbody>
    </table>

   
</div>


</body>
@include('admin.footer')  