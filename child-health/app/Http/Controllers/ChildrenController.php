<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use TCG\Voyager\Database\Schema\SchemaManager;
use TCG\Voyager\Events\BreadDataAdded;
use TCG\Voyager\Events\BreadDataDeleted;
use TCG\Voyager\Events\BreadDataRestored;
use TCG\Voyager\Events\BreadDataUpdated;
use TCG\Voyager\Events\BreadImagesDeleted;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\Traits\BreadRelationshipParser;
use App\User;
use App\Visit;
use App\Country;
use App\State;
use App\Municipality;
use App\Parish;
class ChildrenController extends \TCG\Voyager\Http\Controllers\Controller
{
    use BreadRelationshipParser;

    //***************************************
    //               ____
    //              |  _ \
    //              | |_) |
    //              |  _ <
    //              | |_) |
    //              |____/
    //
    //      Browse our Data Type (B)READ
    //
    //****************************************
    public function reportPerChild(){
        
    }
    public function ReportFormulaDelivery(){
        $Visit=Visit::join("users","users.id","=","visits.child_user_id")
        ->join("countries","countries.id","=","users.country_id")
        ->join("states","states.id","=","users.state_id")
        ->join("municipalities","municipalities.id","=","users.municipality_id")
        ->join("parishes","parishes.id","=","users.parish_id")
        ->select(
                "users.name as user_name",
                "users.last_name as user_lastname",
                DB::raw("count(visits.child_user_id) as quantity_visits"),
                "countries.name as country_name",
                "states.name as state_name",
                "municipalities.name as municipality_name",
                "parishes.name as parish_name",
                "address",
                "date_birth"
            )
        ->groupBy("visits.child_user_id","users.name","users.last_name","countries.name","states.name","municipalities.name","parishes.name","address","date_birth")
        ->get();
        $Country=Country::get();
        // dd($Visit);
        $view = 'voyager::children.quantity-formulas';
        return Voyager::view($view, compact('view','Visit',"Country"));
    }
    public function state(Request $request){
        $State=State::where("country_id",$request['country_id'])->get();
        return response()->json($State);
    }
    public function municipality(Request $request){
        $Municipality=Municipality::where("state_id",$request['state_id'])->get();
        return response()->json($Municipality);
    }
    public function parish(Request $request){
        $Parish=Parish::where("municipality_id",$request['municipality_id'])->get();
        return response()->json($Parish);
    }
    public function searchResult(Request $request){
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
            "parishes.id as parishes_id"

        )
        ->join("users as parents","parents.user_son_id","=","users.id")
        ->join("countries as country","country.id","=","users.country_id")
        ->join("states as state","state.id","=","users.state_id")
        ->join("municipalities as municipio","municipio.id","=","users.municipality_id")
        ->join("parishes as parishes","parishes.id","=","users.parish_id");
        $date_end="";
        $date_start="";
        $aux="";
        // dd($request['date_finish']==null==null);
        if($request['date_start']!=null){
        if(isset($request['date_start'])){
            if(isset($request['date_finish'])){
                if($request['date_start']==null){
                    if($request['date_finish']==null){
                        $Report=$Report->get(); 
                    }else{
                        $Report=$Report->get(); 
                    }
                }else{
                    if($request['date_finish']==null){
                        $Report=$Report->get(); 
                    }else{
                        if($request['date_finish']<$request['date_start']){
                            $aux=$request['date_finish'];
                            $date_end=$request['date_start'];
                            $date_start=$aux;
                        }else{
                            $date_start=$request['date_start'];
                            $date_end=$request['date_finish'];
                        }        
                        $Report=$Report->whereBetween("users.date_birth",[$date_start,$date_end]);
                        if($request['country_id']!=null&&$request['country_id']!="Seleccione"){
                            $Report=$Report->where('users.country_id',$request['country_id']);
                        }else{
                            if($request['state_id']!=null&&$request['state_id']!="Seleccione"){
                                $Report=$Report->where('users.state_id',$request['state_id']);
            
                            }else{
                                if($request['municipality_id']!=null&&$request['municipality_id']!="Seleccione"){
                                    $Report=$Report->where('users.municipality_id',$request['municipality_id']);
                                }else{
                                    if($request['parish_id']!=null&&$request['parish_id']!="Seleccione"){
                                        $Report=$Report->where('users.parish_id',$request['parish_id']);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }else{
            $Report=$Report->get();
        }
        }else{
            if($request['country_id']!=null&&$request['country_id']!="Seleccione"){
                $Report=$Report->where('users.country_id',$request['country_id']);
            }
                if($request['state_id']!=null&&$request['state_id']!="Seleccione"){
                    $Report=$Report->where('users.state_id',$request['state_id']);

                }
                    if($request['municipality_id']!=null&&$request['municipality_id']!="Seleccione"){
                        $Report=$Report->where('users.municipality_id',$request['municipality_id']);
                    }
                        if($request['parish_id']!=null&&$request['parish_id']!="Seleccione"){
                            $Report=$Report->where('users.parish_id',$request['parish_id']);
                        }
                    
                
        }
        $Report=$Report->get();
        // dd($Report);
        $date_finish=$date_end;
        $country_id=$request['country_id'];
        $state_id=$request['state_id'];
        // dd($state_id);
        $municipality_id=$request['municipality_id'];
        // dd($municipality_id);
        $parish_id=$request['parish_id'];
        // dd($parish_id);
        $Visit=Visit::get();
        $Country=Country::get();
        $view = 'voyager::children.general';
        return Voyager::view($view, compact('view',"Report",'Visit','Country','date_finish','date_start','country_id','state_id','municipality_id','parish_id'));
        
    }
    public function GeneralReport(){
        if(\Auth::id()==null)
            return redirect("/admin");
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        //dd($ip);
        //  $ip="181.16.232.24";//190.36.180.179
        $ip="201.208.143.109";//190.36.180.179 Search Results
        
        if($ip!="127.0.0.1"){
        $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}"));}
        // dd($details);
        $country_id=$details->country;
        // dd($country_id);
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
            "users.address as domicilio"

        )
        ->join("users as parents","parents.user_son_id","=","users.id")
        ->join("countries as country","country.id","=","users.country_id")
        ->join("states as state","state.id","=","users.state_id")
        ->join("municipalities as municipio","municipio.id","=","users.municipality_id")
        ->join("parishes as parishes","parishes.id","=","users.parish_id")
        ->get();
        $Visit=Visit::get();
        $Country=Country::get();
        // dd($details);
        // dd($Visit);
        // $dEnd = new DateTime(date("Y-m-d"));
        // $dStart  = new DateTime($User->date_birth);
        // $dDiff = $dStart->diff($dEnd);
        // $days=$dDiff->format('%r%a');
        $view = 'voyager::children.general';
        return Voyager::view($view, compact('view',"Report",'Visit','Country','details'));
    }
    public function verifyChild($array,$child_id,$name,$date){
        for($i=0;$i<count($array);$i++){
            if($array[$i]["id"]==$child_id){
                if($array[$i]["name"]==$name){
                    if($array[$i]["date"]==$date){
                        return 1;
                    }
                }
            }
        }
        return 0;
    }
    public function checked($array,$child_id,$name,$date){
        
        
            if($array["id"]==$child_id){
                // print($array["id"]==$child_id);
                if($array["name"]==$name){
                    // print($array["name"]==$name);
                    if($array["date"]==$date){
                        // dd($i);
                        return 1;
                    }
                }
            }
        return 0;
    }
    public function reportVisits(){
        $view = 'voyager::children.reportes';
        $Visit=DB::select(
        "SELECT DATE_FORMAT(visits.date_visit,'%m-%y') as date_visits, users.id, users.name
        from visits
        join users on users.id=visits.child_user_id
        where role_id=6
        
        order by visits.date_visit desc"
        );
        $arrayChild=[];
        $data=[];
        foreach($Visit as $visit){
            $response=$this->verifyChild($arrayChild,$visit->id,$visit->name,$visit->date_visits);
            if($response==0){
                $data["id"]=$visit->id;
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
        // dd("hola",$arrayChild);
        return Voyager::view($view, compact('view',"arrayChild"));
    }
    public function reportVisitsDate(Request $request){
        // dd($request);
        $date_start=$request['date_start'];
        $date_finish=$request['date_finish'];
        $view = 'voyager::children.reportes';
        $Visit=DB::select(
        "SELECT DATE_FORMAT(visits.date_visit,'%m-%y') as date_visits, users.id, users.name
        from visits
        join users on users.id=visits.child_user_id
        where role_id=6
        and visits.date_visit between '".$request['date_start']."' and '".$request['date_finish']."'
        order by visits.date_visit desc"
        );
        $arrayChild=[];
        $data=[];
        foreach($Visit as $visit){
            $response=$this->verifyChild($arrayChild,$visit->id,$visit->name,$visit->date_visits);
            if($response==0){
                $data["id"]=$visit->id;
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
        // dd("hola",$arrayChild);
        return Voyager::view($view, compact('view',"arrayChild","date_start","date_finish"));
    }

    public function index(Request $request)
    {
        // GET THE SLUG, ex. 'posts', 'pages', etc.

        // dd("index");
        // $slug = $this->getSlug($request);
        
        $slug='users';
        // GET THE DataType based on the slug
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        // dd($dataType);
        // Check permission
        // $this->authorize('browse', app($dataType->model_name));

        $getter = $dataType->server_side ? 'paginate' : 'get';

        $search = (object) ['value' => $request->get('s'), 'key' => $request->get('key'), 'filter' => $request->get('filter')];
        $searchable = $dataType->server_side ? array_keys(SchemaManager::describeTable(app($dataType->model_name)->getTable())->toArray()) : '';
        $orderBy = $request->get('order_by', $dataType->order_column);
        $sortOrder = $request->get('sort_order', null);
        $usesSoftDeletes = false;
        $showSoftDeleted = false;
        $orderColumn = [];
        if ($orderBy) {
            $index = $dataType->browseRows->where('field', $orderBy)->keys()->first() + 1;
            $orderColumn = [[$index, 'desc']];
            if (!$sortOrder && isset($dataType->order_direction)) {
                $sortOrder = $dataType->order_direction;
                $orderColumn = [[$index, $dataType->order_direction]];
            } else {
                $orderColumn = [[$index, 'desc']];
            }
        }
        // dd($orderBy);
        // Next Get or Paginate the actual content from the MODEL that corresponds to the slug DataType
        if (strlen($dataType->model_name) != 0) {
            $model = app($dataType->model_name);

            if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope'.ucfirst($dataType->scope))) {
                $query = $model->{$dataType->scope}();
            } else {
                $query = $model::select('*');
            }

            // Use withTrashed() if model uses SoftDeletes and if toggle is selected
            if ($model && in_array(SoftDeletes::class, class_uses($model)) && app('VoyagerAuth')->user()->can('delete', app($dataType->model_name))) {
                $usesSoftDeletes = true;

                if ($request->get('showSoftDeleted')) {
                    $showSoftDeleted = true;
                    $query = $query->withTrashed();
                }
            }

            // If a column has a relationship associated with it, we do not want to show that field
            $this->removeRelationshipField($dataType, 'browse');

            if ($search->value != '' && $search->key && $search->filter) {
                $search_filter = ($search->filter == 'equals') ? '=' : 'LIKE';
                $search_value = ($search->filter == 'equals') ? $search->value : '%'.$search->value.'%';
                $query->where($search->key, $search_filter, $search_value);
            }

            if ($orderBy && in_array($orderBy, $dataType->fields())) {
                $querySortOrder = (!empty($sortOrder)) ? $sortOrder : 'desc';
                $dataTypeContent = call_user_func([
                    $query->orderBy($orderBy, $querySortOrder),
                    $getter,
                ]);
            } elseif ($model->timestamps) {
                $dataTypeContent = call_user_func([$query->latest($model::CREATED_AT), $getter]);
            } else {
                $dataTypeContent = call_user_func([$query->orderBy($model->getKeyName(), 'DESC'), $getter]);
            }

            // Replace relationships' keys for labels and create READ links if a slug is provided.
            $dataTypeContent = $this->resolveRelations($dataTypeContent, $dataType);
        } else {
            // If Model doesn't exist, get data from table name
            $dataTypeContent = call_user_func([DB::table($dataType->name), $getter]);
            $model = false;
        }

        // Check if BREAD is Translatable
        if (($isModelTranslatable = is_bread_translatable($model))) {
            $dataTypeContent->load('translations');
        }
        $dataTypeContent=User::where("role_id",6)->get();
        $Parents=User::where("role_id",3)->orWhere("role_id",4)->get();
        // dd($parents);
        // dd($dataTypeContent);
        // Check if server side pagination is enabled
        $isServerSide = isset($dataType->server_side) && $dataType->server_side;

        // Check if a default search key is set
        $defaultSearchKey = $dataType->default_search_key ?? null;

        $view = 'voyager.children.browse';

        if (view()->exists("voyager::children.browse")) {
            $view = "voyager::children.browse";
        }
        // dd($view);

        return Voyager::view($view, compact(
            'dataType',
            'dataTypeContent',
            'isModelTranslatable',
            'search',
            'orderBy',
            'orderColumn',
            'sortOrder',
            'searchable',
            'isServerSide',
            'defaultSearchKey',
            'usesSoftDeletes',
            'showSoftDeleted',
            'Parents'
        ));
    }

    //***************************************
    //                _____
    //               |  __ \
    //               | |__) |
    //               |  _  /
    //               | | \ \
    //               |_|  \_\
    //
    //  Read an item of our Data Type B(R)EAD
    //
    //****************************************

    public function show(Request $request, $id)
    {
        // dd("show");
        // $slug = $this->getSlug($request);
        $slug="users";

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        $isSoftDeleted = false;

        if (strlen($dataType->model_name) != 0) {
            $model = app($dataType->model_name);

            // Use withTrashed() if model uses SoftDeletes and if toggle is selected
            if ($model && in_array(SoftDeletes::class, class_uses($model))) {
                $model = $model->withTrashed();
            }
            if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope'.ucfirst($dataType->scope))) {
                $model = $model->{$dataType->scope}();
            }
            $dataTypeContent = call_user_func([$model, 'findOrFail'], $id);
            if ($dataTypeContent->deleted_at) {
                $isSoftDeleted = true;
            }
        } else {
            // If Model doest exist, get data from table name
            $dataTypeContent = DB::table($dataType->name)->where('id', $id)->first();
        }

        // Replace relationships' keys for labels and create READ links if a slug is provided.
        $dataTypeContent = $this->resolveRelations($dataTypeContent, $dataType, true);

        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'read');

        // Check permission
        $this->authorize('read', $dataTypeContent);

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        $view = 'voyager::bread.read';
        $slug="children";
        if (view()->exists("voyager::$slug.read")) {
            $view = "voyager::$slug.read";
        }

        return Voyager::view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable', 'isSoftDeleted'));
    }

    //***************************************
    //                ______
    //               |  ____|
    //               | |__
    //               |  __|
    //               | |____
    //               |______|
    //
    //  Edit an item of our Data Type BR(E)AD
    //
    //****************************************

    public function edit(Request $request, $id)
    {
        // dd("edit");
        // $slug = $this->getSlug($request);
        $slug="users";
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        if (strlen($dataType->model_name) != 0) {
            $model = app($dataType->model_name);

            // Use withTrashed() if model uses SoftDeletes and if toggle is selected
            if ($model && in_array(SoftDeletes::class, class_uses($model))) {
                $model = $model->withTrashed();
            }
            if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope'.ucfirst($dataType->scope))) {
                $model = $model->{$dataType->scope}();
            }
            $dataTypeContent = call_user_func([$model, 'findOrFail'], $id);
        } else {
            // If Model doest exist, get data from table name
            $dataTypeContent = DB::table($dataType->name)->where('id', $id)->first();
        }

        foreach ($dataType->editRows as $key => $row) {
            $dataType->editRows[$key]['col_width'] = isset($row->details->width) ? $row->details->width : 100;
        }

        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'edit');

        // Check permission
        // $this->authorize('edit', $dataTypeContent);

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        $view = 'voyager.children.edit-add';
        $slug="children";
        if (view()->exists("voyager::$slug.edit-add")) {
            $view = "voyager::$slug.edit-add";
        }
        // dd($view);
        $Country=Country::get();
        $State=State::get();
        $Municipality=Municipality::get();
        $Parish=Parish::get();
        return Voyager::view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable','Country'));
    }

    // POST BR(E)AD
    public function update(Request $request, $id)
    {
        // $slug = $this->getSlug($request);
        $slug="users";

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Compatibility with Model binding.
        $id = $id instanceof Model ? $id->{$id->getKeyName()} : $id;

        $model = app($dataType->model_name);
        if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope'.ucfirst($dataType->scope))) {
            $model = $model->{$dataType->scope}();
        }
        if ($model && in_array(SoftDeletes::class, class_uses($model))) {
            $data = $model->withTrashed()->findOrFail($id);
        } else {
            $data = call_user_func([$dataType->model_name, 'findOrFail'], $id);
        }

        // Check permission
        $this->authorize('edit', $data);

        // Validate fields with ajax
        $val = $this->validateBread($request->all(), $dataType->editRows, $dataType->name, $id)->validate();
        $this->insertUpdateData($request, $slug, $dataType->editRows, $data);

        event(new BreadDataUpdated($dataType, $data));
        $User=User::find($id);
        $User->country_id=$request['country_id'];
        $User->state_id=$request['state_id'];
        $User->municipality_id=$request['municipality_id'];
        $User->parish_id=$request['parish_id'];
        $User->address=$request['address'];
        // dd($User);
        $User->role_id=6;
        $User->save();
        return redirect("/admin/children")
        ->with([
            'message'    => __('voyager::generic.successfully_updated')." {$dataType->display_name_singular}",
            'alert-type' => 'success',
        ]);
    }

    //***************************************
    //
    //                   /\
    //                  /  \
    //                 / /\ \
    //                / ____ \
    //               /_/    \_\
    //
    //
    // Add a new item of our Data Type BRE(A)D
    //
    //****************************************

    public function create(Request $request)
    {
        // dd("create");
        // $slug = $this->getSlug($request);
        $slug='users';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('add', app($dataType->model_name));

        $dataTypeContent = (strlen($dataType->model_name) != 0)
                            ? new $dataType->model_name()
                            : false;

        foreach ($dataType->addRows as $key => $row) {
                $dataType->addRows[$key]['col_width'] = $row->details->width ?? 100;
        }
        // dd($dataType->addRows);
        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'add');

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        $view = 'voyager.children.edit-add';

        if (view()->exists("voyager::children.edit-add")) {
            $view = "voyager::children.edit-add";
        }
        // dd($view);
        $Country=Country::get();
        $State=State::get();
        $Municipality=Municipality::get();
        $Parish=Parish::get();
        // dd($Country);
        return Voyager::view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable','Country','State','Municipality','Parish'));
    }

    /**
     * POST BRE(A)D - Store data.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // dd($request);
        // $slug = $this->getSlug($request);
        $slug="users";

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        // dd($dataType);
        // Check permission
        $this->authorize('add', app($dataType->model_name));

        // Validate fields with ajax
        $val = $this->validateBread($request->all(), $dataType->addRows)->validate();
        $data = $this->insertUpdateData($request, $slug, $dataType->addRows, new $dataType->model_name());
        // dd($data);
        $User=User::find($data->id);
        $User->country_id=$request['country_id'];
        $User->state_id=$request['state_id'];
        $User->municipality_id=$request['municipality_id'];
        $User->parish_id=$request['parish_id'];
        $User->address=$request['address'];
        $User->length=$request['length'];
        $User->weight=$request['weight'];
        $User->role_id=6;
        $User->save();
        event(new BreadDataAdded($dataType, $data));

        return redirect("/admin/children/parents/".$User->id."/create")
        ->with([
                'message'    => __('voyager::generic.successfully_added_new')." probando",
                'alert-type' => 'success',
            ]);
    }

    //***************************************
    //                _____
    //               |  __ \
    //               | |  | |
    //               | |  | |
    //               | |__| |
    //               |_____/
    //
    //         Delete an item BREA(D)
    //
    //****************************************

    public function destroy(Request $request, $id)
    {
        dd("destroy");
        // $slug = $this->getSlug($request);
        $slug="users";
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('delete', app($dataType->model_name));

        // Init array of IDs
        $ids = [];
        if (empty($id)) {
            // Bulk delete, get IDs from POST
            $ids = explode(',', $request->ids);
        } else {
            // Single item delete, get ID from URL
            $ids[] = $id;
        }
        foreach ($ids as $id) {
            // dd($id);
            $data = call_user_func([$dataType->model_name, 'findOrFail'], $id);

            $model = app($dataType->model_name);
            if (!($model && in_array(SoftDeletes::class, class_uses($model)))) {
                $this->cleanup($dataType, $data);
            }
        }

        $displayName = count($ids) > 1 ? $dataType->display_name_plural : $dataType->display_name_singular;

        $res = $data->destroy($ids);
        $data = $res
            ? [
                'message'    => __('voyager::generic.successfully_deleted')." {$displayName}",
                'alert-type' => 'success',
            ]
            : [
                'message'    => __('voyager::generic.error_deleting')." {$displayName}",
                'alert-type' => 'error',
            ];

        if ($res) {
            event(new BreadDataDeleted($dataType, $data));
        }

        return redirect("/admin/children")->with($data);
    }

    public function restore(Request $request, $id)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('delete', app($dataType->model_name));

        // Get record
        $model = call_user_func([$dataType->model_name, 'withTrashed']);
        if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope'.ucfirst($dataType->scope))) {
            $model = $model->{$dataType->scope}();
        }
        $data = $model->findOrFail($id);

        $displayName = $dataType->display_name_singular;

        $res = $data->restore($id);
        $data = $res
            ? [
                'message'    => __('voyager::generic.successfully_restored')." {$displayName}",
                'alert-type' => 'success',
            ]
            : [
                'message'    => __('voyager::generic.error_restoring')." {$displayName}",
                'alert-type' => 'error',
            ];

        if ($res) {
            event(new BreadDataRestored($dataType, $data));
        }

        return redirect()->route("voyager.{$dataType->slug}.index")->with($data);
    }

    /**
     * Remove translations, images and files related to a BREAD item.
     *
     * @param \Illuminate\Database\Eloquent\Model $dataType
     * @param \Illuminate\Database\Eloquent\Model $data
     *
     * @return void
     */
    protected function cleanup($dataType, $data)
    {
        // Delete Translations, if present
        if (is_bread_translatable($data)) {
            $data->deleteAttributeTranslations($data->getTranslatableAttributes());
        }

        // Delete Images
        $this->deleteBreadImages($data, $dataType->deleteRows->where('type', 'image'));

        // Delete Files
        foreach ($dataType->deleteRows->where('type', 'file') as $row) {
            if (isset($data->{$row->field})) {
                foreach (json_decode($data->{$row->field}) as $file) {
                    $this->deleteFileIfExists($file->download_link);
                }
            }
        }

        // Delete media-picker files
        $dataType->rows->where('type', 'media_picker')->where('details.delete_files', true)->each(function ($row) use ($data) {
            $content = $data->{$row->field};
            if (isset($content)) {
                if (!is_array($content)) {
                    $content = json_decode($content);
                }
                if (is_array($content)) {
                    foreach ($content as $file) {
                        $this->deleteFileIfExists($file);
                    }
                } else {
                    $this->deleteFileIfExists($content);
                }
            }
        });
    }

    /**
     * Delete all images related to a BREAD item.
     *
     * @param \Illuminate\Database\Eloquent\Model $data
     * @param \Illuminate\Database\Eloquent\Model $rows
     *
     * @return void
     */
    public function deleteBreadImages($data, $rows)
    {
        foreach ($rows as $row) {
            if ($data->{$row->field} != config('voyager.user.default_avatar')) {
                $this->deleteFileIfExists($data->{$row->field});
            }

            if (isset($row->details->thumbnails)) {
                foreach ($row->details->thumbnails as $thumbnail) {
                    $ext = explode('.', $data->{$row->field});
                    $extension = '.'.$ext[count($ext) - 1];

                    $path = str_replace($extension, '', $data->{$row->field});

                    $thumb_name = $thumbnail->name;

                    $this->deleteFileIfExists($path.'-'.$thumb_name.$extension);
                }
            }
        }

        if ($rows->count() > 0) {
            event(new BreadImagesDeleted($data, $rows));
        }
    }

    /**
     * Order BREAD items.
     *
     * @param string $table
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function order(Request $request)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('edit', app($dataType->model_name));

        if (!isset($dataType->order_column) || !isset($dataType->order_display_column)) {
            return redirect()
            ->route("voyager.{$dataType->slug}.index")
            ->with([
                'message'    => __('voyager::bread.ordering_not_set'),
                'alert-type' => 'error',
            ]);
        }

        $model = app($dataType->model_name);
        if ($model && in_array(SoftDeletes::class, class_uses($model))) {
            $model = $model->withTrashed();
        }
        $results = $model->orderBy($dataType->order_column, $dataType->order_direction)->get();

        $display_column = $dataType->order_display_column;

        $dataRow = Voyager::model('DataRow')->whereDataTypeId($dataType->id)->whereField($display_column)->first();

        $view = 'voyager::bread.order';

        if (view()->exists("voyager::$slug.order")) {
            $view = "voyager::$slug.order";
        }

        return Voyager::view($view, compact(
            'dataType',
            'display_column',
            'dataRow',
            'results'
        ));
    }

    public function update_order(Request $request)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('edit', app($dataType->model_name));

        $model = app($dataType->model_name);

        $order = json_decode($request->input('order'));
        $column = $dataType->order_column;
        foreach ($order as $key => $item) {
            if ($model && in_array(SoftDeletes::class, class_uses($model))) {
                $i = $model->withTrashed()->findOrFail($item->id);
            } else {
                $i = $model->findOrFail($item->id);
            }
            $i->$column = ($key + 1);
            $i->save();
        }
    }

    public function action(Request $request)
    {
        $slug = $this->getSlug($request);
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        $action = new $request->action($dataType, null);

        return $action->massAction(explode(',', $request->ids), $request->headers->get('referer'));
    }

    /**
     * Get BREAD relations data.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function relation(Request $request)
    {
        $slug = $this->getSlug($request);
        $page = $request->input('page');
        $on_page = 50;
        $search = $request->input('search', false);
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        $rows = $request->input('method', 'add') == 'add' ? $dataType->addRows : $dataType->editRows;
        foreach ($rows as $key => $row) {
            if ($row->field === $request->input('type')) {
                $options = $row->details;
                $skip = $on_page * ($page - 1);

                // If search query, use LIKE to filter results depending on field label
                if ($search) {
                    $total_count = app($options->model)->where($options->label, 'LIKE', '%'.$search.'%')->count();
                    $relationshipOptions = app($options->model)->take($on_page)->skip($skip)
                        ->where($options->label, 'LIKE', '%'.$search.'%')
                        ->get();
                } else {
                    $total_count = app($options->model)->count();
                    $relationshipOptions = app($options->model)->take($on_page)->skip($skip)->get();
                }

                $results = [];
                foreach ($relationshipOptions as $relationshipOption) {
                    $results[] = [
                        'id'   => $relationshipOption->{$options->key},
                        'text' => $relationshipOption->{$options->label},
                    ];
                }

                return response()->json([
                    'results'    => $results,
                    'pagination' => [
                        'more' => ($total_count > ($skip + $on_page)),
                    ],
                ]);
            }
        }

        // No result found, return empty array
        return response()->json([], 404);
    }
    
    public function searchStateCountry($id){
        $State=State::where("country_id",$id)->get();
        
        return response()->json($State);
    }
    public function searchMunicipalityState($id){
        $Municipality=Municipality::where("state_id",$id)->get();
        
        return response()->json($Municipality);
    }
    public function searchParishMunicipality($id){
        $Parish=Parish::where("municipality_id",$id)->get();
        
        return response()->json($Parish);
    }
}
