<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Part extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
        'name',
        'price',
        'received',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'price' => 'integer',
        'received' => 'boolean',
    ];

    public function getPriceAttribute($value)
    {
        return "$".$value / 100;
    }

    public function getReceivedAttribute($value)
    {
        return $value ? 'Yes' : 'No';
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = preg_replace("/[^0-9]/", "", $value);
    }

    public function setReceivedAttribute($value)
    {
        $this->attributes['received'] = $value == 'Yes' ? 1 : 0;
    }

    public function lineItems(): BelongsToMany
    {
        return $this->belongsToMany(LineItem::class);
    }
}
