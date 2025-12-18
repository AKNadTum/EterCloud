<?php

namespace App\View\Components\Status;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Badge extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $status,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.status.badge');
    }

    public function getLabel(): string
    {
        return match (strtolower($this->status)) {
            'active', 'running' => 'Actif',
            'suspended' => 'Suspendu',
            'installing' => 'Installation',
            'offline', 'stopped' => 'Hors-ligne',
            'pending' => 'En attente',
            default => ucfirst($this->status),
        };
    }

    public function getVariant(): string
    {
        return match (strtolower($this->status)) {
            'active', 'running' => 'success',
            'suspended', 'stopped', 'offline' => 'destructive',
            'installing', 'pending' => 'warning',
            default => 'subtle',
        };
    }
}
