<?php

namespace App\Visitable\Concerns;


use Illuminate\Support\Carbon;

trait SetsPendingInterval
{
    public function hourlyInterval()
    {
        $this->interval = now()->subHour();

        return $this;
    }

    public function dailyInterval()
    {
        $this->interval = now()->subDay();

        return $this;
    }

    public function weeklyInterval()
    {
        $this->interval = now()->subWeek();

        return $this;
    }

    public function monthlyInterval()
    {
        $this->interval = now()->subMonth();

        return $this;
    }

    public function customInterval(Carbon $interval)
    {
        $this->interval = $interval;

        return $this;
    }
}
