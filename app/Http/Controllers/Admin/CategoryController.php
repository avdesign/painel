<?php


namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Http\Controllers\AdminAjaxTablesController;

use AVDPainel\Interfaces\Admin\StockInterface as InterStock;
use AVDPainel\Interfaces\Admin\CategoryInterface as InterModel;
use AVDPainel\Interfaces\Admin\SectionInterface as InterSection;
use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\GridCategoryInterface as InterGrids;
use AVDPainel\Interfaces\Admin\ConfigSystemInterface as ConfigSystem;
use AVDPainel\Interfaces\Admin\ConfigProductInterface as ConfigProduct;
use AVDPainel\Interfaces\Admin\ConfigCategoryInterface as ConfigCategory;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoryController extends AdminAjaxTablesController
{
    protected $ability  = 'category';
    protected $view     = 'backend.categories';
    protected $select;
    protected $upload;
    protected $last_url;
    protected $messages;
    protected $configImages = true;


    public function __construct(
        InterAccess $access,
        InterStock $interStock,
        InterSection $sections,
        InterGrids $interGrids,
        InterModel $interModel,
        ConfigSystem $confUser,
        ConfigCategory $configModel,
        ConfigProduct $configProduct)
    {
        $this->middleware('auth:admin');

        $this->access        = $access;
        $this->confUser      = $confUser;
        $this->interModel    = $interModel;
        $this->interStock    = $interStock;
        $this->interGrids    = $interGrids;
        $this->last_url      = array('last_url'  => 'categories');
        $this->configModel   = $configModel->setId(1);
        $this->upload        = $this->configModel;
        $this->configProduct = $configProduct;
        $this->select        = array(
            'id'     => 'id',
            'name'   => 'name',
            'type'   => 'pluck',
            'edit'   => true,
            'create' => true, 
            'table'  => $sections
        );
        $this->messages = array(
            'section_id.required'   => 'A seção é obrigatória.',
            'name.required'         => 'O nome do é obrigatório.',
            'order.required'        => 'A ordem é obrigatória.',
            'title_index'           => 'Categorias dos Produtos',
            'title_create'          => 'Adicionar Categoria',
            'title_edit'            => 'Alterar o Categoria',
            'store_true'            => 'A Categoria foi registrada.',
            'store_false'           => 'Não foi possível registrar a categoria.',
            'update_true'           => 'A categoria foi alterada.',
            'update_false'          => 'Não foi possível alterar a categoria.',
            'delete_true'           => 'A categoria foi excluida.',
            'delete_false'          => 'Não foi possível excluir a categoria.'
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
        $title       = 'Perfil da Categoria';
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
