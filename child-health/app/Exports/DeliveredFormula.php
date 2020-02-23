<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use TCG\Voyager\Database\Schema\SchemaManager;
use TCG\Voyager\Events\BreadDataAdded;
use TCG\Voyager\Events\BreadDataDeleted;
use TCG\Voyager\Events\BreadDataRestored;
use TCG\Voyager\Events\BreadDataUpdated;
use TCG\Voyager\Events\BreadImagesDeleted;
use TCG\Voyager\Facades\Voyager;
use App\Visit;
class DeliveredFormula implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $data;
    function __construct($data) {
        $this->data = $data;
        // dd($this->data);
    }
    public function reportVisitsDelivered(){
        // dd($request);
        if($this->data['date_start']!=null){
            if($this->data['date_end']!=null){
                $delivered=Visit::select("users.name",DB::raw("count(users.name) as delivered"))
                ->join("users","users.id","=","visits.child_user_id")
                ->groupBy("users.name")
                ->orderBy(DB::raw("count(users.name)"),"desc")
                ->whereBetween("visits.date_visit",[$this->data['date_start'],$this->data['date_end']])->get();
            }
        }else{
            $delivered=Visit::select("users.name",DB::raw("count(users.name) as delivered"))
            ->join("users","users.id","=","visits.child_user_id")
            ->groupBy("users.name")
            ->orderBy(DB::raw("count(users.name)"),"desc")
            ->get();
        }
        if($this->data['date_start']!=null){
            if($this->data['date_end']!=null){
                $arrayExcel=[["name"=>"Bebe","quantity"=>"Cantidad entregada desde el ".$this->data['date_start']." hasta el ".$this->data['date_end']]];
            }
        }else{
            $arrayExcel=[["name"=>"Bebe","quantity"=>"Cantidad entregada total"]];
        }
        $auxExcel=[];
        foreach($delivered as $del){
            $auxExcel["name"]=$del->name;
            $auxExcel["quantity"]=$del->delivered;
            array_push($arrayExcel,$auxExcel);
        }
        return $arrayExcel;
    }
    public function collection()
    {
        return collect($this->reportVisitsDelivered());
    }
}
