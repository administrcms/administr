@extends('administr::layout.auth')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Admini</b>str</a>
        </div><!-- /.login-logo -->
        <div class="login-box-body">

            {!! $form->render() !!}

            <a href="#">I forgot my password</a><br>
            <a href="#" class="text-center">Register a new membership</a>

        </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <script src="/vendor/administr/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="/vendor/administr/bootstrap/js/bootstrap.min.js"></script>
    <script src="/vendor/administr/plugins/iCheck/icheck.min.js"></script>
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
@stop