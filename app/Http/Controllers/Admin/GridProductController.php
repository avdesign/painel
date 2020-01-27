<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Interfaces\Admin\BrandInterface as InterBrand;
use AVDPainel\Http\Requests\Admin\GridProducRequest as ReqModel;
use AVDPainel\Interfaces\Admin\ProductInterface as InterProduct;
use AVDPainel\Interfaces\Admin\SectionInterface as InterSection;
use AVDPainel\Interfaces\Admin\ImageColorInterface as InterImage;
use AVDPainel\Interfaces\Admin\CategoryInterface as InterCategory;
use AVDPainel\Interfaces\Admin\GridProductInterface as InterModel;
use AVDPainel\Interfaces\Admin\ConfigProductInterface as ConfigProduct;


use AVDPainel\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class GridProductController extends Controller
{
    protected $ability  = 'product';
    protected $view     = 'backend.colors-grids';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        InterModel $interModel,
        InterImage $interImage,
        InterBrand $interBrand,
        InterProduct $interProduct,
        InterSection $interSection,
        InterCategory $interCategory,
        ConfigProduct $configProduct)
    {
        $this->middleware('auth:admin');

        $this->interModel     = $interModel;
        $this->interImage     = $interImage;
        $this->interBrand     = $interBrand;
        $this->interProduct   = $interProduct;
        $this->interSection   = $interSection;
        $this->interCategory  = $interCategory;
        $this->configProduct  = $configProduct;
    }


    /**
     * Date: 06/12/2019
     *
     * @param $id
     * @return View
     */
    public function edit($id)
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }
        $configProduct = $this->configProduct->setId(1);
        $image = $this->interImage->setId($id);
        $product = $image->product;

        return view("{$this->view}.modal.create", compact('configProduct', 'image', 'product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReqModel $request)
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }
        try{
            DB::beginTransaction();

        $input = $request['grids'];
        $configProduct = $this->configProduct->setId(1);
        $image = $this->interImage->setId($input['image_color_id']);
        $product = $image->product;

        $create = $this->interModel->addUnit($configProduct, $input, $image, $product, $this->view);

        if ($create) {
            DB::commit();

            return response()->json($create);
        }

        } catch(\Exception $e){
            DB::rollback();
            return $e->getMessage();
        }


    }

    /**
     * Date: 06/13/2019
     *
     * @param  int  $id
     * @return View
     */
    public function show($id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interModel->setId($id);
        $image_color_id = $data->image_color_id;
        $product = $data->product;

        return view("{$this->view}.modal.edit", compact('image_color_id', 'data', 'product'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReqModel $request, $id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        try{
            DB::beginTransaction();

            $configProduct = $this->configProduct->setId(1);
            $grid = $this->interModel->setId($id);
            $image = $grid->image;
            $product = $grid->product;
            $input = $request['grids'];

            $update = $this->interModel->updateUnit($configProduct, $input, $image, $product, $grid, $this->view);
            if ($update) {
                DB::commit();

                return response()->json($update);
            }

        } catch(\Exception $e){
            DB::rollback();
            return $e->getMessage();
        }

    }

    /**
     * Date: 06/13/2019
     *
     * @param  int  $id
     * @return json
     */
    public function destroy($id)
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }

        $configProduct = $this->configProduct->setId(1);
        $grid = $this->interModel->setId($id);
        if ($grid->stock >= 1) {
            $out = array(
                'success' => false,
                'message' => constLang('messages.stock.remove_stock')
            );
            return response()->json($out);
        }

        try{
            DB::beginTransaction();

            $image   = $grid->image;
            $product = $grid->product;
            $delete = $this->interModel->deleteUnit($configProduct, $image, $product, $grid);
            if ($delete) {
                DB::commit();

                return response()->json($delete);
            }


        } catch(\Exception $e){
            DB::rollback();
            return $e->getMessage();
        }

    }

    /**
     * Date: 06/12/2019
     *
     * @param Request $request
     * @return view
     */
    public function load(Request $request)
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }

        $input = $request->all();
        $id    = $input['id'];
        $kit   = $input['kit'];
        $opc   = $input['opc'];
        $idpro = $input['idpro'];
        $stock = $input['stock'];

        $product = $this->interProduct->setId($idpro);
        $configProduct = $this->configProduct->setId(1);

        if ($kit == 1 ? $type = 'kit' : $type = 'unit');

        if ($opc == 'category') {
            $set   = $this->interCategory->setId($id);
            $grids = $set->grids->where('type', $type);
            if (count($grids) == 0) {
                $error = constLang('messages.grids.category_false');
                return view("{$this->view}.errors",compact('error'));
            }
        } elseif ($opc == 'section') {
            $set   = $this->interSection->setId($id);
            $grids = $set->grids->where('type', $type);
            if (count($grids) == 0) {
                $error = constLang('messages.grids.section_false');
                return view("{$this->view}.errors",compact('error'));
            }
        } elseif ($opc == 'brand') {
            $set   = $this->interBrand->setId($id);
            $grids = $set->grids->where('type', $type);
            if (count($grids) == 0) {
                $error = constLang('messages.grids.brand_false');
                return view("{$this->view}.errors",compact('error'));
            }
        }

        if ($kit == 1) {
            return view("{$this->view}.form-create-kits", compact(
                    'configProduct','product', 'grids','opc','stock')
            );
        } else {
            return view("{$this->view}.form-create-units", compact(
                    'configProduct','product', 'grids','opc','stock')
            );
        }
    }

    /**
     * Date: 06/12/2019
     *
     * @param Request $request
     * @return mix
     */
    public function change(Request $request)
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }

        $input = $request->all();
        $stock = $input['stock'];
        $kit   = $input['kit'];

        ($kit == 1 ? $type = 'kit': $type = 'unit');

        if ($input['ac'] == 'create') {
            if ($input['opc'] == 'brand') {
                $brand = $this->interBrand->setId($input['id']);
                $grids = $brand->grids()->where('type', $type)->get();
            } else if ($input['opc'] == 'section') {
                $brand = $this->interSection->setId($input['id']);
                $grids = $brand->grids()->where('type', $type)->get();
            } else {
                $brand = $this->interCategory->setId($input['id']);
                $grids = $brand->grids()->where('type', $type)->get();
            }

            $this->create($kit, $stock, $grids);
        }
    }

}
