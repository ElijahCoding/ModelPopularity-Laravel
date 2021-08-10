<?php

namespace App\Visitable\Concerns;

trait SetsPendingInterval
{
    public function hourlyIntervals()
    {
        $this->interval = now()->subHour();

        return $this;
    }

    public function dailyIntervals()
    {
        $this->interval = now()->subDay();

        return $this;
    }
}
