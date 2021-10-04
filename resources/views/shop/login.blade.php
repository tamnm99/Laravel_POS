<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TEAM 3 | Khách Hàng ĐĂNG NHẬP</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/2818147cbc.js" crossorigin="anonymous"></script>
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{asset('css/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('css/adminlte.min.css')}}">
    <!-- Google Recaptcha -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- Toastr-->
    <link rel="stylesheet" href="{{asset('css/plugins/toastr/toastr.min.css')}}">

</head>
<body class="hold-transition login-page">
<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <h2><b>TEAM 3 - Cửa Hàng</b></h2>
        </div>
        <div class="card-body">
            <h3><p class="login-box-msg">ĐĂNG NHẬP</p></h3>
            <br>
            <div class="row">
                <div class="mx-auto">
                    <button type="submit" class="btn btn-md btn-primary btn-block">
                        Google
                    </button>
                    <button type="submit" class="btn btn-md btn-primary btn-block">
                        Facebook
                    </button>
                </div>

            </div>

        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{asset('js/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('js/plugins/bootstrap/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE -->
<script src="{{asset('js/dashboard/adminlte.min.js')}}"></script>
<!-- Toastr -->
<script src="{{asset('js/plugins/toastr/toastr.min.js')}}"></script>

{{--Script for gg rapcaptcha--}}
<script type="text/javascript">

    @if(session('error'))
    toastr.error('{{session("error")}}', 'Đăng nhập thất bại !!!', {timeOut: 5000});
    @endif

    function recaptchaDataCallBackLogin(response) {
        $('#hiddenRecaptchaLogin').val(response);
    }

    function recaptchaExpiredCallBackLogin(response) {
        $('#hiddenRecaptchaLogin').val('');
    }

    @if(session('success'))
    toastr.success('{{session("success")}}', 'Đổi mật khẩu mới thành công !!!', {timeOut: 5000});
    @endif
</script>
</body>
</html>
