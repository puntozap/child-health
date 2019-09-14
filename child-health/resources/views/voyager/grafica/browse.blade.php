@extends('voyager::master')



@section('page_header')
    
@stop

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div id="chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')
<link href="{{asset('vendor/css/charts-c3js/c3.min.css')}}" rel="stylesheet" type="text/css">

@stop

@section('javascript')
<script src="https://d3js.org/d3.v3.js"></script>
<script src="{{asset('vendor/js/charts-c3js/c3.min.js')}}"></script>

    
    <script>
        var grafi=[];
        var i=0,j=0,k=0;
        @for($i=0;$i<count($grafic);$i++)
            grafi[i]=new Array();
            j=0;
            k=0;
            @for($j=0;$j<364;$j++)
                if(j==0){
                    grafi[i][k]="{{$grafic[$i][$j]}}";
                    k++;
                    grafi[i][k]={{$grafic[$i][$j+1]}}
                    k++;
                }
                else{ 
                    if(j%7==0){
                        grafi[i][k]={{$grafic[$i][$j]}}
                        k++;
                    }
                }
                j++;
            @endfor
            i++;
        @endfor
        console.log(grafi)
        var chart = c3.generate({
            bindto: '#chart',
            data: {
                columns:grafi ,
                type: 'spline'
            }
        });

    </script>
@stop
