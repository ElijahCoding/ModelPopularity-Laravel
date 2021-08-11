<?php


namespace App\Visitable\Concerns;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

trait FiltersByPopularityTimeframe
{
    public function scopePopularAllTime(Builder $query)
    {
        $query->withTotalVisitCount()->orderBy('visit_count_total', 'desc');
    }

    public function scopePopularBetween(Builder $query, Carbon $from, Carbon $to)
    {
        $query->whereHas('visits', $this->betweenScope($from, $to))
            ->withCount([
                'visits as visit_count' => $this->betweenScope($from, $to),
            ])
        ;
    }

    protected function betweenScope(Carbon $from, Carbon $to)
    {
        return function ($query) use ($from, $to) {
            $query->whereBetween('created_at', [$from, $to]);
        };
    }
}
