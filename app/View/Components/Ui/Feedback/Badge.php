<?php

namespace App\View\Components\Ui\Feedback;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Badge extends Component
{
    public string $variant;
    public string $size;
    public string $computedClasses;

    private const BASE = 'inline-flex items-center gap-1 rounded-[var(--radius)] font-medium select-none';

    private const VARIANTS = [
        'subtle' => 'bg-[var(--secondary)] text-[var(--secondary-foreground)]',
        'primary' => 'bg-[var(--primary)] text-[var(--primary-foreground)]',
        'primary-subtle' => 'bg-[var(--primary)]/20 text-[var(--primary-foreground)]',
        'accent' => 'bg-[var(--accent)] text-[var(--accent-foreground)]',
        'accent-subtle' => 'bg-[var(--accent)]/20 text-[var(--accent-foreground)]',
        'destructive' => 'bg-[var(--destructive)] text-[var(--destructive-foreground)]',
        'destructive-subtle' => 'bg-[var(--destructive)]/20 text-[var(--destructive-foreground)]',
        'success' => 'bg-[var(--success)] text-[var(--success-foreground)]',
        'success-subtle' => 'bg-[var(--success)]/20 text-[var(--success-foreground)]',
        'warning' => 'bg-[var(--warning)] text-[var(--warning-foreground)]',
        'warning-subtle' => 'bg-[var(--warning)]/20 text-[var(--warning-foreground)]',
        'outline' => 'border border-[var(--border)] text-[var(--foreground)]',
    ];

    private const SIZES = [
        'sm' => 'text-[11px] px-2 py-0.5',
        'md' => 'text-xs px-2.5 py-1',
        'lg' => 'text-sm px-3 py-1.5',
    ];

    public function __construct(string $variant = 'subtle', string $size = 'md')
    {
        $this->variant = $variant;
        $this->size = $size;
        $this->computedClasses = $this->buildClasses();
    }

    private function buildClasses(): string
    {
        $v = self::VARIANTS[$this->variant] ?? self::VARIANTS['subtle'];
        $s = self::SIZES[$this->size] ?? self::SIZES['md'];

        return implode(' ', [self::BASE, $v, $s]);
    }

    public function render(): View|Closure|string
    {
        return view('components.ui.feedback.badge');
    }
}
