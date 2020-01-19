<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'lat',
        'long',
        'name',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function preferredLocation(): HasMany
    {
        return $this->hasMany(PreferredLocation::class);
    }
}
