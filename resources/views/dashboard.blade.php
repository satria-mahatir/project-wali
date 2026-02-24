<x-app-layout>
    <div class="container py-4">
        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 fw-bold">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            </div>
        @endif

        {{-- INI PEMANGGILAN LIVEWIRE-NYA --}}
        @livewire('chat-user')

    </div>
</x-app-layout>
