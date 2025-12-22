<div class="overflow-x-auto bg-[var(--control-background)] rounded-[var(--radius-lg)] border border-[var(--border)] shadow-sm">
    <table {{ $attributes->merge(['class' => 'min-w-full divide-y divide-[var(--border)]']) }}>
        @if(isset($head))
            <thead class="bg-[var(--muted)]">
                <tr>
                    {{ $head }}
                </tr>
            </thead>
        @endif
        <tbody class="bg-[var(--control-background)] divide-y divide-[var(--border)]">
            {{ $slot }}
        </tbody>
        @if(isset($foot))
            <tfoot class="bg-[var(--muted)]">
                {{ $foot }}
            </tfoot>
        @endif
    </table>
</div>




