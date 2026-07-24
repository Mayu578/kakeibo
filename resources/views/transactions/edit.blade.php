<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-stone-100">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <span class="text-2xl">✏️</span>
                            <h3 class="text-lg font-bold text-gray-800">取引を編集</h3>
                        </div>
                        <a href="{{ route('transactions.index') }}"
                            class="inline-block px-5 py-2.5 bg-stone-50 border border-stone-200 text-stone-500 text-sm font-medium rounded-xl hover:bg-stone-100 transition duration-200 text-center">
                            一覧へ戻る
                        </a>
                    </div>

                    <form method="POST" action="{{ route('transactions.update', $transaction) }}" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="text-xs font-semibold text-stone-500 tracking-wider">口座</label>
                            <select name="account_id" required
                                class="w-full border border-stone-200 rounded-lg p-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#8A9A86] focus:border-transparent">
                                @foreach ($accounts as $account)
                                    <option value="{{ $account->id }}" @selected($transaction->account_id === $account->id)>
                                        {{ $account->name }} (残高: {{ number_format($account->balance) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs font-semibold text-stone-500 tracking-wider">取引日</label>
                                <input type="date" name="transaction_date"
                                    value="{{ old('transaction_date', $transaction->transaction_date) }}" required
                                    class="w-full border border-stone-200 rounded-lg p-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#8A9A86] focus:border-transparent">
                            </div>

                            <div>
                                <label class="text-xs font-semibold text-stone-500 tracking-wider">取引タイプ</label>
                                <select name="type" required
                                    class="w-full border border-stone-200 rounded-lg p-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#8A9A86] focus:border-transparent">
                                    <option value="income" @selected($transaction->type === 'income')>収入</option>
                                    <option value="expense" @selected($transaction->type === 'expense')>支出</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-stone-500 tracking-wider">カテゴリー</label>
                            <select name="category" required
                                class="w-full border border-stone-200 rounded-lg p-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#8A9A86] focus:border-transparent">
                                @foreach (\App\Models\Transaction::CATEGORIES as $value => $label)
                                    <option value="{{ $value }}" @selected($transaction->category === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-stone-500 tracking-wider">金額</label>
                            <div class="relative flex items-center">
                                <span class="absolute left-4 text-stone-400 font-medium text-sm">¥</span>
                                <input type="number" name="amount" min="0"
                                    value="{{ old('amount', $transaction->amount) }}" required
                                    class="w-full border border-stone-200 rounded-lg py-3 pl-8 pr-4 text-sm text-gray-800 font-semibold focus:outline-none focus:ring-2 focus:ring-[#8A9A86] focus:border-transparent">
                            </div>
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-stone-500 tracking-wider">支払い方法</label>
                            <select name="payment_type" id="payment_type" onchange="toggleDueDate()" required
                                class="w-full border border-stone-200 rounded-lg p-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#8A9A86] focus:border-transparent">
                                <option value="cash" @selected($transaction->payment_type === 'cash')>現金</option>
                                <option value="credit" @selected($transaction->payment_type === 'credit')>クレジット</option>
                            </select>
                        </div>

                        <div id="due_date_container" style="display: none;">
                            <label class="text-xs font-semibold text-stone-500 tracking-wider">クレジット引き落とし日</label>
                            <input type="date" name="due_date" value="{{ old('due_date', $transaction->due_date) }}"
                                class="w-full border border-stone-200 rounded-lg p-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#8A9A86] focus:border-transparent">
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-stone-500 tracking-wider">説明</label>
                            <input type="text" name="description" value="{{ old('description', $transaction->description) }}"
                                placeholder="（例：食費、カフェ代など）"
                                class="w-full border border-stone-200 rounded-lg p-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#8A9A86] focus:border-transparent">
                        </div>

                        <button type="submit"
                            class="inline-block mt-3 px-5 py-2.5 bg-[#8A9A86] text-white text-sm font-medium rounded-xl hover:bg-[#788874] transition duration-200 text-center">
                            更新する
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        function toggleDueDate() {
            const paymentType = document.getElementById('payment_type').value;
            const dueContainer = document.getElementById('due_date_container');
            dueContainer.style.display = (paymentType === 'credit') ? 'block' : 'none';
        }
        document.addEventListener('DOMContentLoaded', toggleDueDate);
    </script>
</x-app-layout>