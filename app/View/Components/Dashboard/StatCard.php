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
        $colors = match($this->color) {
            'purple' => ['bg-purple-500/10', 'text-purple-400'],
            'emerald' => ['bg-emerald-500/10', 'text-emerald-400'],
            'orange' => ['bg-orange-500/10', 'text-orange-400'],
            'red' => ['bg-red-500/10', 'text-red-400'],
            default => ['bg-blue-500/10', 'text-blue-400'],
        };

        return implode(' ', $colors);
    }

    public function getTextColorClass(): string
    {
        return match($this->color) {
            'purple' => 'text-purple-400',
            'emerald' => 'text-emerald-400',
            'orange' => 'text-orange-400',
            'red' => 'text-red-400',
            default => 'text-blue-400',
        };
    }
}
