<?php


namespace App\Visitable\Concerns;


use Illuminate\Database\Eloquent\Builder;

trait FiltersByPopularityTimeframe
{
    public function scopePopularAllTime(Builder $query)
    {
        $query->withTotalVisitCount()->orderBy('visit_count_total', 'desc');
    }


}
