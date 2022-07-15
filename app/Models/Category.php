<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * Set the model to exclude timestamp columns for create and update
     *
     * @var boolean
     */
    public $timestamps = false;

    protected $fillable = ['name'];
}
