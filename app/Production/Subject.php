<?php

namespace App\Production;

use Illuminate\Support\Collection;

abstract class Subject
{
    protected string $state;
    protected Collection $observers;

    public function __construct()
    {
        $this->observers = collect();
    }

    public function setState(string $state): void
    {
        $this->state = $state;
        $this->notifyAllObservers();
    }

    public function attach(Observer $observer): void
    {
        $this->observers->push($observer);
    }

    public function notifyAllObservers(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($this->state, $this->name??'Unknown');
        }
    }

}