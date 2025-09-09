<div>
    <div>
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl">Users</h1>
            <button class="btn btn-primary" href="/users/create" wire:navigate>
                <x-lucide-plus class="w-6 h-6" />
                Add new user
            </button>
        </div>
    </div>

    <div class="overflow-x-auto bg-base-100">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>CPF/CNPJ</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Balance</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr wire:key="{{ $user->id }}">
                        <td>{{ $user->name }}</td>
                        <td>
                            {{ $user->cpf_cnpj }}
                        </td>
                        <td>
                            {{ $user->email }}
                        </td>
                        <td>
                            {{ $user->type->name }}
                        </td>
                        <td>
                            {{ $user->wallet->balance }}
                        </td>
                        <td class="space-x-2">
                            <button class="btn btn-sm btn-outline btn-circle btn-error"
                                wire:click="delete({{ $user->id }})"
                                wire:confirm="Are you sure you want to delete this user?">
                                <x-lucide-trash-2 class="w-4 h-4" />
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
