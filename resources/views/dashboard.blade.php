<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- ウェルカムメッセージカード -->
            {{-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div> --}}

            <!-- 家計簿メニューエリア -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- 取引（Transactions）カード -->
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-stone-100 hover:shadow-md transition duration-200">
                    <div class="p-6">
                        <div class="flex items-center space-x-3 mb-4">
                            <span class="text-2xl">📊</span>
                            <h3 class="text-lg font-bold text-gray-800">取引管理 (Transactions)</h3>
                        </div>
                        <p class="text-gray-600 text-sm mb-6">日々の収入・支出の記録、編集、月ごとの集計チャートを確認できます。</p>
                        <a href="{{ route('transactions.index') }}"
                            class="inline-block px-5 py-2.5 bg-[#8A9A86] text-white text-sm font-medium rounded-xl hover:bg-[#788874] transition duration-200 text-center">
                            取引一覧を見る
                        </a>
                    </div>
                </div>

                <!-- 固定費（Fixed Costs）カード -->
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-stone-100 hover:shadow-md transition duration-200">
                    <div class="p-6">
                        <div class="flex items-center space-x-3 mb-4">
                            <span class="text-2xl">⏳</span>
                            <h3 class="text-lg font-bold text-gray-800">固定費管理 (Fixed Costs)</h3>
                        </div>
                        <p class="text-gray-600 text-sm mb-6">家賃、保険、サブスクなど、毎月定額で発生する支出の登録・管理を行います。</p>
                        <a href="{{ route('fixed_costs.index') }}"
                            class="inline-block px-5 py-2.5 bg-stone-700 text-white text-sm font-medium rounded-xl hover:bg-stone-800 transition duration-200 text-center">
                            固定費一覧を見る
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
