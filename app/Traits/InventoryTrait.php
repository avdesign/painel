<?php
/**
 * Created by PhpStorm.
 * User: avdesign
 * Date: 19/01/20
 * Time: 22:50
 */

namespace AVDPainel\Traits;


trait InventoryTrait
{

    public function dataAuth()
    {
        return [
            'admin_id' => auth()->user()->id,
            'profile_name' => constLang('profile_name.admin')
        ];
    }

    public function dataProduct($product)
    {
        if ($product->kit == 1) {
            $kit_name = $product->kit_name. ' ('.$product->unit.' '.$product->measure.')';
        } else {
            $kit_name = $product->kit_name. $product->unit.' '.$product->measure;
        }
        return [
            'product_id' => $product->id,
            'brand' => $product->brand,
            'section' => $product->section,
            'category' => $product->category,
            'product' => $product->name,
            'kit' => $product->kit,
            'kit_name' => $kit_name,
            'offer' => $product->offer,
            'cost_unit' => $product->cost->value
        ];
    }


    public function dataImage($image)
    {
        return [
            'image_color_id' => $image->id,
            'image' => $image->image,
            'code' => $image->code,
            'color' => $image->color
        ];
    }


    public function dataGrid($grid)
    {
        return [
            'grid_id' => $grid->id,
            'grid' => $grid->grid,
            'units' => $grid->units
        ];
    }

    public function getParameters($product, $image, $grid)
    {
        $parameter = $this->dataAuth();
        $parameter = array_merge($parameter, $this->dataProduct($product));
        $parameter = array_merge($parameter, $this->dataImage($image));
        $parameter = array_merge($parameter, $this->dataGrid($grid));

        return $parameter;
    }

}