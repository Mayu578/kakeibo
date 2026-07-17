<x-app-layout>
    
<div class="max-w-3xl mx-auto py-8 md:py-12 px-4 md:px-0 font-sans antialiased text-stone-700" style="font-family: 'Poppins', 'Noto Sans JP', sans-serif;">

    <h1 class="text-xl md:text-2xl font-bold text-stone-800 mb-8 text-center tracking-wide">
        口座・取引一覧
    </h1>

    <div class="flex flex-wrap justify-center gap-3 mb-8">
        <a href="{{route('accounts.create')}}" class="px-5 py-2.5 bg-[#8A9A86] text-white text-sm font-medium rounded-xl shadow-sm hover:bg-[#788874] transition-colors duration-200">
            + 口座新規登録
        </a>

        <a href="{{route('fixed_costs.index')}}" class="px-5 py-2.5 bg-stone-100 border border-stone-200 text-stone-600 text-sm rounded-xl hover:bg-stone-200 transition-colors">
            固定費の確認
        </a>

        <a href="{{route('dashboard')}}" class="px-5 py-2.5 bg-stone-50 border border-stone-200 text-stone-500 text-sm rounded-xl hover:bg-stone-100 transition-colors">
            ダッシュボード
        </a>
    </div>

    <div class="bg-white rounded-2xl md:rounded-3xl shadow-[0_4px_24px_rgba(138,154,134,0.04)] p-4 md:p-6 border border-stone-200/60">
        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[400px]">
                <thead>
                    <tr class="text-stone-400 border-b border-stone-200">
                        <th class="py-3 text-left font-normal pl-4">口座名</th>
                        <th class="py-3 text-right font-normal pr-12">残高</th>
                        <th class="w-24"></th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-stone-100">
                    @foreach ($accounts as $account)
                    <tr class="hover:bg-stone-50/80 transition-colors">
                        <td class="py-4 text-stone-700 font-medium pl-4">
                            {{ $account->name }}
                        </td>
                        <td class="py-4 text-right font-semibold text-stone-800 tracking-wide pr-12">
                            {{ number_format($account->balance) }} 円
                        </td>
                        <td class="py-4 text-right pr-2">
                            <a href="{{ route('accounts.editBalance', $account) }}" class="px-3 py-1 text-xs bg-stone-100 text-stone-600 rounded-lg hover:bg-stone-200 transition-colors inline-block">
                                編集
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr class="border-t-2 border-stone-200 font-bold text-stone-800">
                        <th class="py-4 text-left font-bold pl-4">合計</th>
                        <th class="py-4 text-right font-bold tracking-wide pr-12">{{ number_format($total) }} 円</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>

</x-app-layout>