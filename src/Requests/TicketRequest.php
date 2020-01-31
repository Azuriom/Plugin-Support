<?php

namespace Azuriom\Plugin\Support\Requests;

use Azuriom\Plugin\Support\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TicketRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'subject' => ['required', 'string', 'max:100'],
            'content' => [Rule::requiredIf(! $this->ticket), 'nullable', 'string'],
            'category_id' => ['required', Rule::exists(Category::class, 'id')],
        ];
    }
}
