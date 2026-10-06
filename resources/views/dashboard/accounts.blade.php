<!-- 口座残高（Accounts）カード -->
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-stone-100 hover:shadow-md transition duration-200">
                    <div class="p-6">
                        <div class="flex items-center space-x-3 mb-4">
                            <span class="text-2xl">💰</span>
                            <h3 class="text-lg font-bold text-gray-800">口座残高 (Accounts)</h3>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">現在の口座残高の合計と、各口座の内訳を確認できます。</p>

                        <!-- 合計金額を先に、大きく表示 -->
                        <div class="text-3xl font-bold text-gray-900 mb-6">
                            ¥{{ number_format($total) }}
                        </div>

                        @if ($accounts->isEmpty())
                            <p class="text-sm text-gray-400 mb-6">登録されている口座はまだありません</p>
                        @else
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
                        @endif

                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('accounts.create') }}"
                                class="inline-block px-5 py-2.5 bg-[#8A9A86] text-white text-sm font-medium rounded-xl hover:bg-[#788874] transition duration-200 text-center">
                                ＋ 口座新規登録
                            </a>
                            <a href="{{ route('accounts.index') }}"
                                class="inline-block px-5 py-2.5 bg-amber-700 text-sm font-medium rounded-xl hover:bg-amber-800 transition duration-200 text-center">
                                口座一覧を見る
                            </a>
                        </div>
                    </div>
                </div>