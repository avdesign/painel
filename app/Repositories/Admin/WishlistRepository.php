<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\Wishlist as Model;
use AVDPainel\Interfaces\Admin\WishlistInterface;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Validation\ValidatesRequests;

class WishlistRepository implements WishlistInterface
{
    use ValidatesRequests;

    public $model;

    /**
     * WishlistRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model    = $model;
    }

    public function rules($input, $messages, $id='')
    {
        $this->validate($input, $this->model->rules($id), $messages);
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->model->get();
    }


    /**
     * @param $id
     * @return mixed
     */
    public function setId($id)
    {
        return $this->model->find($id);
    }


    /**
     * @param $request
     * @return array
     */
    public function getAll($request)
    {
        $columns = array(
            0  => 'total',
            1  => 'first_name',
            2  => 'admin',
            3  => 'user_id',
            4  => 'document1',
            5  => 'phone',
            6  => 'cell',
            7  => 'last_name',
            8  => 'profile',
        );

        $totalData = $this->model->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {

            $query = DB::table('wishlists')
                ->join('users','wishlists.user_id','users.id')
                ->join('config_profile_clients','config_profile_clients.id','users.profile_id')
                ->select('config_profile_clients.name as profile','user_id','profile_id','first_name','last_name','email','document1','phone','cell','admin', DB::raw('count(*) as total'))
                ->groupBy('user_id')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                //->take(2) //Qty
                ->get();




        } else {
            $search = $request->input('search.value');

            $query = DB::table('wishlists')
                ->join('users','wishlists.user_id','users.id')
                ->join('config_profile_clients','config_profile_clients.id','users.profile_id')
                ->select('config_profile_clients.name as profile','user_id','profile_id','first_name','last_name','email','document1','phone','cell','admin', DB::raw('count(*) as total'))
                ->groupBy('user_id')
                ->where('user_id','LIKE',"%{$search}%")
                ->orWhere('first_name','LIKE',"%{$search}%")
                ->orWhere('email','LIKE',"%{$search}%")
                ->orWhere('document1','LIKE',"%{$search}%")
                ->orWhere('phone','LIKE',"%{$search}%")
                ->orWhere('cell','LIKE',"%{$search}%")
                ->orWhere('last_name','LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                //->take(2) //Qty
                ->get();



            $totalFiltered = DB::table('wishlists')
                ->join('users','wishlists.user_id','users.id')
                ->join('config_profile_clients','config_profile_clients.id','users.profile_id')
                ->select('config_profile_clients.name as profile','user_id','profile_id','first_name','last_name','email','document1','phone','cell','admin', DB::raw('count(*) as total'))
                ->groupBy('user_id')
                ->where('user_id','LIKE',"%{$search}%")
                ->orWhere('first_name','LIKE',"%{$search}%")
                ->orWhere('email','LIKE',"%{$search}%")
                ->orWhere('document1','LIKE',"%{$search}%")
                ->orWhere('phone','LIKE',"%{$search}%")
                ->orWhere('cell','LIKE',"%{$search}%")
                ->orWhere('last_name','LIKE',"%{$search}%")
                ->count();

        }

        $data  = array();
        if(!empty($query))
        {
            foreach ($query as $val){

                if ($val->profile_id == 3) {
                    $name_html =  "<li>Nome Fantasia: <strong>{$val->first_name}</strong></li><li>Razão Social: <strong>{$val->last_name}</strong></li>";
                    $document_html =  "<li>CNPJ: <strong>{$val->document1}</strong></li>";
                } else {
                    $name_html =  "<li>Nome: <strong> {$val->first_name} {$val->last_name}</strong></li>";
                    $document_html =  "<li>CPF: <strong>{$val->document1}</strong></li>";
                }

                $nData['total']         = $val->total;
                $nData['first_name']    = $val->first_name;
                $nData['admin']         = $val->admin;
                $nData['user_id']       = $val->user_id;
                $nData['email']         = $val->email;
                $nData['document1']     = $val->document1;
                $nData['phone']         = $val->phone;
                $nData['cell']          = $val->cell;
                $nData['last_name']     = $val->last_name;
                $nData['profile']       = $val->profile;
                $nData['name_html']     = $name_html;
                $nData['document_html'] = $document_html;
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
     * @param $user_id
     * @return mixed
     */
    public function getWishlist($user_id)
    {
        return $this->model->where('user_id', $user_id)->orderBy('id','desc')->get();
    }

    /**
     * @param $input
     * @param $user
     * @param $color
     * @param $configProduct
     * @return array
     */
    public function create($input, $user, $color, $configProduct)
    {
        $product = $color->product;
        $prices = $product->prices;
        foreach ($prices as $price) {
            if ($configProduct->config_prices == 1) {
                if ($price->config_profile_client_id == $user->profile_id) {
                    if ($product->offer == 1) {
                        $percent = $price->offer_percent;
                        $price_card = $price->offer_card;
                        $price_cash = $price->offer_cash;
                    } else {
                        $percent = $price->price_cash_percent;
                        $price_card = $price->price_card;
                        $price_cash = $price->price_cash;
                    }
                }
            } else {
                if ($product->offer == 1) {
                    $percent = $price->offer_percent;
                    $price_card = $price->offer_card;
                    $price_cash = $price->offer_cash;
                } else {
                    $percent = $price->price_cash_percent;
                    $price_card = $price->price_card;
                    $price_cash = $price->price_cash;
                }
            }
        }

        $item = [
            'user_id' => $user->id,
            'product_id' => $color->product_id,
            'image_color_id' => $color->id,
            'image' => $color->image,
            'color' => $color->color,
            'code' => $color->code,
            'profile' => $user->profile_id,
            'offer' => $product->offer,
            'percent' => $percent,
            'price_card' => $price_card,
            'price_cash' => $price_cash,
            'slug' => $color->slug,
            'kit' => $color->kit,
            'kit_name' => $color->kit_name,
            'name' => $product->name,
            'category' => $product->category,
            'section' => $product->section,
            'brand' => $product->brand,
            'unit' => $product->unit,
            'measure' => $product->measure,
            'weight' => $product->weight,
            'width' => $product->width,
            'height' => $product->height,
            'length' => $product->length,
            'cost' => $product->cost
        ];

        $i=1;
        if ($color->kit == 1) {
            foreach ($input as $value) {
                $ip              = $value['ip'];
                $grid            = $value['grid'];
                $quantity        = $value['quantity'];
                $grid_product_id = $value['grid_product_id'];
            }
            $item['key']             = md5($i.$user->id.time());
            $item['ip']              = $ip;
            $item['grid']            = $grid;
            $item['quantity']        = $quantity;
            $item['grid_product_id'] = $grid_product_id;
            $exist = $this->model->where(['user_id' => $user->id, 'image_color_id' => $color->id, 'grid' => $grid])->first();
            if ($exist) {

                $update = $exist->update($item);
                if ($update) {
                    generateAccessesTxt(
                        date('H:i:s').utf8_decode(
                            ' Alterou (Lista de Desejo) Cliente:'.$user->first_name.
                            ', Produto:'.$product->name.
                            ', Ref:'.$color->code.
                            ', Cor:'.$color->color.
                            ', '.$grid.
                            ', Qtd:'.$quantity)
                    );
                }

            } else {

                $create = $this->model->create($item);
                if ($create) {
                    generateAccessesTxt(
                        date('H:i:s').utf8_decode(
                            ' Adicionou (Lista de Desejo) Cliente:'.$user->first_name.
                            ', Produto:'.$product->name.
                            ', Ref:'.$color->code.
                            ', Cor:'.$color->color.
                            ', '.$grid.
                            ', Qtd:'.$quantity)
                    );
                }

            }

        } else {
            foreach ($input as $value) {
                $item['key']             = md5($i.$user->id.time());
                $item['ip']              = $value['ip'];
                $item['grid']            = $value['grid'];
                $item['quantity']        = $value['quantity'];
                $item['grid_product_id'] = $value['grid_product_id'];

                $exist = $this->model->where(['user_id' => $user->id, 'image_color_id' => $color->id, 'grid' => $value['grid']])->first();
                if ($exist) {

                    $update = $exist->update($item);
                    if ($update) {
                        generateAccessesTxt(
                            date('H:i:s').utf8_decode(
                                ' Alterou (Lista de Desejo) Cliente:'.$user->first_name.
                                ', Produto:'.$product->name.
                                ', Ref:'.$color->code.
                                ', Cor:'.$color->color.
                                ', '.$value['grid'].
                                ', Qtd:'.$value['quantity'])
                        );
                    }

                } else {
                    $create = $this->model->create($item);
                    if ($create) {
                        generateAccessesTxt(
                            date('H:i:s').utf8_decode(
                                ' Adicionou (Lista de Desejo) Cliente:'.$user->first_name.
                                ', Produto:'.$product->name.
                                ', Ref:'.$color->code.
                                ', Cor:'.$color->color.
                                ', '.$value['grid'].
                                ', Qtd:'.$value['quantity'])
                        );
                    }

                }

                $i++;
            }
        }

        $out = array(
            'success' => true,
            'message' => 'O produto foi adicionado.',
            'reload' => route('wishlist.reload', $user->id)
        );

        return $out;
    }

    /**
     * @param $input
     * @param $id
     * @return bool
     */
    public function update($input, $id)
    {
        $data   = $this->model->find($id);
        $update = $data->update($input);
        if ($update) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                    ' Alterou (Lista de Desejo) Cliente:'.$data->user->first_name.
                    ', Produto:'.$data->name.
                    ', Ref:'.$data->code.
                    ', Cor:'.$data->color.
                    ', '.$data->grid.
                    ', Qtd:'.$input['quantity'])
            );
            return true;
        }

        return false;
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $data   = $this->model->find($id);
        if ($data->kit == 1) {
            $grade = ', '.$data->kit_name.' '.$data->unit.' '.$data->measure.' Grade:'.$data->grid;
        } else {
            $grade = ', Grade:'.$data->grid;
        }
        $delete = $data->delete();
        if ($delete) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                    ' Excluiu o produto (Lista de Desejos) Cliente:'.$data->user->first_name.
                    ', Produto:'.$data->name.
                    ', Ref:'.$data->code.
                    ', Cor:'.$data->color.
                    $grade.
                    ', Qtd:'.$data->quantity)
            );

            return $data;
        }

        return false;
    }


    public function deleteAll($user_id)
    {
        $wishlists = $this->getWishlist($user_id);
        $total = count($wishlists);
        $i=0;
        foreach ($wishlists as $wishlist) {
            $data = $this->model->find($wishlist->id);
            if ($data->kit == 1) {
                $grade = ', '.$data->kit_name.' '.$data->unit.' '.$data->measure.' Grade:'.$data->grid;
            } else {
                $grade = ', Grade:'.$data->grid;
            }
            $delete=true;
            //$delete = $data->delete();
            if ($delete) {
                generateAccessesTxt(
                    date('H:i:s').utf8_decode(
                        ' Excluiu o produto (Lista de Desejos) Cliente:'.$data->user->first_name.
                        ', Produto:'.$data->name.
                        ', Ref:'.$data->code.
                        ', Cor:'.$data->color.
                        $grade.
                        ', Qtd:'.$data->quantity)
                );
            }
            $i++;
        }

        if ($i == $total) {
            return true;
        } else {
            return false;
        }


    }


}