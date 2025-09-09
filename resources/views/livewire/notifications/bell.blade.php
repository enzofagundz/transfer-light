<div x-data="{ open: false }" class="relative" wire:poll.5s="refreshNotifications">
    <button @click="open = !open" class="btn btn-ghost btn-circle">
        <div class="indicator">
            <x-lucide-bell class="w-6 h-6" />
            @if ($unreadNotificationsCount > 0)
                <span class="badge badge-xs badge-primary indicator-item">{{ $unreadNotificationsCount }}</span>
            @endif
        </div>
    </button>

    <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 mt-2 z-[1] card card-compact w-80 bg-base-200 shadow-lg p-4" style="display: none;"
    >
        <div class="card-body">
            <div class="flex justify-between items-center">
                <span class="font-bold text-lg">{{ $unreadNotificationsCount }} New</span>
                <button @if ($unreadNotificationsCount === 0) disabled @endif class="btn btn-primary btn-xs"
                    x-on:click="$wire.markAllAsRead().then(() => { open = false })">
                    Mark all as read
                </button>
            </div>
            <div class="max-h-72 overflow-y-auto divide-y divide-base-200">
                @forelse($this->notifications as $notification)
                    <div class="py-2">
                        <p class="text-sm">{{ $notification->message }}</p>
                        <div class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</div>
                    </div>
                @empty
                    <div class="py-4 text-center text-sm">You have no new notifications.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
