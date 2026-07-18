<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- 家計簿メニューエリア -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- 口座残高（Accounts）カード -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-stone-100 hover:shadow-md transition duration-200">
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

                <div></div>

                <!-- 取引（Transactions）カード -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-stone-100 hover:shadow-md transition duration-200">
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
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-stone-100 hover:shadow-md transition duration-200">
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
                            labels: { boxWidth: 12, font: { size: 11 } }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>