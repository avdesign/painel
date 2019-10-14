<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Interfaces\Admin\ConfigAdminInterface as InterConfig;
use AVDPainel\Interfaces\Admin\ImageAdminInterface as InterModel;
use AVDPainel\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Gate;

class ImageAdminController extends Controller
{
    protected $ability = 'model-admins';
    protected $view = 'backend.admins.images';
    protected $upload;

    public function __construct(
        InterModel $interModel,
        InterConfig $interConfig)
    {
        $this->middleware('auth:admin');

        $this->interConfig = $interConfig->setId(1);
        $this->interModel = $interModel;

        $width    = $this->interConfig->width_photo;
        $height   = $this->interConfig->height_photo;
        $path     = $this->interConfig->path.$width.'x'.$height.'/';
        $disk     = storage_path('app/public/');
        $photoUrl = 'storage/'.$path;

        $this->upload = array(
            'name' => 'image',
            'type' => 'photo',
            'disk' => $disk,
            'width' => $width,
            'height' => $height,
            'path' => $path,
            'photo_url' => $photoUrl,
            "btn" => array(
                "create" => "Adicionar",
                "edit" => "Editar",
                "status" => "Alterar Status",
                "delete" => "Excluir Imagem"
            )
        );

        $this->messages = array(
            'image.required' => 'A Foto é obrigatória.',
            'image.image' => 'O arquivo deverá conter uma imagem',
            'image.mimes' => ' dos tipos jpg,gif,png.',
            'image.unique' => 'Já existe um foto para este usuário.',
            'active.required' => 'O status é obrigatório',
            'title_index' => 'Foto do Usuário',
            'delete_success' => 'A foto foi excluida.',
            'delete_error' => 'Não foi possível excluir a foto.',
            'upload_false' => 'Não foi possível fazer upload a foto.'
        );
    }


    /**
     * Index
     * @param  int $id model
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if (Gate::denies("{$this->ability}-view")) {
            return view("backend.erros.message-401");
        }
        // Verifica se já exite uma foto
        $count = count($this->interModel->getAll(numLetter($id)));

        $upload = $this->upload;
        $title = $this->messages['title_index'];
        $data = $this->interModel->getAll(numLetter($id));

        return view("{$this->view}.index", compact('id', 'data', 'title', 'upload', 'count'));
    }

    /**
     * Form Create
     * @param  int $id model
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        if (Gate::denies("{$this->ability}-create")) {
            return view("backend.erros.message-401");
        }

        $upload = $this->upload;

        return view("{$this->view}.form-create", compact('id', 'upload'));

    }

    /**
     * Store create.
     *
     * @param  int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        if (Gate::denies("{$this->ability}-create")) {
            return view("backend.erros.message-401");
        }

        $this->interModel->rules($request, $this->messages);

        $dataForm = $request->all();

        $dataForm['admin_id'] = numLetter($id);
        $dataForm['config']   = $this->upload;

        $insert = $this->interModel->create($dataForm, $id);

        return response()->json($insert);

    }



    /**
     * Form edit
     *
     * @param  int $id
     * @param  int $mode
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $mod)
    {
        if (Gate::denies("{$this->ability}-update")) {
            return view("backend.erros.message-401");
        }

        $data = $this->interModel->setId($mod);

        $upload = $this->upload;


        return view("{$this->view}.form-edit", compact('id', 'data', 'upload'));
    }

    /**
     * Atualizar o modulo especificado.
     *
     * @param  int $id
     * @param  int $mode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $mod)
    {

        if (Gate::denies("{$this->ability}-update")) {
            return view("backend.erros.message-401");
        }

        $this->interModel->rules($request, $this->messages, $mod);

        $dataForm = $request->all();
        $dataForm['config'] = $this->upload;


        $data = $this->interModel->update($dataForm, $id, $mod);

        return response()->json($data);

    }

    /**
     * Remove
     *
     * @param  int $id
     * @param  int $mod id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $mod)
    {
        if (Gate::denies("{$this->ability}-delete")) {
            return view("backend.erros.message-401");
        }

        $delete = $this->interModel->delete($mod, $this->upload);

        if ($delete) {
            $success = true;
            $message = $this->messages['delete_success'];
        } else {
            $success = false;
            $message = $this->messages['delete_error'];
        }

        $out = array(
            'success' => $success,
            'message' => $message
        );

        return response()->json($out);
    }


    public function status(Request $request, $id)
    {
        if (Gate::denies("{$this->ability}-update")) {
            return view("backend.erros.message-401");
        }

        $dataForm = $request->all();
        $status = $this->interModel->status($id);

        return response()->json($status);
    }


    public function photoDeleteExcluded(Request $request, $id)
    {

        $delete = $this->interModel->deleteExcluded($id, $request['admin'], $this->upload);

        if ($delete) {
            $success = true;
            $message = $this->messages['delete_success'];
        } else {
            $success = false;
            $message = $this->messages['delete_error'];
        }

        $out = array(
            'success' => $success,
            'message' => $message
        );

        return response()->json($out);
    }

}
