<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
        'status',
        'task_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'number' => 'integer',
        'task_id' => 'integer',
        'total' => 'integer',
    ];

    public function getTotalAttribute($value)
    {
        return "$".$value / 100;
    }

    public function setTotalAttribute($value)
    {
        $this->attributes['total'] = preg_replace("/[^0-9]/", "", $value);
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function lineItems(): HasMany
    {
        return $this->hasMany(LineItem::class);
    }
}
