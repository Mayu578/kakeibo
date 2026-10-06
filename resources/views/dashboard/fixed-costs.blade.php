<div
                    class="h-full bg-white overflow-hidden shadow-sm sm:rounded-lg border border-stone-100 hover:shadow-md transition duration-200">
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