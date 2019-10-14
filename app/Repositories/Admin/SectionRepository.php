<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\Section as Model;
use AVDPainel\Interfaces\Admin\SectionInterface;
use AVDPainel\Interfaces\Admin\ConfigKeywordInterface as Keywords;
use AVDPainel\Interfaces\Admin\ConfigCategoryInterface as InterConfigCategory;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Str;

class SectionRepository implements SectionInterface
{
    use ValidatesRequests;

    public $model;
    public $disk;
    public $keywords;
    public $configCategory;

    /**
     * Create construct.
     *
     * @return void
     */
    public function __construct(
        Model $model, 
        Keywords $keywords,
        InterConfigCategory $configCategory)
    {
        $this->model          = $model;
        $this->keywords       = $keywords;
        $this->configCategory = $configCategory->setId(1);
        $this->disk           = storage_path('app/public/');
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
        $data  = $this->model->orderBy('order', 'asc')->get();
        return $data;    
    }

    /**
     * Select
     *
     * @return array
     */
    public function pluck($name, $id)
    {
        return $this->model->where('active', constLang('active_true'))->pluck($name,$id);
    }


    /**
     * Table: Keyword
     *
     * @return array
     */
    public function getAll($request)
    {
        $columns = array( 
            0 => 'order',
            1 => 'name',
            2 => 'visits',
            3 => 'description',
            4 => 'active',
            5 => 'tags',
            6 => 'active_featured',
            7 => 'active_banner',
            8 => 'id'
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
                            ->orWhere('description', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = $this->model->where('name','LIKE',"%{$search}%")
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

                $nData['order']           = $val->order;
                $nData['name']            = $val->name;
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
     * Store a newly created resource in storage.
     *
     * @param  array $input
     * @return boolean true or false
     */
    public function create($input)
    {
        $keywords = $this->keywords->rand();

        // if < 10 add 0 in front
        $count = strlen($input['order']);
        if ($count == 1) {
            $input['order'] = '0'.$input['order'];
        }

        if ($input['tags'] == '') {
            $input['tags']  = $keywords['genders'].','.$input['name'];
        }
        if ($input['description'] == '') {
            $input['description']  = $keywords['description'].' '.$input['name'];
        }

        $input['slug']   = Str::slug($input['name'], "-");
        $input['visits'] = 0;

        $data = $this->model->create($input);
        if ($data) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Adicionou a Seção:'.$data->name.
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

        $data        = $this->model->find($id);
        $name        = $data->name;
        $tags        = $data->tags;

        $update = $data->update($input);
        if ($update) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Alterou a Seção:'.$name.
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
        $data   = $this->model->find($id);

        $total_products   = 0;
        $total_categories = 0;
        $colors           = 0;
        $categories       = $data->categories;
        $products         = $data->products;

        
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

        if (count($categories) >= 1) {

            $pf = $this->disk.$this->configCategory->path.$this->configCategory
                                ->width_featured.'x'.$this->configCategory->height_featured.'/';
            $pb = $this->disk.$this->configCategory->path.$this->configCategory
                                ->width_banner.'x'.$this->configCategory->height_banner.'/';
            $c=1;
            foreach ($categories as $category) {
                $total_categories += $c;
                if (count($category->images) >= 1) {
                    foreach ($category->images as $cat) {
                        if (file_exists($pf.$cat->image)) {
                            unlink($pf.$cat->image);
                        }

                        if (file_exists($pb.$cat->image)) {
                            unlink($pb.$cat->image);
                        }
                    }                
                }
            }      
        }
        //Remove Images Sections
        $images = $data->images;
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
                ' Excluiu a Seção:'.$data->name.
                ', Descrição:'.$data->description.
                ', Tags:'.$data->tags)
            );

            $data['total_colors']     = $colors;
            $data['total_products']   = $total_products;
            $data['total_categories'] = $total_categories;

            return $data;
        }

        return false;
    }

}