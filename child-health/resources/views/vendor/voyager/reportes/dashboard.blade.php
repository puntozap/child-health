@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.'Reportes')

@section('page_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 quantityChild">
                <div class="row text-center box-better">
                    <div class="col-md-12">Bebes Registrados</div>
                    <div class="col-md-12">{{$Child->totalChild}}</div>
                </div>
            </div>
            <div class="col-md-3 quantity-visit">
                <div class="row text-center box-better">
                    <div class="col-md-12">Cantida de Visita realizadas</div>
                    <div class="col-md-12">{{$TotalVisit->totalVisit}}</div>
                </div>
            </div>
            <div class="col-md-3 quantityChild">
                <div class="row text-center box-better">
                    <div class="col-md-12">Formulas En Inventario</div>
                    <div class="col-md-12">{{$totalInventory->totalInventory}}</div>
                </div>
            </div>
            <div class="col-md-3 quantity-visit">
                <div class="row text-center box-better">
                    <div class="col-md-12">Cantidad de Patrocinantes</div>
                    <div class="col-md-12">{{$quantitySponsor->totalSponsor}}</div>
                </div>
            </div>
        </div>
       
    </div>
@stop
@section("css")
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
@endsection

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <section class="tabs-section">
                                    <div class="tabs-section-nav tabs-section-nav-icons">
                                        <div class="tbl">
                                            <ul class="nav" role="tablist">
                                                <li class="nav-item nav-item-1" onclick="changeTheme(1)">
                                                    <a class="nav-link active" href="#tabs-1-tab-1" role="tab" data-toggle="tab">
                                                        <span class="nav-link-in">
                                                            
                                                            Reporte Visitas
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="nav-item nav-item-2" onclick="changeTheme(2)">
                                                    <a class="nav-link" href="#tabs-1-tab-2" role="tab" data-toggle="tab">
                                                        <span class="nav-link-in">
                                                            
                                                            Reporte General
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="nav-item nav-item-3" onclick="changeTheme(3)">
                                                    <a class="nav-link" href="#tabs-1-tab-3" role="tab" data-toggle="tab">
                                                        <span class="nav-link-in">
                                                            
                                                            Formulas entregadas
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div><!--.tabs-section-nav-->

                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade in active" id="tabs-1-tab-1">
                                            <div class="row">
                                                <div class="col-md-12 tab-pane-1">
                                                    @include("vendor.voyager.reportes.tabs.visitas")
                                                </div>
                                            </div>
                                        </div><!--.tab-pane-->
                                        <div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-2">
                                            @include("vendor.voyager.reportes.tabs.general")
                                        </div><!--.tab-pane-->
                                        <div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-3">@include("vendor.voyager.reportes.tabs.delivered-formula")</div><!--.tab-pane-->
                                    </div><!--.tab-content-->
                                </section><!--.tabs-section-->
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
    <script>
        function changeTheme(x){
            $(".nav-item a").removeClass("active show");
            $(".nav-item-"+x+" a").addClass("active show");
            // $(".tab-pane"+x-1+" a").css("display","none","important");
            // $(".nav-item-"+x).removeClass("active");
        }
        function showReport(){
            
        }
        // function searchDelivered(){
        //     // alert()
        //     html="";
        //     $.ajax({
        //             dataType: "json",
        //             method:'post',
        //             url:"/admin/search/visitas-delivered",
        //             data:$(".visits-delivered").serialize(),
        //             success:function(data){
        //                 console.log(data); 
        //                 // return '';//
        //                 for(var i=0;i<data.length;i++){
        //                     html+="<tr>";
        //                         html+="<td>"+data[i].name+"</td>";
        //                         html+="<td>"+data[i].delivered+"</td>";
        //                     html+="</tr>";
        //                 }
        //                 $(".delivered-formula").html(html);
        //             }
        //     })
        // }
        $(".visits-deliveded").submit(function( event ){
            // alert()
            event.preventDefault();
            html="";
            $.ajax({
                    dataType: "json",
                    method:'post',
                    url:"/admin/search/visitas-delivered",
                    data:{date_start:$("input[name='date_starts']").val(),date_end:$("input[name='date_finishs']").val()},
                    success:function(data){
                        console.log(data); 
                        // return '';//
                        for(var i=0;i<data.length;i++){
                            html+="<tr>";
                                html+="<td>"+data[i].name+"</td>";
                                html+="<td>"+data[i].delivered+"</td>";
                            html+="</tr>";
                        }
                        // date-delivered
                        $(".date-delivered").html("Lista de ninos con formula entregada desde el "+$("input[name='date_starts']").val()+" hasta el "+$("input[name='date_finishs']").val())
                        $(".delivered-formula").html(html);
                    }
            })
        });
        $(".visits-report").submit(function( event ){
            event.preventDefault();
            html="";
            $.ajax({
                    dataType: "json",
                    method:'post',
                    url:"/admin/reporte/reportVisitsDate",
                    data:$(".visits-report").serialize(),
                    success:function(data){
                        // console.log(data[0].name); return '';//
                        for(var i=0;i<data.length;i++){
                            html+="<tr>";
                                html+="<td>"+data[i].name+"</td>";
                                html+="<td>"+data[i].total+"</td>";
                                html+="<td>"+data[i].date+"</td>";
                            html+="</tr>";
                        }
                        $(".list-report").html(html);
                    }
            })
        });

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
                    // console.log(data);
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
            // console.log(state_id);
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
                    // console.log(data);
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
            // console.log(municipality_id);
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
                    // console.log(data);
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
        state();
        $(".visit-general").submit(function( event ){
            event.preventDefault();
            html="";
            $.ajax({
                    dataType: "json",
                    method:'post',
                    url:"/admin/reporte/searchResult",
                    data:$(".visit-general").serialize(),
                    success:function(data){
                        console.log(data); 
                        // return '';//
                        aux="";
                        for(var i=0;i<data.Report.length;i++){
                            if(aux!=data.Report[i].user_id){
                                aux=data.Report[i].user_id;
                            html+="<tr>";
                                html+="<td>"+data.Report[i].parent_name+" "+data.Report[i].parent_last_name+"</td>";
                                html+="<td>"+data.Report[i].parent_dni+"</td>";
                                html+="<td>"+data.Report[i].user_phone+"</td>";
                                html+="<td>"+Math.round(data.Report[i].years_parent/365)+"</td>";
                                html+="<td>"+data.Report[i].user_name+" "+data.Report[i].user_last_name+"</td>";
                                html+="<td>"+data.Report[i].user_date_birth+"</td>";
                                for(var j=0;j<data.arrayVisit.length;j++){
                                    if(data.arrayVisit[j].child_user_id==data.Report[i].user_id){
                                    html+="<td>"+data.arrayVisit[j].length+"</td>";
                                    html+="<td>"+data.arrayVisit[j].weight+"</td>";
                                    break;
                                    }
                                }
                                html+="<td>"+data.Report[i].child_days+"</td>";
                                html+="<td>"+data.Report[i].country_name+"</td>";
                                html+="<td>"+data.Report[i].state_name+"</td>";
                                html+="<td>"+data.Report[i].municipio_name+"</td>";
                                html+="<td>"+data.Report[i].parishes_name+"</td>";
                                html+="<td>"+data.Report[i].domicilio+"</td>";
                            html+="</tr>";
                            }
                        }
                        $(".list-report-general").html(html);
                    }
            })
        });
        function ExcelVisited(){
            window.location.href="/admin/excel/visitas?date_start="+$("input[name='date_start']").val()+"&date_end="+$("input[name='date_finish']").val();
        }
        function ExcelGeneral(){
            // console.log($("select[name='country_id']").val()); return '';
            window.location.href="/admin/excel/general?date_start="+$("input[name='date_startx']").val()+"&date_finish="+$("input[name='date_finishx']").val()+"&country_id="+$("select[name='country_id']").val()+"&state_id="+$("select[name='state_id']").val()+"&municipality_id="+$("select[name='municipality_id']").val()+"&parish_id="+$("select[name='parish_id']").val();
        }
        function ExcelDelivery(){
            window.location.href="/admin/excel/entregas?date_start="+$("input[name='date_starts']").val()+"&date_end="+$("input[name='date_finishs']").val();
        }
    </script>
    
@stop
