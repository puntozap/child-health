@php
    $edit = !is_null($dataTypeContent->getKey());
    $add  = is_null($dataTypeContent->getKey());
@endphp

@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{asset('vendor/css/charts-c3js/c3.min.css')}}" rel="stylesheet" type="text/css">
@stop

@section('page_title', 'Grafica de Talla vs Dias')

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ 'Grafica de Talla vs Dias' }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Puntuacion Z talla segun la edad ninos</label>
                            <div id="graficZScoreLengthBoy"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="">Puntuacion Z Peso segun la edad ninos</label>
                            <div id="graficZScoreWeightBoy"></div>
                        </div>
                        <div class="col-md-12">
                            <label for="">6 Puntuacion Z Peso por height ninas</label>
                            <div id="graficZScoreWeightForHeightGirl"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-danger" id="confirm_delete_modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}</h4>
                </div>

                <div class="modal-body">
                    <h4>{{ __('voyager::generic.are_you_sure_delete') }} '<span class="confirm_delete_name"></span>'</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="confirm_delete">{{ __('voyager::generic.delete_confirm') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Delete File Modal -->
@stop

@section('javascript')
<script src="{{asset('vendor/js/d3/d3.min.js')}}"></script>
<script src="{{asset('vendor/js/charts-c3js/c3.min.js')}}"></script>
    <script>
        var graficZScoreLengthBoy=[];
        var i=0,j=0,k=0;
        @php $k=0; @endphp
        @for($i=0;$i<count($graficZScoreLengthBoy);$i++)
        graficZScoreLengthBoy[i]=new Array();
            j=0;
            k=0;
            @for($j=0;$j<182;$j++)
                if(j==0){
                    @if($i+1==count($graficZScoreLengthBoy))
                        @if($k+1<count($graficZScoreLengthBoy[$i]))
                            
                            @foreach($graficZScoreLengthBoy[$i] as $g)
                                @if($k==0)
                                    graficZScoreLengthBoy[i][k]="{{$graficZScoreLengthBoy[$i][$k]}}";
                                    k++;
                                    @php $k++; @endphp
                                @else  
                                    graficZScoreLengthBoy[i][k]={{$graficZScoreLengthBoy[$i][$k]}}
                                    k++;    
                                    @php $k++; @endphp
                                @endif
                                
                            @endforeach
                        @endif
                    @else
                        graficZScoreLengthBoy[i][k]="{{$graficZScoreLengthBoy[$i][$j]}}";
                        k++;
                        graficZScoreLengthBoy[i][k]={{$graficZScoreLengthBoy[$i][$j+1]}}
                        k++;
                    @endif
                    
                }
                else{ 
                    @if($k==0)    
                        if(j%7==0){
                                graficZScoreLengthBoy[i][k]={{$graficZScoreLengthBoy[$i][$j]}}
                                k++;
                        }
                    @endif
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
                type: 'spline',
                colors:{
                    SD2neg:'#000000',
                    SD1neg:'gray',
                    SD0:'green',
                    SD1:'gray',
                    SD2:'#000000',
                    Visitas:'red',
                }
            }
        });

    </script>
    
    <script>
        var params = {};
        var $file;

        function deleteHandler(tag, isMulti) {
          return function() {
            $file = $(this).siblings(tag);

            params = {
                slug:   '{{ $dataType->slug }}',
                filename:  $file.data('file-name'),
                id:     $file.data('id'),
                field:  $file.parent().data('field-name'),
                multi: isMulti,
                _token: '{{ csrf_token() }}'
            }

            $('.confirm_delete_name').text(params.filename);
            $('#confirm_delete_modal').modal('show');
          };
        }

        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();

            //Init datepicker for date fields if data-datepicker attribute defined
            //or if browser does not handle date inputs
            $('.form-group input[type=date]').each(function (idx, elt) {
                if (elt.type != 'date' || elt.hasAttribute('data-datepicker')) {
                    elt.type = 'text';
                    $(elt).datetimepicker($(elt).data('datepicker'));
                }
            });

            @if ($isModelTranslatable)
                $('.side-body').multilingual({"editing": true});
            @endif

            $('.side-body input[data-slug-origin]').each(function(i, el) {
                $(el).slugify();
            });

            $('.form-group').on('click', '.remove-multi-image', deleteHandler('img', true));
            $('.form-group').on('click', '.remove-single-image', deleteHandler('img', false));
            $('.form-group').on('click', '.remove-multi-file', deleteHandler('a', true));
            $('.form-group').on('click', '.remove-single-file', deleteHandler('a', false));

            $('#confirm_delete').on('click', function(){
                $.post('{{ route('voyager.media.remove') }}', params, function (response) {
                    if ( response
                        && response.data
                        && response.data.status
                        && response.data.status == 200 ) {

                        toastr.success(response.data.message);
                        $file.parent().fadeOut(300, function() { $(this).remove(); })
                    } else {
                        toastr.error("Error removing file.");
                    }
                });

                $('#confirm_delete_modal').modal('hide');
            });
            $('[data-toggle="tooltip"]').tooltip();
        });
        
      
    </script>

    
    <script>
        var graficZScoreWeightBoy=[];
        var i=0,j=0,k=0;
        @php $k=0; @endphp
        @for($i=0;$i<count($graficZScoreWeightBoy);$i++)
        graficZScoreWeightBoy[i]=new Array();
            j=0;
            k=0;
            @for($j=0;$j<364;$j++)
                if(j==0){
                    @if($i+1==count($graficZScoreWeightBoy))
                        @if($k+1<count($graficZScoreWeightBoy[$i]))
                            
                            @foreach($graficZScoreWeightBoy[$i] as $g)
                            @if($k==0)
                                    graficZScoreWeightBoy[i][k]="{{$graficZScoreWeightBoy[$i][$k]}}";
                                    k++;
                                    @php $k++; @endphp
                                @else  
                                    graficZScoreWeightBoy[i][k]={{$graficZScoreWeightBoy[$i][$k]}}
                                    k++;    
                                    @php $k++; @endphp
                                @endif
                            @endforeach
                        
                        @endif
                    @else
                        graficZScoreWeightBoy[i][k]="{{$graficZScoreWeightBoy[$i][$j]}}";
                        k++;
                        graficZScoreWeightBoy[i][k]={{$graficZScoreWeightBoy[$i][$j+1]}}
                        k++;
                    @endif
                }
                else{ 
                    @if($k==0)  
                    if(j%7==0){
                        graficZScoreWeightBoy[i][k]={{$graficZScoreWeightBoy[$i][$j]}}
                        k++;
                    }
                    @endif
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
                type: 'spline',
                colors:{
                    SD2neg:'#000000',
                    SD1neg:'gray',
                    SD0:'green',
                    SD1:'gray',
                    SD2:'#000000',
                    Visitas:'red',
                }
            }
        });

    </script>
@stop
