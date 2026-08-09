@props(['href', 'active' => false])

<a href="{{ $href }}"
   class="flex items-center gap-2 px-3 py-2.5 rounded-2xl text-sm transition
   {{ $active ? 'bg-lime text-ink font-semibold' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
    {{ $slot }}
</a>