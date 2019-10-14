<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Http\Requests\Admin\ProductPositionRequest as ReqModel;

use AVDPainel\Interfaces\Admin\ConfigColorPositionInterface as ConfigImage;
use AVDPainel\Interfaces\Admin\ImagePositionInterface as InterModel;
use AVDPainel\Interfaces\Admin\ImageColorInterface as InterColor;
use AVDPainel\Interfaces\Admin\ProductInterface as InterProduct;

use AVDPainel\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ImagePositionController extends Controller
{

    protected $ability   = 'product-images';
    protected $view      = 'backend.positions';
    protected $photoUrl  = 'storage/';


    public function __construct(
        InterModel  $interModel,
        ConfigImage $configImage)
    {
        $this->middleware('auth:admin');

        $this->configImage   = $configImage;
        $this->interModel    = $interModel;
    }

    /**
     * Date 06/04/2019
     *
     * @param InterProduct $interProduct
     * @param $idpro
     * @return View
     */
    public function index(InterProduct $interProduct, $idpro)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $configImage  = $this->configImage->setName('default', 'N');
        $product      = $interProduct->setId($idpro);
        $images       = $product->images;
        $path         = $this->photoUrl.$configImage->path;

        (count($images) >= 1 ? $title_count = constLang('images.count_true') :
                               $title_count = constLang('images.count_false'));

        return view("{$this->view}.gallery", compact('images','path','idpro', 'title_count'));
    }

    /**
     * Date 06/05/2019
     *
     * @param InterColor $interColor
     * @param $idpro
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(InterColor $interColor, $idpro)
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }

        $image = $interColor->setId($idpro);
        $pixel = $this->configImage->setName('default','Z');

        return view("{$this->view}.form-create", compact('idpro', 'image', 'pixel'));
    }

    /**
     * Date: 06/05/2019
     *
     * @param ReqModel $request
     * @param $idpro
     * @return Json
     */
    public function store(ReqModel $request, $idpro)
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }
        $config = $this->configImage->get();
        $action = $request['ac'];
        $input  = $request['pos'];
        $file   = $request->file('file');
        $out    = $this->interModel->create($input, $config, $file, $this->view, $action);

        return response()->json($out);
    }

    /**
     * Date 06/05/2019
     *
     * @param $idimg
     * @param $id
     * @return View
     */
    public function edit($idimg, $id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }
        $configImage = $this->configImage->setName('default', 'N');
        $position    = $this->interModel->setId($id);
        $pixel       = $this->configImage->setName('default','Z');
        $path        = $this->photoUrl.$configImage->path;


        return view("{$this->view}.form-edit", compact('position', 'idimg', 'path', 'pixel'));
    }


    /**
     * Date: 06/05/2019
     *
     * @param Request $request
     * @param $idimg
     * @param $id
     * @return Json
     */
    public function update(Request $request, $idimg, $id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }
        $file   = $request->file('file');
        $input  = $request['pos'];
        $image  = $this->interModel->setId($id);
        $config = $this->configImage->get();
        $action = $request['ac'];

        $out = $this->interModel->update($input, $image, $config, $file, $this->view, $action);
        return response()->json($out);
    }

    /**
     * Date 06/05/2019
     *
     * @param $idimg
     * @param $id
     * @return json
     */
    public function destroy($idimg, $id)
    {
        if( Gate::denies("{$this->ability}-delete") ) {
            return view("backend.erros.message-401");
        }

        $config = $this->configImage->get();
        $delete = $this->interModel->delete($id, $config);

        return response()->json($delete);
    }


    /**
     * date 06/05/2019
     *
     * @param Request $request
     * @param $id
     * @return json
     */
    public function status(Request $request, $id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $input  = $request->all();
        $config = $this->configImage->get();
        $status = $this->interModel->status($config, $input, $this->view, $id);

        return response()->json($status);
    }   
}