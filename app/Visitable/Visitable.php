<?php

namespace App\Visitable;

use App\Models\Visit;

trait Visitable
{
    public function visits()
    {
        return $this->morphMany(Visit::class, 'visitable');
    }
}
