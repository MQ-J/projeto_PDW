<?php

namespace App\Http\Requests;

class BlockRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "text" => "required"
        ];
    }
}
