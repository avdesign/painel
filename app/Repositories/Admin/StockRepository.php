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
    private $view = 'backend.stock';
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

                $image = $val->image;
                $product = $val->product;
                $photoUrl = $this->photoUrl;

                $photo = view("{$this->view}.render.image", compact('path','image', 'photoUrl'))->render();
                $description = view("{$this->view}.render.description", compact('product'))->render();
                $reference = view("{$this->view}.render.reference", compact('image', 'product'))->render();
                $grid = view("{$this->view}.render.grid", compact('val', 'product'))->render();
                $stock = view("{$this->view}.render.stock", compact('val'))->render();
                $quantity = view("{$this->view}.render.quantity", compact('val'))->render();
                $actions = view("{$this->view}.render.actions", compact('val', 'image'))->render();
                /*
                if (Gate::allows('stock-entry')) {
                    $clickEntry = "abreModal('Entrada: {$val->product->name}', '".route('stock.entry', $val->id)."', 'form-stock', 2, 'true',400,450)";
                    $actions .= '<p><button type="button" onclick="'.$clickEntry.'" class="button compact icon-plus blue-gradient">'.constLang('entry').'</button></p>';
                }
                */

                $nData['image']       = $photo;
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


    public function exitStock($configProduct, $input, $id)
    {
        $grid = $this->setId($id);
        $image = $grid->image;
        $product = $grid->product;

        if ($input['qty'] > $grid->stock) {
            $success = false;
            $message = constLang('messages.stock.output_greater');

        } else {

            $motive = $input['motive'];
            if ($motive == 1) {
                $input['input']  = $grid->input - $input['qty'];
                $input['stock']  = $grid->stock - $input['qty'];
            } elseif ($motive == 2) {
                $input['output']  = $grid->output + $input['qty'];
                $input['stock']  = $grid->stock - $input['qty'];
            }

            $update = $grid->update($input);
            if ($update) {
                if ($product->kit == 1) {

                    $inventory = $this->interInventory->exitKit($configProduct, $grid, $image, $product, $input);
                }
                $success = true;
                $message = constLang('messages.stock.movement_text.output');
            } else {
                $message = constLang('messages.stock.update_false');
            }
        }
        $out = array(
            'success' => $success,
            'message' => $message,
            'entry' => $grid->input,
            'exit' => $grid->output,
            'total' => $grid->stock
        );

        return response()->json($out);


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
                $message = constLang('messages.stock.movement_text.input');
            } else {
                $message = constLang('messages.stock.update_false');
            }

        } elseif ($input['ac'] == 'exit') {



        } else {
            $success = false;
            $message = constLang('messages.stock.action_null');
        }


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
     * Verifica se existe o produto no estoque
     *
     * @param $configProduct
     * @param $product
     * @return array
     */
    public function existStock($configProduct, $product)
    {
        if ($product->stock == 1) {
            if ($configProduct->grids == 1) {
                $qty=0;
                foreach ($product->grids as $grid) {
                    $qty += $grid->stock;
                }

                if ($qty >= 1) {
                    $out = array(
                        'success' => false,
                        'message' => constLang('messages.stock.remove_stock')
                    );
                    return $out;
                }
            }
        }
    }


}