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
                        <div class="col-md-12">
                        <label for="">1 Puntuacion Z talla segun la edad ninas</label>
                            <div id="graficZScoreGirl"></div>
                        </div>
                        <div class="col-md-12">
                            <label for="">2 Puntuacion Z talla segun la edad ninos</label>
                            <div id="graficZScoreLengthBoy"></div>
                        </div>
                        <div class="col-md-12">
                            <label for="">3 Puntuacion Z Peso segun la edad ninas</label>
                            <div id="graficZScoreWeightGirl"></div>
                        </div>
                        <div class="col-md-12">
                            <label for="">4 Puntuacion Z Peso segun la edad ninos</label>
                            <div id="graficZScoreWeightBoy"></div>
                        </div>
                        <div class="col-md-12">
                            <label for="">5 Puntuacion Z Peso por talla ninas</label>
                            <div id="graficZScoreWeightForLenghtGirl"></div>
                        </div>
                        <div class="col-md-12">
                            <label for="">6 Puntuacion Z Peso por height ninas</label>
                            <div id="graficZScoreWeightForHeightGirl"></div>
                        </div>
                        <div class="col-md-12">
                            <label for="">7 Puntuacion Z Peso por talla ninos</label>
                            <div id="graficZScoreWeightForLenghtBoy"></div>
                        </div>
                        <div class="col-md-12">
                            <label for="">8 Puntuacion Z Peso por height ninos</label>
                            <div id="graficZScoreWeightForHeightBoy"></div>
                        </div>

                        <div class="col-md-12">
                            <label for="">2 Puntuacion Z talla segun la edad nima</label>
                            <div id="graficZScoreGirlx"></div>
                        </div>
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
<script src="{{asset('vendor/js/d3/d3.min.js')}}"></script>
<script src="{{asset('vendor/js/charts-c3js/c3.min.js')}}"></script>

    
    <script>
        var graficZScoreGirl=[];
        var i=0,j=0,k=0;
        @for($i=0;$i<count($graficZScoreGirl);$i++)
        graficZScoreGirl[i]=new Array();
            j=0;
            k=0;
            @for($j=0;$j<364;$j++)
                if(j==0){
                    graficZScoreGirl[i][k]="{{$graficZScoreGirl[$i][$j]}}";
                    k++;
                    graficZScoreGirl[i][k]={{$graficZScoreGirl[$i][$j+1]}}
                    k++;
                }
                else{ 
                    if(j%7==0){
                        graficZScoreGirl[i][k]={{$graficZScoreGirl[$i][$j]}}
                        k++;
                    }
                }
                j++;
            @endfor
            i++;
        @endfor
        console.log(graficZScoreGirl)
        var chart = c3.generate({
            bindto: '#graficZScoreGirl',
            data: {
                columns:graficZScoreGirl ,
                type: 'spline'
            }
        });

    </script>

    <script>
        var graficZScoreLengthBoy=[];
        var i=0,j=0,k=0;
        @for($i=0;$i<count($graficZScoreLengthBoy);$i++)
        graficZScoreLengthBoy[i]=new Array();
            j=0;
            k=0;
            @for($j=0;$j<364;$j++)
                if(j==0){
                    graficZScoreLengthBoy[i][k]="{{$graficZScoreLengthBoy[$i][$j]}}";
                    k++;
                    graficZScoreLengthBoy[i][k]={{$graficZScoreLengthBoy[$i][$j+1]}}
                    k++;
                }
                else{ 
                    if(j%7==0){
                        graficZScoreLengthBoy[i][k]={{$graficZScoreLengthBoy[$i][$j]}}
                        k++;
                    }
                }
                j++;
            @endfor
            i++;
        @endfor
        console.log(graficZScoreLengthBoy)
        var graficZScoreLengthBoy = c3.generate({
            bindto: '#graficZScoreLengthBoy',
            data: {
                columns:graficZScoreLengthBoy ,
                type: 'spline'
            }
        });

    </script>

    <script>
        var graficZScoreWeightGirl=[];
        var i=0,j=0,k=0;
        @for($i=0;$i<count($graficZScoreWeightGirl);$i++)
        graficZScoreWeightGirl[i]=new Array();
            j=0;
            k=0;
            @for($j=0;$j<364;$j++)
                if(j==0){
                    graficZScoreWeightGirl[i][k]="{{$graficZScoreWeightGirl[$i][$j]}}";
                    k++;
                    graficZScoreWeightGirl[i][k]={{$graficZScoreWeightGirl[$i][$j+1]}}
                    k++;
                }
                else{ 
                    if(j%7==0){
                        graficZScoreWeightGirl[i][k]={{$graficZScoreWeightGirl[$i][$j]}}
                        k++;
                    }
                }
                j++;
            @endfor
            i++;
        @endfor
        console.log(graficZScoreWeightGirl)
        var graficZScoreWeightGirl = c3.generate({
            bindto: '#graficZScoreWeightGirl',
            data: {
                columns:graficZScoreWeightGirl ,
                type: 'spline'
            }
        });

    </script>

    <script>
        var graficZScoreWeightBoy=[];
        var i=0,j=0,k=0;
        @for($i=0;$i<count($graficZScoreWeightBoy);$i++)
        graficZScoreWeightBoy[i]=new Array();
            j=0;
            k=0;
            @for($j=0;$j<364;$j++)
                if(j==0){
                    graficZScoreWeightBoy[i][k]="{{$graficZScoreWeightBoy[$i][$j]}}";
                    k++;
                    graficZScoreWeightBoy[i][k]={{$graficZScoreWeightBoy[$i][$j+1]}}
                    k++;
                }
                else{ 
                    if(j%7==0){
                        graficZScoreWeightBoy[i][k]={{$graficZScoreWeightBoy[$i][$j]}}
                        k++;
                    }
                }
                j++;
            @endfor
            i++;
        @endfor
        console.log(graficZScoreWeightBoy)
        var graficZScoreWeightBoy = c3.generate({
            bindto: '#graficZScoreWeightBoy',
            data: {
                columns:graficZScoreWeightBoy ,
                type: 'spline'
            }
        });

    </script>

    <script>
        var graficZScoreWeightForLenghtGirl=[];
        var i=0,j=0,k=0;
        @for($i=0;$i<count($graficZScoreWeightForLenghtGirl);$i++)
        graficZScoreWeightForLenghtGirl[i]=new Array();
            j=0;
            k=0;
            @for($j=0;$j<364;$j++)
                if(j==0){
                    graficZScoreWeightForLenghtGirl[i][k]="{{$graficZScoreWeightForLenghtGirl[$i][$j]}}";
                    k++;
                    graficZScoreWeightForLenghtGirl[i][k]={{$graficZScoreWeightForLenghtGirl[$i][$j+1]}}
                    k++;
                }
                else{ 
                    if(j%1==0){
                        graficZScoreWeightForLenghtGirl[i][k]={{$graficZScoreWeightForLenghtGirl[$i][$j]}}
                        k++;
                    }
                }
                j++;
            @endfor
            i++;
        @endfor
        console.log(graficZScoreWeightForLenghtGirl)
        var graficZScoreWeightForLenghtGirl = c3.generate({
            bindto: '#graficZScoreWeightForLenghtGirl',
            data: {
                columns:graficZScoreWeightForLenghtGirl ,
                type: 'spline'
            }
        });

    </script>

    <script>
        var graficZScoreWeightForHeightGirl=[];
        var i=0,j=0,k=0;
        @for($i=0;$i<count($graficZScoreWeightForHeightGirl);$i++)
        graficZScoreWeightForHeightGirl[i]=new Array();
            j=0;
            k=0;
            @for($j=0;$j<364;$j++)
                if(j==0){
                    graficZScoreWeightForHeightGirl[i][k]="{{$graficZScoreWeightForHeightGirl[$i][$j]}}";
                    k++;
                    graficZScoreWeightForHeightGirl[i][k]={{$graficZScoreWeightForHeightGirl[$i][$j+1]}}
                    k++;
                }
                else{ 
                    if(j%1==0){
                        graficZScoreWeightForHeightGirl[i][k]={{$graficZScoreWeightForHeightGirl[$i][$j]}}
                        k++;
                    }
                }
                j++;
            @endfor
            i++;
        @endfor
        console.log(graficZScoreWeightForHeightGirl)
        var graficZScoreWeightForHeightGirl = c3.generate({
            bindto: '#graficZScoreWeightForHeightGirl',
            data: {
                columns:graficZScoreWeightForHeightGirl ,
                type: 'spline'
            }
        });

    </script>

    <script>
        var graficZScoreWeightForLenghtBoy=[];
        var i=0,j=0,k=0;
        @for($i=0;$i<count($graficZScoreWeightForLenghtBoy);$i++)
        graficZScoreWeightForLenghtBoy[i]=new Array();
            j=0;
            k=0;
            @for($j=0;$j<364;$j++)
                if(j==0){
                    graficZScoreWeightForLenghtBoy[i][k]="{{$graficZScoreWeightForLenghtBoy[$i][$j]}}";
                    k++;
                    graficZScoreWeightForLenghtBoy[i][k]={{$graficZScoreWeightForLenghtBoy[$i][$j+1]}}
                    k++;
                }
                else{ 
                    if(j%1==0){
                        graficZScoreWeightForLenghtBoy[i][k]={{$graficZScoreWeightForLenghtBoy[$i][$j]}}
                        k++;
                    }
                }
                j++;
            @endfor
            i++;
        @endfor
        console.log(graficZScoreWeightForLenghtBoy)
        var graficZScoreWeightForLenghtBoy = c3.generate({
            bindto: '#graficZScoreWeightForLenghtBoy',
            data: {
                xs: {
                    'SD2neg': 'x',
                    'SD1neg': 'x',
                    'SD0': 'x',
                    'SD1': 'x',
                    'SD2': 'x',
                },
                columns:graficZScoreWeightForLenghtBoy ,
                type: 'spline'
            }
        });

    </script>

    <script>
        var graficZScoreWeightForHeightBoy=[];
        var i=0,j=0,k=0;
        @for($i=0;$i<count($graficZScoreWeightForHeightBoy);$i++)
        graficZScoreWeightForHeightBoy[i]=new Array();
            j=0;
            k=0;
            @for($j=0;$j<364;$j++)
                if(j==0){
                    graficZScoreWeightForHeightBoy[i][k]="{{$graficZScoreWeightForHeightBoy[$i][$j]}}";
                    k++;
                    graficZScoreWeightForHeightBoy[i][k]={{$graficZScoreWeightForHeightBoy[$i][$j+1]}}
                    k++;
                }
                else{ 
                    if(j%1==0){
                        graficZScoreWeightForHeightBoy[i][k]={{$graficZScoreWeightForHeightBoy[$i][$j]}}
                        k++;
                    }
                }
                j++;
            @endfor
            i++;
        @endfor
        console.log(graficZScoreWeightForHeightBoy)
        var graficZScoreWeightForHeightBoy = c3.generate({
            bindto: '#graficZScoreWeightForHeightBoy',
            data: {
                columns:graficZScoreWeightForHeightBoy ,
                type: 'spline'
            }
        });

    </script>

    <script>
        var graficZScoreWeightForHeightBoy=[];
        var i=0,j=0,k=0;
        @for($i=0;$i<count($graficZScoreWeightForHeightBoy);$i++)
        graficZScoreWeightForHeightBoy[i]=new Array();
            j=0;
            k=0;
            @for($j=0;$j<364;$j++)
                if(j==0){
                    graficZScoreWeightForHeightBoy[i][k]="{{$graficZScoreWeightForHeightBoy[$i][$j]}}";
                    k++;
                    graficZScoreWeightForHeightBoy[i][k]={{$graficZScoreWeightForHeightBoy[$i][$j+1]}}
                    k++;
                }
                else{ 
                    if(j%1==0){
                        graficZScoreWeightForHeightBoy[i][k]={{$graficZScoreWeightForHeightBoy[$i][$j]}}
                        k++;
                    }
                }
                j++;
            @endfor
            i++;
        @endfor
        console.log(graficZScoreWeightForHeightBoy)
        var graficZScoreWeightForHeightBoy = c3.generate({
            bindto: '#graficZScoreWeightForHeightBoy',
            data: {
                columns:graficZScoreWeightForHeightBoy ,
                type: 'spline'
            }
        });

    </script>
    <script>
        var graficZScoreGirlx=[];
        var i=0,j=0,k=0;
        @for($i=0;$i<count($graficZScoreGirlx);$i++)
        graficZScoreGirlx[i]=new Array();
            j=0;
            k=0;
            @for($j=0;$j<364;$j++)
                if(j==0){
                    graficZScoreGirlx[i][k]="{{$graficZScoreGirlx[$i][$j]}}";
                    k++;
                    graficZScoreGirlx[i][k]={{$graficZScoreGirlx[$i][$j+1]}}
                    k++;
                }
                else{ 
                    if(j%7==0){
                        graficZScoreGirlx[i][k]={{$graficZScoreGirlx[$i][$j]}}
                        k++;
                    }
                }
                j++;
            @endfor
            i++;
        @endfor
        console.log(graficZScoreGirlx)
        var graficZScoreGirlx = c3.generate({
            bindto: '#graficZScoreGirlx',
            
            data: {
                xs: {
                    'SD2neg': 'x',
                    'SD1neg': 'x',
                    'SD0': 'x',
                    'SD1': 'x',
                    'SD2': 'x',
                },
                columns:graficZScoreGirlx ,
                type: 'spline'
            }
        });

    </script>
@stop
