<form action="{{ route('transactions.update', $transaction) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- account_id -->
    <div>
        <label>口座ID</label>
        <input type="number" name="account_id" value="{{ $transaction->account_id }}">
    </div>

    <!-- type -->
    <div>
        <label>取引タイプ</label>
        <select name="type">
            <option value="income" {{ $transaction->type == 'income' ? 'selected' : '' }}>収入</option>
            <option value="expense" {{ $transaction->type == 'expense' ? 'selected' : '' }}>支出</option>
        </select>
    </div>

    <!-- amount -->
    <div>
        <label>金額</label>
        <input type="number" name="amount" value="{{ $transaction->amount }}">
    </div>

    <!-- transaction_date -->
    <div>
        <label>取引日</label>
        <input type="date" name="transaction_date" value="{{ $transaction->transaction_date }}">
    </div>

    <!-- reflect_date -->
    {{-- <div>
        <label>反映日</label>
        <input type="date" name="reflect_date" value="{{ $transaction->reflect_date }}">
    </div> --}}

    <!-- description -->
    <div>
        <label>説明</label>
        <input type="text" name="description" value="{{ $transaction->description }}">
    </div>

    <!-- payment_type -->
    <div>
        <label>支払方法</label>
        <select name="payment_type">
            <option value="cash" {{ $transaction->payment_type == 'cash' ? 'selected' : '' }}>現金</option>
            <option value="card" {{ $transaction->payment_type == 'card' ? 'selected' : '' }}>カード</option>
            <option value="bank" {{ $transaction->payment_type == 'bank' ? 'selected' : '' }}>銀行</option>
        </select>
    </div>

    <!-- due_date -->
    <div>
        <label>支払期限</label>
        <input type="date" name="due_date" value="{{ $transaction->due_date }}">
    </div>

    <button type="submit">更新</button>
</form>