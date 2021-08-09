<?php

namespace App\Visitable;

use App\Models\User;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Model;

class PendingVisit
{
    protected $attributes = [];

    protected $interval;

    public function __construct(protected Model $model)
    {
        $this->interval = now()->subDay();
    }

    public function withIp($ip = null)
    {
        $this->attributes['ip'] = $ip ?? request()->ip();

        return $this;
    }

    public function withData($data)
    {
        $this->attributes = array_merge($this->attributes, $data);

        return $this;
    }

    public function withUser(?User $user = null)
    {
        $this->attributes['user_id'] = $user?->id ?? auth()->id();

        return $this;
    }

    protected function buildJsonColumns()
    {
        return collect($this->attributes)
            ->mapWithKeys(function ($value, $index) {
                return ['data->' . $index => $value];
            })
            ->toArray();
    }

    protected function shouldBeLoggedAgain(Visit $visit)
    {
        return !$visit->wasRecentlyCreated && $visit->created_at->lt($this->interval);
    }

    public function __destruct()
    {
        $visit = $this->model->visits()->firstOrCreate($this->buildJsonColumns(), [
            'data' => $this->attributes,
        ]);

        $visit->when($this->shouldBeLoggedAgain($visit), function () use ($visit) {
            $visit->replicate()->save();
        });
    }
}
