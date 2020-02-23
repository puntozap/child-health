<div class="col-md-12">
<form action="/admin/search/visitas-delivered" class="visits-deliveded" method="post">
{{ csrf_field() }}

    <div class="col-md-12">
        <label for="">Rango por fechas</label>
    </div>
    <div class="col-md-3">
        <input type="date" name="date_starts" class="form-control" value={{isset($date_start)?$date_start:''}} >
    </div>
    <div class="col-md-3">
        <input type="date" name="date_finishs" class="form-control" value={{isset($date_finish)?$date_finish:''}}>
    </div>
    <div class="col-md-6">
        <button class="btn btn-success btn-block" type="button" onclick="ExcelDelivery()">Exporta Excel</button>
    </div>
    <div class="col-md-12">
        <button  class="btn btn-dark btn-block" >Buscar</button>
    </div>
</form>
</div>
<div class="col-md-12"><hr></div>
<div class="col-md-12"><h3 class="date-delivered">Lista de ninos con formula entregada</h3></div>
<div class="col-md-12"><hr></div>

<div class="col-md-12">
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Cantidad entregada</th>
            </tr>
        </thead>
        <tbody class="delivered-formula">
            @foreach($delivered as $deliver)
            <tr>
                <td>{{$deliver->name}}</td>
                <td>{{$deliver->delivered}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>