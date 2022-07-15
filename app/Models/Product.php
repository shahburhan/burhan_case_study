<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * Set the model to exclude timestamp columns for create and update
     *
     * @var boolean
     */
    public $timestamps = false;
}
