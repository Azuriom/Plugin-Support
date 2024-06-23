<?php

namespace Azuriom\Plugin\Support\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Illuminate\Support\Collection|\Azuriom\Plugin\Support\Models\Ticket[] $tickets
 * @property \Illuminate\Support\Collection|\Azuriom\Plugin\Support\Models\Field[] $fields
 */
class Category extends Model
{
    use HasTablePrefix;

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
        'name', 'description',
    ];

    /**
     * Get the tickets in this category.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Get the fields of this category.
     */
    public function fields()
    {
        return $this->hasMany(Field::class);
    }

    public function syncFields(array $fields): void
    {
        $ids = array_filter(Arr::pluck($fields, 'id'));

        $this->fields()->whereNotIn('id', $ids)->delete();

        foreach ($fields as $field) {
            $id = Arr::pull($field, 'id');
            $field['is_required'] = Arr::exists($field, 'is_required');

            $this->fields()->updateOrCreate(['id' => $id], $field);
        }
    }
}
