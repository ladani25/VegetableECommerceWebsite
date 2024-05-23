@include('admin.header')
<div class="page-content" style="padding-bottom: 70px;">
    <div class="page-header">
      <div class="container-fluid">
        <h2 class="h5 no-margin-bottom">User </h2>
      </div>
    </div>
    <div class="table-responsive p-3">
      
        {{-- {{-- <div class="row"> --}}
            
            
      <table class="table align-items-center table-flush dataTable" id="dataTable" role="grid"
          aria-describedby="dataTable_info">
         
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>email</th>
                <th>Phone_number</th>
                 <th>password</th>
                {{-- <th>ACTION</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($user as $user)
                <tr>
                    <td>{{$user->u_id }}</td>
                    <td>{{ $user->name  }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone_number}}</td>               
                    <td>{{ $user->password}}</td> 
                    {{-- <td><button class="btn btn-primary btn-lg"><a href="{{url('p_edit/'.$product->p_id )}}"> <span class="text-white">Edit</span></a></button>
                        <button class="btn btn-primary btn-lg"><a href="{{url('p_delete/'.$product->p_id  )}}"><span class="text-white">Delete</span></a></button></td>
                        <td>{!! $product->description !!}</td>
                    </tr> --}}
            @endforeach
         
        </tbody>
    </table>



</body>
@include('admin.footer')  