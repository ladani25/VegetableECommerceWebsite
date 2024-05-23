@include('admin.header')
<div class="page-content" style="padding-bottom: 70px;">
    <div class="page-header">
      <div class="container-fluid">
        <h2 class="h5 no-margin-bottom">Dashboard</h2>
      </div>
    </div>
  <div style="padding-left:2%">
    <a href="{{url('add_products')}}" class="btn btn-primary btn-icon-split">
      <span class="icon text-white-50">
          {{-- <i class="fas fa-plus"></i> --}}
      </span>
      <span class="text">Add Products</span>
      </a>
  </div>  
    <div class="table-responsive p-3">
        <h1>Products List</h1>
        {{-- <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="dataTables_length" id="dataTable_length">
                    <label>Show <select name="dataTable_length" aria-controls="dataTable" class="custom-select custom-select-sm form-control form-control-sm">
                        <option value="2">2</option><option value="2">2</option>
                        <option value="5">5</option><option value="5">5</option>
                    </select> entries</label>
                </div></div><div class="col-sm-12 col-md-6">
                    <div id="dataTable_filter" class="dataTables_filter">
                        <label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="dataTable">
                        </label>
                    </div>
                </div>
            </div> --}}
      <table class="table align-items-center table-flush dataTable" id="dataTable" role="grid"
          aria-describedby="dataTable_info">
         
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Images</th>
                <th>Prices</th>
                <th>Selling Prices</th>
                <th>quantity</th>
                 <th>Categeroy</th>
                <th>ACTION</th>
                <th>description</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{$product->p_id }}</td>
                    <td>{{$product->name }}</td>
                    {{-- <td>{{$product->images}}</td> --}}
                    <td>
                        @foreach(explode(',',$product->images) as $image)
                            <img src="{{ asset('images/' . $image) }}" alt="{{ $image }}" style="width: 100px; height: auto;">
                        @endforeach
                    </td>
                    <td>{{$product->price }}</td>
                    <td>{{ $product->selling_price}}</td>               
                    <td>{{$product->quantity }}</td>
                   
                    <td>
                        @if($product->category)
                            {{ $product->category->c_name }}
                        @else
                            No Category
                        @endif
                    </td>
                    {{-- <td>
                        @foreach(explode(',',$product->images) as $image)
                            <img src="{{ asset('images/' . $image) }}" alt="{{ $image }}" style="width: 100px; height: auto;">
                        @endforeach
                    </td> --}}
                    <td><button class="btn btn-primary btn-lg"><a href="{{url('p_edit/'.$product->p_id )}}"> <span class="text-white">Edit</span></a></button>
                        <button class="btn btn-primary btn-lg"><a href="{{url('p_delete/'.$product->p_id  )}}"><span class="text-white">Delete</span></a></button></td>
                        <td>{!! $product->description !!}</td>
                    </tr>
            @endforeach
         
        </tbody>
    </table>
{{-- 
    <div class="row">
        <div class="col-sm-12 col-md-5">
            <div class="dataTables_info" id="dataTable_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div>
        </div>
        <div class="col-sm-12 col-md-7">
            <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                <ul class="pagination">
                    <li class="paginate_button page-item previous disabled" id="dataTable_previous">
                        <a href="#" aria-controls="dataTable" data-dt-idx="0" tabindex="0" class="page-link">Previous</a>
                    </li>
                    <li class="paginate_button page-item active">
                        <a href="{{ $products->links() }}" aria-controls="dataTable" data-dt-idx="1" tabindex="0" class="page-link">1</a>
                    </li>
                    <li class="paginate_button page-item ">
                        <a href="#" aria-controls="dataTable" data-dt-idx="2" tabindex="0" class="page-link">2</a></li>
                        <li class="paginate_button page-item ">
                            <a href="#" aria-controls="dataTable" data-dt-idx="3" tabindex="0" class="page-link">3</a></li>
                            <li class="paginate_button page-item ">
                                <a href="#" aria-controls="dataTable" data-dt-idx="4" tabindex="0" class="page-link">4</a>
                            </li>
                            <li class="paginate_button page-item "><a href="#" aria-controls="dataTable" data-dt-idx="5" tabindex="0" class="page-link">5</a></li><li class="paginate_button page-item "><a href="#" aria-controls="dataTable" data-dt-idx="6" tabindex="0" class="page-link">6</a></li><li class="paginate_button page-item next" id="dataTable_next"><a href="#" aria-controls="dataTable" data-dt-idx="7" tabindex="0" class="page-link">Next</a></li></ul></div></div></div>
   
</div> --}}


</body>
@include('admin.footer')  