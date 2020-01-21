<?php

namespace AVDPainel\Repositories\Admin;

use AVDPainel\Models\Admin\GridProduct as Model;
use AVDPainel\Interfaces\Admin\GridProductInterface;
use AVDPainel\Interfaces\Admin\InventoryInterface as InterInventory;

class GridProductRepository implements GridProductInterface
{

    public $model;
    public $interInventory;

    /**
     * Create construct.
     *
     * @return void
     */
    public function __construct(Model $model, InterInventory $interInventory)
    {
        $this->model = $model;
        $this->interInventory = $interInventory;
    }

    /**
     * Date: 06/14/2019
     *
     * @param  int  $id
     * @return array
     */
    public function setId($id)
    {
        return $this->model->find($id);
    }

    /**
     * Date: 06/12/2019
     *
     * @param $idmg
     * @return mixed
     */
    public function getGrids($idmg)
    {
        return $this->model->where('image_color_id', $idmg)->get();
    }


    /**
     * Date 02/06/2019
     *
     * @param $configProduct
     * @param $input
     * @param $image
     * @param $product
     * @return mixed
     */
    public function createKit($configProduct, $input, $image, $product)
    {
        $dataForm['color']          = $image->color;
        $dataForm['kit']            = $product->kit;
        $dataForm['units']          = $this->countKit($input['grid']);
        $dataForm['grid']           = $input['grid'];
        $dataForm['product_id']     = $product->id;
        $dataForm['image_color_id'] = $image->id;


        $access = $product->kit_name;
        $access .= ', '.constLang('grid').':'.$input['grid'];

        if ($product->stock == 1) {

            $dataForm['input'] = $input['input'];
            $dataForm['stock'] = $input['input'];
            $access .= ', '.constLang('entry').' '.$input['input'];
            $access .= ', '.constLang('stock').' '.$input['input'];

            if ($product->qty_min == 1) {
                $dataForm['qty_min'] = $input['qty_min'];
                $access .= ', qtd-min:'.$input['qty_min'];
            }

            if ($product->qty_max == 1) {
                $dataForm['qty_max'] = $input['qty_max'];
                $access .= ', qtd-max:'.$input['qty_max'];
            }
        }

        $data = $this->model->create($dataForm);
        if ($data) {
            if ($product->stock == 1) {
                $inventory = $this->interInventory->createKit($configProduct, $data, $image, $product);
            }
            if ($data) {
                generateAccessesTxt(date('H:i:s').
                    utf8_decode(' '.$access));
                return $data;
            }
        }
    }



    /**
     * Date: 01/21/2020
     * Note: return empty -> invetary(empty)
     *
     * @param $configProduct
     * @param $input
     * @param $image
     * @param $product
     */
    public function updateKit($configProduct, $input, $image, $product)
    {
        $data = $this->setId($input['id']);

        if ($data->color != $image->color) {
            $dataForm['color'] = $image->color;
        }

        $change = '';
        if ($product->stock == 1) {
            $entry = $input['input'];
            if (!empty($entry)) {

                $dataForm['entry'] = $data->input;
                $dataForm['grid'] = $data->grid;
                $dataForm['grid_id'] = $data->id;
                $dataForm['previous_stock'] = $data->stock;
                $previousInput = $data->input;
                $currentInput = $previousInput + $entry;
                $previousStock = $data->stock;
                $currentStock = ($previousStock + $entry) - $data->output;
                $dataForm['input'] = $currentInput;
                $dataForm['stock'] = $currentStock;
                $change .= ' '.constLang('entry').':'.$entry.' '.constLang('stock').':'.$currentStock;
            }
            if ($data->qty_min != $input['qty_min']) {
                $dataForm['qty_min'] = $input['qty_min'];
                $change = ' Qtd Min:'.$input['qty_min'];
            }
            if ($data->qty_max != $input['qty_max']) {
                $dataForm['qty_max'] = $input['qty_max'];
                $change = ' Qtd Max:'.$input['qty_max'];
            }
        }

        if ($change){
            $update = $data->update($dataForm);
            if ($update) {
                generateAccessesTxt(date('H:i:s').utf8_decode(
                        ' '.constLang('updated').
                        ' '.constLang('grid').$change)
                );
                if ($product->stock == 1) {
                    $inventory = $this->interInventory->updateKit($configProduct, $data, $image, $product, $entry);
                    if ($inventory) {
                        return $inventory;
                    }
                } else {
                    return true;
                }
            }
        } else {
            return true;
        }

        // Note: return empty -> invetary(empty)
    }


