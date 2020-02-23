
<div class="col-md-12">
<form action="/admin/search/visitas-fechas" class="visits-report" method="post">
{{ csrf_field() }}

    <div class="col-md-12">
        <label for="">Rango por fechas</label>
    </div>
    <div class="col-md-3">
        <input type="date" name="date_start" class="form-control" value={{isset($date_start)?$date_start:''}} >
    </div>
    <div class="col-md-3">
        <input type="date" name="date_finish" class="form-control" value={{isset($date_finish)?$date_finish:''}}>
    </div>
    <div class="col-md-6">
        <button type="button" class="btn btn-success btn-block" onclick="ExcelVisited()">Exportar a Excel</button>
    </div>
    <div class="col-md-12">
        <button class="btn btn-dark btn-block">Buscar</button>
    </div>
</form>
</div>
<div class="col-md-12">
    <hr>
    <h3>Lista de visitas</h3>
    <hr>
</div>
<div class="col-md-12 scrolling style-3">
    <table class="table">
        <thead>
            <tr class="text-center">
                <th class="text-center">Nombre del niño</th>
                <th class="text-center">Asistencia</th>
                <th class="text-center">Fecha</th>
            </tr>
        </thead>
        <tbody class="list-report">
            @foreach($arrayVisit as $visit)
            <tr>
                <td>{{$visit['name']}}</td>
                <td>{{$visit['total']}}</td>
                <td>{{$visit['date']}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>