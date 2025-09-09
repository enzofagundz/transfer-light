<div>
    @if ($show)
        <div
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => { show = false; $wire.set('show', false) }, 5000)"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="transform opacity-0 translate-y-2"
            x-transition:enter-end="transform opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="transform opacity-100 translate-y-0"
            x-transition:leave-end="transform opacity-0 translate-y-2"
        >
            <div role="alert" class="{{ $type == 'success' ? 'alert-success' : 'alert-error' }} alert shadow-lg m-4">
                <span>{{ $message }}</span>
                <button @click="show = false; $wire.call('close')" class="btn btn-ghost btn-xs">✕</button>
            </div>
        </div>
    @endif
</div>
