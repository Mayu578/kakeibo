<x-app-layout>

    <div class="max-w-3xl mx-auto py-8 md:py-12 px-4 md:px-0 font-sans antialiased text-stone-700">

        <h1 class="text-xl md:text-2xl font-bold text-stone-800 mb-8 text-center tracking-wide">
            固定費一覧
        </h1>

        <div class="flex justify-center gap-3 mb-8">
            <a href="{{ route('fixed-costs.create') }}"
               class="px-5 py-2.5 bg-[#8A9A86] text-white text-sm font-medium rounded-xl shadow-sm hover:bg-[#788874] transition-colors duration-200">
                ＋ 新規登録
            </a>

            <a href="{{ route('dashboard') }}"
               class="px-5 py-2.5 bg-stone-50 border border-stone-200 text-stone-500 text-sm rounded-xl hover:bg-stone-100 transition-colors">
                戻る
            </a>
        </div>

        <div class="bg-white rounded-2xl md:rounded-3xl shadow-[0_4px_24px_rgba(138,154,134,0.04)] p-4 md:p-6 border border-stone-200/60">
            <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[450px]">
                    <thead>
                        <tr class="text-stone-400 border-b border-stone-200">
                            <th class="py-3 text-left font-normal">口座</th>
                            <th class="py-3 text-left font-normal">名称</th>
                            <th class="py-3 text-right font-normal">金額</th>
                            <th class="py-3 text-center font-normal">引き落とし日</th>
                            <th class="w-20"></th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-stone-100">
                        @foreach ($fixedCosts as $fixedCost)
                            <tr class="hover:bg-stone-50/80 transition-colors">
                                <td class="py-4 text-stone-600">
                                    {{ $fixedCost->account->name }}
                                </td>

                                <td class="py-4 text-stone-800 font-medium">
                                    {{ $fixedCost->name }}
                                </td>

                                <td class="py-4 text-right font-semibold text-stone-800 tracking-wide">
                                    {{ number_format($fixedCost->amount) }} 円
                                </td>

                                <td class="py-4 text-center text-stone-400 text-xs">
                                    {{ $fixedCost->withdrawal_day }} 日
                                </td>

                                <td class="py-4 text-right">
                                    <form action="{{ route('fixed-costs.destroy', $fixedCost) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('本当に削除しますか？')"
                                            class="px-3 py-1 text-xs bg-stone-50 border border-stone-200 text-stone-400 rounded-lg hover:bg-red-50 hover:text-red-500 hover:border-red-100 transition-all">
                                            削除
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>

    </div>

</x-app-layout>