<?php

namespace App\View\Components\Ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    public string $type;
    public string $size;
    public bool $invalid;
    public ?string $label;
    public ?string $name;
    public bool $required;
    public ?string $description;
    public ?string $error;
    public string $computedClasses;

    private const BASE_CLASSES = 'w-full rounded-[var(--radius)] border border-[var(--border)] bg-[var(--control-background)] px-3 text-sm text-[var(--control-foreground)] placeholder:text-[var(--muted-foreground)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--ring)] focus-visible:ring-offset-2 ring-offset-[var(--background)] disabled:cursor-not-allowed disabled:opacity-50 transition-colors';

    private const SIZES = [
        'default' => 'h-10 py-2',
        'sm' => 'h-9',
        'lg' => 'h-11 px-4',
    ];

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $type = 'text',
        string $size = 'default',
        bool $invalid = false,
        ?string $label = null,
        ?string $name = null,
        bool $required = false,
        ?string $description = null,
        ?string $error = null,
    ) {
        $this->type = $type;
        $this->size = $size;
        $this->invalid = $invalid;
        $this->label = $label;
        $this->name = $name;
        $this->required = $required;
        $this->description = $description;
        $this->error = $error;
        $this->computedClasses = $this->buildClasses();
    }

    private function buildClasses(): string
    {
        $sizeClass = self::SIZES[$this->size] ?? self::SIZES['default'];
        $invalidClass = $this->invalid
            ? ' border-[var(--destructive)] focus-visible:ring-[var(--destructive)]'
            : '';

        return trim(implode(' ', [
            self::BASE_CLASSES,
            $sizeClass,
            $invalidClass,
        ]));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.input');
    }
}
