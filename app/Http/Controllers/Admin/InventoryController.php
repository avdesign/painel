<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Interfaces\Admin\AdminInterface as InterAdmin;
use AVDPainel\Interfaces\Admin\UserInterface as InterUser;
use AVDPainel\Interfaces\Admin\InventoryInterface as InterModel;
use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\ConfigSystemInterface as ConfigSystem;


use AVDPainel\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class InventoryController extends Controller
{
    protected $ability  = 'inventory';
    protected $view     = 'backend.reports.inventory';

    public function __construct(
        InterUser $interUser,
        InterAdmin $interAdmin,
        InterAccess $access,
        InterModel $interModel,
        ConfigSystem $confUser)
    {

        $this->middleware('auth:admin');

        $this->access     = $access;
        $this->confUser   = $confUser;
        $this->interUser  = $interUser;
        $this->interModel = $interModel;
        $this->interAdmin = $interAdmin;

        $this->last_url   = array('last_url' => 'inventory');
    }

     /**
     * Date: 06/17/2019
     *
     * @return View
     */
    public function index()
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.errors.message-401");
        }

        $this->access->update($this->last_url);
        $confUser = $this->confUser->get();

        return view("$this->view.index", compact('confUser'));
    }


    /**
     * Date: 06/17/2019
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

    public function details($id)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interModel->setId($id);

        return view("{$this->view}.details", compact('data'));
    }

    public function admin($id)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interAdmin->setId(numLetter($id));

        return view("{$this->view}.modal.admin", compact('data'));
    }

    public function user($id)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interUser->setId($id);

        return view("{$this->view}.modal.user", compact('data'));
    }

}
