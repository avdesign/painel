<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\Category as Model;
use AVDPainel\Interfaces\Admin\CategoryInterface;
use AVDPainel\Interfaces\Admin\SectionInterface as InterSection;
use AVDPainel\Interfaces\Admin\ConfigKeywordInterface as Keywords;


use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Str;

class CategoryRepository implements CategoryInterface
{
    use ValidatesRequests;

    public $model;
    private $disk;


    /**
     * Create construct.
     *
     * @return void
     */
    public function __construct(
        Model $model, 
        Keywords $keywords,
        InterSection $interSection)
    {
        $this->model         = $model;
        $this->keywords      = $keywords;
        $this->interSection  = $interSection;
        $this->disk          = storage_path('app/public/');

    }

    /**
     * ValidatesRequests
     *
     * @param  array $input
     * @param  array $messages
     * @return array
     */
    public function rules($input, $messages, $id='')
    {
        $this->validate($input, $this->model->rules($id), $messages);
    }

    /**
     * Init Model
     *
     * @return array
     */
    public function get()
    {
        $data  = $this->model->get();
        return $data;    
    }


    /**
     * Table: Keyword
     *
     * @return array
     */
    public function getAll($request)
    {
        $columns = array( 
            0  => 'order',
            1  => 'name',
            2  => 'section',
            3  => 'visits',
            4  => 'description',
            5  => 'active',
            6  => 'tags',
            7  => 'status_featured',
            8  => 'status_banner',
            9  => 'id'
        );
  
        $totalData = $this->model->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');
            
        if (empty($request->input('search.value'))) {            
            $query = $this->model->offset($start) ->limit($limit) ->orderBy($order,$dir)
                         ->get();
        } else {
            $search = $request->input('search.value'); 

            $query =  $this->model->where('name','LIKE',"%{$search}%")
                            ->orWhere('section','LIKE',"%{$search}%")
                            ->orWhere('description', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = $this->model->where('name','LIKE',"%{$search}%")
                            ->orWhere('section','LIKE',"%{$search}%")
                            ->orWhere('description', 'LIKE',"%{$search}%")
                             ->count();
        }

        $data  = array();
        if(!empty($query))
        {
            foreach ($query as $val){

                ($val->active == constLang('active_true') ? $color = 'blue' : $color = 'red');
                ($val->active_featured == constLang('active_true') ? $color_featured = 'blue' : $color_featured = 'red');
                ($val->active_banner == constLang('active_true') ? $color_banner = 'blue' : $color_banner = 'red');

                $edit   = "abreModal('Editar {$val->name}', '".route('categories.edit', $val->id)."', 'categories', 2, 'true', 450, 450)";
                $delete = "deleteCategory('".route('categories.destroy', ['id' => $val->id])."', '{$val->name}')";

                $nData['order']           = $val->order;
                $nData['name']            = $val->name;
                $nData['section']         = $val->section;
                $nData['visits']          = $val->visits;
                $nData['description']     = $val->description;
                $nData['active']          = '<small class="tag '.$color.'-bg">'.$val->active.'</small>';
                $nData['tags']            = $val->tags;
                $nData['active_featured'] = '<small class="tag '.$color_featured.'-bg">'.$val->active_featured.'</small>';
                $nData['active_banner']   = '<small class="tag '.$color_banner.'-bg">'.$val->active_banner.'</small>';
                $nData['id']              = $val->id;
                $data[] = $nData;
            }
        }
          
        $out = array(
            "draw" => intval($request->input('draw')),  
            "recordsTotal" => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data" => $data
        );

        return $out;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return array
     */
    public function setId($id)
    {
        return $this->model->find($id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return array
     */
    public function setName($field, $name)
    {
        return $this->model->where($field, $name)->first();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  array $input
     * @return boolean true or false
     */
    public function create($input)
    {
        $keywords = $this->keywords->rand();
        $section  = $this->interSection->setId($input['section_id']);
        // if < 10 add 0 in front
        $count = strlen($input['order']);
        if ($count == 1) {
            $input['order'] = '0'.$input['order'];
        }

        if ($input['tags'] == '') {
            $input['tags']  = $section->name.' '.$input['name'].','.$keywords['genders'];
        }
        if ($input['description'] == '') {
            $input['description']  = $keywords['description'].' '.$section->name.' '.$input['name'];
        }
        $input['slug']    = Str::slug($input['name'].'-'.$section->name, "-");
        $input['section'] = $section->name;
        $input['visits']  = 0;

        $data = $this->model->create($input);

        if ($data) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Adicionou a Categoria:'.$data->name.'/'.$section->name.
                ', Descrição: '.$data->description.
                ', Tags: '.$data->tags)
            );

            return $data;
        }

        return false;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param  array $input
     * @return boolean true or false
     */
    public function update($input, $id)
    {
        // if < 10 add 0 in front
        $count = strlen($input['order']);
        if ($count == 1) {
            $input['order'] = '0'.$input['order'];
        }
        $keywords = $this->keywords->rand();
        $section  = $this->interSection->setId($input['section_id']);
        // if < 10 add 0 in front
        $count = strlen($input['order']);
        if ($count == 1) {
            $input['order'] = '0'.$input['order'];
        }

        if ($input['tags'] == '') {
            $input['tags']  = $section->name.' '.$input['name'].','.$keywords['genders'];
        }
        if ($input['description'] == '') {
            $input['description']  = $keywords['description'].' '.$section->name.' '.$input['name'];
        }

        $input['slug']    = Str::slug($input['name'].'-'.$section->name, "-");
        $input['section'] = $section->name;

        $data        = $this->model->find($id);
        $name        = $data->name;
        $tags        = $data->tags;
        $description = $data->description;

        $update = $data->update($input);
        if ($update) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Alterou a Categoria:'.$name.'/'.$section->name.
                ', Descrição:'.$data->description.
                ', Tags:'.$tags)
            );

            return true;
        }

        return false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param  int  $config
     * @param  int  $configImages
     * @return array
     */
    public function delete($id, $config, $configImages)
    {
        $total_products = 0;
        $colors         = 0;
        $data           = $this->model->find($id);
        $section        = $this->interSection->setId($data->section_id);
        $products       = $data->products;
        $images         = $data->images;        

        if (count($products) >= 1) {
            $p=1;
            foreach ($products as $product) {
                $i = 1;
                $total_products += $p;                   
                foreach ($product->images as $color) {
                    $colors += $i;
                    foreach ($color->positions as $position) {
                        foreach ($configImages as $value) {
                            if ($value->type == 'P') {
                                $image_position = $this->disk.$value->path.$position->image;
                                if (file_exists($image_position)) {
                                    $remove = unlink($image_position);
                                }
                            }
                            if ($value->type == 'C') {
                                $image_color = $this->disk.$value->path.$color->image;
                                if (file_exists($image_color)) {
                                    $remove = unlink($image_color);
                                }
                            }
                        }
                    }
                }                        
            }
        }

        if (count($images) >= 1) {
            $path_featured   = $this->disk.$config->path.$config->width_featured.'x'.$config->height_featured.'/';
            $path_banner = $this->disk.$config->path.$config->width_banner.'x'.$config->height_banner.'/';
            foreach ($images as $name) {

                if (file_exists($path_featured.$name->image)) {
                    unlink($path_featured.$name->image);
                }

                if (file_exists($path_banner.$name->image)) {
                    unlink($path_banner.$name->image);
                }
            }
        }

        $delete = $data->delete();
        if ($delete) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Excluiu a Categoria:'.$data->name.'/'.$section->name.
                ', Descrição:'.$data->description.
                ', Tags:'.$data->tags)
            );

            $data['total_colors']   = $colors;
            $data['total_products'] = $total_products;

            return $data;
        }

        return false;
    }

}