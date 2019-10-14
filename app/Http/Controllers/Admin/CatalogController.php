<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Interfaces\Admin\CatalogInterface as InterModel;
use AVDPainel\Interfaces\Admin\ConfigSystemInterface as ConfigSystem;
use AVDPainel\Interfaces\Admin\ConfigProductInterface as ConfigProduct;


use AVDPainel\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Gate;
use DB;


class CatalogController extends Controller
{
    protected $ability = 'product-images';
    protected $view    = 'backend.catalog';

    public function __construct(
        ConfigSystem $confUser,
        InterModel $interModel,
        ConfigProduct $configProduct)
    {
        $this->middleware('auth:admin');

        $this->confUser       = $confUser;
        $this->interModel     = $interModel;
        $this->configProduct  = $configProduct;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( Gate::denies("product-view") ) {
            return view("backend.erros.message-401");
        }

        $confUser      = $this->confUser->get();
        $configProduct = $this->configProduct->setId(1);

        return view("{$this->view}.index", compact('configProduct','confUser'));
    }


    public function data(Request $request)
    {
        if( Gate::denies("product-view") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interModel->getAll($request);

        return response()->json($data);
    }


    public function status(Request $request, $id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }
        try{
            DB::beginTransaction();

            $input   = $request->all();
            $image   = $this->interModel->setId($id);
            $product = $image->product;
            $status  = $this->interModel->status($input, $product, $this->view, $image);

            DB::commit();

            return response()->json($status);

        } catch(\Exception $e){

            DB::rollback();
            return $e->getMessage();
        }
    }

}
