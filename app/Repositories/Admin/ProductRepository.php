<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\Product as Model;
use AVDPainel\Interfaces\Admin\ProductInterface;
use AVDPainel\Interfaces\Admin\GridProductInterface as InterGrid;
use AVDPainel\Interfaces\Admin\ConfigKeywordInterface as Keywords;
use AVDPainel\Interfaces\Admin\InventoryInterface as InterInventory;
use AVDPainel\Interfaces\Admin\ConfigProductInterface as ConfigProduct;
use AVDPainel\Interfaces\Admin\ConfigFreightInterface as ConfigFreight;
use AVDPainel\Interfaces\Admin\ConfigColorPositionInterface as ConfigImage;




use DB;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ProductRepository implements ProductInterface
{

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
        InterGrid $interGrid,
        ConfigImage $configImage,
        ConfigProduct $configProduct,
        ConfigFreight $configFreight,
        InterInventory $interInventory)
    {

        $this->disk           = storage_path('app/public/');
        $this->model          = $model;
        $this->keywords       = $keywords;
        $this->interGrid      = $interGrid;
        $this->configImage    = $configImage;
        $this->configProduct  = $configProduct;
        $this->configFreight  = $configFreight;
        $this->interInventory = $interInventory;
    }


    public function getAll($request, $id)
    {
        $columns = array(
            0  => 'id',
            1  => 'visits',
            2  => 'new',
            3  => 'offer',
            4  => 'active',
            5  => 'featured',
            6  => 'trend',
            7  => 'black_friday',
            8  => 'name',
            9  => 'description',
            10 => 'brand',
            11 => 'section',
            12 => 'category',
            13 => 'tags',
            14 => 'video',
            15 => 'percent',
            16 => 'unit',
            17 => 'measure',
            23 => 'price_card',
            24 => 'price_cash',
            25 => 'offer_card',
            26 => 'offer_cash',
            27 => 'sum_stock',
            28 => 'freight',
            29 => 'prices',
            30 => 'kit'
        );

        $totalData = $this->model->where('category_id',$id)->with(array(
            'images' => function ($query) {
                $query->orderBy('cover', 'asc');
            }
        )) ->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {

            $query = $this->model->where('category_id',$id)->with(array(
                'prices' => function ($query) {
                    $query->orderBy('id', 'asc')->get();
                }
            ))
                ->with(array(
                    'images' => function ($query) {
                        $query->orderBy('cover', 'asc');
                    }
                ))
                ->with(array(
                    'grids' => function ($query) {
                        $query->where('input', '>', 0);
                    }
                ))
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

        } else {
            $search = $request->input('search.value');
            if (strlen($search) >= 3) {
                $query = $this->model->where('category_id',$id)->with(array(
                    'images' => function ($query) use($search) {
                        $query->where('code', 'LIKE',"%{$search}%")
                            ->where('description', 'LIKE',"%{$search}%")
                            ->where('image', 'LIKE',"%{$search}%")
                            ->orWhere('code', 'LIKE',"%{$search}%")
                            ->orderBy('cover', 'asc');
                    }
                ))
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();

                $totalFiltered = $this->model->where('category_id',$id)->with(array(
                    'images' => function ($query) use($search) {
                        $query->where('code', 'LIKE',"%{$search}%")
                            ->where('description', 'LIKE',"%{$search}%")
                            ->where('image', 'LIKE',"%{$search}%")
                            ->orWhere('code', 'LIKE',"%{$search}%")
                            ->count();
                    }
                ))
                    ->orWhere('description', 'LIKE',"%{$search}%")
                    ->count();
            }
        }
        // Configurações
        $configImage   = $this->configImage->setName('default', 'T');
        $configProduct = $this->configProduct->setId(1);
        $configFreight = $this->configFreight->setId(1);

        $price_default = $configFreight->price_default;

        $default = $configProduct->freight;
        $width   = $configFreight->width;
        $height  = $configFreight->height;
        $length  = $configFreight->length;
        $video   = $configProduct->video;
        $stock   = $configProduct->stock;
        ($stock == 1 ? $sum_stock = '<p>Estoque: <strong> 0 </strong></p>' : $sum_stock = '');
        $confCost= $configProduct->cost;
        $path    = 'storage/'. $configImage->path;
        $kit     = $configProduct->kit;
        $data    = array();
        if(!empty($query))
        {
            foreach ($query as $val){

                $count = count($val->images);
                if ($count >= 1) {
                    ($count >= 2 ? $total = ' cores' : $total = ' cor');
                    foreach ($val->images as $field) {
                        if ($field->cover == 1) {
                            $info_image  = '<small class="tag"> capa '.$count.$total.' </small>';
                        } else {
                            $info_image  = '<small class="tag"> '.$count.$total.' </small>';
                        }
                        $image  = '<a href="javascript:void(0)"><img src="'.url($path.$field->image).'" />';
                        $image .= $info_image;
                    }

                } else {
                    $image = '<img src="'.url('backend/img/default/no_image.png').'" />';
                }
                // Stock
                $grids = count($val->grids);
                if ($grids >= 1) {
                    $stock = 0;
                    foreach ($val->grids as $grid) {
                        $stock += $grid->stock;
                    }

                    if ($sum_stock) {
                        $sum_stock = '<p>Estoque: <strong> '.$stock.' </strong></p>';
                    }
                }


                //dd($val->prices);

                // Prices
                foreach ($val->prices as $price) {

                    if ($price->config_profile_client_id == 1) {
                        ($price->profile == $price_default ? $price_card_percent = '' : $price_card_percent = $price->sum_card.round($price->price_card_percent, 2).'%&nbsp;&nbsp;');
                        $prices = '<p><small class="tag">'.$price->profile.'</small> À Vista: '.$price->sum_cash.round($price->price_cash_percent, 2).'%<strong>&nbsp;&nbsp;'.
                            setReal($price->price_cash).'</strong>&nbsp;&nbsp; - &nbsp;&nbsp;Parcelado: '.$price_card_percent.'<strong>'.
                            setReal($price->price_card).'</strong></p>';
                    }

                    if ($price->config_profile_client_id == 2) {
                        ($price->profile == $price_default ? $price_card_percent = '' : $price_card_percent = $price->sum_card.round($price->price_card_percent, 2).'%&nbsp;&nbsp;');
                        $prices .= '<p><small class="tag">'.$price->profile.'</small> À Vista: '.$price->sum_cash.round($price->price_cash_percent, 2).'%<strong>&nbsp;&nbsp;'.
                            setReal($price->price_cash).'</strong>&nbsp;&nbsp; - &nbsp;&nbsp;Parcelado: '.$price_card_percent.'<strong>'.
                            setReal($price->price_card).'</strong></p>';
                    }



                    if ($val->offer == 1) {
                        $prices .= '<p><small class="tag green-bg">'.
                            $price->profile.'</small> Oferta à Vista: '.round($price->offer_percent, 2).'%<strong>&nbsp;&nbsp;'.
                            setReal($price->offer_cash).'</strong>&nbsp;&nbsp; - &nbsp;&nbsp;Parcelado: <strong>'.
                            setReal($price->offer_card).'</strong></p>';
                        $offer_cash = $price->offer_cash;
                        $offer_card = $price->offer_card;
                    } else {
                        $offer_cash = '';
                        $offer_card = '';
                    }
                    $price_cash = $price->price_cash;
                    $price_card = $price->price_card;
                }

                // Visits
                $visits  = '<p><button type="button" class="button compact blue-gradient">Visitas '.$val->visits.'</button></p>';
                $visits .= "<p>{$val->name}</p>";
                if ($val->kit == 1) {
                    $visits .= "<p> {$val->kit_name} ({$val->unit})</p>";
                } else {
                    $visits .= "<p>{$val->unit} {$val->measure}</p>";
                }

                // New
                $new = $val->new;
                ($new == 1 ? $color_new = 'icon-tick green-gradient">Ativo' : $color_new = 'grey-gradient">Inativo');
                $clickNew = "statusFields('new','{$val->id}','".route('product.status', $val->id)."','{$new}','".csrf_token()."')";
                $new  = '<p id="new-'.$val->id.'"><button type="button" onclick="'.$clickNew.'" class="button compact '.$color_new.'</button></p>';
                $new .= '<p>À vista: '.setReal($price_cash).'</p>';
                $new .= '<p>À prazo: '.setReal($price_card).'</p>';

                // Offer
                $offer = $val->offer;
                ($offer == 1 ? $color_offer = 'icon-tick green-gradient">Ativo' : $color_offer = 'grey-gradient">Inativo');
                $clickOffer = "statusFields('offer','{$val->id}','".route('product.status', $val->id)."','{$offer}','".csrf_token()."')";
                $offers  = '<p id="offer-'.$val->id.'"><button type="button" onclick="'.$clickOffer.'" class="button compact '.$color_offer.'</button></p>';
                if($offer == 1) {
                    $offers .= '<p>À vista: '.setReal($offer_cash).'</p>';
                    $offers .= '<p>À prazo: '.setReal($offer_card).'</p>';
                }
                // Active
                $status = $val->active;
                ($status == 1 ? $color_status = 'icon-tick green-gradient">Ativo' : $color_status = 'grey-gradient">Inativo');
                $clickStatus = "statusFields('active','{$val->id}','".route('product.status', $val->id)."','{$status}','".csrf_token()."')";
                $status  = '<p id="active-'.$val->id.'"><button type="button" onclick="'.$clickStatus.'" class="button compact '.$color_status.'</button></p>';
                // Featured
                $featured  = $val->featured;
                ($featured == 1 ? $color_featured = 'icon-tick green-gradient">Ativo' : $color_featured = 'grey-gradient">Inativo');
                $clickFeatured = "statusFields('featured','{$val->id}','".route('product.status', $val->id)."','{$featured}','".csrf_token()."')";
                $featured  = '<p id="featured-'.$val->id.'"><button type="button" onclick="'.$clickFeatured.'" class="button compact '.$color_featured.'</button></p>';

                // Trend
                $trend = $val->trend;
                ($trend == 1 ? $color_trend = 'icon-tick green-gradient">Ativo' : $color_trend = 'grey-gradient">Inativo');
                $clickTrend = "statusFields('trend','{$val->id}','".route('product.status', $val->id)."','{$trend}','".csrf_token()."')";
                $trend  = '<p id="trend-'.$val->id.'"><button type="button" onclick="'.$clickTrend.'" class="button compact '.$color_trend.'</button></p>';
                // Black Friday
                $black_friday = $val->black_friday;
                ($black_friday == 1 ? $color_black_friday = 'icon-tick green-gradient">Ativo' : $color_black_friday = 'grey-gradient">Inativo');
                $clickBlackfriday = "statusFields('black_friday','{$val->id}','".route('product.status', $val->id)."','{$black_friday}','".csrf_token()."')";
                $black_friday  = '<p id="black_friday-'.$val->id.'"><button type="button" onclick="'.$clickBlackfriday.'" class="button compact '.$color_black_friday.'</button></p>';
                // Freight.
                if ($default == 1) {
                    $freight  = '<p>Peso: <strong> '.$val->weight.' gr </strong></p>';
                    ($height == 1 && $val->height != '' ? $freight .= '<p>Altura: <strong> '.$val->height.' cm </strong></p>' : '');
                    ($width == 1 && $val->width != '' ? $freight .= '<p>Largura: <strong> '.$val->width.' cm </strong></p>' : '');
                    ($length == 1 && $val->length != '' ? $freight .= '<p>Comprimento: <strong> '.$val->length.' cm </strong></p>' : '');
                }

                if ($confCost == 1) {
                    $costProd = $val->cost;
                    $cost = '<p>Custo: <strong> '.setReal($costProd->value).' </strong></p>';
                } else {
                    $cost = '';
                }

                // Video
                ($video == 1 ? $video = '<p>Video: <strong> '.$val->video.' </strong></p>' : $video = '');

                // Video
                ($kit == 1 ? $kit = '<p>Kit: <strong> '.$val->kit_name.' </strong></p>' : $kit = '');

                $nData['image']       = $image;
                $nData['visits']      = [0 => $visits];
                $nData['new']         = $new;
                $nData['offer']       = [0 => $offers];
                $nData['active']      = $status;
                $nData['featured']    = $featured;
                $nData['trend']       = $trend;
                $nData['black_friday']= $black_friday;
                $nData['id']          = $val->id;
                $nData['name']        = $val->name;
                $nData['description'] = $val->description;
                $nData['brand']       = $val->brand;
                $nData['section']     = $val->section;
                $nData['category']    = $val->category;
                $nData['tags']        = $val->tags;
                $nData['video']       = $video;
                $nData['percent']     = $val->percent;
                $nData['unit']        = $val->unit;
                $nData['measure']     = $val->measure;
                $nData['cost']        = $cost;
                $nData['price_card']  = setReal($price_card);
                $nData['price_cash']  = setReal($price_cash);
                $nData['offer_card']  = ($offer_card != null && $offer == 1 ?
                    'Em Oferta: <strong>'.setReal($offer_card).'</strong>' : '');
                $nData['offer_cash']  = ($offer_cash != null && $offer == 1 ?
                    'Em Oferta: <strong>'.setReal($offer_cash).'</strong>' : '');
                $nData['sum_stock']   = $sum_stock;
                $nData['freight']     = $freight;
                $nData['prices']      = $prices;
                $nData['kit']         = $kit;

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
     * Table: Keyword
     *
     * @return array
     */

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

        if (isset($input['freight']) && $input['freight'] == 0) {
            unset($input['declare']);
            unset($input['weight']);
            unset($input['width']);
            unset($input['height']);
            unset($input['length']);
        }

        $exp = explode("|", $input['unit_measure']);
        $input['unit']    = $exp[0];
        $input['measure'] = $exp[1];

        $brand    = $input['brand'];
        $product  = $input['name'];
        $section  = $input['section'];
        $category = $input['category'];
        $keywords = $this->keywords->rand();

        if ($input['tags'] == '') {
            $input['tags']  = $keywords['title'].",{$product},{$section},{$category},{$brand}";
        }
        if ($input['description'] == '') {
            $input['description']  = $keywords['description'].", {$product},  {$section}, {$category}, {$brand}";
        }

        $input['slug']    = Str::slug("{$product}-{$category}-{$section}-{$brand}");
        $input['visits']  = 0;

        if ($input['offer'] == 1) {
            $offer_days = intval($input['offer_days']);
            $timestamp  = strtotime("+{$offer_days} days");
            $input['offer_date'] = date('Y-m-d H:i:s', $timestamp); 
        }


        $data = $this->model->create($input); 
        if ($data) {

            $slug = ["slug" => $data->slug.'-'.numLetter($data->id, 'letter')];
            $update = $data->update($slug);

            if ($update) {

                ($data->stock != 0 ? $stock = ", Estoque:$data->stock" : $stock = "");
                ($data->declare != 1 ? $declare = ", Declarar Valor:{$data->declare}" : $declare = "");
                ($data->weight  != NULL ? $weight = ", Peso:{$data->weight}"   : $weight = "");
                ($data->width   != NULL ? $width  = ", Largura:{$data->width}" : $width  = "");
                ($data->height  != NULL ? $height = ", Altura:{$data->height}" : $height = "");
                ($data->length  != NULL ? $length = ", Compr:{$data->length}"  : $length = "");

                ($data->new == 1 ? $new = ", Novo:Ativo"  : $new = "");
                ($data->offer == 1 ? $offer = ", Oferta:Ativo, Dias:".$offer_days  : $offer = "");
                ($data->trend == 1 ? $trend = ", Tendência:Ativo"  : $trend = "");
                ($data->featured == 1 ? $featured = ", Destaque:Ativo"  : $featured = "");
                ($data->black_friday == 1 ? $black_friday = ", Black Friday:Ativo"  : $black_friday = "");
                ($data->active == 1 ? $active = "Ativo"  : $active = "Inativo");

                generateAccessesTxt(
                    date('H:i:s').utf8_decode(' Adicionou o produto Nome:'.$data->name.
                    ', Status:'.$active.
                    ', Und Medida:'.$data->unit.' '.$data->measure.
                    $stock.
                    $weight.$width.$height.$length.
                    ', Tags: '.$data->tags.
                    ', Descrição: '.strip_tags($data->description).
                    $new.$offer.$trend.$featured.$black_friday)
                );
            }

            return $data;
        }

        return false;
    }

    /**
     * Update 
     *
     * @param  int  $id
     * @param  array $input
     * @return boolean true or false
     */
    public function update($input, $data, $id)
    {
        //dd($input);
        $offer_days = '';
        $success = false;
        $message = 'Não foi possível alterar o produto';

        $exp = explode("|", $input['unit_measure']);
        $input['unit']    = $exp[0];
        $input['measure'] = $exp[1];

        if (isset($input['freight']) && $input['freight'] == 0) {
            unset($input['declare']);
            unset($input['weight']);
            unset($input['width']);
            unset($input['height']);
            unset($input['length']);
        }

        if (isset($input['change'])) {

            $brand    = $input['brand'];
            $product  = $input['name'];
            $section  = $input['section'];
            $category = $input['category'];
            $keywords = $this->keywords->rand();

            if ($input['tags'] == '') {
                $input['tags']  = "{$product}, {$section}, {$category}, {$brand}, ".Str::slug($keywords['title']);
            }
            if ($input['description'] == '') {
                $input['description']  = $keywords['description'].", {$product}, {$section}, {$category}, {$brand}";
            }

            $input['slug'] = Str::slug("{$product}-{$category}-{$section}-{$brand}");
        }

        $current_brand       = $data->brand;
        $current_section     = $data->section;
        $current_category    = $data->category;
        $current_name        = $data->name;
        $current_tags        = $data->tags;
        $current_description = $data->description;
        $current_declare     = $data->declare;
        $current_measure     = $data->measure;
        $current_unit        = $data->unit;
        $current_section_id  = $data->section_id;
        $current_category_id = $data->category_id;

        ($data->stock != 0 ? $current_stock = ", Estoque:$data->stock" : $current_stock = "");
        ($data->declare != 1 ? $current_declare = ", Declrar Valor :{$data->declare}"   : $current_declare = "");
        ($data->weight != NULL ? $current_weight = ", Peso:{$data->weight}"   : $current_weight = "");
        ($data->width  != NULL ? $current_width  = ", Largura:{$data->width}" : $current_width  = "");
        ($data->height != NULL ? $current_height = ", Altura:{$data->height}" : $current_height = "");
        ($data->length != NULL ? $current_length = ", Compr:{$data->length}"  : $current_length = "");


        if ($input['offer'] == 1) {
            $offer_days = intval($input['offer_days']);
            $timestamp  = strtotime("+{$offer_days} days");
            $input['offer_date'] = date('Y-m-d H:i:s', $timestamp); 
        }

        ($data->new == 1 ? $current_new = ", Novo:Ativo"  : $current_new = "");
        ($data->offer == 1 ? $current_offer = ", Oferta:Ativo, Dias:".$offer_days  : $current_offer = "");
        ($data->trend == 1 ? $current_trend = ", Tendência:Ativo"  : $current_trend = "");
        ($data->featured == 1 ? $current_featured = ", Destaque:Ativo"  : $current_featured = "");
        ($data->black_friday == 1 ? $current_black_friday = ", Black Friday:Ativo"  : $current_black_friday = "");
        ($data->active == 1 ? $current_active = "Ativo"  : $current_active = "Inativo");


        $update = $data->update($input);
        if ($update) {

            ($data->stock != 0 ? $stock = ", Estoque:$data->stock" : $stock = "");
            ($data->weight != NULL ? $weight = ", Peso:{$data->weight}"   : $weight = "");
            ($data->width  != NULL ? $width  = ", Largura:{$data->width}" : $width  = "");
            ($data->height != NULL ? $height = ", Altura:{$data->height}" : $height = "");
            ($data->length != NULL ? $length = ", Compr:{$data->length}"  : $length = "");

            ($data->new == 1 ? $new = ", Novo:Ativo"  : $new = "");
            ($data->offer == 1 ? $offer = ", Oferta:Ativo, Dias:".$offer_days  : $offer = "");
            ($data->trend == 1 ? $trend = ", Tendência:Ativo"  : $trend = "");
            ($data->featured == 1 ? $featured = ", Destaque:Ativo"  : $featured = "");
            ($data->black_friday == 1 ? $black_friday = ", Black Friday:Ativo"  : $black_friday = "");
            ($data->active == 1 ? $active = "Ativo"  : $active = "Inativo");

            generateAccessesTxt(
                date('H:i:s').utf8_decode(' alterou o Produto: '.$current_name.'/'.
                $current_category.'/'.$current_section.'/'.$current_brand.
                ', Status:'.$current_active.
                ', Und Medida:'.$current_unit.' '.$current_measure.
                $current_stock.
                $current_weight.$current_width.$current_height.$current_length.
                ', Tags: '.$current_tags.
                ', Descrição: '.strip_tags($current_description).
                $current_new.$current_offer.$current_trend.$current_featured.$current_black_friday.
                ' Para '.$data->name.'/'.$data->category.'/'.$data->section.'/'.$data->brand.
                ', Status:'.$active.
                ', Und Medida:'.$data->unit.' '.$data->measure.
                $stock.
                $weight.$width.$height.$length.
                ', Tags: '.$data->tags.
                ', Descrição: '.strip_tags($data->description).
                $new.$offer.$trend.$featured.$black_friday)
            );

            $success = true;
            $message = 'O produto foi alterado';

        }

        $out = array(
            "success" => $success,
            "message" => $message,
            "change" => $input['change'],
            "refresh" => $input['refresh'],
            "redirect" => $input['redirect'],
            "id" => $id
        );

        if ($input['change'] == true) {
            $out['update'] = array(
                'section_id' => $data->section_id,
                'category_id' => $data->category_id
            ); 
            $out['current'] = array(
                'section_id' => $current_section_id,
                'category_id' => $current_category_id
            );           
        }

        return $out;
    }

    /**
     * Date 06/04/2019
     *
     * @param $config
     * @param $product
     * @return bool
     */
    public function delete($configProduct, $config, $product)
    {
        $images = $product->images;
        $total  = count($images);


        if ($configProduct->grids == 1) {
            $deleteGrids = $this->deleteGrids($configProduct, $images, $product);
        }

        if ($total >= 1) {
            $deleteImages = $this->deleteImages($config, $images, $total);
        }

        $delete = $product->delete();
        if ($delete) {
            generateAccessesTxt(date('H:i:s').utf8_decode(
                    ' '.constLang('deleted').
                    ' '.constLang('product').':'.Str::slug($product->name.
                        '/'.$product->category.'/'.$product->section.'/'.$product->brand).
                    ', '.constLang('messages.products.total_colors').':'.$total)
            );
            $product['total_colors'] = $total;

            return true;
        }

    }


    /**
     * Date: 06/10/2019
     *
     * @param $images
     * @param $product
     * @return mixed
     */
    protected function deleteGrids($configProduct, $images, $product)
    {
        if ($product->stock == 1) {
            if ($product->kit == 0) {
                foreach ($images as $image) {
                    $grids = $this->interGrid->getGrids($image->id);
                    foreach ($grids as $grid) {
                        if ($product->kit == 1) {
                            $inventory = $this->interInventory->deleteKit($configProduct, $product, $image, $grid);
                        } else {
                            $inventory = $this->interInventory->deleteUnit($configProduct, $product, $image, $grid);
                        }
                    }
                }
            }
        }
    }

    /**
     * Date 06/04/2019
     * Excludes if the image is unique
     *
     * @param $config
     * @param $product
     * @param $image
     * @return bool
     */
    public function deleteUnique($configProduct, $config, $product, $reload)
    {
        $delete = $this->delete($configProduct, $config, $product);
        if ($delete) {
            $success = true;
            $message = constLang('messages.products.delete_true');

        } else {
            $success = false;
            $message = constLang('messages.products.delete_false');
        }

        $out = array(
            'success' => $success,
            'message' => $message,
            'reload'  => $reload
        );

        return $out;
    }


    /**
     * Date: 06/10/2019
     *
     * @param  int  $id
     * @param  array $input
     * @return json
     */
    public function status($input, $id)
    {
        $field  = $input['field'];
        $status = $input['status'];
        $data   = $this->model->find($id);

        $form[$field] = $status;
        $update = $data->update($form);

        if ($update) {

            switch ($field) {
                case 'offer':
                    $name = constLang('offer');
                    break;
                case 'new':
                    $name = constLang('new');
                    break;
                case 'featured':
                    $name = constLang('featured');
                    break;
                case 'trend':
                    $name = constLang('trend');
                    break;
                case 'black_friday':
                    $name = constLang('black_friday');
                    break;
                default:
                    $name = ' ';
                    break;
            }

            $route = route('product.status', $id);
            $token = csrf_token();
            $onclick = "statusFields('{$field}','{$id}','{$route}','{$status}','{$token}')";

            if ($status == 1) {
                $cls = 'green-gradient';
                $active = constLang('active_true');
            } else {
                $cls = 'grey-gradient';
                $active = constLang('active_false');
            }

            $btn = '<button onclick="'.$onclick.'" class="button compact '.$cls.'">'.$active.'</button>';

            $success = true;
            $message = constLang('updated').' '.constLang('status').' '.$name.':'.$active;

            generateAccessesTxt(date('H:i:s').utf8_decode(
                    ' '.$message. ', '.constLang('product').':'.$data->name.
                    ', '.constLang('category').':'.$data->category.
                    ', '.constLang('section').':'.$data->section)
            );

        } else {
            $success = false;
            $message = constLang('status_false');
            $click   = null;
        }

        $out = array(
            "success" => $success,
            "message" => $message,
            "click" => $btn
        );

        return $out;
    }




    /**
     * Date: 06/10/2019
     *
     * @param $config
     * @param $images
     * @return bool
     */
    protected function deleteImages($config, $images)
    {
        foreach ($config as $value) {
            foreach ($images as $image) {
                if ($value->type == 'C') {
                    if ($value->default != 'T') {
                        $file = $this->disk . $value->path . $image->image;
                        if (file_exists($file)) {
                            $remove = unlink($file);
                        }
                    }
                }
                $positions = $image->positions;
                if (!empty($positions)) {
                    if ($value->type == 'P') {
                        foreach ($positions as $position) {
                            $file = $this->disk.$value->path.$position->image;
                            if (file_exists($file)) {
                                $remove = unlink($file);
                            }
                        }
                    }
                }
            }
        }
        return true;
    }
}