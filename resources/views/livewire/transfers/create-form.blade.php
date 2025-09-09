<div>
    <div>
        <h1 class="text-3xl">New Transfer</h1>
    </div>

    <form class="flex flex-col w-full items-center" wire:submit.prevent="transfer">
        <fieldset class="fieldset border-none rounded-box w-xs border p-4 lg:w-3/4">
            <label class="label">
                Sender
            </label>
            <select class="select select-bordered w-full max-w-xs" wire:model.live="form.senderId">
                <option value="" selected>Select a sender</option>
                @foreach ($this->senders as $sender)
                    <option value="{{ $sender->id }}">{{ $sender->name }}</option>
                @endforeach
            </select>

            @if (filled($this->senderBalance))
                <div class="label">
                    <span class="label-text-alt text-success font-bold">Balance: R$
                        {{ number_format($this->senderBalance, 2, ',', '.') }}</span>
                </div>
            @endif

            @error('senderId')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror

            <label class="label">
                Receiver
            </label>
            <select class="select select-bordered w-full max-w-xs" wire:model="form.receiverId">
                <option selected>Select a receiver</option>
                @foreach ($this->receivers as $receiver)
                    <option value="{{ $receiver->id }}">{{ $receiver->name }}</option>
                @endforeach
            </select>
            @error('receiverId')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror

            <label class="label">
                Amount
            </label>
            <input type="number" step="0.01" class="input lg:w-full" placeholder="e.g. 10.50" wire:model="form.amount" />
            @error('amount')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror

            <button type="submit" class="btn btn-primary mt-4" wire:loading.attr="disabled">Transfer</button>
        </fieldset>
    </form>
</div>
