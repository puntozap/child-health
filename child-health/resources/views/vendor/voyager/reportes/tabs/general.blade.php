<div class="col-md-12">
<form action="/admin/generals/results" class="visit-general" method="post">
    {{ csrf_field() }}

    <div class="col-md-12">
        <label for="">Rango por fechas</label>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <label for="">Desde</label>
                <input type="date" name="date_startx" class="form-control" value={{isset($date_start)?$date_start:''}} >
            </div>
            <div class="col-md-12">
                <label for="">Hasta</label>
                <input type="date" name="date_finishx" class="form-control" value={{isset($date_finish)?$date_finish:''}}>    
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
                    <option value="{{$countries->id}}" {{(isset($country_id)&&$country_id==$countries->id?"selected":"")}} {{$country_id==$countries->code?"selected":""}} >{{$countries->name}} </option>
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
    <div class="col-md-4">
        <a href="/admin/reporte/general" class="btn btn-dark btn-block">Limpiar Busqueda</a>
    </div>
    <div class="col-md-4">
        <button class="btn btn-primary btn-block">Buscar</button>
    </div>
    <div class="col-md-4">
        <button type="button" class="btn btn-success btn-block" onclick="ExcelGeneral()">Exportar a Excel</button>
    </div>
</form>
</div>
<div class="col-md-12">
    <hr>
    <h3>Lista general</h3>
    <hr>
</div>
<div class="col-md-12 scrolling style-3">
<table class="table">
    <thead>
        <tr>
            <th>Nombre del representante</th>
            <th>cedula</th>
            <th>telefono</th>
            <th>edad</th>
            <th>bebe</th>
            <th>fecha de nacimiento</th>
            <th>talla</th>
            <th>peso</th>
            <th>edad (dias)</th>
            <th>pais</th>
            <th>estado</th>
            <th>municipio</th>
            <th>parroquia</th>
            <th>domicilio</th>
        </tr>
    </thead>
    <tbody class="list-report-general">
    @php $aux="" @endphp
        @foreach($arrayGeneral as $data)
        @if($aux!=$data->user_id)
        @php $aux=$data->user_id; @endphp
        <tr>
            <td>{{$data->parent_name." ".$data->parent_last_name}}</td>
            <td>{{$data->parent_dni}}</td>
            <td>{{$data->user_phone}}</td>
            <td>
            @php 
                $days=$data->years_parent/365;
            @endphp
            {{round($days)}}</td>
            <td>{{$data->user_name." ".$data->user_last_name}}</td>
            <td>{{$data->user_date_birth}}</td>
            @foreach($Visit as $visit)
            @if($visit->child_user_id==$data->user_id)
            <td>{{$visit->length}}</td>
            <td>{{$visit->weight}}</td>
            @php break; @endphp
            @endif
            @endforeach
            <td>
            @php 
                $days=$data->child_days;
            @endphp
            {{$days}}</td>
            <td>{{$data->country_name}}</td>
            <td>{{$data->state_name}}</td>
            <td>{{$data->municipio_name}}</td>
            <td>{{$data->parishes_name}}</td>
            <td>{{$data->domicilio}}</td>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>
</div>