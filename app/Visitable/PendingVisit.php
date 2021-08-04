<?php

namespace App\Visitable;

use Illuminate\Database\Eloquent\Model;

class PendingVisit
{
    protected $attributes = [];

    public function __construct(protected Model $model) {}

    public function withIp($ip = null)
    {
        $this->attributes['ip'] = $ip ?? request()->ip();
    }

    public function __destruct()
    {
        $this->model->visits()->create([
            'data' => $this->attributes,
        ]);
    }
}