    /**
     * Date: 06/12/2019
     *
     * @param $configProduct
     * @param $image
     * @param $product
     * @return bool
     */
    public function deleteKit($configProduct, $image, $product)
    {
        if ($product->stock == 1) {
            foreach ($image->grids as $grid) {
                dd($grid);
                $inventory = $this->interInventory->deleteKit($configProduct, $product, $image, $grid);
            }
            return $inventory;
        }

        return true;
    }


    /**
     * @param $configProduct
     * @param $input
     * @param $image
     * @param $product
     * @return mixed
     */
    public function createUnit($configProduct, $input, $image, $product)
    {
        $grid    = collect($input['grid'])->filter()->unique();
        $total   = count($grid);
        $success = true;
        if (empty($grid)) {
            $success = false;
            $message = constLang('validation.grids.grid');
        }

        if ($product->stock == 1) {
            $entry = collect($input['input'])->filter();
            if ($total != $entry->count()) {
                $success = false;
                $message = constLang('validation.grids.input');
            }
            if ($product->qty_min == 1) {
                $qty_min = collect($input['qty_min'])->filter();
                if ($total != $qty_min->count()) {
                    $success = false;
                    $message = constLang('validation.grids.qty_min');
                }
            }
            if ($product->qty_max == 1) {
                $qty_max = collect($input['qty_max'])->filter();
                if ($total != $qty_max->count()) {
                    $success = false;
                    $message = constLang('validation.grids.qty_max');
                }
            }
        }

        if ($success == true) {

            for($i = 0; $i < count($grid); ++$i) {
                $array[$i]['grid'] = $input['grid'][$i];
                if ($product->stock ==1) {
                    $array[$i]['input'] = $input['input'][$i];

                    if ($product->qty_min == 1) {
                        $array[$i]['qty_min'] = $input['qty_min'][$i];
                    }

                    if ($product->qty_max == 1) {
                        $array[$i]['qty_max'] =  $input['qty_max'][$i];
                    }
                }
            }

            $access = '- '.constLang('grid').':';
            $grids = collect($array)->sortBy('grid');
            foreach ($grids as $value) {
                $dataForm = [
                    'product_id' => $product->id,
                    'image_color_id' => $image->id,
                    'kit' => $product->kit,
                    'units' => 1,
                    'color' => $image->color,
                    'grid' => $value['grid'],
                ];
                $access .= $value['grid'];

                if ($product->stock ==1) {

                    $dataForm['output'] = 0;
                    $dataForm['input'] = $value['input'];
                    $dataForm['stock'] = $value['input'];

                    $access .= ', '.constLang('entry').':'.$value['input'];
                    $access .= ', '.constLang('stock').':'.$value['input'];

                    if ($product->qty_min == 1) {
                        $dataForm['qty_min'] = $value['qty_min'];
                        $access .= ', '.constLang('min').':'.$value['qty_min'];
                    }
                    if ($product->qty_min == 1) {
                        $dataForm['qty_max'] = $value['qty_max'];
                        $access .= ', '.constLang('max').':'.$value['qty_max'];
                    }
                }

                $data = $this->model->create($dataForm);
                if ($data) {
                    $inventory = $this->interInventory->createUnit($configProduct, $data, $image, $product);
                    generateAccessesTxt(date('H:i:s').utf8_decode($access));
                }
            }

            if ($data) {
                $data['success'] = true;
                return $data;
            } else {
                $error['success'] = false;
                $error['message'] = constLang('error.server');
            }

        }

        $error['success'] = $success;
        $error['message'] = $message;
        return $error;
    }

