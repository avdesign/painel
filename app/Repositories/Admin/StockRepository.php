<?php

namespace AVDPainel\Repositories\Admin;

use Illuminate\Support\Facades\Gate;

use AVDPainel\Models\Admin\GridProduct as Model;
use AVDPainel\Interfaces\Admin\StockInterface;
use AVDPainel\Interfaces\Admin\InventoryInterface as InterInventory;
use AVDPainel\Interfaces\Admin\ConfigColorPositionInterface as ConfigImage;

class StockRepository implements StockInterface
{
    private $disk;
    private $model;
    private $photoUrl;
    private $interInventory;

    /**
     * Create construct.
     *
     * @return void
     */
    public function __construct(
        Model $model,
        ConfigImage $configImage,
        InterInventory $interInventory)
    {
        $this->disk           = storage_path('app/public/');
        $this->model          = $model;
        $this->photoUrl       = 'storage/';
        $this->configImage    = $configImage;
        $this->interInventory = $interInventory;

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
            1 => 'kit',
            2 => 'units',
            3 => 'qty_min',
            4 => 'qty_max',
            5 => 'grid',
            6 => 'input',
            7 => 'output',
            8 => 'stock'
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

            $query =  $this->model->where('product_id','LIKE',"%{$search}%")
                ->orWhere('image_color_id', 'LIKE',"%{$search}%")
                ->orWhere('color', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered = $this->model->where('product_id','LIKE',"%{$search}%")
                ->orWhere('image_color_id', 'LIKE',"%{$search}%")
                ->orWhere('color', 'LIKE',"%{$search}%")
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
                    $image = '<a href="javascript:void(0)"><img id="img-'.$val->id.'" src="'.url($this->photoUrl.$path.$val->image->image).'" width="80" /></a>';
                } else {
                    $image = '<img src="'.url('backend/img/default/no_image.png').'" />';
                }

                ($val->image->cover == 1 ? $cover   = '<p><small class="tag">Capa</small></p>' : $cover = '');


                $description  = '';
                $description .= "<p>{$val->product->brand}</p>";
                $description .= "<p>{$val->product->category}</p>";
                $description .= "<p>{$val->product->section}</p>";


                $reference  = '';
                $reference .= "<p>Código: <strong>{$val->image->code}</strong></p>";
                $reference .= "<p>Ref.Produto: <strong>{$val->product_id}</strong></p>";
                $reference .= "<p>Ref Cor: <strong>{$val->image_color_id}</strong></p>";

                $grid  = '';
                $grid .= "<p>{$val->product->kit_name}<strong> {$val->product->unit} {$val->product->measure}</strong></p>";
                $grid .= "<p><strong>{$val->grid}</strong></p>";
                $grid .= "<p>Cor: <strong>{$val->color}</strong></p>";

                $stock  = "";
                $stock .= "<p>Entrada: <strong>{$val->input}</strong></p>";
                $stock .= "<p>Saida: <strong>{$val->output}</strong></p>";
                $stock .= "<p>Total: <strong>{$val->stock}</strong></p>";

                $quantity = '';
                $quantity .= "<p>Mínimo: <strong>{$val->qty_min}</strong></p>";
                $quantity .= "<p>Máximo: <strong>{$val->qty_max}</strong></p>";

                $actions = '';
                if ($val->image->active == constLang('active_true')) {
                    $active = constLang('active_false');
                    $clickStatus = "statusCatalog('{$val->image_color_id}','".route('status.catalog', $val->image_color_id)."','{$active}','".csrf_token()."')";
                    $actions .= '<p id="status-'.$val->image_color_id.'"><button type="button" id="status-'.$val->image_color_id.'" onclick="'.$clickStatus.'" class="button compact icon-tick green-gradient">'.constLang('active_true').'</button></p>';

                } else {
                    $active = constLang('active_true');
                    $clickStatus = "statusCatalog('{$val->image_color_id}','".route('status.catalog', $val->image_color_id)."', '{$active}','".csrf_token()."')";
                    $actions .= '<p id="status-'.$val->image_color_id.'"><button type="button" onclick="'.$clickStatus.'" class="button compact grey-gradient">'.constLang('active_true').'</button></p>';

                }

                if (Gate::allows('stock-exit')) {
                    $clickExit = "abreModal('Saida: {$val->product->name}', '" . route('stock.exit', $val->id) . "', 'form-stock', 2, 'true',400,450)";
                    $actions .= '<p><button type="button" onclick="' . $clickExit . '" class="button compact icon-minus red-gradient">' . constLang('exit') . '</button></p>';
                }

                if (Gate::allows('stock-entry')) {
                    $clickEntry = "abreModal('Entrada: {$val->product->name}', '".route('stock.entry', $val->id)."', 'form-stock', 2, 'true',400,450)";
                    $actions .= '<p><button type="button" onclick="'.$clickEntry.'" class="button compact icon-plus blue-gradient">'.constLang('entry').'</button></p>';
                }

                $nData['image']       = $image. $cover;
                $nData['description'] = $description;
                $nData['reference']   = $reference;
                $nData['grid']        = $grid;
                $nData['stock']       = $stock;
                $nData['quantity']    = $quantity;
                $nData['actions']     = $actions;

                $data[] = $nData;
            }

        }

        //dd($nData);

        $out = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        return $out;

    }


    public function update($configProduct, $input, $id)
    {
        $grid = $this->setId($id);
        $image = $grid->image;
        $product = $grid->product;

        $success = false;
        $message = constLang('messages.stock.update_false');
        if ($input['ac'] == 'entry') {

            $input['input'] = $grid->input + $input['qty'];
            $input['stock'] = ($grid->input + $input['qty']) - $grid->output;
            $update = $grid->update($input);
            if ($update) {
                $inventory = $this->interInventory->updateStock($configProduct, $grid, $image, $product, $input);
                $success = true;
                $message = constLang('messages.stock.entry_true');
            } else {
                $message = constLang('messages.stock.update_false');
            }

        } elseif ($input['ac'] == 'exit') {

            $input['output'] = $grid->output + $input['qty'];
            $input['stock'] = $grid->input - ($grid->output + $input['qty']);
            $update = $grid->update($input);
            if ($update) {
                $inventory = $this->interInventory->updateStock($configProduct, $grid, $image, $product, $input);
                $success = true;
                $message = constLang('messages.stock.exit_true');
            } else {
                $message = constLang('messages.stock.update_false');
            }

        } else {
            $success = false;
            $message = constLang('messages.stock.action_null');
        }

        $out = array(
            'success' => $success,
            'message' => $message
        );

        return response()->json($out);
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

}