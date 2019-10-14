<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Interfaces\Admin\ConfigBannerInterface as InterConfig;
use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\ImageBannerInterface as InterModel;
use AVDPainel\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ImageBannerController extends Controller
{
    protected $ability = 'images-site';
    protected $view    = 'backend.banners.images';
    protected $upload;

    public function __construct(
        InterAccess $access,
        InterModel $interModel,
        InterConfig $interConfig)
    {

        $this->middleware('auth:admin');

        $this->interConfig   = $interConfig->setId(1);
        $this->interModel    = $interModel;
        $this->access        = $access;
        $this->last_url      = array("last_url" => "images/four/banner");
        $width        = $this->interConfig->width;
        $height       = $this->interConfig->height;
        $path         = $this->interConfig->path.$width.'x'.$height.'/';
        $disk         = storage_path('app/public/');
        $photoUrl     = 'storage/'.$path;

        $this->upload  = array(
            'name' => 'image',
            'width' => $width,
            'height' => $height,
            'path' => $path,
            'disk' => $disk,
            'photo_url' => $photoUrl,
            "btn"   => array(
                "create" => "Adicionar",
                "edit"   => "Editar",
                "status" => "Alterar Status",
                "order"  => "Ordem",
                "delete" => "Excluir Imagem"
            )
        );

        $this->messages = array(
            'status.required'       => 'O status é obrigatório',
            'order.required'        => 'A ordem é obrigatória.',
            'order.numeric'         => 'A ordem tem que ser numérica.',
            'image.image'           => 'O arquivo deverá conter uma imagem',
            'image.mimes'           => ' dos tipos jpg,gif,png.',
            'title_index'           => 'Imagem Banner',
            'delete_error'          => 'Não foi possível excluir a imagem.',
            'error'                 => 'Houve um erro no servidor.',
            'photo_create_true'     => 'A foto foi salva com sucesso.',
            'photo_create_false'    => 'Não foi possível salvar a foto.',
            'photo_delete_min'      => 'Não foi possível excluir, o mínimo de fotos é ',
            'photo_delete_true'     => 'A imagem foi excluida.',
            'photo_delete_false'    => 'Não foi possível excluir a imagem.',
            'photo_upload_true'     => 'A imagem foi alterada.',
            'photo_upload_false'    => 'Não foi possível alterar a imagem.',
            'status_true'           => 'O status foi alterado',
            'status_false'          => 'Não foi possível alterar o status',
            'order_true'            => 'A ordem foi alterada',
            'order_false'           => 'Não foi possível alterar a ordem'
        );

    }


    /**
     * Index
     * @param  int  $id  model
     * @return \Illuminate\Http\Response
     */
    public function index($type)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $upload = $this->upload;
        $title  = $this->messages['title_index'];
        $data   = $this->interModel->getAll($type);

        return view("{$this->view}", compact('type', 'data', 'title', 'upload'));
    }

    /**
     * Form Create
     * @param  int  $id  model
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }
        $upload  = $this->upload;

        return view("{$this->view}-form-create", compact('type', 'upload'));

    }

    /**
     * Salvar a imagem
     *
     * @param Request $request
     * @param $type
     * @return View
     */
    public function store(Request $request, $type)
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }

        $this->interModel->rules($request, $this->messages);

        $dataForm = $request->all();
        $dataForm['config'] = $this->upload;

        $insert = $this->interModel->create($dataForm, $type, $this->messages);

        return response()->json($insert);

    }

    /**
     * Form
     *
     * @param $type
     * @param $id
     * @return View
     */
    public function edit($id, $type)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $data    = $this->interModel->setId($id);
        $upload  = $this->upload;

        return view("{$this->view}-form-edit", compact(
                'type','id', 'data', 'upload')
        );
    }

    /**
     * Atualizar o modulo especificado.
     *
     * @param  int  $id
     * @param  int  $mode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $type)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $this->interModel->rules($request, $this->messages, $id);

        $dataForm = $request->all();

        if ( $this->upload && $request->hasFile($this->upload['name']) ) {

            $dataForm['config'] = $this->upload;
        }


        $data = $this->interModel->update($dataForm, $id, $this->messages);

        return response()->json($data);

    }

    /**
     * Remove
     *
     * @param  int  $id
     * @param  int  $mod  id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $type)
    {
        if( Gate::denies("{$this->ability}-delete") ) {
            return view("backend.erros.message-401");
        }

        $delete = $this->interModel->delete($id, $type, $this->messages, $this->upload);

        return response()->json($delete);
    }


    /**
     * Alterar o status
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

        $status = $this->interModel->status($id, $this->messages);

        return response()->json($status);
    }

    /**
     * Retora o input order referente ao banner
     *
     * @param $id
     * @return View
     */
    public function order($id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $order = $this->interModel->getOrder($id);
        return view("{$this->view}-order", compact('order', 'id'));
    }


    public function updateOrder(Request $request)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }
        $dataForm = $request->all();
        return $this->interModel->updateOrder($dataForm, $this->messages);
    }

}