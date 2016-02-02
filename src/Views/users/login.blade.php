@extends('administr::layout.master')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-sm-6 col-xs-12 col-lg-push-6 col-sm-push-6">
                {!! $form->render() !!}
            </div>
        </div>
    </div>

@stop