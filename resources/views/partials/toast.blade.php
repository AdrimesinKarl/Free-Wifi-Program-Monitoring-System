{{-- Toast Notification --}}
@if(session('success') || session('warning') || $errors->has('csv_file'))
<div
    id="toast"
    class="fixed top-6 left-1/2 -translate-x-1/2 z-50 flex items-start gap-3 w-80 p-4 rounded-xl shadow-lg border
    {{ session('success')
        ? 'bg-green-50 dark:bg-green-950 border-green-200 dark:border-green-800 text-green-800 dark:text-green-300'
        : 'bg-yellow-50 dark:bg-yellow-950 border-yellow-200 dark:border-yellow-800 text-yellow-800 dark:text-yellow-300' }}
    {{ $errors->has('csv_file') ? 'bg-red-50 dark:bg-red-950 border-red-200 dark:border-red-800 text-red-800 dark:text-red-300' : '' }}">

    {{-- Icon --}}
    <div class="mt-0.5 shrink-0">
        @if(session('success'))
            <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        @elseif($errors->has('csv_file'))
            <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        @else
            <svg class="w-5 h-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M12 2a10 10 0 100 20A10 10 0 0012 2z"/></svg>
        @endif
    </div>

    {{-- Message --}}
    <div class="flex-1 text-sm">
        @if(session('success'))
            {{ session('success') }}
        @elseif($errors->has('csv_file'))
            {{ $errors->first('csv_file') }}
        @elseif(session('warning'))
            <p class="font-medium">{{ session('warning') }}</p>
            @if(session('import_errors'))
                <ul class="mt-1 pl-4 list-disc text-xs space-y-0.5 opacity-80">
                    @foreach(session('import_errors') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        @endif
    </div>

    {{-- Close button --}}
    <button onclick="document.getElementById('toast').remove()" class="shrink-0 opacity-50 hover:opacity-100 transition-opacity">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
    </button>
</div>

{{-- Auto-dismiss after 4 seconds --}}
<script>
    setTimeout(() => document.getElementById('toast')?.remove(), 4000);
</script>
@endif