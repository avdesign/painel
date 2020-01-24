<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Http\Controllers\Controller;
use AVDPainel\Http\Requests\Admin\StockRequest;
use AVDPainel\Interfaces\Admin\StockInterface as InterModel;
use AVDPainel\Interfaces\Admin\ConfigSystemInterface as ConfigSystem;
use AVDPainel\Interfaces\Admin\ConfigProductInterface as ConfigProduct;
use AVDPainel\Interfaces\Admin\ConfigColorPositionInterface as ConfigImage;

use DB;
use Gate;
use Illuminate\Http\Request;



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

    /**
     * Desabilitado
     *
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
     */


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

    /**
     * @param StockRequest $request
     * @param $id
     * @return View
     */
    public function update(StockRequest $request, $id)
    {
        try{
            DB::beginTransaction();

            $dataForm = $request->all();
            $configProduct = $this->configProduct->setId(1);

            /* Desabilitado
            if ($dataForm['ac'] == 'entry') {
                if( Gate::denies("stock-entry") ) {
                    return view("backend.erros.message-401");
                }

                // Criar o update = entryStock aqui
            }
            */

            if ($dataForm['ac'] == 'exit') {
                if( Gate::denies("stock-exit") ) {
                    return view("backend.erros.message-401");
                }
                $update = $this->interModel->exitStock($configProduct, $dataForm, $id);
            }

            if ($update) {
                DB::commit();
                return $update;
            }

        } catch(\Exception $e){

            DB::rollback();
            return $e->getMessage();
        }
    }

}
