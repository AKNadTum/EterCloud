<div class="space-y-4">
    @if (session('success'))
        <x-ui.alert variant="success" dismissible="true" class="animate-in fade-in slide-in-from-top-4 duration-500">
            <x-heroicon-o-check-circle class="size-5" />
            
                {{ session('success') }}
            
        </x-ui.alert>
    @endif

    @if (session('status'))
        <x-ui.alert variant="info" dismissible="true" class="animate-in fade-in slide-in-from-top-4 duration-500">
            <x-heroicon-o-information-circle class="size-5" />
            
                {{ session('status') }}
            
        </x-ui.alert>
    @endif

    @if (session('error'))
        <x-ui.alert variant="error" dismissible="true" class="animate-in fade-in slide-in-from-top-4 duration-500">
            <x-heroicon-o-exclamation-circle class="size-5" />
            
                {{ session('error') }}
            
        </x-ui.alert>
    @endif

    @if ($errors->any())
        <x-ui.alert variant="error" dismissible="true" class="animate-in fade-in slide-in-from-top-4 duration-500">
            <x-heroicon-o-x-circle class="size-5 shrink-0" />
            
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            
        </x-ui.alert>
    @endif
</div>





