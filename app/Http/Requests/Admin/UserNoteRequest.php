<?php

namespace AVDPainel\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserNoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        $notes = $this->get('notes');

        if ($this->method() == 'POST') {
            $rules['notes.label']        = "required";
        }

        $rules['notes.label']        = "required";
        $rules['notes.description']  = "required";

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'notes.label.required'        => 'A observação é obrigatória.',
            'notes.description.required'  => 'A descrição é obrigatória.',
        ];


        return $messages;
    }
}
