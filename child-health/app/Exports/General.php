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
use App\User;
use App\Visit;
class General implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $data;
    function __construct($data) {
        $this->data = $data;
        // dd($this->data);
    }
    public function searchResult(){
        if(\Auth::id()==null)
            return redirect("/admin");
            // dd($request);
        $Report=User::select(
            "users.id as user_id",
            "users.name as user_name",
            "users.last_name as user_last_name",
            "users.date_birth as user_date_birth",
            "users.user_son_id",
            "users.role_id as user_role_id",
            "users.phone as user_phone",

            "parents.id as parent_id",
            "parents.name as parent_name",
            "parents.last_name as parent_last_name",
            "parents.date_birth as parent_date_birth",
            "parents.user_son_id as parents_user_son_id",
            "parents.role_id as parent_role_id",
            "parents.dni as parent_dni",

            "country.name as country_name",
            "state.name as state_name",
            "municipio.name as municipio_name",
            "parishes.name as parishes_name",
            "users.address as domicilio",

            "country.id as country_id",
            "state.id as state_id",
            "municipio.id as municipio_id",
            "parishes.id as parishes_id",
            DB::raw("DATEDIFF(CURDATE(),parents.date_birth) as years_parent"),
            DB::raw("DATEDIFF(CURDATE(),users.date_birth) as child_days")

        )
        ->join("users as parents","parents.user_son_id","=","users.id")
        ->join("countries as country","country.id","=","users.country_id")
        ->join("states as state","state.id","=","users.state_id")
        ->join("municipalities as municipio","municipio.id","=","users.municipality_id")
        ->join("parishes as parishes","parishes.id","=","users.parish_id")
        ->orderBy("user_id");
        $date_end="";
        $date_start="";
        $aux="";
        // dd(isset($this->data['date_start']));
        if($this->data['date_start']!=null){
        if(isset($this->data['date_start'])){
            if(isset($this->data['date_finish'])){
                if($this->data['date_start']==null){
                    if($this->data['date_finish']==null){
                        $Report=$Report->get(); 
                    }else{
                        $Report=$Report->get(); 
                    }
                }else{
                    if($this->data['date_finish']==null){
                        $Report=$Report->get(); 
                    }else{
                        if($this->data['date_finish']<$this->data['date_start']){
                            $aux=$this->data['date_finish'];
                            $date_end=$this->data['date_start'];
                            $date_start=$aux;
                        }else{
                            $date_start=$this->data['date_start'];
                            $date_end=$this->data['date_finish'];
                            // dd($date_start,$date_end);
                        }        
                        $Report=$Report->whereBetween("users.date_birth",[$date_start,$date_end]);
                        if($this->data['country_id']!=null&&$this->data['country_id']!="Seleccione"){
                            $Report=$Report->where('users.country_id',$this->data['country_id']);
                        }
                        if($this->data['state_id']!=null&&$this->data['state_id']!="Seleccione"){
                            $Report=$Report->where('users.state_id',$this->data['state_id']);
        
                        }
                        if($this->data['municipality_id']!=null&&$this->data['municipality_id']!="Seleccione"){
                            $Report=$Report->where('users.municipality_id',$this->data['municipality_id']);
                        }
                        if($this->data['parish_id']!=null&&$this->data['parish_id']!="Seleccione"){
                            $Report=$Report->where('users.parish_id',$this->data['parish_id']);
                        }
                    }
                }
            }
        }else{
            $Report=$Report->get();
        }
        }else{
            if($this->data['country_id']!=null&&$this->data['country_id']!="Seleccione"){
                $Report=$Report->where('users.country_id',$this->data['country_id']);
            }
            if($this->data['state_id']!=null&&$this->data['state_id']!="Seleccione"){
                $Report=$Report->where('users.state_id',$this->data['state_id']);

            }
            if($this->data['municipality_id']!=null&&$this->data['municipality_id']!="Seleccione"){
                $Report=$Report->where('users.municipality_id',$this->data['municipality_id']);
            }
            if($this->data['parish_id']!=null&&$this->data['parish_id']!="Seleccione"){
                $Report=$Report->where('users.parish_id',$this->data['parish_id']);
            }
                    
                
        }
        $Report=$Report->get();
        // dd($Report);
        // $arrayVisit=$this->reportVisits();
        $Visit=Visit::get();
        $totalArray=[["name_parents"=>"Nombre del representante",
                      "dni"=>"Cedula",
                      "phone"=>"Telefono",
                      "age_parents"=>"Edad",
                      "name_baby"=>"Bebe",
                      "birth_baby"=>"fecha de nacimiento",
                      "height"=>"Talla",
                      "weigth"=>"Peso",
                      "age_baby"=>"Edad en dias",
                      "country"=>"Pais",
                      "state"=>"Estado",
                      "municipality"=>"Municipio",
                      "parish"=>"Parroquia",
                      "address"=>"Domicilio"]];
        $auxArray=[];
        $aux="";
        foreach($Report as $array){
            if($aux!=$array->user_id){
                $aux=$array->user_id;
                $auxArray["name_parents"]=$array->parent_name." ".$array->parent_last_name;                
                $auxArray["dni"]=$array->parent_dni;                
                $auxArray["phone"]=$array->user_phone;                
                $auxArray["age_parents"]=round($array->years_parent/365);
                $auxArray["name_baby"]=$array->user_name." ".$array->user_last_name;       
                $auxArray["birth_baby"]=$array->user_date_birth;
                $auxArray["height"]=$array->length;
                $auxArray["weigth"]=$array->weight;
                $auxArray["age_baby"]=$array->child_days;
                $auxArray["country"]=$array->country_name;
                $auxArray["state"]=$array->state_name;
                $auxArray["municipality"]=$array->municipio_name;
                $auxArray["parish"]=$array->parishes_name;
                $auxArray["address"]=$array->domicilio;
                array_push($totalArray,$auxArray);

            }
        }
        // dd($totalArray);
        // $date_finish=$date_end;
        // $country_id=$this->data['country_id'];
        // $state_id=$request['state_id'];
        // dd($state_id);
        // $municipality_id=$request['municipality_id'];
        // dd($municipality_id);
        // $parish_id=$request['parish_id'];
        // dd($parish_id);
        // $Visit=Visit::get();
        // $Country=Country::get();
        // $view = 'voyager::children.general';
        
        return $totalArray;
        // return Voyager::view($view, compact('view',"Report",'Visit','Country','date_finish','date_start','country_id','state_id','municipality_id','parish_id'));
        
    }
    
    public function collection()
    {
        return collect($this->searchResult());
    }
}
