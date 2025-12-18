<?php

namespace App\View\Components\Plan;

use App\Models\Plan;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FeatureList extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Plan $plan,
        public bool $showLocations = true,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.plan.feature-list');
    }
}
