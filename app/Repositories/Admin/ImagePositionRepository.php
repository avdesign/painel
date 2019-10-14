<?php

namespace AVDPainel\Repositories\Admin;

use AVDPainel\Interfaces\Admin\ConfigKeywordInterface as Keywords;

use AVDPainel\Models\Admin\ImagePosition as Model;
use AVDPainel\Interfaces\Admin\ImagePositionInterface;
use Intervention\Image\Facades\Image;


class ImagePositionRepository implements ImagePositionInterface
{

    public $model;
    public $keywords;
    private $photoUrl;
    private $disk;


    /**
     * Create construct.
     *
     * @return void
     */
    public function __construct(Model $model, Keywords $keywords)
    {
        $this->model    = $model;
        $this->keywords = $keywords;
        $this->photoUrl = 'storage/';
        $this->disk     = storage_path('app/public/');

    }

    /**
     * Init Model
     *
     * @return array
     */
    public function get($id)
    {
        $data  = $this->model->where('image_color_id', $id)->get();
        return $data;    
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return array
     */
    public function setId($id)
    {
        return $this->model->find($id);
    }

    /**
     * Create
     *
     * @param  array $input
     * @param  array $config
     * @param  file $file
     * @return array
     */
    public function create($input, $config, $file, $wiew, $action)
    {
        $count = strlen($input['order']);
        if ($count == 1) {
            $dataForm['order'] = '0'.$input['order'];
        }
        $dataForm['image_color_id'] = $input['image_color_id'];
        $dataForm['active'] = $input['active'];
        $name = substr($input['name'], 0, -4);
        $upload = $this->uploadImagem($config, $file, $name, $action);
        $dataForm['image'] = $upload;
        if ($upload) {
            $input['image'] = $name;
            $image = $this->model->create($dataForm);
            if ($image) {
                generateAccessesTxt(date('H:i:s').utf8_decode(
                    ', '.constLang('upload_true.position').' '.$upload.
                    ', '.constLang('status').':'.$image->active.
                    ', '.constLang('order').':'.$image->order)
                );
                $success  = true;
                $message  = constLang('upload_true.image');
                $color_id = $image->image_color_id;

                foreach ($config as $value) {
                    if ($value->default == 'T') {
                        $path = $this->photoUrl.$value->path;
                    }
                }
                $html = view("{$wiew}.gallery-render", compact('path','image', 'action'))->render();
            } else {
                $success  = false;
                $message  = constLang('upload_false.image');
                $color_id = null;
                $html     = null;
            }
        } else {
            $success  = false;
            $message  = constLang('error.server');
            $color_id = null;
            $html     = null;
        }
        $out = array(
            'success' => $success,
            'message' => $message,
            'ac' => $action,
            'html' => $html,
            'color_id' => $color_id
        );
        return $out;
    }

    /**
     * Date 06/05/2019
     *
     * @param $input
     * @param $image
     * @param $config
     * @param $file
     * @param $action
     * @return mixed
     */
    public function update($input, $image, $config, $file, $wiew, $action)
    {
        $change  = null;
        $message = constLang('update_true');
        $corrent_name = substr($image->image, 0, -4);
        if (!empty($file)) {
            $upload = $this->uploadImagem($config, $file, $corrent_name, $action);
            if ($upload) {

                $dataForm['image'] = $upload;
                $change  = ' '.constLang('upload_true.position').' '.$upload;
                $success = true;
                $message = constLang('upload_true.image');

            } else {
                $success = true;
                $message = constLang('upload_false');
            }
        } else {
            $success = true;
        }
        if ($input['active'] != $image->active) {
            $dataForm['active'] = $input['active'];
            $change .= ', '.constLang('status').':'.$input['active'];
        }
        $count = strlen($input['order']);
        if ($count == 1) {
            $order = '0'.$input['order'];
            if ($order != $image->order) {
                $dataForm['order'] = $order;
                $change .= ', '.constLang('order').':'.$order;
            }
        }
        if ($change) {
            $update = $image->update($dataForm);
            if ($update) {
                $success = true;
                if (!empty($file)) {
                    generateAccessesTxt(date('H:i:s').utf8_decode($change));
                } else {
                    generateAccessesTxt(date('H:i:s').utf8_decode(
                        ' '.constLang('updated').
                        ' '.constLang('image').
                        ' '.constLang('position').$change)
                    );
                }

            } else {
                $success = false;
                $message = constLang('upload_false');
            }
        }
        foreach ($config as $value) {
            if ($value->default == 'T') {
                $path = $this->photoUrl.$value->path;
            }
        }
        $html = view("{$wiew}.gallery-render", compact('path','image', 'action'))->render();
        $out = array(
            'success' => $success,
            'message' => $message,
            'ac'      => $action,
            'id'      => $image->id,
            'html'    => $html
        );
        return $out;
    }

    /**
     * Remove
     *
     * @param  int $id
     * @return boolean true or false
     */
    public function delete($id, $config)
    {
        $data  = $this->model->find($id);
        foreach ($config as $value) {
            if ($value->type == 'P') {
                $image = $this->disk.$value->path.$data->image;

                if (file_exists($image)) {
                    $remove = unlink($image);
                } else {
                    return array(
                        'success' => false,
                        'message' => constLang('images.deleted_false')
                    );
                }
            }
        }
        $delete = $data->delete();
        if ($delete) {
            generateAccessesTxt(date('H:i:s').utf8_decode(
                ' '.constLang('deleted').
                ' '.constLang('image').
                ' '.constLang('position').
                ' '.$data->image)
            );

            $success = true;
            $message = constLang('images.deleted_true');
        } else {
            $success = false;
            $message = constLang('error.server');
        }

        $out = array(
            'success' => $success,
            'message' => $message
        );

        return $out;

    }


    /**
     * Status
     *
     * @param  array $input
     * @param  int $id 
     * @return json
     */
    public function status($config, $input, $wiew, $id)
    {
        $html   = null;
        $action = 'status';
        if ($input['active'] == constLang('active_true')) {
            $dataForm['active'] = constLang('active_false');
        } else {
            $dataForm['active'] = constLang('active_true');
        }
        $image  = $this->model->find($id);
        $update = $image->update($dataForm);
        if ($update) {
            $success = true;
            $message = constLang('status_true');
            foreach ($config as $value) {
                if ($value->default == 'T') {
                    $path = $this->photoUrl.$value->path;
                }
            }
            $html = view("{$wiew}.gallery-render", compact('path','image', 'action'))->render();

            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                    ' '.constLang('updated').
                    ' '.constLang('status').
                    ' '.constLang('image').
                    ' '.constLang('position').
                    ':'.$image->active)
            );

        } else {
            $success = false;
            $message = constLang('status_false');
        }

        $out = array(
            "success"    => $success,
            "message"    => $message,
            "html"      => $html
        );

        return $out;
    }


    /**
     * Date: 06/04/2019
     *
     * @param $config
     * @param $file
     * @param $name
     * @return string
     */
    public function uploadImagem($config, $file, $name, $action){

        if ($action == 'upload') {
            foreach ($config as $value) {
                $image = $this->disk.$value->path.$name;
                if (file_exists($image)) {
                    $delete = unlink($image);
                }
            }
        }

        $ext   = $file->getClientOriginalExtension();
        $image = $name.numLetter(date('Ymdhs'),'letter').'.'.$ext;
        foreach ($config as $value) {
            if ($value->type == 'P') {
                $width    = $value->width;
                $height   = $value->height;
                $path     = $this->disk . $value->path;
                $upload = Image::make($file)->resize($width, $height)->save($path.$image);
            }
        }

        if ($upload) {
            return $image;
        }

    }

}