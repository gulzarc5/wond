<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Wonderland National School</title>
    <link rel="icon" href="{{asset('web/assets/images/favicon.png')}}" type="image/icon type">

    <!-- Bootstrap -->
    <link href="{{asset('admin/src_files/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{asset('admin/src_files/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{asset('admin/src_files/vendors/nprogress/nprogress.css')}}" rel="stylesheet">
    <!-- Animate.css -->
    <link href="{{asset('admin/src_files/vendors/animate.css/animate.min.css')}}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{asset('admin/src_files/build/css/custom.min.css')}}" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            {{ Form::open(array('url' => 'admin/login', 'method' => 'post')) }}

              <h1>Admin Login Form</h1>
              <div>

                {{ Form::email('email', '',array('class' => 'form-control','placeholder'=>'Enter Email')) }}
                @if ($message = Session::get('login_error'))
                  <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @endif
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                {{-- <input type="text" class="form-control" placeholder="Username" required="" /> --}}
              </div>
              <div>
                {{ Form::password('password',array('class' => 'form-control','placeholder'=>'Enter Passssword')) }}
                
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div>
                {{ Form::submit('Log In', array('class'=>'btn btn-success','style'=>'margin-left:139px')) }}
                {{-- <a class="btn btn-default submit" type="submit">Log in</a> --}}
              </div>

              <div class="clearfix"></div>

              <div class="separator">

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1>
                    {{-- <img style="padding-right: 42PX;" src="{{asset('web/assets/images/logo_dark.png')}}" height="100"> --}}
                    Wonderland National School
                  </h1>
                  <p>©2019 All Rights Reserved. Wonderland National School Privacy and Terms</p>
                </div>
              </div>
            {{ Form::close() }}
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
