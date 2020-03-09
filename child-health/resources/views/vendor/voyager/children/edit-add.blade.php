@php
    $edit = !is_null($dataTypeContent->getKey());
    $add  = is_null($dataTypeContent->getKey());
@endphp

@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', __('voyager::generic.'.($edit ? 'edit' : 'add')).' Niño/Niña ')

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager::generic.'.($edit ? 'edit' : 'add')).' Niño/Niña ' }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">
                    <!-- form start -->
                    <form role="form"
                            class="form-edit-add"
                            action="{{ $edit ? '/admin/children/'.$dataTypeContent->id : '/admin/children' }}"
                            method="POST" enctype="multipart/form-data">
                        <!-- PUT Method if we are editing -->
                        @if($edit)
                            {{ method_field("PUT") }}
                        @endif

                        <!-- CSRF TOKEN -->
                        {{ csrf_field() }}

                        <div class="panel-body">

                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Adding / Editing -->
                            @php
                                $dataTypeRows = $dataType->{($edit ? 'editRows' : 'addRows' )};
                            @endphp
                            <!-- <div class="col-md-12">
                                <label for="">Cedula de Identidad</label>
                                <input type="number" class="form-control" id="dni">
                            </div> -->
                            @foreach($dataTypeRows as $row)
                                <!-- GET THE DISPLAY OPTIONS -->
                                @if($row->id!=9&&$row->id!=10&&$row->id!=4&&$row->id!=3)
                                    @php
                                        $display_options = $row->details->display ?? NULL;
                                        if ($dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')}) {
                                            $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')};
                                        }
                                    @endphp
                                    @if (isset($row->details->legend) && isset($row->details->legend->text))
                                        <legend class="text-{{ $row->details->legend->align ?? 'center' }}" style="background-color: {{ $row->details->legend->bgcolor ?? '#f0f0f0' }};padding: 5px;">{{ $row->details->legend->text }}</legend>
                                    @endif

                                    <div class="form-group @if($row->type == 'hidden') hidden @endif col-md-{{ $display_options->width ?? 12 }} {{ $errors->has($row->field) ? 'has-error' : '' }}" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                        {{ $row->slugify }}
                                        <label class="control-label" for="name">{{ $row->display_name }}</label>
                                        @include('voyager::multilingual.input-hidden-bread-edit-add')
                                        @if (isset($row->details->view))
                                            @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => ($edit ? 'edit' : 'add')])
                                        @elseif ($row->type == 'relationship')
                                            @include('voyager::formfields.relationship', ['options' => $row->details])
                                        @else
                                            {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                        @endif

                                        @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                            {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                        @endforeach
                                        @if ($errors->has($row->field))
                                            @foreach ($errors->get($row->field) as $error)
                                                <span class="help-block">{{ $error }}</span>
                                            @endforeach
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                            <div class="col-md-12">
                                <label for="">Talla</label>
                                <input type="number" step="any" class="form-control" name="length" value="{{isset($dataTypeContent->length)?$dataTypeContent->length:''}}">
                            </div>
                            <div class="col-md-12">
                                <label for="">Peso</label>
                                <input type="number" step="any" class="form-control" name="weight" value="{{isset($dataTypeContent->weight)?$dataTypeContent->weight:''}}">
                            </div>
                            <div class="col-md-12">
                                <label for="">Seleccione Pais</label>
                                
                                <select name="country_id" id="country_id" class="form-control select2" onchange="searchStateCountry()">
                                    <option value="">Seleccione Pais</option>
                                    @foreach($Country as $country)
                                        <option value="{{$country->id}}" {{isset($dataTypeContent->country_id)&&$dataTypeContent->country_id==$country->id?'selected':''}}>{{$country->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 state_id">
                                
                            </div>
                            <div class="col-md-12 municipality_id">
                                
                            </div>
                            <div class="col-md-12 parish_id">
                                
                            </div>
                            <div class="col-md-12">
                                <label for="">Direccion de habitacion</label>
                                <textarea class="form-control" name="address" id="addresss" cols="30" rows="10">{{isset($dataTypeContent->address)?$dataTypeContent->address:""}}</textarea>
                            </div>
                            

                        </div><!-- panel-body -->

                        <div class="panel-footer">
                            @section('submit-buttons')
                                <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                            @stop
                            @yield('submit-buttons')
                        </div>
                    </form>

                    <iframe id="form_target" name="form_target" style="display:none"></iframe>
                    <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
                            enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
                        <input name="image" id="upload_file" type="file"
                                 onchange="$('#my_form').submit();this.value='';">
                        <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
                        {{ csrf_field() }}
                    </form>

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
        function searchStateCountry(){
            var country_id=$("#country_id").val()
            var url="/admin/"+country_id+"/searchStateCountry" ;
            var state="state_id";
            var label="Seleccione Estado";
            var state_id='{{isset($dataTypeContent->state_id)?$dataTypeContent->state_id:""}}';
            var functions="searchMunicipalityState()";
            ajax(url,state,label,functions,state_id);
            // console.log(country_id);
        }
        function searchMunicipalityState(){
            var state_id=$("#state_id").val();
            // alert(state_id==null);
            if(state_id==null){
                state_id="{{isset($dataTypeContent->state_id)?$dataTypeContent->state_id:''}}";
            }
            var url="/admin/"+state_id+"/searchMunicipalityState" ;
            var state="municipality_id";
            var label="Seleccione Municipio";
            
            var municipality_id="{{isset($dataTypeContent->municipality_id)?$dataTypeContent->municipality_id:""}}";
            
            var functions="searchParishMunicipality()";
            ajax(url,state,label,functions,municipality_id);
            // console.log(data);
        }
        function searchParishMunicipality(){
            var municipality_id=$("#municipality_id").val();
            if(municipality_id==null){
                municipality_id='{{isset($dataTypeContent->municipality_id)?$dataTypeContent->municipality_id:""}}';
            }
            var url="/admin/"+municipality_id+"/searchParishMunicipality" ;
            var state="parish_id";
            var label="Seleccione Parroquia";
            var parish_id='{{isset($dataTypeContent->parish_id)?$dataTypeContent->parish_id:""}}';
            var functions="";
            ajax(url,state,label,functions,parish_id);
            // console.log(data);
        }
        function ajax(url,div,label,functions,dataSelected){
            console.log(functions);
            var html="";
            var selected="";
            $.ajax({
                dataType: "json",
                method:'get',
                url:url,    
                success:function(data){
                    $("."+div).html("");
                    console.log(data);
                    html+="<label>"+label+"</label>";
                    html+='<select name="'+div+'" id="'+div+'" class="form-control select2" onchange="'+functions+'">';
                        html+='<option value="">'+label+'</option>';
                        for(var i=0;i<data.length;i++){
                            if(dataSelected==data[i].id){
                                selected="selected";
                            }else{
                                selected="";
                            }
                            html+='<option value="'+data[i].id+'" '+selected+'>'+data[i].name+'</option>';
                        }
                    html+="</select>";
                    $("."+div).append(html);                    
                }
            });
        }
        var band=0;
        @if(!$edit)
            if($("input[name='pathology']").is(':checked')){
                band=1;
                $("select[name='pathology_id']").removeAttr('disabled');
            }else{
                $("select[name='pathology_id']").attr("disabled","disabled");
                band=0;
            }
        @else
            if($("input[name='pathology']").is(':checked')){
                band=1;
                $("select[name='pathology_id']").removeAttr('disabled');
            }else{
                $("select[name='pathology_id']").attr("disabled","disabled");
                band=0;
                
            }
        @endif
        $("input[name='pathology']").change(function(){
            if(band==0){
                $("select[name='pathology_id']").removeAttr('disabled');
                band=1;
            }else{
                $("select[name='pathology_id']").attr("disabled","disabled");
                band=0;
            }
        });
    </script>
    <script>
        @if(isset($dataTypeContent))
            searchStateCountry();
            searchMunicipalityState();
            searchParishMunicipality();
        @endif
    </script>
@stop