    /**
     * Date: 06/14/2019
     *
     * @param $configProduct
     * @param $input
     * @param $image
     * @param $product
     * @param $view
     * @return array
     */
    public function addUnit($configProduct, $input, $image, $product, $view)
    {

        $dataForm['color']          = $image->color;
        $dataForm['kit']            = $product->kit;
        $dataForm['units']          = 1;
        $dataForm['grid']           = $input['grid'];
        $dataForm['product_id']     = $product->id;
        $dataForm['image_color_id'] = $image->id;


        $access = ' '.constLang('grid').':'.$input['grid'];

        if ($product->stock == 1) {

            $dataForm['input'] = $input['input'];
            $dataForm['stock'] = $input['input'];
            $access .= ', '.constLang('entry').' '.$input['input'];
            $access .= ', '.constLang('stock').' '.$input['input'];

            if ($product->qty_min == 1) {
                $dataForm['qty_min'] = $input['qty_min'];
                $access .= ', qtd-min:'.$input['qty_min'];
            }

            if ($product->qty_max == 1) {
                $dataForm['qty_max'] = $input['qty_max'];
                $access .= ', qtd-max:'.$input['qty_max'];
            }
        }

        $unique= [];
        $dulicate = $image->grids;
        foreach ($dulicate as $value) {
            if ($value->grid == $dataForm['grid']) {
                $unique[] = $value->grid;
            }
        }
        if (empty($unique)) {

            $grid = $this->model->create($dataForm);
            if ($grid) {
                if ($product->stock == 1) {
                    $inventory = $this->interInventory->createKit($configProduct, $grid, $image, $product);
                }

                generateAccessesTxt(date('H:i:s').utf8_decode(
                    ' '.constLang('created').$access.
                    ' '.constLang('product').':'.$product->name.
                    ' '.constLang('code').':'.$image->code.
                    ' '.constLang('color').':'.$image->color)
                );

                $html = view("{$view}.modal.render-create", compact('grid', 'product'))->render();

                $out = array(
                    'success' => true,
                    'id' => $image->id,
                    'load' => true,
                    'html' => $html,
                    'message' => constLang('update_true')
                );

            } else {
                $out = array(
                    'success' => false,
                    'message' => constLang('update_false')
                );
            }
        } else {
            $out = array(
                'success' => false,
                'message' => constLang('validation.grids.unique')
            );
        }

        return $out;

    }


    /**
     * Date: 06/13/2019
     *
     * @param $configProduct
     * @param $input
     * @param $image
     * @param $product
     * @param $grid
     * @param $view
     * @return array
     */
    public function updateUnit($configProduct, $input, $image, $product, $grid, $view)
    {

        if ($configProduct->grids == 1) {

            $change = '';
            $action['name'] = false;
            $action['entry'] = false;
            if ($grid->grid != $input['grid']) {
                $dataForm['grid'] = $input['grid'];
                $change .= $input['grid'];
                $action['name'] = 'update';
            }

            if ($product->stock == 1) {

                if (!empty($input['input'])) {
                    $dataForm['input'] = $input['input'];
                    $dataForm['stock'] = $input['input'] + $grid->stock;
                    $change .= ', ' . constLang('entry') . ':' . $input['input'];
                    $change .= ', ' . constLang('stock') . ':' . $dataForm['stock'];
                    $action['entry'] = 'create';
                }
                if ($product->qty_min == 1) {
                    if ($grid->qty_min != $input['qty_min']) {
                        $dataForm['qty_min'] = $input['qty_min'];
                        $change .= ', ' . constLang('stock') . ' ' . constLang('min') . ':' . $input['qty_min'];
                    }
                }
                if ($product->qty_max == 1) {
                    if ($grid->qty_max != $input['qty_max']) {
                        $dataForm['qty_max'] = $input['qty_max'];
                        $change .= ', ' . constLang('stock') . ' ' . constLang('min') . ':' . $input['qty_max'];
                    }
                }
            }

            if ($change) {
                $data = $grid->update($dataForm);
                if ($data) {
                    generateAccessesTxt(date('H:i:s').utf8_decode(
                            ' '. constLang('updated').
                            ' '.constLang('grid').':'.$change.
                            ', '.constLang('product').':'.$product->name.
                            ', '.constLang('code').':'.$image->code.
                            ', '.constLang('code').':'.$image->color)
                    );

                    if ($product->stock == 1) {
                        $inventory = $this->interInventory->updateUnit($configProduct, $grid, $image, $product, $action);
                    }

                    $html = view("{$view}.modal.render-update", compact('grid', 'product'))->render();
                    $out = array(
                        'success' => true,
                        'id' => $grid->id,
                        'load' => true,
                        'html' => $html,
                        'message' => constLang('update_true')
                    );
                }
            } else {
                $out = array(
                    'success' => true,
                    'load' => false,
                    'message' => constLang('update_true')
                );
            }
            return $out;
        }
    }


