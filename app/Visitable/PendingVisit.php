<?php

namespace App\Visitable;

use Illuminate\Database\Eloquent\Model;

class PendingVisit
{
    protected $attributes = [];

    public function __construct(protected Model $model) {}

    public function withIp()
    {
        $this->attributes['ip'] = 'test';
    }

    public function __destruct()
    {
        dd('abc');
    }
}
