@extends('administr::layout.master')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{ title }</h3>

                    <div class="box-tools">
                        @foreach($list->getActions('global') as $action)
                            <a href="{{ $action->url }}" class="btn btn-default">
                                <span class="{{ $action->icon }}"></span>
                                {{ $action->getLabel() }}
                            </a>
                        @endforeach
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    {!! $list->render() !!}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@stop