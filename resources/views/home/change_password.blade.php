@include('home.header')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"></div>

                <div class="card-body">
                    <form method="POST" action="{{url('update_password', ['u_id' => $user->u_id]) }}" >
                        @csrf

                         <label for="new_password">{{ __('New Password') }}</label>
                        <input id="new_password" type="password" class="form-control" name="new_password" required autocomplete="new-password">
                        @error('new_password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    
                        <label for="confirm_password">{{ __('Confirm Password') }}</label>
                        <input id="confirm_password" type="password" class="form-control" name="new_password_confirmation" required autocomplete="new-password">
                        @error('new_password_confirmation')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    
                        <div style="padding-top: 10px">
                            {{-- <button type="submit" class="btn btn-primary">confirm</button> --}}
                            <button type="submit" name="submit" class="btn btn-primary">confirm</button>
                            </div>
                        </div>
                    </form>

                    {{-- <form action="{{url('update_password', ['u_id' => $user->u_id]) }}" method="POST">
                        @csrf
                    
                        <label for="new_password">{{ __('New Password') }}</label>
                        <input id="new_password" type="password" class="form-control" name="new_password" required autocomplete="new-password">
                        @error('new_password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    
                        <label for="confirm_password">{{ __('Confirm Password') }}</label>
                        <input id="confirm_password" type="password" class="form-control" name="new_password_confirmation" required autocomplete="new-password">
                        @error('new_password_confirmation')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    
                        <button type="submit" name="submit" class="btn btn-primary">Update Password</button>
                    </form> --}}
                    
                </div>
            </div>
        </div>
    </div>
</div>
                           


@include('home.footer')