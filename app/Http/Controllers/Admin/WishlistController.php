<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Http\Controllers\AdminAjaxTablesController;

use AVDPainel\Interfaces\Admin\WishlistInterface as InterModel;
use AVDPainel\Interfaces\Admin\AdminInterface as InterAdmin;
use AVDPainel\Interfaces\Admin\UserInterface as InterUser;
use AVDPainel\Interfaces\Admin\ImageColorInterface as InterProduct;
use AVDPainel\Interfaces\Admin\GridProductInterface as InterGrid;
use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\ConfigSystemInterface as ConfigSystem;
use AVDPainel\Interfaces\Admin\ConfigProductInterface as ConfigProduct;
use AVDPainel\Interfaces\Admin\ConfigColorPositionInterface as ConfigImages;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class WishlistController extends AdminAjaxTablesController
{
    protected $ability  = 'wishlist';
    protected $view     = 'backend.wishlists';
    protected $select;
    protected $upload;
    protected $last_url;
    protected $messages;

    public function __construct(
        InterAccess $access,
        InterUser $interUser,
        InterGrid $interGrid,
        InterAdmin $interAdmin,
        InterModel $interModel,
        ConfigSystem $confUser,
        InterProduct $interProduct,
        ConfigImages $configImages,
        ConfigProduct $configProduct)
    {
        $this->middleware('auth:admin');

        $this->access       = $access;
        $this->confUser     = $confUser;
        $this->interUser    = $interUser;
        $this->interGrid    = $interGrid;
        $this->interAdmin   = $interAdmin;
        $this->interModel   = $interModel;
        $this->interProduct = $interProduct;
        $this->configProduct = $configProduct;
        $this->configImages = $configImages;
        $this->last_url     = array('last_url' => 'wishlist');
        $this->messages = array(
            'quantity.required' => 'A quantidade é obrigatória.',
            'title_index'       => 'Lista de Desejos',
            'title_create'      => 'Adicionar Lista de Desejos',
            'title_edit'        => 'Alterar o Lista de Desejos',
            'store_true'        => 'O produto foi adicionado.',
            'store_false'       => 'Não foi possível adicionar o produto.',
            'update_true'       => 'A quantidade foi alterada.',
            'update_false'      => 'Não foi possível alterar a quantidade.',
            'delete_true'       => 'O produto foi excluido.',
            'delete_false'      => 'Não foi possível excluir produto.'
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
    protected function profile($id)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interUser->setId($id);


       return view("{$this->view}.profile", compact('data'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function lists($id)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $data  = $this->interModel->getWishlist($id);
        $user  = $this->interUser->setId($id);
        $image = $this->configImages->setName('default','T');


        return view("{$this->view}.lists", compact('data', 'user', 'image'));
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function reload($id)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $data  = $this->interModel->getWishlist($id);
        $user  = $this->interUser->setId($id);
        $image = $this->configImages->setName('default','T');


        return view("{$this->view}.reload", compact('data', 'user', 'image'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function products($user_id)
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }
        $image = $this->configImages->setName('default','T');
        return view("{$this->view}.products", compact('image','user_id'));
    }

    /**
     * @param Request $request
     * @param $user_id
     * @return Json
     */
    public function search(Request $request, $user_id)
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interProduct->search($request, $user_id, 'wishlist.add');

        return response()->json($data);
    }

    /**
     * @param Request $request
     * @param $id
     * @return json
     */
    protected function add(Request $request, $id, $user_id)
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }

        $grids = array_filter($request['grid']);


        if (count($grids) >= 1) {

            foreach ($grids as $key => $value) {
                $size = $this->interGrid->setId($key);
                $input[] = [
                    'grid_product_id' => $key,
                    'grid' => $size->grid,
                    'quantity' => $value,
                    'ip' => $request->ip()
                ];
            }

            $user          = $this->interUser->setId($user_id);
            $color         = $this->interProduct->setId($id);
            $configProduct = $this->configProduct->setId(1);

            $data  =  $this->interModel->create($input, $user, $color, $configProduct);

            return response()->json($data);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'A Grade e quantidade são obrigatóios.'
            ]);
        }
    }

    /**
     * @param $user_id
     * @return view
     */
    protected  function editAdmin($user_id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $user  = $this->interUser->setId($user_id);

        $data  = $this->interAdmin->get();

        $i=0;
        foreach ($data as $val) {
            if ($val->profile != 'Master') {
                $admins[$i]['name']     = $val->name;
                $admins[$i]['profile']  = $val->profile;
                $admins[$i]['status']   = $val->status;
                $admins[$i]['count']    = $this->interUser->countAdmin($val->name);

                ($val->name == $user->admin ? $admins[$i]['checked'] = ' checked' : $admins[$i]['checked'] = '');
                ($val->status == "Ativo" ? $admins[$i]['icon'] = 'icon-blue' : $admins[$i]['icon'] = 'icon-red');
            }
            $i++;
        }

        asort($admins);

        return view("{$this->view}.edit-admin", compact('admins', 'user_id'));
    }

    protected function storeAdmin(Request $request, $user_id)
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }

        $validator = Validator::make($request->all(), [
            'admin' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'O Atendente é obrigatório'
            ]);
        }


        $dataForm['admin'] = $request['admin'];

        $data = $this->interUser->updateAdmin($dataForm, $user_id);
        if ($data) {
            $success = true;
            $message = 'O Atendente foi registrado';
        } else {
            $success = false;
            $message = 'Não foi possível registrar o atendente.';
        }

        $out = array(
            'success' => $success,
            'message' => $message
        );

        return response()->json($out);

    }

    /**
     * @param $user_id
     * @return json
     */
    protected function deleteAll($user_id)
    {
        if( Gate::denies("{$this->ability}-delete") ) {
            return view("backend.erros.message-401");
        }

        $data  =  $this->interModel->deleteAll($user_id);
        if ($data) {
            $success = true;
            $message = 'A Lista foi excluida';
        } else {
            $success = false;
            $message = 'Não foi possível exclir esta Lista.';
        }

        $out = array(
            'success' => $success,
            'message' => $message
        );

        return response()->json($out);

    }


    protected function saveWishlist($user_id)
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }

        $items  =  $this->interModel->getWishlist($user_id);
        if (count($items) > 0){
            foreach ($items as $item) {

            }
            $success = true;
            $message = 'A Lista foi Salva';

        } else {
            $success = false;
            $message = 'Esta lista está vazia!';

        }

        $out = array(
            'success' => $success,
            'message' => $message
        );

        return response()->json($out);

    }










}
