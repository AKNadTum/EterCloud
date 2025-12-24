<x-layout.master :title="($__env->yieldContent('title') ?: 'Support Staff') . ' · Support'">
    <main class="min-h-screen">
        <div class="mx-auto w-full px-4 md:px-6 lg:px-8 py-8" style="max-width: 1400px;">
            <div class="grid grid-cols-1 md:grid-cols-[280px_1fr] gap-8">
                <!-- Sidebar -->
                <div class="md:sticky md:top-8 self-start">
                    <x-layout.support-sidebar />
                </div>

                <!-- Main Content Area -->
                <div class="space-y-6">
                    <!-- Topbar -->
                    <header class="bg-[var(--control-background)] border border-[var(--border)] rounded-[var(--radius-lg)] shadow-sm px-6 py-4 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <h1 class="text-2xl font-extrabold tracking-tight text-[var(--foreground)]">
                                @yield('title', 'Support Staff')
                            </h1>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="hidden sm:flex items-center gap-3 glass px-4 py-1.5 rounded-full text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-widest border-[var(--border)]/50">
                                <div class="size-2 rounded-full bg-[var(--primary-foreground)]"></div>
                                Support: {{ auth()->user()->name ?? auth()->user()->email }}
                            </div>
                            <x-ui.button href="{{ route('dashboard.index') }}" variant="outline" size="sm" class="rounded-full">
                                <x-heroicon-o-arrow-left class="size-4 mr-1" />
                                Dashboard Client
                            </x-ui.button>
                        </div>
                    </header>

                    <div class="min-h-[60vh]">
                        <x-layout.notifications class="mb-6" />

                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout.master>









