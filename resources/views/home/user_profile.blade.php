{{-- @include('home.header')

  <div class="container">
    <h1>User Profile</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
   
    <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="{{ $user->name }}"  placeholder="Enter product name">
    </div>
    <div class="form-group">
        <label>Email:</label>
        <input type="text" name="name" class="form-control" value="{{ $user->email }}"  placeholder="Enter product name">
    </div>
    <div class="form-group">
        <label>Phone Number:</label>
        <input type="text" name="name" class="form-control" value="{{ $user->phone_number }}"  placeholder="Enter product name">
    </div>

    <button class="btn btn-primary"> <a>Edit Profile</a></button>
</div>

  @include('home.footer')
                    --}}

@include('home.header')
<div class="container">
    <h1>User Profile</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="form-group">
      <form method="POST" action="{{ url('edit_profile/'.$user->u_id ) }}">
        @csrf
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ $user->name }}" placeholder="Enter product name">
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="text" name="email" class="form-control" value="{{ $user->email }}" placeholder="Enter product email">
                </div>
                <div class="form-group">
                    <label>Phone Number:</label>
                    <input type="text" name="phone_number" class="form-control" value="{{ $user->phone_number }}" placeholder="Enter phone number">
                  </div>
                  <div class="form-group">
                  {{-- <label>password:</label>
                  <input type="text" name="password" class="form-control"  placeholder="Enter password">
                  </div> --}}
                <button class="btn btn-primary" type="submit" name="submit"><a>Edit Profile</a></button>
                {{-- <button class="btn btn-primary" type="submit" name="submit"><a href="{{url('change_password/'.$user->u_id)}}">Change Password</a></button> --}}
                  <br><br>
                  {{-- <a href="{{url('password/reset')}}">Forgot Password?</a> --}}
     </form>
     <button class="btn btn-primary" type="submit" name="submit"><a href="{{url('change_password/'.$user->u_id)}}">Change Password</a></button>
    </div>
@include('home.footer')
