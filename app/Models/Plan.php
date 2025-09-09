<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'employee_limit',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    /**
     * Get the companies for the plan
     */
    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }

    /**
     * Get the payments for the plan
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
