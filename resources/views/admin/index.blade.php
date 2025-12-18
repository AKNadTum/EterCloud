@extends('admin.layout')

@section('title', 'Vue d\'ensemble')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-[var(--radius-lg)] border border-[var(--border)] shadow-sm">
            <h3 class="text-sm font-medium text-muted-foreground uppercase tracking-wider">Utilisateurs</h3>
            <p class="mt-2 text-3xl font-bold">{{ $stats['users_count'] }}</p>
        </div>

        <div class="bg-white p-6 rounded-[var(--radius-lg)] border border-[var(--border)] shadow-sm">
            <h3 class="text-sm font-medium text-muted-foreground uppercase tracking-wider">Plans</h3>
            <p class="mt-2 text-3xl font-bold">{{ $stats['plans_count'] }}</p>
        </div>

        <div class="bg-white p-6 rounded-[var(--radius-lg)] border border-[var(--border)] shadow-sm">
            <h3 class="text-sm font-medium text-muted-foreground uppercase tracking-wider">Locations</h3>
            <p class="mt-2 text-3xl font-bold">{{ $stats['locations_count'] }}</p>
        </div>
    </div>
@endsection
