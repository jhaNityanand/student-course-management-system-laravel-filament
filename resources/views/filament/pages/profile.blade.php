<x-filament-panels::page>
    <x-filament-panels::form wire:submit="save">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-filament-panels::form>
</x-filament-panels::page> 

<script>
    document.addEventListener('DOMContentLoaded', function() {
       console.log('DOMContentLoaded');
       const main = document.querySelector('main');
       main.classList.remove('max-w-lg');
    });
</script>
