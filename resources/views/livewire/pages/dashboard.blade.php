<div x-data="{ activeTab: 'users' }" class="w-full">
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-8 gap-4" aria-label="Tabs">
            <button @click="activeTab = 'users'"
                :class="activeTab === 'users' ? 'border-violet-500 text-violet-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Users
            </button>

            <button @click="activeTab = 'transactions'"
                :class="activeTab === 'transactions' ? 'border-violet-500 text-violet-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Transactions
            </button>
        </nav>
    </div>

    <div class="pt-5">
        <div x-show="activeTab === 'users'" x-cloak>
            <livewire:users.table />
        </div>
        <div x-show="activeTab === 'transactions'" x-cloak>
            <livewire:transactions.table />
        </div>
    </div>
</div>

