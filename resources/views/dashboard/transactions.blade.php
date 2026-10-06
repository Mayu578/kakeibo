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
                    <div class="p-6">
                        <div class="flex items-center space-x-3 mb-4">
                            <span class="text-2xl">🏷️</span>
                            <h3 class="text-lg font-bold text-gray-800">カテゴリー別支出</h3>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">{{ $month }} の支出をカテゴリー別に集計しています。</p>

                        @if ($categoryData->isEmpty())
                            <p class="text-sm text-gray-400">この月の支出はまだありません</p>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
                                <!-- 円グラフ -->
                                <div style="max-width: 220px; margin: 0 auto;">
                                    <canvas id="categoryPieChart"></canvas>
                                </div>
                                <!-- 棒グラフ -->
                                <div>
                                    <canvas id="categoryBarChart"></canvas>
                                </div>
                            </div>

                            <ul class="space-y-1 mt-6">
                                @foreach ($categoryData as $label => $amount)
                                    <li class="flex justify-between text-sm border-b pb-1">
                                        <span>{{ $label }}</span>
                                        <span>¥{{ number_format($amount) }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>