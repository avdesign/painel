<?php

namespace AVDPainel\Http\Controllers\Admin;


use AVDPainel\Interfaces\Admin\OrderInterface as InterOrder;
use AVDPainel\Interfaces\Admin\OrderItemInterface as InterModel;
use AVDPainel\Interfaces\Admin\GridProductInterface as InterGrid;
use AVDPainel\Interfaces\Admin\ImageColorInterface as InterProduct;
use AVDPainel\Interfaces\Admin\ConfigSystemInterface as ConfigSystem;
use AVDPainel\Interfaces\Admin\ConfigProductInterface as ConfigProduct;
use AVDPainel\Interfaces\Admin\ConfigFreightInterface as ConfigFreight;
use AVDPainel\Interfaces\Admin\ConfigColorPositionInterface as ConfigImages;

use AVDPainel\Interfaces\Admin\UserInterface as InterUser;
use AVDPainel\Interfaces\Admin\ConfigStatusPaymentInterface as StatusPayment;
use AVDPainel\Interfaces\Admin\ConfigFormPaymentInterface as FormPayment;

use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use AVDPainel\Http\Controllers\Controller;

class OrderItemController extends Controller
{
    protected $ability  = 'orders';
    protected $view     = 'backend.orders.items';
    protected $view_pdf = 'backend.orders';
    protected $disk_pdf;
    protected $url_pdf;
    protected $select;
    protected $upload;
    protected $last_url;
    protected $photo_url;
    protected $messages;

    public function __construct(
        InterUser $interUser,
        InterGrid $interGrid,
        InterOrder $interOrder,
        InterModel $interModel,
        ConfigSystem $confUser,
        FormPayment $formPayment,
        InterProduct $interProduct,
        ConfigImages $configImages,
        ConfigFreight $configFreight,
        ConfigProduct $configProduct,
        StatusPayment $statusPayment)
    {
        $this->middleware('auth:admin');

        $this->confUser      = $confUser;
        $this->interUser     = $interUser;
        $this->interGrid     = $interGrid;
        $this->interOrder    = $interOrder;
        $this->interModel    = $interModel;
        $this->formPayment   = $formPayment;
        $this->interProduct  = $interProduct;
        $this->configFreight = $configFreight;
        $this->configProduct = $configProduct;
        $this->statusPayment = $statusPayment;
        $this->configImages  = $configImages;
        $this->photo_url     = 'storage/';
        $this->url_pdf       = 'storage/pdf/order';
        $this->disk_pdf      = storage_path('app/public/pdf/order');
        $this->messages = array(
            'quantity.required'                 => 'A quantidade é obrigatória.',
            'title_index'                       => 'Produtos do Pedido',
            'title_create'                      => 'Adicionar Produto',
            'title_edit'                        => 'Alterar Produto',
            'store_true'                        => 'O produto foi adicionado.',
            'store_false'                       => 'Não foi possível adicionar o produto.',
            'update_true'                       => 'O produto foi alterado.',
            'update_false'                      => 'Não foi possível alterar o produto.',
            'delete_true'                       => 'O produto foi excluido.',
            'delete_false'                      => 'Não foi possível excluir o produto.',
            'quantity_false'                    => 'A quantidade é obrigatŕia.',
            'success_false'                     => 'Houve um erro no servidor.'
        );
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }
        $order = $this->interOrder->setId($id);

        $items = $order->items;
        $image =  $this->configImages->setName('default','T');
        $photo_url = $this->photo_url;
        $title =  $this->messages['title_index'];

