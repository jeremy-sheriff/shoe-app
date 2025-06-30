<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>
<script src="{{ asset('js/slim.kickstart.min.js') }}"></script>
