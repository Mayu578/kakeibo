<x-app-layout>

    <div class="max-w-4xl mx-auto py-8 md:py-12 px-4 md:px-0 font-sans antialiased text-stone-700">

        <h1 class="text-xl md:text-2xl font-bold text-stone-800 text-center mb-8 tracking-wide">
            取引一覧
        </h1>

        <div class="flex flex-wrap justify-center gap-3 mb-8">
            <a href="{{ route('transactions.create') }}"
                class="px-5 py-2.5 bg-[#8A9A86] text-white text-sm font-medium rounded-xl shadow-sm hover:bg-[#788874] transition-colors duration-200">
                ＋ 新規取引
            </a>

            <a href="{{ route('accounts.index') }}"
                class="px-5 py-2.5 bg-stone-100 border border-stone-200 text-stone-600 text-sm rounded-xl hover:bg-stone-200 transition-colors">
                口座一覧へ戻る
            </a>

            <a href="{{ route('dashboard') }}"
                class="px-5 py-2.5 bg-stone-50 border border-stone-200 text-stone-500 text-sm rounded-xl hover:bg-stone-100 transition-colors">
                ダッシュボード
            </a>
        </div>

        <div class="max-w-md mx-auto mb-8 bg-stone-50 border border-stone-200/80 rounded-2xl p-4">
            <form method="GET" class="flex justify-center items-center gap-2 mb-3">
                <input type="month" name="month" value="{{ $month }}"
                    class="border border-stone-200 rounded-xl p-2 text-sm bg-white text-stone-700 focus:outline-none focus:border-[#8A9A86] focus:ring-1 focus:ring-[#8A9A86]">

                <button
                    class="px-4 py-2 bg-stone-800 text-white text-sm rounded-xl hover:bg-stone-700 transition-colors">
                    表示
                </button>
            </form>

            <div class="flex justify-between items-center px-2 text-xs font-medium text-stone-400">
                <a href="?month={{ \Carbon\Carbon::parse($month)->subMonth()->format('Y-m') }}"
                    class="hover:text-stone-600 transition-colors flex items-center gap-1">← 前月</a>
                <span
                    class="text-stone-500 font-semibold text-sm">{{ \Carbon\Carbon::parse($month)->format('Y年m月') }}</span>
                <a href="?month={{ \Carbon\Carbon::parse($month)->addMonth()->format('Y-m') }}"
                    class="hover:text-stone-600 transition-colors flex items-center gap-1">次月 →</a>
            </div>
        </div>

        <!-- まとめボードエリア -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">

            <!-- 変動費（今月の取引合計） -->
            <div class="bg-white rounded-2xl p-5 border border-stone-200/60 shadow-[0_4px_20px_rgba(0,0,0,0.02)]">
                <span class="text-xs text-stone-400 font-medium block mb-1">今月の変動費</span>
                <span class="text-xl font-bold text-stone-800">
                    {{ number_format($totalExpenses) }} <span class="text-xs font-normal text-stone-500">円</span>
                </span>
            </div>

            <!-- 固定費合計 -->
            <div class="bg-white rounded-2xl p-5 border border-stone-200/60 shadow-[0_4px_20px_rgba(0,0,0,0.02)]">
                <span class="text-xs text-stone-400 font-medium block mb-1">毎月の固定費</span>
                <span class="text-xl font-bold text-stone-800">
                    {{ number_format($fixedCostsTotal) }} <span class="text-xs font-normal text-stone-500">円</span>
                </span>
            </div>

            <!-- 差額（合計支出） -->
            <div
                class="bg-[#8A9A86]/10 rounded-2xl p-5 border border-[#8A9A86]/20 shadow-[0_4px_20px_rgba(138,154,134,0.02)]">
                <span class="text-xs text-[#6B7B67] font-medium block mb-1">総支出（変動費 ＋ 固定費）</span>
                <span class="text-xl font-bold text-[#6B7B67]">
                    {{ number_format($totalExpenses + $fixedCostsTotal) }} <span
                        class="text-xs font-normal text-stone-600">円</span>
                </span>
            </div>

        </div>

        <div
            class="bg-white rounded-2xl md:rounded-3xl shadow-[0_4px_24px_rgba(138,154,134,0.04)] p-4 md:p-6 border border-stone-200/60">
            <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[600px]">
                    <thead>
                        <tr class="text-stone-400 border-b border-stone-200">
                            <th class="py-3 text-left font-normal">日付</th>
                            <th class="py-3 text-left font-normal">口座</th>
                            <th class="py-3 text-center font-normal">種別</th>
                            <th class="py-3 text-center font-normal">カテゴリー</th>
                            <th class="py-3 text-right font-normal">金額</th>
                            <th class="py-3 text-left font-normal pl-4">内容</th>
                            <th class="py-3 text-center font-normal">反映日</th>
                            <th class="w-20"></th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-stone-100">
                        @foreach ($transactions as $transaction)
                            <tr class="hover:bg-stone-50/80 transition-colors">
                                <td class="py-4 text-stone-400 text-xs whitespace-nowrap">
                                    {{ $transaction->transaction_date }}
                                </td>

                                <td class="py-4 text-stone-600 whitespace-nowrap">
                                    {{ $transaction->account->name }}
                                </td>

                                <td class="py-4 text-center whitespace-nowrap">
                                    @if ($transaction->type === 'income')
                                        <span
                                            class="px-2.5 py-0.5 text-xs bg-stone-100 text-[#6B8E6A] rounded-md font-medium border border-[#6B8E6A]/20">
                                            収入
                                        </span>
                                    @else
                                        <span
                                            class="px-2.5 py-0.5 text-xs bg-stone-50 text-[#C87A53] rounded-md font-medium border border-[#C87A53]/10">
                                            支出
                                        </span>
                                    @endif
                                </td>

                                <td class="py-4 text-center whitespace-nowrap">
                                    <span
                                        class="px-2.5 py-0.5 text-xs bg-stone-50 text-stone-500 rounded-md font-medium border border-stone-200">
                                        {{ $transaction->category_label }}
                                    </span>
                                </td>

                                <td class="py-4 text-right font-semibold whitespace-nowrap tracking-wide">
                                    @if ($transaction->type === 'income')
                                        <span class="text-[#6B8E6A]">
                                            +¥{{ number_format($transaction->amount) }}
                                        </span>
                                    @else
                                        <span class="text-[#C87A53]">
                                            -¥{{ number_format($transaction->amount) }}
                                        </span>
                                    @endif
                                </td>

                                <td class="py-4 text-stone-800 pl-4">
                                    {{ $transaction->description }}
                                </td>

                                <td class="py-4 text-center text-stone-400 text-xs whitespace-nowrap">
                                    {{ $transaction->reflect_date }}
                                </td>

                                <td class="py-4 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('transactions.edit', $transaction) }}"
                                            class="px-3 py-1 text-xs bg-stone-50 border border-stone-200 text-stone-500 rounded-lg hover:bg-stone-100 transition-all inline-block">
                                            編集
                                        </a>
                                        <form action="{{ route('transactions.destroy', $transaction) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('本当に削除しますか？')"
                                                class="px-3 py-1 text-xs bg-stone-50 border border-stone-200 text-stone-400 rounded-lg hover:bg-red-50 hover:text-red-500 hover:border-red-100 transition-all">
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

    </div>

</x-app-layout>