        return view("{$this->view}.index", compact('order','title','items', 'image', 'photo_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $order_id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interModel->setId($id);

        return view("{$this->view}.form-edit", compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $order_id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $this->interModel->rules($request, $this->messages);

        $dataForm = $request->all();

        $data = $this->interModel->update($dataForm, $id);
        if ($data) {

            $order = $this->interOrder->setId($order_id);
            $items = $order->items;

            $qty=0;
            $weight=null;
            $width=null;
            $height=null;
            $length=null;
            $price_card=0;
            $price_cash=0;
            $subtotal=0;

            foreach ($items as $item) {
                if ($item->kit == 1) {
                    $price_card += $item->price_card * ($item->quantity * $item->unit);
                    $price_cash += $item->price_cash * ($item->quantity * $item->unit);
                } else {
                    $price_card += ($item->price_card * $item->quantity);
                    $price_cash += ($item->price_cash * $item->quantity);
                }

                $qty += intval($item->quantity);

                ($item->weight != null ? $weight += $item->weight : '');
                ($item->width != null ? $width += $item->width : '');
                ($item->height != null ? $height += $item->height : '');
                ($item->length != null ? $length += $item->length : '');

                ($order->config_form_payment_id == 1 ? $subtotal = $price_cash : $subtotal = $price_card);

            }

            $dataForm = [
                'qty' => $qty,
                'price_card' => $price_card,
                'price_cash' => $price_cash,
                'subtotal' => $subtotal,
                'weight' => $weight,
                'width' => $width,
                'height' =>$height,
                'length' =>$length,
                'ip' => $request->ip()
            ];

            $data = $this->interOrder->update($dataForm, $order_id);
            if ($data) {

                if ($this->generatePdf($order->id))
                    $success = true;
                    $message = $this->messages['update_true'];
            } else {
                $success = true;
                $message = $this->messages['update_false'];
            }
        } else {
            $success = false;
            $message = $this->messages['update_false'];
        }

        $out = array(
            'success' => $success,
            'message' => $message,
            'sum' => $dataForm
        );

        return response()->json($out);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if( Gate::denies("{$this->ability}-delete") ) {
            return view("backend.erros.message-401");
        }

        $product = $this->interModel->setId($id);
        $delete  =  $this->interModel->delete($id);

        if ($delete) {
            $order = $this->interOrder->setId($product->order_id);
            $items = $order->items;

            $qty=0;
            $weight=null;
            $width=null;
            $height=null;
            $length=null;
            $price_card=0;
            $price_cash=0;
            $subtotal=0;

            foreach ($items as $item) {
                if ($item->kit == 1) {
                    $price_card += $item->price_card * ($item->quantity * $item->unit);
                    $price_cash += $item->price_cash * ($item->quantity * $item->unit);
                } else {
                    $price_card += ($item->price_card * $item->quantity);
                    $price_cash += ($item->price_cash * $item->quantity);
                }

                $qty += intval($item->quantity);

                ($item->weight != null ? $weight += $item->weight : '');
                ($item->width != null ? $width += $item->width : '');
                ($item->height != null ? $height += $item->height : '');
                ($item->length != null ? $length += $item->length : '');

                ($order->config_form_payment_id == 1 ? $subtotal = $price_cash : $subtotal = $price_card);

            }

            $dataForm = [
                'qty' => $qty,
                'price_card' => $price_card,
                'price_cash' => $price_cash,
                'subtotal' => $subtotal,
                'weight' => $weight,
                'width' => $width,
                'height' =>$height,
                'length' =>$length
            ];

            $data = $this->interOrder->update($dataForm, $order->id);
            if ($data) {
                if ($this->generatePdf($order->id))
                $success = true;
                $message = $this->messages['delete_true'];
            } else {
                $success = true;
                $message = $this->messages['delete_false'];
            }
        } else {
            $success = false;
            $message = $this->messages['delete_false'];
        }

        $out = array(
            'success' => $success,
            'message' => $message,
            'sum' => $dataForm
        );

        return response()->json($out);

    }

    /**
     * @param $order_id
     * @return View
     */
    protected function products($order_id)
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }
        $image = $this->configImages->setName('default','T');
        return view("{$this->view}.products", compact('image','order_id'));
    }

    /**
     * @param Request $request
     * @param $order_id
     * @return Json
     */
    public function search(Request $request, $order_id)
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interProduct->search($request, $order_id, 'order-items.add');

