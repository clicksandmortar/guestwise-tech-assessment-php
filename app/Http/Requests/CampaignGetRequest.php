<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CampaignGetRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'brand'      => 'exists:brands,id',
            'start_date' => 'date',
            'end_date'   => 'date',
            'order_by'   => 'in:desc,asc',
        ];
    }
}
