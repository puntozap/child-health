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

class VisitsPerMonth implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $data;
    function __construct($data) {
        $this->data = $data;
        // dd($this->data);
    }
    public function verifyChild($array,$child_id,$name,$date){
        for($i=0;$i<count($array);$i++){
                if($array[$i]["name"]==$name){
                    if($array[$i]["date"]==$date){
                        return 1;
                    }
                }
        }
        return 0;
    }
    public function reportVisitsDate(){
        // $view = 'voyager::children.reportes';
        $date_start=$this->data->date_start;
        $date_finish=$this->data->date_end;
        if($date_start!=null&&$date_finish!=null){
            $Visit=DB::select(
            "SELECT DATE_FORMAT(visits.date_visit,'%m-%y') as date_visits, users.id, users.name
            from visits
            join users on users.id=visits.child_user_id
            where role_id=6
            and visits.date_visit between '".$date_start."' and '".$date_finish."'
            
            order by visits.date_visit desc"
            );
        }else{
            $Visit=DB::select(
                "SELECT DATE_FORMAT(visits.date_visit,'%m-%y') as date_visits, users.id, users.name
                from visits
                join users on users.id=visits.child_user_id
                where role_id=6
                
                order by visits.date_visit desc"
                );
        }
        // $arrayChild=[];
        $arrayChild=[["name"=>"Nombre del bebe","date"=>"Fecha","total"=>"Cantida de asistencia"]];
        // dd($arrayChild);
        $data=[];
        // return $Visit;
        foreach($Visit as $visit){
            $response=$this->verifyChild($arrayChild,$visit->id,$visit->name,$visit->date_visits);
            if($response==0){
                $data["name"]=$visit->name;
                $data["date"]=$visit->date_visits;
                $data["total"]=0;
                array_push($arrayChild,$data);
            }
            // print($response." ");
        }
        // dd($arrayChild);
        for($i=0;$i<count($arrayChild);$i++){
            foreach($Visit as $visit){
                $response=$this->checked($arrayChild[$i],$visit->id,$visit->name,$visit->date_visits);
                if($response==1){
                    // print($arrayChild[$response]["total"]. " ");
                    $arrayChild[$i]["total"]=$arrayChild[$i]["total"]+1;
                }
            }
        }
        return $arrayChild;
        // dd("hola",$arrayChild);
        // return Voyager::view($view, compact('view',"arrayChild","date_start","date_finish"));
    }
    public function checked($array,$child_id,$name,$date){
        
        
            // print($array["id"]==$child_id);
            if($array["name"]==$name){
                // print($array["name"]==$name);
                if($array["date"]==$date){
                    // dd($i);
                    return 1;
                }
            }
        return 0;
    }
    public function collection()
    {
       $data=$this->reportVisitsDate();
    //    dd($data);
        return collect($data);
    }
}
