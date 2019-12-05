@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.'Reportes')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            {{ 'Reportes' }}
        </h1>
       
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <label for="">Inventario de formulas del total recibido, cuanto queda y cuanto se ha repartido</label>
                                <div id="InventoryTotalReceivedAndDelivered"></div>
                            </div>
                            <div class="col-md-6 text-center">
                                <label for="">Cantida de pacientes atendidos</label>
                                <div id="childrensAattended"></div>

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
                    <h4 class="modal-title"><i class="voyager-trash"></i></h4>
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
<link href="{{asset('vendor/css/charts-c3js/c3.min.css')}}" rel="stylesheet" type="text/css">

@stop

@section('javascript')
    <!-- DataTables -->
    <script src="{{asset('vendor/js/d3/d3.min.js')}}"></script>
<script src="{{asset('vendor/js/charts-c3js/c3.min.js')}}"></script>
    <script>
        var graphicInventoryTotalReceivedAndDelivered=[[],[],[],[]];
        i=0;
        
        @for($i=0;$i<count($graphicInventoryTotalReceivedAndDelivered);$i++)
       
            graphicInventoryTotalReceivedAndDelivered[i][0]='{{$graphicInventoryTotalReceivedAndDelivered[$i][0]}}';
            graphicInventoryTotalReceivedAndDelivered[i][1]='{{$graphicInventoryTotalReceivedAndDelivered[$i][1]}}';
            graphicInventoryTotalReceivedAndDelivered[i][2]='{{$graphicInventoryTotalReceivedAndDelivered[$i][2]}}';
            graphicInventoryTotalReceivedAndDelivered[i][3]='{{$graphicInventoryTotalReceivedAndDelivered[$i][3]}}';
            console.log(graphicInventoryTotalReceivedAndDelivered);
            i++;
        @endfor
        var InventoryTotalReceivedAndDelivered = c3.generate({
            bindto: '#InventoryTotalReceivedAndDelivered',
            data: {
                x : 'x',
                columns: graphicInventoryTotalReceivedAndDelivered,
                type: 'bar'
            },
            
            axis: {
                x: {
                    type: 'category', // this needed to load string x value
                    label: {
                        text: 'Distintas formulas entregadas',
                        position: 'outer-center'
                    }

                },
                y:{
                    label: {
                        text: 'Cantidad de formulas entregadas',
                        position: 'outer-center'
                    }
                }
                
            }
        });
    </script>
    
@stop
