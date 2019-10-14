<?php

namespace AVDPainel\Repositories\Admin;

use AVDPainel\Models\Admin\GroupColor as Model;
use AVDPainel\Interfaces\Admin\GroupColorInterface;
use Illuminate\Support\Arr;

class GroupColorRepository implements GroupColorInterface
{

    public $model;

    /**
     * Create construct.
     *
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->model    = $model;
    }

    /**
     * Init Model
     *
     * @param  string  $field
     * @param  int  $id
     * @return array
     */
    public function get($field, $id)
    {
        $data  = $this->model->where($field, $id)->get();
        return $data;    
    }

    /**
     * Date: 06/07/2019
     *
     * @param  array $input
     * @param  int $idpro
     * @param  int $id
     * @return boolean true or false
     */
    public function create($input, $idpro, $idimg)
    {
        $i=0;
        $_label='';
        foreach ($input as $key => $value) {
            $exePinker = explode("#", $key);
            $exeLabel = explode(":", $value);
            $grs[$i]['config_color_group_id'] = (int) $exeLabel[0];
            $grs[$i]['product_id'] =  $idpro;
            $grs[$i]['image_color_id'] = $idimg;
            $grs[$i]['pinker'] = $exePinker[1];
            $grs[$i]['label'] = $exeLabel[1];
            $_label .= "{$grs[$i]['label']},";
            $data = $this->model->create($grs[$i]);
            $i++;
        }

        $label = substr($_label, 0, -1);
        generateAccessesTxt(date('H:i:s').utf8_decode(
                ' '.constLang('created').
                ' '.constLang('group').
                ' '.constLang('colors').':'.$label)
        );
    }


    /**
     * Update
     *
     * @param  array $input
     * @param  int $idpro
     * @param  int $id
     * @return boolean true or false
     */
    public function update($input, $idpro, $image)
    {
        $colors = $image->groups;
        $groups = collect($colors)->where('image_color_id', $image->id)->toArray();
        $count_groups = collect($groups)->where('image_color_id', $image->id)->count();
        $count_inputs = collect($input)->count();
        $i=0;
        $_label='';
        foreach ($input as $key => $value) {
            $exePinker = explode("#", $key);
            $exeLabel = explode(":", $value);
            $inputs[$i]['config_color_group_id'] = (int) $exeLabel[0];
            $inputs[$i]['product_id'] =  $idpro;
            $inputs[$i]['image_color_id'] = $image->id;
            $inputs[$i]['pinker'] = $exePinker[1];
            $inputs[$i]['label'] = $exeLabel[1];
            $_label .= "{$inputs[$i]['label']},";

            $i++;
        }

        $label = substr($_label, 0, -1);

        if ($count_groups != $count_inputs) {

            $delete = $this->model->where('image_color_id', $image->id)->delete();
            if ($delete) {
                foreach ($inputs as $value) {
                    $dataForm = [
                        "config_color_group_id" => $value['config_color_group_id'],
                        "product_id" => $idpro,
                        "image_color_id" => $image->id,
                        "pinker" => $value['pinker'],
                        "label" => $value['label']
                    ];
                    $upd = $this->model->create($dataForm);
                }
                generateAccessesTxt(date('H:i:s').utf8_decode(
                        ' '.constLang('updated').
                        ' '.constLang('group').
                        ' '.constLang('colors').':'.$label)
                );
            }

        } else {
            if ($count_inputs == 1) {
                $id = $colors[0]->id;
                unset($groups[0]['id']);
                $result = ary_diff($inputs, $groups);
                if (!empty($result)) {
                    $dataForm = $result[0];
                    $group = $this->model->find($id);
                    $upd = $group->update($dataForm);
                    if ($upd) {
                        generateAccessesTxt(date('H:i:s').utf8_decode(
                                ' '.constLang('updated').
                                ' '.constLang('group').
                                ' '.constLang('colors').':'.$label)
                        );
                    } else {
                        return false;
                    }
                }
            } else {
                foreach ($colors as $key => $color) {
                    if ($inputs[$key]['pinker'] != $color->pinker) {
                        $group = $this->model->find($color->id);
                        $dataForm = [
                            'config_color_group_id' => $inputs[$key]['config_color_group_id'],
                            'pinker' => $inputs[$key]['pinker'],
                            'label' => $inputs[$key]['label']
                        ];
                        $upd = $group->update($dataForm);
                        if ($upd) {
                            generateAccessesTxt(date('H:i:s').utf8_decode(
                                    ' '.constLang('updated').
                                    ' '.constLang('group').
                                    ' '.constLang('colors').':'.$label)
                            );
                        }
                    }
                }

            }

        }

    }

}