<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\ConfigKeyword as Model;
use AVDPainel\Interfaces\Admin\ConfigKeywordInterface;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ConfigKeywordRepository implements ConfigKeywordInterface
{
    use ValidatesRequests;

    public $model;

    /**
     * Create construct.
     *
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
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
            0 => 'title', 
            1 => 'description',
            2 => 'active',
            3 => 'actions', 
            4 => 'keywords',
            5 => 'genders',
            6 => 'categories',
            7 => 'id'

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

            $query =  $this->model->where('title','LIKE',"%{$search}%")
                            ->where('description','LIKE',"%{$search}%")
                            ->where('keywords','LIKE',"%{$search}%")
                            ->where('genders','LIKE',"%{$search}%")
                            ->orWhere('categories', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = $this->model->where('title','LIKE',"%{$search}%")
                            ->where('description','LIKE',"%{$search}%")
                            ->where('keywords','LIKE',"%{$search}%")
                            ->where('genders','LIKE',"%{$search}%")
                            ->orWhere('categories', 'LIKE',"%{$search}%")
                             ->count();
        }

        $data  = array();
        if(!empty($query))
        {
            foreach ($query as $val){

                ($val->active == constLang('active_true') ? $color = 'blue' : $color = 'red');

                $edit   = "abreModal('Editar Seo', '".route('keywords.edit', ['id' => $val->id])."', 'keywords', 2, 'true', 450, 450)";
                $delete = "deleteKeyword('".route('keywords.destroy', ['id' => $val->id])."', '{$val->title}')";

                $nData['title']       = $val->title;
                $nData['description'] = $val->description;
                $nData['active']      = '<small class="tag '.$color.'-bg">'.$val->active.'</small>';
                $nData['actions']     = '<span class="button-group">';
                if (Gate::allows('config-keyword-delete')) {
                    $nData['actions'].= '<button onclick="'.$delete.'" class="button icon-trash red-gradient compact"></button>';
                }
                if (Gate::allows('config-keyword-update')) {
                    $nData['actions'].= '<button onclick="'.$edit.'" class="button icon-pencil compact"></button>';
                }
                $nData['actions']    .= '</span>';
                $nData['keywords']    = $val->keywords;
                $nData['genders']     = $val->genders;
                $nData['categories']  = $val->categories;
                $nData['id']          = $val->id;
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
     * array_rand
     *
     * @param string $fild
     * @return array
     */
    public function rand($fild='')
    {
        foreach ($this->model->get() as $key => $value) {

           if ($value->active == constLang('active_true')) {
               $keywords[$key]['title']       = $value->title;
               $keywords[$key]['genders']     = $value->genders;
               $keywords[$key]['keywords']    = $value->keywords;
               $keywords[$key]['categories']  = $value->categories;
               $keywords[$key]['description'] = $value->description;
            } 
        }

        $id_keyword = array_rand($keywords);

        if ($fild) {
            return $keywords[$id_keyword][$fild];
        }

        return $keywords[$id_keyword];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array $input
     * @return boolean true or false
     */
    public function create($input)
    {

        $data = $this->model->create($input);
        if ($data) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Adicionou o SEO:  Titulo: '.$data->title.
                ', Gêneros: '.$data->genders.
                ', Categorias: '.$data->categories.
                ', Descrição: '.$data->description.
                ', Tags: '.$data->keywords)
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

        $data        = $this->model->find($id);
        $title       = $data->title;
        $genders     = $data->genders;
        $keywords    = $data->keywords;
        $categories  = $data->categories;
        $description = $data->description;

        $update = $data->update($input);
        if ($update) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Alterou as palavras chaves Titulo:'.$title.
                ', Gêneros:'.$genders.
                ', Categorias:'.$categories.
                ', Descrição:'.$description.
                ', Tags:'.$keywords.
                ' para Titulo:'.$data->title.
                ', Gêneros:'.$data->genders.
                ', Categorias:'.$data->categories.
                ', Descrição:'.$data->description.
                ', Tags:'.$data->keywords)
            );

            return true;
        }

        return false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return boolean true or false
     */
    public function delete($id)
    {
        $data   = $this->model->find($id);
        $delete = $data->delete();
        if ($delete) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Excluiu o SEO:  Titulo: '.$data->title.
                ', Gêneros: '.$data->genders.
                ', Categorias: '.$data->categories.
                ', Descrição: '.$data->description.
                ', Tags: '.$data->keywords)
            );
            return true;
        }

        return false;
    }

}