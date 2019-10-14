<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\ConfigColorPosition as Model;
use AVDPainel\Interfaces\Admin\ConfigColorPositionInterface;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;


class ConfigColorPositionRepository implements ConfigColorPositionInterface
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
     * Obter totos os registros.
     *
     * @return array
     */
    public function getAll($request)
    {
        $columns = array( 
            0 => 'type',
            1 => 'width',
            2 => 'height',
            3 => 'default',
            4 => 'path',
            5 => 'actions',
            6 => 'updated_at',
            7 => 'created_at',
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


            $query =  $this->model->where('type','LIKE',"%{$search}%")
                            ->where('width','LIKE',"%{$search}%")
                            ->where('height','LIKE',"%{$search}%")
                            ->where('default','LIKE',"%{$search}%")
                            ->orWhere('path', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = $this->model->where('type','LIKE',"%{$search}%")
                            ->where('width','LIKE',"%{$search}%")
                            ->where('height','LIKE',"%{$search}%")
                            ->where('default','LIKE',"%{$search}%")
                            ->orWhere('path', 'LIKE',"%{$search}%")
                            ->count();
        }

        $data  = array();
        if(!empty($query))
        {
            foreach ($query as $val){


                $edit   = "abreModal('Editar Padrão {$val->default}', '".route('colors-positions.edit', ['id' => $val->id])."', 'config-images', 2, 'true', 400, 300)";
                $delete = "deleteConfigImage('".route('colors-positions.destroy', ['id' => $val->id])."', '{$val->default}')";

                $nData['type']     = $val->type;
                $nData['width']    = $val->width;
                $nData['height']   = $val->height;
                $nData['default']  = $val->default;
                $nData['path']     = $val->path;
                $nData['actions']      = '<span class="button-group">';
                if (Gate::allows('config.image.product-delete')) {
                    $nData['actions'] .= '<button onclick="'.$delete.'" class="button icon-trash red-gradient compact"></button>';
                }
                if (Gate::allows('config.image.product-update')) {
                    $nData['actions'] .= '<button onclick="'.$edit.'" class="button icon-pencil compact"></button>';
                }
                $nData['actions']     .= '</span>';
                $nData['updated_at']   = date('j M Y h:i:s',strtotime($val->created_at));
                $nData['created_at']   = date('j M Y h:i:s',strtotime($val->created_at));
                $nData['id']           = $val->id;
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
     *
     * @param  int  $id
     * @return array
     */
    public function setId($id)
    {
        return $this->model->find($id);
    }

    /**
     * Set Name
     *
     * @param  string  $field
     * @param  string  $name
     * @return array
     */
    public function setName($field, $name)
    {
        return $this->model->where($field, $name)->first();
    }


    /**
     * Adicionar
     *
     * @param  array $input
     * @return boolean true or false
     */
    public function create($input)
    {
        $path   = 'public/'.$input['path'];

        if ( !file_exists($path) ) {
            Storage::makeDirectory($path, 0777, true);
        }

        $data = $this->model->create($input);

        if ($data) {
            ($data->type == 'P' ? $type = 'Posições' : $type = 'Cores');
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Adicionou um padrão de imagem, Padrão:'.$data->default.
                ', Tipo:'.$type.
                ', Largura:'.$data->width.
                ', Altura:'.$data->height.
                ', Pasta:'.$data->path)
            );
            return $data;
        }

    }


    /**
     * Alterar
     *
     * @param  int  $id
     * @param  array $input
     * @return boolean true or false
     */
    public function update($input, $id)
    {
        $path   = 'public/'.$input['path'];

        if ( !file_exists($path) ) {
            Storage::makeDirectory($path, 0777, true);
        }

        $data = $this->model->find($id);

        ($data->type == 'P' ? $type = 'Posições' : $type = 'Cores');

        $default = $data->default;
        $width   = $data->width;
        $height  = $data->height;
        $path    = $data->path;

        $update = $data->update($input);
        if ($update) {

            ($input['type'] == 'P' ? $type_post = 'Posições' : $type_post = 'Cores');

            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Alterou o padrão de imagem, Padrão:'.$default.
                ', Tipo:'.$type.
                ', Largura:'.$width.
                ', Altura:'.$height.
                ', Pasta:'.$path.
                ' - Para:'.$input['default'].
                ', Tipo:'.$type_post.
                ', Largura:'.$input['width'].
                ', Altura:'.$input['height'].
                ', Pasta:'.$input['path'])
            );
            return true;
        }

        return false;
    }

    /**
     * Remover
     *
     * @param  int  $id
     * @return boolean true or false
     */
    public function delete($id)
    {
        $data   = $this->model->find($id);
        $delete = $data->delete();
        if ($delete) {
            ($data->type == 'P' ? $type = 'Posições' : $type = 'Cores');
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Removeu o padrão de imagem Padrão:'.$data->default.
                ', Tipo:'.$type.
                ', Largura:'.$data->width.
                ', Altura:'.$data->height.
                ', Pasta:'.$data->path)
            );
            return true;
        }

        return false;
    }


}