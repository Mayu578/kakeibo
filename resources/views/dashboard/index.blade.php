<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- 家計簿メニューエリア -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                @php
                    $months = collect(range(0, 5))->map(fn($i) => now()->subMonths($i)->format('Y-m'));
                @endphp
                <div>
                    @include('dashboard.monthly-comments')
                </div>
                <div>
                    @include('dashboard.transactions')
                </div>

                <div>
                    @include('dashboard.fixed-costs')
                </div>
                <div>
                    @include('dashboard.accounts')
                </div>
                <div class="md:col-span-2">
                    @include('dashboard.expense-calender')
                </div>
            </div>
        </div>
</x-app-layout>
