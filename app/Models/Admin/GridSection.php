<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class GridSection extends Model
{

    protected $fillable = [
        'section_id',
        'type',
        'name',
        'label'
    ];

    /**
     * @return array
     **/
    public function rules($id = '')
    {
        return [
            "type" => "required",
            "name"  => "required",
            "label" => "required"
        ];
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
