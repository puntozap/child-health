<?php

namespace App\Http\Controllers;;

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
use App\ZScoreLengthGirl;
use App\ZScoreLengthBoy;
use App\ZScoreWeightForHeightGirl;
use App\ZScoreWeightForLenghtGirl;
use App\ZScoreWeightForLenghtBoy;
use App\ZScoreWeightForHeightBoy;
use App\ZScoreWeightBoy;
use App\ZScoreWeightGirl;

class GraficasController extends \TCG\Voyager\Http\Controllers\Controller
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

    public function index(Request $request)
    {
        // dd("hola");
        // GET THE SLUG, ex. 'posts', 'pages', etc.
        $ZScoreGirl = ZScoreLengthGirl::get();
        $ZScoreLengthBoy = ZScoreLengthBoy::get();
        $ZScoreWeightForHeightGirl = ZScoreWeightForHeightGirl::get();
        $ZScoreWeightForLenghtGirl = ZScoreWeightForLenghtGirl::get();
        $ZScoreWeightForLenghtBoy = ZScoreWeightForLenghtBoy::get();
        $ZScoreWeightForHeightBoy = ZScoreWeightForHeightBoy::get();
        $ZScoreWeightBoy = ZScoreWeightBoy::get();
        $ZScoreWeightGirl = ZScoreWeightGirl::get();
        // dd($ZScoreLengthBoy);
        $slug='.vendor.voyager.grafica';
        $view = $slug.'.browse';
        // dd('sub-'.$slug);
        $graficZScoreGirl=[['SD2neg'],['SD1neg'],['SD0'],['SD1'],['SD2']];
        // // dd($grafic);
        foreach($ZScoreGirl as $z){
            array_push($graficZScoreGirl[0],$z->SD2neg);
            array_push($graficZScoreGirl[1],$z->SD1neg);
            array_push($graficZScoreGirl[2],$z->SD0);
            array_push($graficZScoreGirl[3],$z->SD1);
            array_push($graficZScoreGirl[4],$z->SD2);
        }
        $graficZScoreLengthBoy=[['SD2neg'],['SD1neg'],['SD0'],['SD1'],['SD2']];
        // // dd($grafic);
        foreach($ZScoreLengthBoy as $z){
            array_push($graficZScoreLengthBoy[0],$z->SD2neg);
            array_push($graficZScoreLengthBoy[1],$z->SD1neg);
            array_push($graficZScoreLengthBoy[2],$z->SD0);
            array_push($graficZScoreLengthBoy[3],$z->SD1);
            array_push($graficZScoreLengthBoy[4],$z->SD2);
        }
        $graficZScoreWeightForHeightGirl=[['SD2neg'],['SD1neg'],['SD0'],['SD1'],['SD2']];
        // // dd($grafic);
        foreach($ZScoreWeightForHeightGirl as $z){
            array_push($graficZScoreWeightForHeightGirl[0],$z->SD2neg);
            array_push($graficZScoreWeightForHeightGirl[1],$z->SD1neg);
            array_push($graficZScoreWeightForHeightGirl[2],$z->SD0);
            array_push($graficZScoreWeightForHeightGirl[3],$z->SD1);
            array_push($graficZScoreWeightForHeightGirl[4],$z->SD2);
        }
        $graficZScoreWeightForLenghtGirl=[['SD2neg'],['SD1neg'],['SD0'],['SD1'],['SD2']];
        // // dd($grafic);
        foreach($ZScoreWeightForLenghtGirl as $z){
            array_push($graficZScoreWeightForLenghtGirl[0],$z->SD2neg);
            array_push($graficZScoreWeightForLenghtGirl[1],$z->SD1neg);
            array_push($graficZScoreWeightForLenghtGirl[2],$z->SD0);
            array_push($graficZScoreWeightForLenghtGirl[3],$z->SD1);
            array_push($graficZScoreWeightForLenghtGirl[4],$z->SD2);
        }
        $graficZScoreWeightForLenghtBoy=[['SD2neg'],['SD1neg'],['SD0'],['SD1'],['SD2'],['x']];
        // // dd($grafic);
        foreach($ZScoreWeightForLenghtBoy as $z){
            array_push($graficZScoreWeightForLenghtBoy[0],$z->SD2neg);
            array_push($graficZScoreWeightForLenghtBoy[1],$z->SD1neg);
            array_push($graficZScoreWeightForLenghtBoy[2],$z->SD0);
            array_push($graficZScoreWeightForLenghtBoy[3],$z->SD1);
            array_push($graficZScoreWeightForLenghtBoy[4],$z->SD2);
            array_push($graficZScoreWeightForLenghtBoy[5],$z->lenght);
        }
        $graficZScoreWeightForHeightBoy=[['SD2neg'],['SD1neg'],['SD0'],['SD1'],['SD2']];
        // // dd($grafic);
        foreach($ZScoreWeightForHeightBoy as $z){
            array_push($graficZScoreWeightForHeightBoy[0],$z->SD2neg);
            array_push($graficZScoreWeightForHeightBoy[1],$z->SD1neg);
            array_push($graficZScoreWeightForHeightBoy[2],$z->SD0);
            array_push($graficZScoreWeightForHeightBoy[3],$z->SD1);
            array_push($graficZScoreWeightForHeightBoy[4],$z->SD2);
        }
        $graficZScoreWeightBoy=[['SD2neg'],['SD1neg'],['SD0'],['SD1'],['SD2']];
        // // dd($grafic);
        foreach($ZScoreWeightBoy as $z){
            array_push($graficZScoreWeightBoy[0],$z->SD2neg);
            array_push($graficZScoreWeightBoy[1],$z->SD1neg);
            array_push($graficZScoreWeightBoy[2],$z->SD0);
            array_push($graficZScoreWeightBoy[3],$z->SD1);
            array_push($graficZScoreWeightBoy[4],$z->SD2);
        }
        $graficZScoreWeightGirl=[['SD2neg'],['SD1neg'],['SD0'],['SD1'],['SD2']];
        // // dd($grafic);
        foreach($ZScoreWeightGirl as $z){
            array_push($graficZScoreWeightGirl[0],$z->SD2neg);
            array_push($graficZScoreWeightGirl[1],$z->SD1neg);
            array_push($graficZScoreWeightGirl[2],$z->SD0);
            array_push($graficZScoreWeightGirl[3],$z->SD1);
            array_push($graficZScoreWeightGirl[4],$z->SD2);
        }
        // dd($grafic);
        // dd($view);


        $graficZScoreGirlx=[['SD2neg'],['SD1neg'],['SD0'],['SD1'],['SD2'],['x']];
        $age=[['x']];
        // // dd($grafic);
        foreach($ZScoreGirl as $z){
            array_push($graficZScoreGirlx[0],$z->SD2neg);
            array_push($graficZScoreGirlx[1],$z->SD1neg);
            array_push($graficZScoreGirlx[2],$z->SD0);
            array_push($graficZScoreGirlx[3],$z->SD1);
            array_push($graficZScoreGirlx[4],$z->SD2);
            array_push($graficZScoreGirlx[5],$z->days);
        }
        // dd($age);
        $ZScoreLengthBoy = ZScoreLengthBoy::get();
        $ZScoreWeightForHeightGirl = ZScoreWeightForHeightGirl::get();
        $ZScoreWeightForLenghtGirl = ZScoreWeightForLenghtGirl::get();
        $ZScoreWeightForLenghtBoy = ZScoreWeightForLenghtBoy::get();
        $ZScoreWeightForHeightBoy = ZScoreWeightForHeightBoy::get();
        $ZScoreWeightBoy = ZScoreWeightBoy::get();
        $ZScoreWeightGirl = ZScoreWeightGirl::get();
        return Voyager::view($view, compact(
            'ZScoreGirl',
            'graficZScoreGirlx',
            'graficZScoreGirl',
            'ZScoreWeightForHeightGirl',
            'ZScoreWeightForLenghtGirl',
            'ZScoreWeightForLenghtBoy',
            'ZScoreWeightForHeightBoy',
            'ZScoreWeightBoy',
            'ZScoreWeightGirl',
            'ZScoreLengthBoy',
            'graficZScoreWeightForHeightGirl',
            'graficZScoreWeightForLenghtGirl',
            'graficZScoreWeightForLenghtBoy',
            'graficZScoreWeightForHeightBoy',
            'graficZScoreWeightBoy',
            'graficZScoreWeightGirl',
            'graficZScoreLengthBoy',

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
        $slug = $this->getSlug($request);

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
        $slug = $this->getSlug($request);

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
        $this->authorize('edit', $dataTypeContent);

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        $view = 'voyager::bread.edit-add';

        if (view()->exists("voyager::$slug.edit-add")) {
            $view = "voyager::$slug.edit-add";
        }

        return Voyager::view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable'));
    }

    // POST BR(E)AD
    public function update(Request $request, $id)
    {
        $slug = $this->getSlug($request);

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

        return redirect()
        ->route("voyager.{$dataType->slug}.index")
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
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('add', app($dataType->model_name));

        $dataTypeContent = (strlen($dataType->model_name) != 0)
                            ? new $dataType->model_name()
                            : false;

        foreach ($dataType->addRows as $key => $row) {
            $dataType->addRows[$key]['col_width'] = $row->details->width ?? 100;
        }

        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'add');

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        $view = 'voyager::bread.edit-add';

        if (view()->exists("voyager::$slug.edit-add")) {
            $view = "voyager::$slug.edit-add";
        }

        return Voyager::view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable'));
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
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('add', app($dataType->model_name));

        // Validate fields with ajax
        $val = $this->validateBread($request->all(), $dataType->addRows)->validate();
        $data = $this->insertUpdateData($request, $slug, $dataType->addRows, new $dataType->model_name());

        event(new BreadDataAdded($dataType, $data));

        return redirect()
        ->route("voyager.{$dataType->slug}.index")
        ->with([
                'message'    => __('voyager::generic.successfully_added_new')." {$dataType->display_name_singular}",
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
        $slug = $this->getSlug($request);

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

        return redirect()->route("voyager.{$dataType->slug}.index")->with($data);
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
}