    /**
     * Date: 06/12/2019
     *
     * @param $configProduct
     * @param $image
     * @param $product
     * @param $grid
     * @return json
     */
    public function deleteUnit($configProduct, $image, $product, $grid)
    {
        if ($configProduct->grids == 1) {

            $prev = $grid;
            if ($product->stock == 1) {
                $inventory = $this->interInventory->deleteUnit($configProduct, $product, $image, $grid);
            }

            $delGrid = $grid->delete();
            if ($delGrid) {

                generateAccessesTxt(date('H:i:s').utf8_decode(
                        ' '.constLang('deleted').
                        ' '.constLang('grid').
                        ':'.$prev->grid.
                        ', '.constLang('stock').':'.$prev->stock.
                        ', '.constLang('product').':'.$product->name.
                        ', '.constLang('code').':'.$image->code.
                        ', '.constLang('color').':'.$image->color)
                );

                $success = true;
                $message = constLang('delete_true');
            } else {
                $success = true;
                $message = constLang('error.server');
            }
        }

        $out = array(
            'success' => $success,
            'message' => $message
        );

        return $out;

    }


    /**
     * Date: 06/12/2019
     *
     * @param  int $id
     * @param  int $stock
     * @param  int $kit
     */
    public function change($id, $stock, $kit)
    {
        $current = $this->model->where('image_color_id', $id)->get();

        if ($kit == 1) {
            $input=0;
            $output=0;
            foreach ($current as $value) {
                $product_id = $value->product_id;
                $input += $value->input;
                $output += $value->output;
                if ($value->kit == 0) {
                    $grids[] = $value->grid;
                }
            }
            if (isset($grids)) {

                $grid   = implode(",", $grids);
                $total  = $input - $output;
                $delete = $this->model->where('image_color_id', $id)->delete();

                if ($stock == 1) {
                    $update = [
                        'product_id' => $product_id,
                        'image_color_id' => $id,
                        'grid' => $grid,
                        'kit' => $kit,
                        'input' => $input,
                        'output' => $output,
                        'stock' => $total
                    ];
                } else {
                    $update = [
                        'product_id' => $product_id,
                        'image_color_id' => $id,
                        'kit' => $kit,
                        'grid' => $grid
                    ];
                }

                $create = $this->model->create($update);
            }


        } else {
            foreach ($current as $value) {
                if($value->kit == 1) {
                    $product_id = $value->product_id;
                    $grids  = explode(",", $value->grid);
                    $delete = $this->model->where('image_color_id', $id)->delete();
                    foreach ($grids as $key => $val) {
                        $update = [
                            'product_id' => $product_id,
                            'image_color_id' => $id,
                            'kit' => $kit,
                            'grid' => $val,
                            'input' => 0,
                            'output' => 0,
                            'stock' => 0
                        ];

                        $create = $this->model->create($update);
                    }
                }
            }
        }

        return $this->model->where('image_color_id', $id)->get();
    }


    /**
     * Date 06/28/2019
     *
     * @param $kit
     * @return int|mixed
     */
    public function countKit($kit)
    {
        $units = 0;
        $grids = explode(',', $kit);

        foreach ($grids as $grid) {
            $key = explode('/', $grid);
            $values[] = $key[0];
        }

        foreach ($values as $value)
        {
            $units  += $value;
        }


        return $units;
    }




}