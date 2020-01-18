<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Interfaces\Admin\StockInterface as InterModel;
use AVDPainel\Interfaces\Admin\ConfigSystemInterface as ConfigSystem;
use AVDPainel\Interfaces\Admin\ConfigProductInterface as ConfigProduct;
use AVDPainel\Interfaces\Admin\ConfigColorPositionInterface as ConfigImage;



use AVDPainel\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Gate;
use DB;


class StockController extends Controller
{
    protected $ability = 'stock';
    protected $view    = 'backend.stock';
    private $photoUrl;
    private $disk;

    public function __construct(
        ConfigSystem $confUser,
        InterModel $interModel,
        ConfigImage $configImage,
        ConfigProduct $configProduct)
    {
        $this->middleware('auth:admin');

        $this->confUser       = $confUser;
        $this->interModel     = $interModel;
        $this->configProduct  = $configProduct;

        $this->configImage    = $configImage;

        $this->photoUrl       = 'storage/';
        $this->disk           = storage_path('app/public/');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( Gate::denies("stock-view") ) {
            return view("backend.erros.message-401");
        }

        $confUser      = $this->confUser->get();
        $configProduct = $this->configProduct->setId(1);

        return view("{$this->view}.index", compact('configProduct','confUser'));
    }


    public function data(Request $request)
    {
        if( Gate::denies("stock-view") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interModel->getAll($request);

        return response()->json($data);
    }


    public function entryStock($id)
    {
        if( Gate::denies("stock-entry") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interModel->setId($id);
        $product = $data->product;
        $configProduct = $this->configProduct->setId(1);

        // Configurações da pasta da imagem
        $configImage   = $this->configImage->setName('default', 'T');
        $path  = $configImage->path;
        $image = url("{$this->photoUrl}{$path}{$data->image->image}");

        return view("{$this->view}.entry", compact( 'data', 'image', 'product', 'configProduct'));
    }

    public function exitStock($id)
    {
        if( Gate::denies("stock-exit") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interModel->setId($id);
        $product = $data->product;
        $configProduct = $this->configProduct->setId(1);

        // Configurações da pasta da imagem
        $configImage   = $this->configImage->setName('default', 'T');
        $path  = $configImage->path;
        $image = url("{$this->photoUrl}{$path}{$data->image->image}");

        return view("{$this->view}.exit", compact( 'data', 'image', 'product', 'configProduct'));

    }


    public function update(Request $request, $id)
    {
        $dataForm = $request->all();
        $configProduct = $this->configProduct->setId(1);

        return $dataForm;
    }

}