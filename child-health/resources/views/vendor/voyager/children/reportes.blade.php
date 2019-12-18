@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.'Ninos que vinieron y que no vinieron')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
             {{ 'Ninos que vinieron y que no vinieron' }}
        </h1>
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="container">
                        <div class="row">
                            <form action="/admin/search/visitas-fechas" method="post">
                            {{ csrf_field() }}

                            <div class="col-md-12">
                                <label for="">Rango por fechas</label>
                            </div>
                            <div class="col-md-6">
                                <input type="date" name="date_start" class="form-control" value={{isset($date_start)?$date_start:''}} >
                            </div>
                            <div class="col-md-6">
                                <input type="date" name="date_finish" class="form-control" value={{isset($date_finish)?$date_finish:''}}>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-dark btn-block">Buscar</button>
                            </div>
                            </form>
                            <div class="col-md-12">
                                <h4 for="">Lista de ninos que recibieron formulas</h4>
                            </div>
                            <div class="col-md-12">
                                <table class="datatable">
                                    <thead>
                                    <tr>
                                        <th>Nombre del nino</th>
                                        <th>Asistencia</th>
                                        <th>Fecha</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($arrayChild as $child)
                                    <tr>
                                        <td>{{$child["name"]}}</td>
                                        <td>{{$child["total"]}}</td>
                                        <td>{{$child["date"]}}</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Single delete modal --}}
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> </h4>
                </div>
                <div class="modal-footer">
                    <form action="#" id="delete_form" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm" value="{{ __('voyager::generic.delete_confirm') }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@section('css')
    <link rel="stylesheet" href="{{ voyager_asset('lib/css/responsive.dataTables.min.css') }}">
@stop

@section('javascript')
        <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
    <script>
        


        

       
        
    </script>
@stop
