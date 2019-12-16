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
                                <div id="graphicChild"></div>

                            </div>
                            <div class="col-md-6 text-center">
                                <label for="">Visitas hechas por meses</label>
                                <div id="graphicVisit"></div>
                            </div>
                            <div class="col-md-6 text-center">
                                <label for="">Cantidad de pacientes con patologias</label>
                                <div id="graphicUserPathologies"></div>
                            </div>
                            <div class="col-md-6 text-center">
                                <label for="">Cantidad de representantes con patologias</label>
                                <div id="graphicUserPatologiesParents"></div>
                            </div>
                            <div class="col-md-6 text-center">
                                <label for="">Cantidad de representantes con patologias</label>
                                <div id="graficUserPathologiesChildCountry"></div>
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
        j=0;
        @for($i=0;$i<count($graphicInventoryTotalReceivedAndDelivered);$i++)
            @for($j=0;$j<count($graphicInventoryTotalReceivedAndDelivered[$i]);$j++)
                graphicInventoryTotalReceivedAndDelivered[i][j]='{{$graphicInventoryTotalReceivedAndDelivered[$i][$j]}}';
                j++;
            @endfor
            console.log(graphicInventoryTotalReceivedAndDelivered);
            j=0;
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
    <script>
        var graphicChild=[[],[]];
        i=0;
        j=0;
        @for($i=0;$i<count($graphicChild);$i++)
            @for($j=0;$j<count($graphicChild[$i]);$j++)
                graphicChild[i][j]='{{$graphicChild[$i][$j]}}';
                j++;
            @endfor
            j=0;
            i++;
        @endfor
        // console.log(graphicChild);

        var graphicChild = c3.generate({
            bindto: '#graphicChild',
            data: {
                columns: graphicChild,
                type: 'pie'
            },
            
            axis: {
                x: {
                    type: 'category', // this needed to load string x value
                    label: {
                        text: 'Variacion entre niños y niñas',
                        position: 'outer-center'
                    }

                },
                y:{
                    label: {
                        text: 'Cantidad de niños registrados',
                        position: 'outer-center'
                    }
                }
                
            }
        });
    </script>
    <script>
        var graphicVisit=[[],[],[]];
        i=0;
        j=0;
        @for($i=0;$i<count($graphicVisit);$i++)
            @for($j=0;$j<count($graphicVisit[$i]);$j++)
                graphicVisit[i][j]='{{$graphicVisit[$i][$j]}}';
                j++;
            @endfor
            
            // console.log(graphicVisit);
            j=0;
            i++;
        @endfor
        var graphicVisit = c3.generate({
            bindto: '#graphicVisit',
            data: {
                x : 'x',
                columns: graphicVisit,
                type: 'bar'
            },
            
            axis: {
                x: {
                    type: 'category', // this needed to load string x value
                    label: {
                        text: 'Variacion entre niños y niñas',
                        position: 'outer-center'
                    }

                },
                y:{
                    label: {
                        text: 'Cantidad de niños registrados',
                        position: 'outer-center'
                    }
                }
                
            }
        });
    </script>

    <script>
        var graphicUserPathologies=[];
        i=0;
        j=0;
        @for($i=0;$i<count($graphicUserPathologies);$i++)
            graphicUserPathologies[i]=[];
            @for($j=0;$j<count($graphicUserPathologies[$i]);$j++)
                graphicUserPathologies[i][j]='{{$graphicUserPathologies[$i][$j]}}';
                j++;
            @endfor
            j=0;
            i++;
        @endfor
        console.log(graphicUserPathologies);
        var graphicUserPathologies = c3.generate({
            bindto: '#graphicUserPathologies',
            data: {
                columns: graphicUserPathologies,
                type: 'bar'
            },
            
            axis: {
                x: {
                    type: 'category', // this needed to load string x value
                    label: {
                        text: 'Patologias captadas en ninos y ninas',
                        position: 'outer-center'
                    }

                },
                y:{
                    label: {
                        text: 'Cantidad De ninos y ninas con patologias',
                        position: 'outer-center'
                    }
                }
                
            }
        });
    </script>

    <script>
        var graphicUserPatologiesParents=[];
        i=0;
        j=0;
        @for($i=0;$i<count($graphicUserPatologiesParents);$i++)
            graphicUserPatologiesParents[i]=[];
            @for($j=0;$j<count($graphicUserPatologiesParents[$i]);$j++)
                graphicUserPatologiesParents[i][j]='{{$graphicUserPatologiesParents[$i][$j]}}';
                j++;
            @endfor
            j=0;
            i++;
        @endfor
        console.log(graphicUserPatologiesParents);
        var graphicUserPatologiesParents = c3.generate({
            bindto: '#graphicUserPatologiesParents',
            data: {
                columns: graphicUserPatologiesParents,
                type: 'bar'
            },
            
            axis: {
                x: {
                    type: 'category', // this needed to load string x value
                    label: {
                        text: 'Patologias captadas en representantes',
                        position: 'outer-center'
                    }

                },
                y:{
                    label: {
                        text: 'Cantidad De representantes con patologias',
                        position: 'outer-center'
                    }
                }
                
            }
        });
    </script>


<script>
        var graficUserPathologiesChildCountry=[];
        i=0;
        j=0;
        @for($i=0;$i<count($graficUserPathologiesChildCountry);$i++)
            graficUserPathologiesChildCountry[i]=[];
            @for($j=0;$j<count($graficUserPathologiesChildCountry[$i]);$j++)
                graficUserPathologiesChildCountry[i][j]='{{$graficUserPathologiesChildCountry[$i][$j]}}';
                j++;
            @endfor
            j=0;
            i++;
        @endfor
        console.log(graficUserPathologiesChildCountry);
        var graficUserPathologiesChildCountry = c3.generate({
            bindto: '#graficUserPathologiesChildCountry',
           
            data: {
                x : 'x',
                columns: graficUserPathologiesChildCountry,
                type: 'bar'
            },
            
            axis: {
                x: {
                    type: 'category', // this needed to load string x value
                    label: {
                        text: 'Patologias captadas en representantes',
                        position: 'outer-center'
                    }

                },
                y:{
                    label: {
                        text: 'Cantidad De representantes con patologias',
                        position: 'outer-center'
                    }
                }
                
            }
        });
    </script>
@stop
