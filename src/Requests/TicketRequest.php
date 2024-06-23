<?php

namespace Azuriom\Plugin\Support\Requests;

use Azuriom\Plugin\Support\Models\Field;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property \Azuriom\Plugin\Support\Models\Ticket|null $ticket
 * @property \Azuriom\Plugin\Support\Models\Category $category
 */
class TicketRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if ($this->ticket !== null || $this->category->fields->isEmpty()) {
            return;
        }

        // Build the content from the field fields
        $content = $this->category->fields
            ->filter(fn (Field $field) => $this->filled($field->inputName()))
            ->flatMap(fn (Field $field) => [
                '## '.$field->name, '', $this->input($field->inputName()),
            ])
            ->join("\n");

        $this->merge(['content' => $content]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $newTicket = $this->ticket === null;
        $fieldRules = $this->category->fields->mapWithKeys(fn (Field $field) => [
            $field->inputName() => $field->getValidationRule(),
        ]);

        return array_merge([
            'subject' => ['required', 'string', 'max:100'],
            'content' => [Rule::requiredIf($newTicket), 'nullable', 'string'],
        ], $newTicket ? $fieldRules->all() : []);
    }
}
