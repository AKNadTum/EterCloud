<?php

namespace App\View\Components\Ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public string $variant;
    public string $size;
    public string $type;
    public ?string $href;
    public ?string $target;
    public ?string $rel;
    public bool $glow;
    public string $computedClasses;

    private const BASE_CLASSES = 'inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-[var(--radius)] text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--background)] disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0';

    private const VARIANTS = [
        'default' => 'bg-[var(--primary)] text-[var(--primary-foreground)] hover:bg-[var(--primary-hover)] focus-visible:ring-[var(--ring)]',
        'primary' => 'bg-[var(--primary)] text-[var(--primary-foreground)] hover:bg-[var(--primary-hover)] focus-visible:ring-[var(--ring)]',
        'destructive' => 'bg-[var(--destructive)] text-[var(--destructive-foreground)] hover:bg-[var(--destructive-hover)] focus-visible:ring-[var(--ring)]',
        'outline' => 'border border-[var(--border)] bg-transparent text-[var(--foreground)] hover:bg-[var(--secondary)]',
        'secondary' => 'bg-[var(--secondary)] text-[var(--secondary-foreground)] hover:bg-[var(--secondary-hover)]',
        'ghost' => 'hover:bg-[var(--secondary)] hover:text-[var(--secondary-foreground)]',
        'link' => 'text-[var(--link)] underline-offset-4 hover:text-[var(--link-hover)] hover:underline',
        'accent' => 'bg-[var(--accent)] text-[var(--accent-foreground)] hover:bg-[var(--accent-hover)] focus-visible:ring-[var(--ring)]',
        'success' => 'bg-[var(--success)] text-[var(--success-foreground)] hover:opacity-90',
    ];

    private const SIZES = [
        'default' => 'h-10 px-4 py-2',
        'sm' => 'h-9 px-3',
        'lg' => 'h-11 px-8',
        'icon' => 'h-10 w-10',
    ];

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $variant = 'default',
        string $size = 'default',
        string $type = 'button',
        ?string $href = null,
        ?string $target = null,
        ?string $rel = null,
        bool $glow = false,
    ) {
        $this->variant = $variant;
        $this->size = $size;
        $this->type = $type;
        $this->href = $href;
        $this->target = $target;
        $this->glow = $glow;
        if ($rel !== null) {
            $this->rel = $rel;
        } elseif ($target === '_blank') {
            $this->rel = 'noopener noreferrer';
        } else {
            $this->rel = null;
        }
        $this->computedClasses = $this->buildClasses();
    }

    /**
     * Build the CSS classes for the button.
     */
    private function buildClasses(): string
    {
        $variantClass = self::VARIANTS[$this->variant] ?? self::VARIANTS['default'];
        $sizeClass = self::SIZES[$this->size] ?? self::SIZES['default'];

        // Optional soft shadow instead of neon glow
        $glowClass = '';
        if (property_exists($this, 'glow') && $this->glow) {
            $glowClass = 'shadow-sm';
        }

        return implode(' ', [
            self::BASE_CLASSES,
            $variantClass,
            $sizeClass,
            $glowClass,
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.button');
    }
}
