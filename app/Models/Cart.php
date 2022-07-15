<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /**
     * Set the model to exclude timestamp columns for create and update
     *
     * @var boolean
     */
    public $timestamps = false;

    protected $guarded = [];

    /**
     * Return related Product
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Session || User scope
     *
     * @return void
     */
    public function scopeHavingUserOrSession($query)
    {
        if (auth()->id()) {
            return $query->where('user_id', auth()->id());
        }

        return $query->where('session_id', request()->header('SessionId'));
    }

    /**
     * Having Session Scope
     *
     * @return void
     */
    public function scopeHavingSession($query)
    {
        return $query->where('session_id', request()->header('SessionId'));
    }
}
