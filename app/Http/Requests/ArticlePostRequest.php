<?php

namespace App\Http\Requests;



use Illuminate\Foundation\Http\FormRequest;

class ArticlePostRequest extends FormRequest
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
            'data.type' => ['required', 'in:article'],
            'data.attributes.title' => ['required'],
            'data.attributes.content' => ['required'],
            'data.attributes.category' => ['nullable', 'in:General,World,Nature'],
            
        ];
    }

    public function messages() 
    {
        return
        [   'data.type.in' => 'The type must be : article!!!',
            'data.attributes.title.required' => 'Title is required!!!',
            'data.attributes.content.required' => 'Content is required!!!',
            'data.attributes.category.in' => 'The category must be one of the following types: General,World,Nature!!',
           
        ];
    }

   
    
}
