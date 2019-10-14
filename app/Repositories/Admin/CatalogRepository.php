<?php

namespace AVDPainel\Repositories\Admin;

use Illuminate\Support\Facades\Gate;

use AVDPainel\Models\Admin\ImageColor as Model;
use AVDPainel\Interfaces\Admin\CatalogInterface;
use AVDPainel\Interfaces\Admin\ConfigColorPositionInterface as ConfigImage;

class CatalogRepository implements CatalogInterface
{

    public $model;
    private $photoUrl;
    private $disk;

    /**
     * Create construct.
     *
     * @return void
     */
    public function __construct(
        Model $model,
        ConfigImage $configImage)
    {
        $this->model          = $model;
        $this->configImage    = $configImage;

        $this->photoUrl      = 'storage/';
        $this->disk           = storage_path('app/public/');
    }

    /**
     * Date: 15/06/2019
     *
     * @param $request
     * @return json
     */
    public function getAll($request)
    {
        $columns = array(
            0 => 'id',
            1 => 'code',
            2 => 'color',
            3 => 'category',
            4 => 'section',
            5 => 'brand',
            6 => 'visits',
            7 => 'active',
            8 => 'actions'
        );

        $totalData = $this->model->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {

            $query = $this->model->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

        } else {
            $search = $request->input('search.value');

            $query =  $this->model->where('slug','LIKE',"%{$search}%")
                ->orWhere('code', 'LIKE',"%{$search}%")
                ->orWhere('description', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered = $this->model->where('slug','LIKE',"%{$search}%")
                ->orWhere('code', 'LIKE',"%{$search}%")
                ->orWhere('description', 'LIKE',"%{$search}%")
                ->count();
        }

        // Configurações
        $configImage   = $this->configImage->setName('default', 'T');

        $path    = $configImage->path;
        $data    = array();

        if(!empty($query))
        {
            foreach ($query as $val){

                if ($val->image != '') {
                    $image = '<a href="javascript:void(0)"><img id="img-'.$val->id.'" src="'.url($this->photoUrl.$path.$val->image).'" width="80" /></a>';
                } else {
                    $image = '<img src="'.url('backend/img/default/no_image.png').'" />';
                }

                ($val->cover == 1 ? $cover   = '<p><small class="tag">Capa</small></p>' : $cover = '');

                if ($val->active == constLang('active_true')) {
                    $active = constLang('active_false');
                    $clickStatus = "statusCatalog('{$val->id}','".route('status.catalog', $val->id)."','{$active}','".csrf_token()."')";
                    $status = '<button type="button" onclick="'.$clickStatus.'" class="button compact icon-tick green-gradient">'.constLang('active_true').'</button>';

                } else {
                    $active = constLang('active_true');
                    $clickStatus = "statusCatalog('{$val->id}','".route('status.catalog', $val->id)."', '{$active}','".csrf_token()."')";
                    $status = '<button type="button" onclick="'.$clickStatus.'" class="button compact grey-gradient">'.constLang('active_true').'</button>';

                }


                $color   = $cover.'<span id="color-'.$val->id.'">'.$val->color.'</span>';
                $code    = '<span id="code-'.$val->id.'">'.$val->code.'</span>';

                $edit   = "abreModal('Editar: Cor {$val->color}', '".route('colors-product.edit', ['idpro' => $val->product_id,'id' => $val->id])."', 'form-colors', 2, 'true',800,780)";
                $delete = "deleteColor('{$val->id}', '".route('colors-product.destroy', ['idpro' => $val->product_id, 'id' => $val->id])."')";

                $nData['image']    = $image;
                $nData['code']     = $code;
                $nData['color']    = $color;
                $nData['category'] = $val->product->category;
                $nData['section']  = $val->product->section;
                $nData['brand']    = $val->product->brand;
                $nData['visits']   = $val->visits;
                $nData['active']   = $status;
                $nData['actions']  = '<span class="button-group">';
                if (Gate::allows('product-images-delete')) {
                    $nData['actions'] .= '<button onclick="'.$delete.'" class="button icon-trash red-gradient compact"></button>';
                }
                if (Gate::allows('product-images-update')) {
                    $nData['actions'] .= '<button onclick="'.$edit.'" class="button icon-pencil compact">Editar</button>';
                }
                $nData['actions']  .= '</span>';
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
     * Date: 06/15/2019
     *
     * @param $id
     * @return mixed
     */
    public function setId($id)
    {
        return $this->model->find($id);
    }


    /**
     * Date: 06/06/2019
     *
     * @param $input
     * @param $product
     * @param $view
     * @param $id
     * @return array
     */
    public function status($input, $product, $view, $image)
    {
        $html  = null;
        $cover = null;
        $dataForm['active'] = $input['active'];
        $active = ', '.constLang('status').':'.$dataForm['active'];

        if ($image->cover == 1 && $dataForm['active'] == constLang('active_false')) {
            $update = $image->update($dataForm);
            if ($update) {
                $cover = $this->changeCover($product, $image, 'status_false');
            }
        } else if ($image->cover == 0 && $dataForm['active'] == constLang('active_true')) {
            $update = $image->update($dataForm);
            if ($update) {
                $cover = $this->changeCover($product, $image, 'status_true');
            }
        } else {
            $update = $image->update($dataForm);
        }
        if ($update) {

            $success = true;
            $message = constLang('status_true').' '.$image->active;
            generateAccessesTxt(date('H:i:s').utf8_decode(
                    ' '.constLang('updated').
                    ' '.constLang('status').
                    ' '.constLang('product').
                    ', '.constLang('code').':'.$image->code.
                    $active)
            );

            $html = view("{$view}.status-render", compact('image'))->render();
        } else {
            $success = false;
            $message = constLang('status_false');
        }

        $out = array(
            "success" => $success,
            "message" => $message,
            'alert' => $cover,
            "html"  => $html
        );

        return $out;
    }


    /**
     * Date: 06/05/2019
     * Create cover=1 - active=true
     * Status cover=1 - active=true
     * Delete cover=1 - active=true
     * Update cover=1 - active=true
     * @param $product
     * @param $id
     * @param string $change
     */
    public function changeCover($product, $image, $action=null)
    {
        $collection = $product->images;

        $data   = null;
        $alert  = null;
        $input  = ['cover' => 1];
        $output = ['cover' => 0];
        $count  = $collection->count();
        $true   = constLang('active_true');

         if ($action == 'status_true') {

            if ($count >= 2) {
                $count_cover = collect($collection)->where('cover', 1)->count();
                if ($count_cover == 0) {
                    $upd = $image->update($input);
                } else {
                    $cover = collect($collection)->where('cover', 1)->first();
                    $cover->update($output);
                    $first_active   = collect($collection)->where('active', $true)->first();
                    if ($first_active) {
                        $data  = $first_active->update($input);
                        $code  = $first_active->code;
                        $color = $first_active->color;
                    }
                }
            } else {
                if ($image->cover == 0) {
                    $upd = $image->update($input);
                }
            }

        } else if ($action == 'status_false'){
            if ($count >= 1) {
                $count_active   = collect($collection)->where('active', $true)->count();

                if ($count_active >= 1) {
                    $last_active = collect($collection)->where('active', $true)->last();
                    $first_active   = collect($collection)->where('active', $true)->first();

                    $image->update($output);
                    if ($first_active) {
                        if ($first_active->id != $image->id) {
                            $data  = $first_active->update($input);
                            $code  = $first_active->code;
                            $color = $first_active->color;
                        }
                    } else if ($last_active) {
                        if ($last_active->id != $image->id) {
                            $data  = $last_active->update($input);
                            $code  = $last_active->code;
                            $color = $last_active->color;
                        }
                    }

                } else {
                    if ($image->cover != 1) {
                        $image_diff = collect($collection)->where('id', '!=', $image->id)->first();
                        $data  = $image_diff->update($input);
                        $code  = $image_diff->code;
                        $color = $image_diff->color;
                    }

                }
                if ($data) {
                    if ($count_active <= 0){
                        $upd = $product->update(['active' => 0]);
                    }

                    $alert = '<span class="silver">' .
                        constLang('alert.cover_new').'<br>' .
                        constLang('code').':'.$code .'<br>' .
                        constLang('color').':'.$color .'</span>';
                }

            } else {
                $alert = '<span class="red">'.constLang('alert.cover_false').'</span>';
            }
            return $alert;
        }

    }




    /**
     * @param $request
     * @param $mod_id
     * @return array
     */
    public function search($request, $mod_id, $route)
    {

        $data = array();
        $totalData=0;
        $totalFiltered=0;

        $search = $request->input('search.value');

        if(!empty($search) && strlen($search) >= 3) {

            $columns = array(
                0 => 'image',
                1 => 'code',
                2 => 'color',
                3 => 'category',
                4 => 'section',
                5 => 'brand',
                6 => 'id'
            );

            $limit = 10;
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir   = $request->input('order.0.dir');


            $query =  $this->model->where('slug','LIKE',"%{$search}%")->with(array(
                'sizes' => function ($query) use($search) {
                    $query->orderBy('grid');
                }
            ))
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();


            $totalFiltered = $this->model->where('slug','LIKE',"%{$search}%")->with(array(
                'sizes' => function ($query) use($search) {
                    $query->orderBy('grid');
                }
            ))->count();


            $totalData = $totalFiltered;

            // Configurações
            $configImage   = $this->configImage->setName('default', 'T');

            $path    = $configImage->path;
        }


        if(!empty($query))
        {
            foreach ($query as $val){

                $grids='';
                $kits='';
                $i=0;

                if ($val->kit == 1) {
                    $unit     = $val->product->unit;
                    $measure  = $val->product->measure;
                    $kit_name = $val->product->kit_name;
                    $kits = '<label for="kit-'.$val->id.'" class="button silver-gradient">'.$kit_name.' '.$unit.' '.$measure.'</label>';
                }

                foreach ($val->sizes as $size) {
                    $grids .= '<p class="button-height">';
                    $grids .= '<span class="input">';
                    $grids .= $kits.'<label for="size-'.$size->grid.'" class="button blue-gradient">'.$size->grid.'</label>';
                    $grids .= '<input type="text" id="qty-'.$size->grid.'" name="grid['.$size->id.']" class="input-unstyled" placeholder="Qtd" value="" autocomplete="off" style="width: 30px;">';
                    $grids .= '</span>';
                    $grids .= '</p>';
                    $i++;
                }

                if ($val->image != '') {
                    $image = '<a href="javascript:void(0)"><img id="img-'.$val->id.'" src="'.url($this->j.$path.$val->image).'" width="80" /></a>';
                } else {
                    $image = '<a href="javascript:void(0)"><img id="img-'.$val->id.'"  src="'.url('assets/imagens/padrao/product-no-image.png').'" /></a>';
                }

                ($val->active == 1 ? $status   = '<p><small class="tag">Ativo</small></p>' : $status = '<p><small class="tag red-bg">Inativo</small></p>');

                $nData['image']    = $image;
                $nData['code']     = $val->code.'<p>'.$val->category.' <br>'.$val->section.'</p>';
                $nData['color']    = $status. $val->color;
                $nData['category'] = $val->category;
                $nData['section']  = $val->section;
                $nData['brand']    = $val->brand;
                $nData['id']       = $val->id;
                $nData['grids']    = $grids;
                $nData['token']    = csrf_token();
                $nData['action']   = route($route, ["id" => $val->id, "mod_id" => $mod_id]);

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



}