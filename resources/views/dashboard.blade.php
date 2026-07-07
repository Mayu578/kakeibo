<x-app-layout>

    <div
        class="max-w-5xl mx-auto py-6 md:py-12 px-4 md:px-0 space-y-10 md:space-y-16 font-sans antialiased text-stone-700">

        <section>
            <div
                class="max-w-3xl mx-auto my-4 md:my-8 bg-white p-4 md:p-8 rounded-2xl md:rounded-3xl shadow-[0_4px_24px_rgba(138,154,134,0.06)] border border-stone-200/60">

                <div class="flex justify-between items-center mb-6 md:mb-8">
                    <h2 class="text-base md:text-lg font-bold tracking-wide text-stone-800">口座一覧</h2>
                    <a href="{{ route('accounts.create') }}"
                        class="px-5 py-2 text-xs md:text-sm bg-[#8A9A86] text-white font-medium rounded-xl hover:bg-[#788874] shadow-sm transition-colors duration-200">
                        ＋ 口座登録
                    </a>
                </div>

                <div class="overflow-x-auto -mx-4 px-4 md:mx-0 md:px-0">
                    <table class="w-full text-sm min-w-[300px]">
                        <thead>
                            <tr class="border-b border-stone-200 text-stone-400 font-medium">
                                <th class="py-3 text-left font-normal">口座名</th>
                                <th class="py-3 text-right font-normal">残高</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-stone-100">
                            @foreach ($accounts as $account)
                                <tr class="hover:bg-stone-50/80 transition-colors">
                                    <td class="py-4 text-stone-700">
                                        {{ $account->name }}
                                    </td>
                                    <td class="py-4 text-right font-semibold text-stone-800 tracking-wide">
                                        ¥{{ number_format($account->balance) }}
                                    </td>
                                    <td class="py-4 text-right">
                                        <a href="{{ route('accounts.editBalance', $account) }}"
                                            class="px-3 py-1 text-xs bg-stone-100 text-stone-600 rounded-lg hover:bg-stone-200 transition-colors">
                                            編集
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('accounts.destroy', $account->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1 text-xs bg-stone-100 text-stone-600 rounded-lg hover:bg-stone-200 transition-colors"
                                                onclick="return confirm('本当に削除しますか？')">削除</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr class="border-t-2 border-stone-200">
                                <th class="py-4 text-left text-stone-500 font-medium">合計</th>
                                <th class="py-4 text-right font-bold text-stone-800 tracking-wide">
                                    ¥{{ number_format($total) }}</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </section>


        <section>
            <h2 class="text-base md:text-lg text-stone-800 mb-6 text-center font-bold tracking-wide">
                今月の取引一覧
            </h2>

            <div class="grid grid-cols-2 md:flex md:justify-center gap-3 mb-8">
                <a href="{{ route('transactions.create') }}"
                    class="col-span-2 md:col-span-1 text-center px-5 py-2.5 bg-[#8A9A86] text-white rounded-xl shadow-sm hover:bg-[#788874] transition-colors text-sm font-medium">
                    + 取引登録
                </a>
                <a href="{{ route('fixed-costs.create') }}"
                    class="text-center px-5 py-2.5 bg-stone-100 text-stone-700 rounded-xl hover:bg-stone-200 transition-colors text-sm font-medium">
                    + 固定費登録
                </a>
                <a href="{{ route('transactions.index') }}"
                    class="text-center px-5 py-2.5 bg-stone-50 border border-stone-200 text-stone-500 rounded-xl hover:bg-stone-100 transition-colors text-sm">
                    取引確認
                </a>
            </div>

            <div
                class="bg-white rounded-2xl md:rounded-3xl shadow-[0_4px_24px_rgba(138,154,134,0.04)] p-4 md:p-6 border border-stone-200/60">
                <form method="GET" class="text-center mb-6 flex justify-center items-center gap-2">
                    <input type="month" name="month" value="{{ $month }}"
                        class="border border-stone-200 rounded-xl p-2 text-sm bg-stone-50 text-stone-700 focus:outline-none focus:border-[#8A9A86] focus:ring-1 focus:ring-[#8A9A86]">
                    <button
                        class="px-5 py-2 bg-stone-800 text-white text-sm rounded-xl hover:bg-stone-700 transition-colors">
                        表示
                    </button>
                </form>

                <div class="overflow-x-auto -mx-4 px-4 md:mx-0 md:px-0">
                    <table class="w-full text-sm min-w-[500px]">
                        <thead>
                            <tr class="border-b border-stone-200 text-stone-400 font-normal">
                                <th class="py-3 text-left font-normal">日付</th>
                                <th class="py-3 text-left font-normal">口座</th>
                                <th class="py-3 text-left font-normal">内容</th>
                                <th class="py-3 text-right font-normal">金額</th>
                                <th class="w-24"></th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-stone-100">
                            @foreach ($transactions as $transaction)
                                <tr class="hover:bg-stone-50/80 transition-colors">
                                    <td class="py-4 text-stone-400 text-xs whitespace-nowrap">
                                        {{ $transaction->transaction_date }}
                                    </td>
                                    <td class="py-4 text-stone-600 whitespace-nowrap">
                                        {{ $transaction->fixedCost ? $transaction->fixedCost->account->name : $transaction->account->name }}
                                    </td>
                                    <td class="py-4 text-stone-700">
                                        {{ $transaction->description }}
                                    </td>
                                    <td class="py-4 text-right font-semibold whitespace-nowrap tracking-wide">
                                        @if ($transaction->type === 'income')
                                            <span
                                                class="text-[#6B8E6A]">+¥{{ number_format($transaction->amount) }}</span>
                                        @else
                                            <span
                                                class="text-[#C87A53]">-¥{{ number_format($transaction->amount) }}</span>
                                        @endif
                                    </td>
                                    <td class="py-2 text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a href="{{ route('transactions.edit', $transaction) }}"
                                                class="px-2.5 py-1 text-xs bg-stone-100 text-stone-600 rounded-lg hover:bg-stone-200 inline-block transition-colors">
                                                編集
                                            </a>
                                            <form action="{{ route('transactions.destroy', $transaction) }}"
                                                method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('本当に削除しますか？')"
                                                    class="px-2.5 py-1 text-xs bg-stone-50 border border-stone-200 text-stone-400 rounded-lg hover:bg-red-50 hover:text-red-500 hover:border-red-100 transition-all">
                                                    削除
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>


        <section class="max-w-3xl mx-auto">
            <div
                class="p-6 rounded-2xl space-y-2 text-sm text-stone-700 shadow-[0_4px_20px_rgba(0,0,0,0.02)] border border-stone-200/80 bg-[#FBF9F6]">
                <h3 class="font-bold text-stone-800 text-base mb-4 border-b border-stone-200 pb-2 tracking-wide">今月の集計
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <p class="flex items-center gap-1.5 text-stone-600">🏠 毎月の固定費合計：<span
                            class="font-semibold text-stone-800">{{ number_format($totalFixedCost) }} 円</span></p>
                    <p class="flex items-center gap-1.5 text-stone-600">💰 収入：<span
                            class="font-semibold text-[#6B8E6A]">{{ number_format($totalIncome) }} 円</span></p>
                    <p class="flex items-center gap-1.5 text-stone-600">💸 支出：<span
                            class="font-semibold text-[#C87A53]">{{ number_format($totalExpense) }} 円</span></p>

                    <p class="sm:col-span-2 text-base font-bold border-t border-dashed border-stone-300 pt-4 mt-2">
                        📊 差額：<span
                            class="{{ $balance >= 0 ? 'text-[#6B8E6A]' : 'text-[#C87A53]' }}">{{ number_format($balance) }}
                            円</span>
                    </p>
                </div>
            </div>

            <section class="max-w-3xl mx-auto">
                <div class="mt-6">
                    <canvas id="myChart" class="max-h-64 w-full"></canvas>
                </div>
            </section>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                const ctx = document.getElementById('myChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['1月', '2月', '3月', '4月', '5月', '6月','7月'], // 月のラベル
                        datasets: [{
                            label: '資産推移 (円)',
                            data: [2000000, 2050000, 2080000, 2095000, 2105000, 2112282,2106647], // ここを実際の数値に！
                            borderColor: '#8A9A86', // あなたのサイトのテーマカラーに合わせました
                            tension: 0.3
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            </script>
        </section>


        <section>
            <div
                class="max-w-3xl mx-auto bg-white rounded-2xl md:rounded-3xl shadow-[0_4px_24px_rgba(138,154,134,0.04)] p-4 md:p-6 border border-stone-200/60">
                <div class="mb-6">
                    <h3 class="text-base md:text-lg font-bold mb-4 flex items-center gap-2 text-[#8A9A86]">
                        📝 <span>今月の感想</span>
                    </h3>
                    <div class="space-y-3">
                        @foreach ($comments as $comment)
                            <div
                                class="flex items-center justify-between bg-stone-50/80 p-3.5 rounded-xl gap-4 border border-stone-100">
                                <p class="text-sm text-stone-700 leading-relaxed">{{ $comment->comment }}</p>
                                <form action="/comment/delete" method="POST"
                                    onsubmit="return confirm('本当にこの感想を削除しますか？');" class="flex-shrink-0">
                                    <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                    @csrf
                                    <button type="submit"
                                        class="px-3 py-1 text-xs bg-stone-200/60 text-stone-500 rounded-lg hover:bg-red-50 hover:text-red-500 transition-colors">
                                        削除
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>

                @if (session('success'))
                    <p class="text-[#6B8E6A] text-sm mb-3 font-medium">
                        {{ session('success') }}
                    </p>
                @endif

                <form method="POST" action="{{ route('dashboard.comment') }}" class="w-full space-y-4">
                    @csrf
                    <input type="hidden" name="month" value="{{ $month }}">

                    <textarea name="comment" rows="3" placeholder="今月の振り返りを記入しましょう"
                        class="w-full border border-stone-200 focus:border-[#8A9A86] focus:ring-1 focus:ring-[#8A9A86] focus:outline-none rounded-xl p-3 text-sm bg-stone-50/40 text-stone-700 placeholder-stone-400"></textarea>

                    <div class="text-right">
                        <button
                            class="px-6 py-2 bg-[#8A9A86] text-white text-sm font-medium rounded-xl hover:bg-[#788874] shadow-sm transition-colors duration-200">
                            保存する
                        </button>
                    </div>
                </form>
            </div>
        </section>

    </div>

</x-app-layout>