        return response()->json($data);
    }

    /**
    * @param Request $request
    * @param $id
    * @return json
    */
    protected function add(Request $request, $id, $order_id)
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }

        $grids = array_filter($request['grid']);
        if (count($grids) >= 1) {

            foreach ($grids as $key => $value) {
                $size = $this->interGrid->setId($key);
                $input[] = [
                    'grid' => $size->grid,
                    'quantity' => $value
                ];
            }

            $order         = $this->interOrder->setId($order_id);
            $color         = $this->interProduct->setId($id);
            $configProduct = $this->configProduct->setId(1);

            $insert  =  $this->interModel->create($input, $order, $color, $configProduct);
            if ($insert) {
                $items = $order->items;

                $qty=0;
                $weight=null;
                $width=null;
                $height=null;
                $length=null;
                $price_card=0;
                $price_cash=0;
                $subtotal=0;

                foreach ($items as $item) {
                    if ($item->kit == 1) {
                        $price_card += $item->price_card * ($item->quantity * $item->unit);
                        $price_cash += $item->price_cash * ($item->quantity * $item->unit);
                    } else {
                        $price_card += ($item->price_card * $item->quantity);
                        $price_cash += ($item->price_cash * $item->quantity);
                    }

                    $qty += intval($item->quantity);

                    ($item->weight != null ? $weight += $item->weight : '');
                    ($item->width != null ? $width += $item->width : '');
                    ($item->height != null ? $height += $item->height : '');
                    ($item->length != null ? $length += $item->length : '');

                    ($order->config_form_payment_id == 1 ? $subtotal = $price_cash : $subtotal = $price_card);

                }

                $dataForm = [
                    'qty' => $qty,
                    'price_card' => $price_card,
                    'price_cash' => $price_cash,
                    'subtotal' => $subtotal,
                    'weight' => $weight,
                    'width' => $width,
                    'height' =>$height,
                    'length' =>$length,
                    'ip' => $request->ip()
                ];

                $data = $this->interOrder->update($dataForm, $order_id);
                if ($data) {

                    $generate = $this->generatePdf($order_id);

                    if ($generate)
                        $success = true;
                        $message = $this->messages['store_true'];
                } else {
                    $success = true;
                    $message = $this->messages['store_false'];
                }

                $out = array(
                    'success' => $success,
                    'message' => $message,
                    'sum' => $dataForm,
                    'reload' => $insert['route']
                );

                return response()->json($out);
            }

        } else {
            return response()->json([
                'success' => false,
                'message' => $this->messages['quantity_false']
            ]);
        }
    }

    /**
     * @param $id
     * @return View
     */
    protected function reload($id)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $order = $this->interOrder->setId($id);
        $items = $order->items;
        $image =  $this->configImages->setName('default','T');
        $photo_url = $this->photo_url;

        return view("{$this->view}.reload", compact(
            'order','items','image', 'photo_url'
        ));
    }


    /**
     * @param $order_id
     * @return string
     */
    public function generatePdf($order_id)
    {
        $order = $this->interOrder->setId($order_id);
        $items = $order->items;
        $notes = $order->notes;
        $year  = date('Y', strtotime($order->created_at));
        $shippings = $order->shippings;
        $image = $this->configImages->setName('default', 'T');


        $name = md5($order->id) . md5($order->user_id) . '.pdf';
        $path = "{$this->disk_pdf}/{$year}/{$order->user_id}";
        $file = "{$path}/{$name}";
        $photo_url = $this->photo_url;

        $route = url("{$this->url_pdf}/{$year}/{$order->user_id}/{$name}");

        if ( !file_exists($path) ) {
            \File::makeDirectory($path, 0777, true);
        }

        if (file_exists($file)) {
            $delete = unlink($file);
        }

        $pdf = PDF::loadView("{$this->view_pdf}.pdf",compact(
            'order','items','notes','shippings','image','photo_url'
        ));
        $pdf->save($file);

        return $route;
    }

}
