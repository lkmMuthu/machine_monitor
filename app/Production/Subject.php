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

    /**
     * Set the state of the machine and notify observers.
     *
     * @param string $state The new state of the machine.
     * @return void
     */
    public function setState(string $state): void
    {
        $this->state = $state;
        $this->notifyAllObservers();
    }

    /**
     * Get the current state of the machine.
     *
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * Attach an observer to the subject.
     *
     * @param Observer $observer The observer to attach.
     * @return void
     */
    public function attach(Observer $observer): void
    {
        $this->observers->push($observer);
    }

    /**
     * Notify all observers of a state change.
     *
     * @return void
     */
    public function notifyAllObservers(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($this->state, $this->name??'Unknown');
        }
    }

}