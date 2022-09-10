<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentUpdateRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'data.type' => ['required', 'in:comment'],
            'data.attributes.content' => ['required'],
            
        ];
    }

    public function messages() 
    {
        return
        [   'data.type.in' => 'The type must be : comment!!!',
            'data.attributes.content.required' => 'Content is required!!!',
           
        ];
    }
}
