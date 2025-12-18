<?php

namespace App\View\Components\Ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    public string $variant;
    public bool $dismissible;
    public string $computedClasses;

    private const BASE_CLASSES = 'relative w-full rounded-[var(--radius-lg)] border p-4 [&>svg~*]:pl-7 [&>svg]:absolute [&>svg]:left-4 [&>svg]:top-4 [&>svg]:text-[var(--foreground)]';

    private const VARIANTS = [
        'default' => 'bg-[var(--primary)] text-[var(--primary-foreground)] border-[var(--primary-foreground)]/20 [&>svg]:text-[var(--primary-foreground)]',
        'primary' => 'bg-[var(--primary)] text-[var(--primary-foreground)] border-[var(--primary-foreground)]/20 [&>svg]:text-[var(--primary-foreground)]',
        'destructive' => 'bg-[var(--destructive)] text-[var(--destructive-foreground)] border-[var(--destructive-foreground)]/20 [&>svg]:text-[var(--destructive-foreground)]',
        'error' => 'bg-[var(--destructive)] text-[var(--destructive-foreground)] border-[var(--destructive-foreground)]/20 [&>svg]:text-[var(--destructive-foreground)]',
        'success' => 'bg-[var(--success)] text-[var(--success-foreground)] border-[var(--success-foreground)]/20 [&>svg]:text-[var(--success-foreground)]',
        'warning' => 'bg-[var(--warning)] text-[var(--warning-foreground)] border-[var(--warning-foreground)]/20 [&>svg]:text-[var(--warning-foreground)]',
        'accent' => 'bg-[var(--accent)] text-[var(--accent-foreground)] border-[var(--accent-foreground)]/20 [&>svg]:text-[var(--accent-foreground)]',
        'info' => 'bg-[var(--accent)] text-[var(--accent-foreground)] border-[var(--accent-foreground)]/20 [&>svg]:text-[var(--accent-foreground)]',
    ];

    /**
     * Create a new component instance.
     */
    public function __construct(string $variant = 'default', bool $dismissible = false)
    {
        $this->variant = $variant;
        $this->dismissible = $dismissible;
        $this->computedClasses = $this->buildClasses();
    }

    /**
     * Build the CSS classes for the alert.
     */
    private function buildClasses(): string
    {
        $variantClass = self::VARIANTS[$this->variant] ?? self::VARIANTS['default'];

        return implode(' ', [
            self::BASE_CLASSES,
            $variantClass,
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.alert');
    }
}
