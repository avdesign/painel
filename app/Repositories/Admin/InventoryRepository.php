<?php

namespace AVDPainel\Repositories\Admin;

use AVDPainel\Traits\InventoryTrait;
use AVDPainel\Models\Admin\Inventory as Model;
use AVDPainel\Interfaces\Admin\InventoryInterface;
use AVDPainel\Interfaces\Admin\ConfigColorPositionInterface as ConfigImage;

use Illuminate\Support\Str;


class InventoryRepository implements InventoryInterface
{
    use InventoryTrait;

    private $disk;
    private $view;
    public $model;
    private $photoUrl;



    /**
     * Create construct.
     *
     * @return void
     */
    public function __construct(Model $model, ConfigImage $configImage)
    {
        $this->model = $model;
        $this->configImage = $configImage;
        $this->view = 'backend.reports.inventory';

        $this->photoUrl = 'storage/';
        $this->disk = storage_path('app/public/');

    }


    /**
     * Date: 06/18/2019
     *
     * @param $request
     * @return json
     */
    public function getAll($request)
    {
        $columns = array(
            0 => 'id',
            1 => 'code',
            2 => 'product',
            3 => 'stock',
            4 => 'previous',
            6 => 'updated_at'
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

            $query =  $this->model->where('code','LIKE',"%{$search}%")
                ->orWhere('image', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered = $this->model->where('code','LIKE',"%{$search}%")
                ->orWhere('image', 'LIKE',"%{$search}%")
                ->count();
        }

        // Configurações
        $configImage   = $this->configImage->setName('default', 'T');

        $path  = $configImage->path;
        $data  = array();
        $collection = collect($query)->all();

        if(!empty($collection))
        {
            foreach ($collection as $collect){

                /** param */
                $photoUrl = $this->photoUrl.$path.$collect->image;

                /** Renders */
                $image = view("{$this->view}.render.image", compact('collect', 'photoUrl'))->render();
                $users = view("{$this->view}.render.users", compact('collect'))->render();
                $values = view("{$this->view}.render.values", compact('collect'))->render();
                $product = view("{$this->view}.render.product", compact('collect'))->render();
                $details = view("{$this->view}.render.details", compact('collect'))->render();
                $movement = view("{$this->view}.render.movement", compact('collect', 'previous_stock'))->render();
                $attributes = view("{$this->view}.render.attributes", compact('collect'))->render();

                $nData['image']      = $image;
                $nData['code']       = $product;
                $nData['product']    = $attributes;
                $nData['stock']      = $movement;
                $nData['previous']   = $values;
                $nData['updated_at'] = $users;
                $nData['details']    = $details;
                $nData['id']         = $collect->id;

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
     * Date: 01/21/2020
     *
     * @param $configProduct
     * @param $grid
     * @param $image
     * @param $product
     * @return mixed
     */
    public function createKit($configProduct, $grid, $image, $product)
    {
        if ($configProduct->grids == 1) {
            $movement = [
                'previous' => 0,
                'movement_type' => constLang('messages.stock.movement_text.input'),
                'movement_qty' => $grid->input,
                'cost_total' => $grid->input * $product->cost->value,
                'stock' => (int) $grid->stock,
                'note' => auth()->user()->name. ' '.constLang('messages.stock.create').' '.$grid->input,
            ];
            $parameters = array_merge($movement, $this->getParameters($product, $image, $grid));
            $data = $this->model->create($parameters);
            if ($data) {
                return $data;
            }
        }

    }

    /**
     * Date: 01/21/2020
     *
     * @param $configProduct
     * @param $grid
     * @param $image
     * @param $product
     * @param $entry
     * @return bool
     */
    public function updateKit($configProduct, $grid, $image, $product, $entry)
    {
        if ($configProduct->grids == 1) {
            if($grid) {
                $movement = [
                    'previous' => (int) $grid->stock - $entry,
                    'movement_type' => constLang('messages.stock.movement_text.input'),
                    'movement_qty' => $entry,
                    'cost_total' => $grid->input * $product->cost->value,
                    'stock' => (int) $grid->stock,
                    'note' => auth()->user()->name. ' '.constLang('messages.inventory.entry').' '.$entry
                ];

                $parameters = array_merge($movement, $this->getParameters($product, $image, $grid));
                $data = $this->model->create($parameters);
                if ($data) {
                    return $data;
                }
            } else {
                return true;
            }
        }
    }


    /**
     * Date: 06/12/2019
     *
     * @param $product
     * @param $image
     * @param $grids
     * @return mixed
     */
    public function deleteKit($configProduct, $product, $image, $grid)
    {
        if ($configProduct->grids == 1) {
            $stock = (int) $grid->stock;
            if ($stock >= 1) {
                $diff_qty = $stock;
                $diff_value = $product->cost->value * $stock;
            } else {
                $diff_qty = 0;
                $diff_value = 0;
            }

            $movement = [
                'previous' => (int) $grid->stock,
                'movement_type' => constLang('messages.stock.movement_text.delete'),
                'movement_qty' => (int) $grid->stock,
                'diff_value' => $diff_value,
                'diff_qty' => $diff_qty,
                'cost_total' => $grid->input * $product->cost->value,
                'stock' => $stock,
                'note' => auth()->user()->name. ' '.constLang('messages.stock.deleted_stock').' '.$stock

            ];

            dd($movement);

            $parameters = array_merge($movement, $this->getParameters($product, $image, $grid));
            $data = $this->model->create($parameters);
            if ($data) {
                return $data;
            }
        }
    }


    public function exitKit($configProduct, $grid, $image, $product, $input)
    {
        if ($configProduct->grids == 1) {

            $previous = (int) $grid->stock + $input['qty'];
            $motive = $input['motive'];
            if ($motive == 1) {
                $diff_qty = 0;
                $diff_value = 0;
            } elseif ($motive == 2) {
                $diff_qty = (int) $input['qty'];
                $diff_value = $input['qty'] * $product->cost->value;
            }

            $movement_type = constLang('messages.stock.movement_text.output');
            $note = auth()->user()->name. ' '.constLang('messages.inventory.exit');

            $movement = [
                'entry' => $grid->input,
                'exit' => $grid->output,
                'previous' => $previous,
                'motive' => $motive,
                'movement_type' => $movement_type,
                'movement_qty' => $input['qty'],
                'diff_value' => $diff_value,
                'diff_qty' => $diff_qty,
                'cost_total' => $grid->stock * $product->cost->value,
                'stock' => $grid->stock,
                'note' => "{$note} {$input['qty']}, {$input['note']}"
            ];

            $parameters = array_merge($movement, $this->getParameters($product, $image, $grid));
            $data = $this->model->create($parameters);
            if ($data) {
                return $data;
            }
        }
    }


    /**
     * Date: 06/13/2019
     *
     * @param $configProduct
     * @param $grids
     * @param $image
     * @param $product
     * @return mixed
     */
    public function createUnit($configProduct, $grid, $image, $product)
    {
        if ($configProduct->grids == 1) {

            $movement = [
                'previous' => (int) $grid->input,
                'movement_type' => constLang('messages.stock.movement_text.input'),
                'movement_qty' => $grid->entry,
                'cost_total' => $grid->input * $product->cost->value,
                'stock' => (int) $grid->stock,
                'note' => auth()->user()->name. ' '.constLang('messages.stock.update')
            ];


            $dataForm['product_id'] = $product->id;
            $dataForm['image_color_id'] = $image->id;
            $dataForm['grid_id'] = $grids->id;
            $dataForm['admin_id'] = auth()->user()->id;
            $dataForm['profile_name'] = constLang('profile_name.admin');
            $dataForm['movement_type'] = constLang('messages.stock.movement_text.input');
            $dataForm['brand'] = $product->brand;
            $dataForm['section'] = $product->section;
            $dataForm['category'] = $product->category;
            $dataForm['product'] = $product->name;
            $dataForm['image'] = $image->image;
            $dataForm['code'] = $image->code;
            $dataForm['color'] = $image->color;
            $dataForm['grid'] = $grids->grid;
            $dataForm['previous'] = (int)$grids->input;
            $dataForm['kit'] = $product->kit;
            $dataForm['kit_name'] = $product->unit. ' '.$product->measure;
            $dataForm['units'] = $grids->units;
            $dataForm['offer'] = $product->offer;
            $dataForm['cost_unit'] = $product->cost->value;
            $dataForm['cost_total'] = $grids->input * $product->cost->value;
            $dataForm['stock'] = (int)$grids->input;

            $data = $this->model->create($dataForm);
            if ($data) {
                return $data;
            }
        }
    }


    /**
     * Date: 06/13/2019
     *
     * @param $configProduct
     * @param $grid
     * @param $image
     * @param $product
     * @param $action
     * @return mixed
     */
    public function updateUnit($configProduct, $grid, $image, $product, $action)
    {
        if ($action['name'] == 'update') {
            $movements = $this->getGrids($grid->id);
            foreach ($movements as $movement){
                if ($movement->grid != $grid->grid) {
                    $name = [
                        'grid' => $grid->grid
                    ];
                    $upMov = $movement->update($name);
                }
            }
        }
        if ($configProduct->grids == 1) {

            if ($action['entry'] == 'create') {

                $dataForm['product_id'] = $product->id;
                $dataForm['image_color_id'] = $image->id;
                $dataForm['grid_id'] = $grid->id;
                $dataForm['admin_id'] = auth()->user()->id;
                $dataForm['profile_name'] = constLang('profile_name.admin');
                $dataForm['movement_type'] = constLang('messages.stock.movement_text.input');
                $dataForm['brand'] = $product->brand;
                $dataForm['section'] = $product->section;
                $dataForm['category'] = $product->category;
                $dataForm['product'] = $product->name;
                $dataForm['image'] = $image->image;
                $dataForm['code'] = $image->code;
                $dataForm['color'] = $image->color;
                $dataForm['grid'] = $grid->grid;
                $dataForm['previous'] = (int)$grid->input;
                $dataForm['kit'] = $product->kit;
                $dataForm['kit_name'] = $product->unit. ' '.$product->measure;
                $dataForm['units'] = $grid->units;
                $dataForm['offer'] = $product->offer;
                $dataForm['cost_unit'] = $product->cost->value;
                $dataForm['cost_total'] = $grid->input * $product->cost->value;
                $dataForm['stock'] = (int)$grid->stock;

                $data = $this->model->create($dataForm);
                if ($data) {
                    return $data;
                }
            }
        }
    }



    public function deleteUnit($configProduct, $product, $image, $grid)
    {
        if ($configProduct->grids == 1) {

            $dataForm['product_id'] = $image->product_id;
            $dataForm['image_color_id'] = $image->id;
            $dataForm['grid_id'] = $grid->id;
            $dataForm['admin_id'] = auth()->user()->id;
            $dataForm['profile_name'] = constLang('profile_name.admin');
            $dataForm['movement_type'] = constLang('messages.stock.movement_text.delete');
            $dataForm['movement'] = 0;
            $dataForm['note'] = auth()->user()->name. ' '.constLang('messages.products.delete_true');
            $dataForm['brand'] = $product->brand;
            $dataForm['section'] = $product->section;
            $dataForm['category'] = $product->category;
            $dataForm['product'] = $product->name;
            $dataForm['image'] = $image->image;
            $dataForm['code'] = $image->code;
            $dataForm['color'] = $image->color;
            $dataForm['grid'] = $grid->grid;
            $dataForm['previous'] = $grid->stock;
            $dataForm['kit'] = $product->kit;
            $dataForm['kit_name'] = $product->unit. ' '.$product->measure;
            $dataForm['units'] = $grid->units;
            $dataForm['offer'] = $product->offer;
            $dataForm['cost_unit'] = $product->cost->value;
            $dataForm['cost_total'] = $grid->stock * $product->cost->value;
            $dataForm['stock'] = 0;

            $data = $this->model->create($dataForm);
            if ($data) {
                return $data;
            }
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
     * Date: 06/15/2019
     *
     * @param $id
     * @return mixed
     */
    public function getGrids($id)
    {
        return $this->model->where('grid_id', $id)->get();
    }








}