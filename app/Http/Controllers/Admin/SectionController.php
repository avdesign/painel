<?php


namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Http\Controllers\AdminAjaxTablesController;

use AVDPainel\Interfaces\Admin\StockInterface as InterStock;
use AVDPainel\Interfaces\Admin\SectionInterface as InterModel;
use AVDPainel\Interfaces\Admin\GridSectionInterface as InterGrids;
use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\ConfigSystemInterface as ConfigSystem;
use AVDPainel\Interfaces\Admin\ConfigSectionInterface as ConfigSection;
use AVDPainel\Interfaces\Admin\ConfigProductInterface as ConfigProduct;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SectionController extends AdminAjaxTablesController
{
    protected $ability  = 'section';
    protected $view     = 'backend.sections';
    protected $select;
    protected $upload;
    protected $last_url;
    protected $messages;
    protected $configImages = true;


    public function __construct(
        InterAccess $access,
        InterStock $interStock,
        InterGrids $interGrids,
        InterModel $interModel,
        ConfigSystem $confUser,
        ConfigSection $configModel,
        ConfigProduct $configProduct)
    {
        $this->middleware('auth:admin');

        $this->access        = $access;
        $this->confUser      = $confUser;
        $this->interModel    = $interModel;
        $this->interStock    = $interStock;
        $this->interGrids    = $interGrids;
        $this->last_url      = array('last_url'  => 'sections');
        $this->configModel   = $configModel->setId(1);
        $this->upload        = $this->configModel;
        $this->configProduct = $configProduct;
        $this->messages      = array(
            'name.required'  => 'O nome do é obrigatório.',
            'name.unique'    => 'Este nome já se encontra utilizado.',
            'order.required' => 'A ordem é obrigatória.',
            'title_index'    => 'Seções dos Produtos',
            'title_create'   => 'Adicionar Seção',
            'title_edit'     => 'Alterar o Seção',
            'store_true'     => 'A Seção foi registrada.',
            'store_false'    => 'Não foi possível registrar a seção.',
            'update_true'    => 'A seção foi alterada.',
            'update_false'   => 'Não foi possível alterar a seção.',
            'delete_true'    => 'A seção foi excluida.',
            'delete_false'   => 'Não foi possível excluir a seção.'
        );
    }

    /**
     * Table getAll()
     *
     * @param  array  $request
     * @return json
     */
    public function data(Request $request)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interModel->getAll($request);

        return response()->json($data);     
    }


    /**
     * Detals
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function details($id)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $data        = $this->interModel->setId($id);
        $title       = 'Perfil da Seção';
        $configModel = $this->configModel;

        return view("{$this->view}.details", compact('data', 'title', 'configModel'));    
    }


    /**
     * Remover o modulo especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if( Gate::denies("{$this->ability}-delete") ) {
            return view("backend.erros.message-401");
        }
        $configProduct = $this->configProduct->setId(1);
        $data = $this->interModel->setId($id);
        $products = $data->products;
        foreach ($products as $product) {
            $existStock = $this->interStock->existStock($configProduct, $product);
            if ($existStock) {
                return $existStock;
            }
        }
        $delete = $this->interModel->delete($data, $products, $this->upload, $this->configImages);
        if ($delete) {
            $success = true;
            $message = $this->messages['delete_true'];
            $deleted = $delete;
        } else {
            $success = false;
            $message = $this->messages['delete_false'];
            $deleted = false;
        }
        $out = array(
            "success" => $success,
            "message" => $message,
            "deleted" => $deleted
        );

        return response()->json($out);
    }

}
