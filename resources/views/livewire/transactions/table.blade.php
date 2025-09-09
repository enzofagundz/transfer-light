<div>
    <div>
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl">Transactions</h1>
        </div>
    </div>

    <div class="overflow-x-auto bg-base-100">
        <table class="table">
            <thead>
                <tr>
                    <th>Sender</th>
                    <th>Receiver</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr wire:key="{{ $transaction->id }}">
                        <td>{{ $transaction->sender->name }}</td>
                        <td>{{ $transaction->receiver->name }}</td>
                        <td>{{ $transaction->amount }}</td>
                        <td>{{ $transaction->status->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
