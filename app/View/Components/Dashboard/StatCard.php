<?php

namespace App\View\Components\Dashboard;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StatCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $title,
        public string $value,
        public string $icon,
        public ?string $href = null,
        public ?string $linkText = null,
        public string $color = 'blue',
        public ?string $badgeText = null,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.stat-card');
    }

    public function getColorClasses(): string
    {
        return match($this->color) {
            'purple' => 'bg-purple-50 text-purple-600',
            'emerald' => 'bg-emerald-50 text-emerald-600',
            'orange' => 'bg-orange-50 text-orange-600',
            'red' => 'bg-red-50 text-red-600',
            default => 'bg-blue-50 text-blue-600',
        };
    }
}
