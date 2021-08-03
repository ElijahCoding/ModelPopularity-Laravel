<?php

namespace App\Visitable;

use App\Models\Visit;

trait Visitable
{
    public function visit()
    {
        return new PendingVisit($this);
    }

    public function visits()
    {
        return $this->morphMany(Visit::class, 'visitable');
    }
}
