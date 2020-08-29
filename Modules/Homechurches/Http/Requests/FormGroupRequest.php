<?php

namespace Modules\Homechurches\Http\Requests;

use Modules\Core\Http\Requests\AbstractFormRequest;

class FormGroupRequest extends AbstractFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'type' => 'required',
            'church_id' => 'required',
        ];
    }


}
