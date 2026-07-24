<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Noto+Sans+JP:wght@400;500;700&display=swap"
        rel="stylesheet">

    <title>取引登録</title>
</head>

<div class="min-h-screen flex items-center justify-center bg-[#F4F3EF] px-4 py-12 font-sans antialiased text-stone-700"
    style="font-family: 'Poppins', 'Noto Sans JP', sans-serif;">

    <div
        class="w-full max-w-md bg-white p-6 md:p-8 rounded-2xl md:rounded-3xl shadow-[0_8px_30px_rgba(138,154,134,0.06)] border border-stone-200/60">

        <h2 class="text-xl font-bold text-stone-800 text-center mb-8 tracking-wide">
            取引登録
        </h2>

        <form action="{{ route('transactions.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="space-y-1.5">
                <label class="text-xs font-semibold text-stone-500 tracking-wider">口座</label>
                <select name="account_id" required
                    class="w-full border border-stone-200 rounded-xl p-3 text-sm bg-stone-50/50 text-stone-700 focus:outline-none focus:border-[#8A9A86] focus:ring-1 focus:ring-[#8A9A86] transition-all">
                    <option value="">選択してください</option>
                    @foreach ($accounts as $account)
                        <option value="{{ $account->id }}">{{ $account->name }} (残高:
                            {{ number_format($account->balance) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-stone-500 tracking-wider">取引日</label>
                    <input type="date" name="transaction_date" value="{{ old('transaction_date') ?? date('Y-m-d') }}"
                        required
                        class="w-full border border-stone-200 rounded-xl p-3 text-sm bg-stone-50/50 text-stone-700 focus:outline-none focus:border-[#8A9A86] focus:ring-1 focus:ring-[#8A9A86] transition-all">
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-stone-500 tracking-wider">取引タイプ</label>
                    <select name="type" required
                        class="w-full border border-stone-200 rounded-xl p-3 text-sm bg-stone-50/50 text-stone-700 focus:outline-none focus:border-[#8A9A86] focus:ring-1 focus:ring-[#8A9A86] transition-all">
                        <option value="income">収入</option>
                        <option value="expense">支出</option>
                    </select>
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-semibold text-stone-500 tracking-wider">カテゴリー</label>
                <select name="category" required
                    class="w-full border border-stone-200 rounded-xl p-3 text-sm bg-stone-50/50 text-stone-700 focus:outline-none focus:border-[#8A9A86] focus:ring-1 focus:ring-[#8A9A86] transition-all">
                    <option value="">選択してください</option>
                    @foreach (\App\Models\Transaction::CATEGORIES as $value => $label)
                        <option value="{{ $value }}" @selected(old('category') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-semibold text-stone-500 tracking-wider">金額</label>
                <div class="relative flex items-center">
                    <span class="absolute left-4 text-stone-400 font-medium text-sm">¥</span>
                    <input type="number" name="amount" min="0" value="{{ old('amount') }}" placeholder="0"
                        required
                        class="w-full border border-stone-200 rounded-xl py-3 pl-8 pr-4 text-sm bg-stone-50/50 text-stone-800 font-semibold tracking-wide focus:outline-none focus:border-[#8A9A86] focus:ring-1 focus:ring-[#8A9A86] transition-all">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-semibold text-stone-500 tracking-wider">支払い方法</label>
                <select name="payment_type" id="payment_type" onchange="toggleDueDate()" required
                    class="w-full border border-stone-200 rounded-xl p-3 text-sm bg-stone-50/50 text-stone-700 focus:outline-none focus:border-[#8A9A86] focus:ring-1 focus:ring-[#8A9A86] transition-all">
                    <option value="cash">現金</option>
                    <option value="credit">クレジット</option>
                </select>
            </div>

            <div id="due_date_container" style="display: none;" class="space-y-1.5 transition-all duration-300">
                <label class="text-xs font-semibold text-stone-500 tracking-wider">クレジット引き落とし日</label>
                <input type="date" name="due_date" value="{{ old('due_date') }}"
                    class="w-full border border-stone-200 rounded-xl p-3 text-sm bg-stone-50/50 text-stone-700 focus:outline-none focus:border-[#8A9A86] focus:ring-1 focus:ring-[#8A9A86] transition-all">
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-semibold text-stone-500 tracking-wider">説明</label>
                <input type="text" name="description" value="{{ old('description') }}" placeholder="（例：食費、カフェ代など）"
                    class="w-full border border-stone-200 rounded-xl p-3 text-sm bg-stone-50/50 text-stone-700 placeholder-stone-300 focus:outline-none focus:border-[#8A9A86] focus:ring-1 focus:ring-[#8A9A86] transition-all">
            </div>

            <div class="pt-4 space-y-3">
                <button type="submit"
                    class="w-full py-3 bg-[#8A9A86] text-white text-sm font-semibold rounded-xl shadow-sm hover:bg-[#788874] transition-colors duration-200 tracking-wider">
                    登録する
                </button>

                <div class="text-center">
                    <a href="{{ route('dashboard') }}"
                        class="inline-block text-xs text-stone-400 hover:text-stone-600 transition-colors py-1">
                        ダッシュボードへ戻る
                    </a>
                </div>
            </div>

        </form>
    </div>

    <script>
        function toggleDueDate() {
            const paymentType = document.getElementById('payment_type').value;
            const dueContainer = document.getElementById('due_date_container');
            dueContainer.style.display = (paymentType === 'credit') ? 'block' : 'none';
        }

        document.addEventListener('DOMContentLoaded', toggleDueDate);
    </script>

</div>
