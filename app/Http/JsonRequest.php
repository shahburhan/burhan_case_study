<?php

namespace App\Http;

use Illuminate\Http\Request;

class JsonRequest extends Request
{
    /**
     * Set all requests to require json response
     *
     * @return void
     */
    public function wantsJson()
    {
        return true;
    }

    /**
     * Set all requests to accept json response
     *
     * @return void
     */
    public function acceptsJson()
    {
        return true;
    }
}