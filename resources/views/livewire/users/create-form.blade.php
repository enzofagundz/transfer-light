<div class="flex flex-col gap-4">
    <div>
        <h1 class="text-3xl">Add New User</h1>
    </div>

    <form class="flex flex-col w-full items-center" wire:submit.prevent="save">
        <fieldset class="fieldset border-none rounded-box w-xs border p-4 lg:w-3/4">
            <label class="label">Name</label>
            <input type="text" class="input lg:w-full" placeholder="e.g. John Doe" wire:model="form.name" />
            @error('name')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror

            <label class="label">Email</label>
            <input type="email" class="input lg:w-full" placeholder="e.g. 8q0Tt@example.com"
                wire:model="form.email" />
            @error('email')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror

            <label class="label">Password</label>
            <input type="password" class="input lg:w-full" placeholder="Password" wire:model="form.password" />
            @error('password')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror

            <label class="label">Confirm Password</label>
            <input type="password" class="input lg:w-full" placeholder="Password"
                wire:model="form.password_confirmation" />
            @error('password_confirmation')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror

            <label class="label">CPF/CNPJ</label>
            <input type="text" class="input lg:w-full" placeholder="e.g. 123.456.789-00"
                wire:model="form.cpf_cnpj" />
            @error('cpf_cnpj')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror

            <label class="label">Type</label>
            <select class="select select-bordered w-full max-w-xs" wire:model="form.type">
                <option disabled selected>Select user type</option>
                @foreach (\App\Enums\UserType::cases() as $type)
                    <option value="{{ $type->value }}">{{ $type->name }}</option>
                @endforeach
            </select>
            @error('type')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror

            <label class="label">Balance</label>
            <input type="number" class="input lg:w-full" placeholder="e.g. 1000" wire:model="form.balance" />

            <button type="submit" class="btn btn-primary mt-4" wire:loading.attr="disabled">Create User</button>
        </fieldset>
    </form>
</div>
