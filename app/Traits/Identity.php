<?php

namespace App\Traits;

use Str;

trait Identity
{
    /** @return string  */
    public function getIdentityAttribute()
    {
        return ucwords($this->first_name, " \t\r\n\f\v-'") . ' ' . ucwords($this->last_name, " \t\r\n\f\v-'");
    }

    /** @return string  */
    public function getInitialsAttribute()
    {
        return Str::upper($this->first_name ?? '')[0] . Str::upper($this->last_name ?? '')[0];
    }
}
