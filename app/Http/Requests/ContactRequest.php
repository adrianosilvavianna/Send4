<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactRequest extends FormRequest
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
    public function rules()
    {
        switch ($this->method()){
            case 'POST':
                return [
                    'name'      => ['required','string','max:100'],
                    'last_name' => ['required','string','max:100'],
                    'email'     => ['required', 'email', 'string', 'max:100','unique:contacts,email'],
                    'phone'     => ['required', 'string', 'max:14', 'unique:contacts,phone']
                ];

            case 'PUT' :
                return [
                    'name'      => ['required','string','max:100'],
                    'last_name' => ['required','string','max:100'],
                    'email'     => ['required', 'email', 'string', 'max:100',
                        Rule::unique('contacts')
                            ->ignore($this->route('contact'))
                            ->where(function ($query) {
                                return $query->whereNull('deleted_at');
                            })
                    ],
                    'phone'     => ['required', 'string', 'max:14',
                        Rule::unique('contacts')
                            ->ignore($this->route('contact'))
                            ->where(function ($query) {
                                return $query->whereNull('deleted_at');
                            })
                    ]
                ];
        }
    }
}
