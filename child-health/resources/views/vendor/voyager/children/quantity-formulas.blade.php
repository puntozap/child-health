@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.'DONACION AID FOR AIDS')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
             {{ 'DONACION AID FOR AIDS' }}
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
                            <form action="/admin/generals/results" method="post">
                            {{ csrf_field() }}

                            <div class="col-md-12">
                                <label for="">Rango por fechas</label>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="">Desde</label>
                                        <input type="date" name="date_start" class="form-control" value={{isset($date_start)?$date_start:''}} >
                                    </div>
                                    <div class="col-md-12">
                                        <label for="">Hasta</label>
                                        <input type="date" name="date_finish" class="form-control" value={{isset($date_finish)?$date_finish:''}}>    
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Pais</label>
                                        <select onchange="state()" name="country_id" class="form-control select2" id="country_id" >
                                            <option value="">Seleccione</option>
                                            @foreach($Country as $countries)
                                            <option value="{{$countries->id}}" {{(isset($country_id)&&$country_id==$countries->id?"selected":"")}} {{isset($details)&&$details->country==$countries->code?"selected":""}} >{{$countries->name}} </option>
                                            @endforeach
                                        </select>                                        
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Estado</label>
                                        <select name="state_id" onchange="municipality()" class="form-control state select2" id="state_id">
                                            <option value="">Seleccione</option>
                                            
                                        </select>                                    
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Municipio</label>
                                        <select name="municipality_id" class="form-control select2 municipality" id="municipality_id" onchange="parish()">
                                            <option value="">Seleccione</option>
                                           
                                        </select>                                    
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Parroquia</label>
                                        <select name="parish_id" class="form-control select2 parish" id="parish_id">
                                            <option value="">Seleccione</option>
                                            
                                        </select>                                    
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <a href="/admin/reporte/general" class="btn btn-secondary">Limpiar Busqueda</a>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-dark btn-block">Buscar</button>
                            </div>
                            </form>
                            <div class="col-md-12">
                                <h4 for="">DONACION AID FOR AIDS</h4>
                            </div>
                            <div class="col-md-12">
                                <table class="datatable">
                                    <thead>
                                    <tr>
                                        <th>Bebe</th>
                                        <th>Cantidad Formulas entregadas</th>
                                        <th>Edad</th>
                                        <th>Pais</th>
                                        <th>Estado</th>
                                        <th>Municipio</th>
                                        <th>Parroquia</th>
                                        <th>Domicilio</th>
                                        
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($Visit as $data)
                                    <tr>
                                        <td>{{$data->user_name." ".$data->user_lastname}}</td>
                                        <td>{{$data->quantity_visits}}</td>
                                        <td>
                                        @php 
                                            $dEnd = new DateTime(date("Y-m-d"));
                                            $dStart  = new DateTime($data->date_birth);
                                            $dDiff = $dStart->diff($dEnd);
                                            $days=$dDiff->format('%r%a');
                                        @endphp
                                        {{$days}}</td>
                                        <td>{{$data->country_name}}</td>
                                        <td>{{$data->state_name}}</td>
                                       
                                        <td>{{$data->municipality_name}}</td>
                                        <td>{{$data->parish_name}}</td>
                                        <td>{{$data->address}}</td>
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
        var ban_state=0;
        function state(){
            var country_id=$("#country_id").val();
            console.log(country_id);
            selected="";
            // return '';
            @if(isset($state_id))
                State_id="{{$state_id}}";
                ban_state=1;
                // console.log(ban_state)
            @endif
            
            html="";
            $.ajax({
                dataType: "json",
                method:'get',
                url:'/admin/state',
                data:{country_id:country_id},
                success:function(data){
                    console.log(data);
                    html+="<option>";
                        html+="Seleccione";
                    html+="</option>";
                    for(i=0;i<data.length;i++){
                        if(ban_state==1){
                            if(data[i].id==State_id){
                                selected="selected";
                            }else{
                                selected="";
                            }
                        }
                        html+="<option value='"+data[i].id+"' "+selected+" >";
                            html+=data[i].name;
                        html+="</option>";
                    }
                    // console.log(selected)
                    $(".state").html(html);
                    
                    $(".municipality").html("<option>Seleccione</option>");
                    $(".parish").html("<option>Seleccione</option>");
                    if(ban_state==1)
                        municipality()       
                    
                }
            });
        }
        var ban_municipality=0;
        function municipality(){
            var state_id=$("#state_id").val();
            console.log(state_id);
            // Municipality
            selected="";
            @if(isset($municipality_id)&&$municipality_id!="Seleccione")
                Municipality_id="{{$municipality_id}}";
                ban_municipality=1;
            @endif
            html="";
            $.ajax({
                dataType: "json",
                method:'get',
                url:'/admin/municipality',
                data:{state_id:state_id},
                success:function(data){
                    console.log(data);
                    html+="<option>";
                        html+="Seleccione";
                    html+="</option>";
                    for(i=0;i<data.length;i++){
                        if(ban_municipality==1){
                            if(data[i].id==Municipality_id){
                                selected="selected";
                            }else{
                                selected="";
                            }
                        }
                        html+="<option value='"+data[i].id+"' "+selected+" >";
                            html+=data[i].name;
                        html+="</option>";
                    }
                    $(".municipality").html(html);
                    if(ban_municipality==1){
                        parish();      
                    }
                }
            });
        }
        var ban_parish=0;
        function parish(){
            var municipality_id=$("#municipality_id").val();
            console.log(municipality_id);
            selected="";
            @if(isset($parish_id)&&$parish_id!="seleccione")
                Parish_id="{{$parish_id}}";
                ban_parish=1;
            @endif
            // return '';
            html="";
            $.ajax({
                dataType: "json",
                method:'get',
                url:'/admin/parish',
                data:{municipality_id:municipality_id},
                success:function(data){
                    console.log(data);
                    html+="<option>";
                        html+="Seleccione";
                    html+="</option>";
                    for(i=0;i<data.length;i++){
                        if(ban_parish==1){
                            if(data[i].id==Parish_id){
                                selected="selected";
                            }else{
                                selected="";
                            }
                        }
                        html+="<option value='"+data[i].id+"' "+selected+" >";
                            html+=data[i].name;
                        html+="</option>";
                    }
                    $(".parish").html(html);
                }
            });
        }
        @if(isset($country_id)||isset($details))
            state();
        @endif     
    </script>
@stop
