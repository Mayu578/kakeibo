<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- 家計簿メニューエリア -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                @php
                    $months = collect(range(0, 5))->map(fn($i) => now()->subMonths($i)->format('Y-m'));
                @endphp


                <!-- コメント（Monthly Comments）カード -->
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-stone-100 hover:shadow-md transition duration-200">
                    <div class="p-6">
                        <div class="flex items-center space-x-3 mb-4">
                            <span class="text-2xl">💬</span>
                            <h3 class="text-lg font-bold text-gray-800">コメント (Monthly Comments)</h3>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">月ごとの振り返りメモを確認・投稿できます。</p>

                        <ul class="flex flex-wrap gap-2">
                            @foreach ($months as $m)
                                <li>
                                    <a href="{{ route('monthly-comments.index', $m) }}"
                                        class="inline-block px-3 py-1.5 bg-stone-50 border border-stone-200 text-stone-600 text-sm rounded-lg hover:bg-stone-100 transition duration-200">
                                        {{ $m }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

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
                        <p class="text-gray-600 text-sm mb-4">家賃、保険、サブスクなど、毎月定額で発生する支出の登録・管理を行います。</p>

                        <!-- サマリー3項目 -->
                        <div class="grid grid-cols-3 gap-3 mb-4">
                            <div class="bg-stone-50 rounded-lg p-3">
                                <p class="text-xs text-gray-500 mb-1">月間合計</p>
                                <p class="text-lg font-bold text-gray-900">¥{{ number_format($totalFixedCost) }}</p>
                            </div>
                            <div class="bg-stone-50 rounded-lg p-3">
                                <p class="text-xs text-gray-500 mb-1">件数</p>
                                <p class="text-lg font-bold text-gray-900">{{ $fixedCostsCount }}件</p>
                            </div>
                            <div class="bg-stone-50 rounded-lg p-3">
                                <p class="text-xs text-gray-500 mb-1">次回引落</p>
                                <p class="text-lg font-bold text-gray-900">
                                    {{ $nextWithdrawalDay ? $nextWithdrawalDay . '日' : '-' }}
                                </p>
                            </div>
                        </div>

                        <!-- 品目一覧（金額が大きい順に上位3件） -->
                        <ul class="space-y-1 mb-6">
                            @forelse ($fixedCosts->sortByDesc('amount')->take(3) as $fixedCost)
                                <li class="flex justify-between text-sm border-b pb-1">
                                    <span>{{ $fixedCost->name }}</span>
                                    <span>¥{{ number_format($fixedCost->amount) }}</span>
                                </li>
                            @empty
                                <li class="text-sm text-gray-400">登録されている固定費はありません</li>
                            @endforelse
                            @if ($fixedCostsCount > 3)
                                <li class="text-xs text-gray-400 text-right">他 {{ $fixedCostsCount - 3 }} 件</li>
                            @endif
                        </ul>

                        <a href="{{ route('fixed_costs.index') }}"
                            class="inline-block px-5 py-2.5 bg-stone-700 text-white text-sm font-medium rounded-xl hover:bg-stone-800 transition duration-200 text-center">
                            固定費一覧を見る
                        </a>
                    </div>
                </div>

                <!-- 口座残高（Accounts）カード -->
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-stone-100 hover:shadow-md transition duration-200">
                    <div class="p-6">
                        <div class="flex items-center space-x-3 mb-4">
                            <span class="text-2xl">💰</span>
                            <h3 class="text-lg font-bold text-gray-800">口座残高 (Accounts)</h3>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">現在の口座残高の合計と、各口座の内訳を確認できます。</p>

                        <div class="text-3xl font-bold text-gray-900 mb-4">
                            ¥{{ number_format($total) }}
                        </div>

                        <!-- 円グラフ -->
                        <div class="mb-6" style="max-width: 260px; margin-left: auto; margin-right: auto;">
                            <canvas id="accountsPieChart"></canvas>
                        </div>

                        <ul class="space-y-1 mb-6">
                            @foreach ($accounts as $account)
                                <li class="flex justify-between text-sm border-b pb-1">
                                    <span>{{ $account->name }}</span>
                                    <span>¥{{ number_format($account->balance) }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <a href="{{ route('accounts.index') }}"
                            class="inline-block px-5 py-2.5 bg-amber-700 text-white text-sm font-medium rounded-xl hover:bg-amber-800 transition duration-200 text-center">
                            口座一覧を見る
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('accountsPieChart');
            if (!ctx) return;

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: [
                        @foreach ($accounts as $account)
                            "{{ $account->name }}",
                        @endforeach
                    ],
                    datasets: [{
                        data: [
                            @foreach ($accounts as $account)
                                {{ $account->balance }},
                            @endforeach
                        ],
                        backgroundColor: [
                            '#8A9A86', '#D4A574', '#7B8CA3', '#C4785C',
                            '#A68DAD', '#6B9080', '#B08968', '#5C7A99'
                        ],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>