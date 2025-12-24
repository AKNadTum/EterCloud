<x-layout.master :title="$title ?? null">
    <x-layout.header />

    <main class="min-h-screen">
        <div class="container-custom pt-20 md:pt-24 relative z-50">
            <x-layout.notifications class="mb-6" />
        </div>

        @yield('content')
    </main>

    <x-layout.footer />
</x-layout.master>








