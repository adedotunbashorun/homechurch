<?php

namespace Modules\Manuals\Http\Requests;

use Modules\Core\Http\Requests\AbstractFormRequest;

class FormUpdateRequest extends AbstractFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:5',
            'body' => 'required|min:5',
            // 'document' => 'required|mimes:doc,docx,jpg,jpeg,pdf,png,txt|max:2048'
        ];
    }


}
