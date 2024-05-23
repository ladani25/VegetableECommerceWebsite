
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dark Bootstrap Admin </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{url('admin/vendor/bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="{{url('admin/vendor/font-awesome/css/font-awesome.min.css')}}">
    <!-- Custom Font Icons CSS-->
    <link rel="stylesheet" href="{{url('admin/css/font.css')}}">
    <!-- Google fonts - Muli-->
    <link rel="stylesheet" href="{{url('admin/https://fonts.googleapis.com/css?family=Muli:300,400,700')}}">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{url('admin/css/style.default.css')}}" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{url('admin/css/custom.css')}}">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{url('admin/img/favicon.ico')}}">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <body>
    <div class="login-page">
      <div class="container d-flex align-items-center" style="padding-left:25%">
        <div class="form-holder has-shadow">
          <div class="row" >
            <div class="col-lg-6 bg-white" >
              <div class="form d-flex align-items-center">
                <div class="content">
                  <form method="post"  action="{{url('login')}}" class="form-validate">
                    @method('post')
                    @csrf
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp"
                          placeholder="Enter Email Address">
                      </div>
                      <div class="form-group">
                        <input type="password" name="password" class="form-control" id="exampleInputPassword" placeholder="Password">
                      </div>
                      <div class="form-group">
                          <button type="submit" name="submit" class="btn btn-primary btn-block">Login</button>
                      </div>
                    <!-- This should be submit button but I replaced it with <a> for demo purposes-->
                    </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
    {{-- <!-- JavaScript files-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper.js/umd/popper.min.js"> </script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="js/front.js"></script> --}}
  </body>
</html>