<div class="overflow-x-auto bg-white rounded-[var(--radius-lg)] border border-[var(--border)] shadow-sm">
    <table {{ $attributes->merge(['class' => 'min-w-full divide-y divide-[var(--border)]']) }}>
        @if(isset($head))
            <thead class="bg-gray-50">
                <tr>
                    {{ $head }}
                </tr>
            </thead>
        @endif
        <tbody class="bg-white divide-y divide-[var(--border)]">
            {{ $slot }}
        </tbody>
        @if(isset($foot))
            <tfoot class="bg-gray-50">
                {{ $foot }}
            </tfoot>
        @endif
    </table>
</div>
