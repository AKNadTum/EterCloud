<?php

namespace App\View\Components\User;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Avatar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public User $user,
        public string $size = 'md',
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.user.avatar');
    }

    public function getInitials(): string
    {
        $name = $this->user->getDisplayNameAttribute();
        $words = explode(' ', $name);
        $initials = '';
        foreach ($words as $w) {
            $initials .= strtoupper(substr($w, 0, 1));
        }
        return substr($initials, 0, 2);
    }

    public function getSizeClass(): string
    {
        return match ($this->size) {
            'xs' => 'size-6 text-[10px]',
            'sm' => 'size-8 text-xs',
            'lg' => 'size-12 text-base',
            'xl' => 'size-16 text-xl',
            default => 'size-10 text-sm',
        };
    }
}
