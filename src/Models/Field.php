<?php

namespace Azuriom\Plugin\Support\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string|null $description
 * @property string $type
 * @property bool $is_required
 * @property array|null $options
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Azuriom\Plugin\Support\Models\Category $category
 */
class Field extends Model
{
    use HasTablePrefix;

    public const TYPES = ['text', 'number', 'email', 'textarea', 'checkbox', 'dropdown'];

    /**
     * The table prefix associated with the model.
     */
    protected string $prefix = 'support_';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'description', 'type', 'is_required', 'options',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_required' => 'boolean',
        'options' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function inputName(): string
    {
        return Str::snake($this->name);
    }

    public function getValidationRule(): array
    {
        $rules = match ($this->type) {
            'text' => ['string', 'max:100'],
            'number' => ['numeric'],
            'email' => ['email', 'max:100'],
            'dropdown' => ['string', Rule::in($this->options ?? [])],
            default => [],
        };

        return array_merge([
            $this->is_required ? 'required' : 'nullable',
        ], $rules);
    }
}
