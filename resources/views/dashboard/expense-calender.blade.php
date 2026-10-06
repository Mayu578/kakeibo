<!-- 支出カレンダー -->

<div class="md:col-span-2">

    <div  class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-stone-100 hover:shadow-md transition duration-200">
        <div class="p-6">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center space-x-3">
                    <span class="text-2xl">📅</span>
                    <h3 class="text-lg font-bold text-gray-800">
                        支出カレンダー
                    </h3>
                </div>
                <!-- 月切替 -->
                <div class="flex items-center gap-2">
                    <a href="?month={{ \Carbon\Carbon::parse($month)->subMonth()->format('Y-m') }}"
                        class="px-3 py-1 bg-stone-100 rounded-lg hover:bg-stone-200">
                        ←
                    </a>
                    <span class="font-bold text-sm">
                        {{ $month }}
                    </span>

                    <a href="?month={{ \Carbon\Carbon::parse($month)->addMonth()->format('Y-m') }}"
                        class="px-3 py-1 bg-stone-100 rounded-lg hover:bg-stone-200">
                        →
                    </a>
                </div>
            </div>

            <!-- 曜日 -->
            <div class="grid grid-cols-7 gap-2 mb-2 text-center text-xs text-gray-500">

                <div>日</div>
                <div>月</div>
                <div>火</div>
                <div>水</div>
                <div>木</div>
                <div>金</div>
                <div>土</div>

            </div>

            @php
                $firstDay = \Carbon\Carbon::parse($month . '-01')->dayOfWeek;
            @endphp

            <!-- 月初空白 -->

            @for ($i = 0; $i < $firstDay; $i++)
                <div></div>
            @endfor

            @foreach ($calendar as $day)
                <div class=" border rounded-xl  p-3 min-h-[130px] bg-stone-50 hover:bg-stone-100 transition">
                    <div class="font-bold text-sm mb-3">
                        {{ \Carbon\Carbon::parse($day['date'])->day }}日
                    </div>

                    @forelse($day['expenses'] as $category=>$amount)
                        <div class="text-xs mb-2">
                            <div class="text-gray-600">
                                {{ $category }}
                            </div>
                            <div class="font-bold">
                                ¥{{ number_format($amount) }}
                            </div>
                        </div>
                    @empty
                        <div class="text-xs text-gray-300">
                            -
                        </div>
                    @endforelse
                </div>
            @endforeach
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

        @php
            $categoryLabelsJson = $categoryData->keys();
            $categoryAmountsJson = $categoryData->values();
        @endphp
        const categoryLabels = @json($categoryLabelsJson);
        const categoryAmounts = @json($categoryAmountsJson);

        const categoryColors = [
            '#C87A53', '#8A9A86', '#7B8CA3', '#D4A574',
            '#A68DAD', '#6B9080', '#E0A96D', '#9C8AA5'
        ];
        const pieCtx = document.getElementById('categoryPieChart');
        if (pieCtx) {
            new Chart(pieCtx, {
                type: 'pie',
                data: {
                    labels: categoryLabels,
                    datasets: [{
                        data: categoryAmounts,
                        backgroundColor: categoryColors,
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
        }

        const barCtx = document.getElementById('categoryBarChart');
        if (barCtx) {
            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: categoryLabels,
                    datasets: [{
                        label: '支出額',
                        data: categoryAmounts,
                        backgroundColor: categoryColors,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: (value) => '¥' + value.toLocaleString()
                            }
                        }
                    }
                }
            });
        }
    });
</script>
