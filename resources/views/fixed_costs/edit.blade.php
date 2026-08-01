<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-stone-100">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <span class="text-2xl">✏️</span>
                            <h3 class="text-lg font-bold text-gray-800">固定費の編集</h3>
                        </div>
                        <a href="{{ route('fixed_costs.index') }}"
                            class="inline-block px-5 py-2.5 bg-stone-50 border border-stone-200 text-stone-500 text-sm font-medium rounded-xl hover:bg-stone-100 transition duration-200 text-center">
                            一覧へ戻る
                        </a>
                    </div>

                    <form method="POST" action="{{ route('fixed_costs.update', $fixed_cost) }}">
                        @csrf
                        @method('PATCH')
                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-stone-500 tracking-wider">引き落とし口座</label>
                            <select name="account_id" required
                                class="w-full border border-stone-200 rounded-xl p-3 text-sm bg-stone-50/50 text-stone-700 focus:outline-none focus:border-[#8A9A86] focus:ring-1 focus:ring-[#8A9A86] transition-all">
                                @foreach ($accounts as $account)
                                    <option value="{{ $account->id }}" @selected(old('account_id', $fixed_cost->account_id) == $account->id)>
                                        {{ $account->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-stone-500 tracking-wider">固定費の名称</label>
                            <input type="text" name="name" value="{{ old('name', $fixed_cost->name) }}"
                                placeholder="（例：家賃、光熱費、サブスクなど）" required
                                class="w-full border border-stone-200 rounded-xl p-3 text-sm bg-stone-50/50 text-stone-700 placeholder-stone-300 focus:outline-none focus:border-[#8A9A86] focus:ring-1 focus:ring-[#8A9A86] transition-all">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="text-xs font-semibold text-stone-500 tracking-wider">金額</label>
                                <div class="relative flex items-center">
                                    <span class="absolute left-4 text-stone-400 font-medium text-sm">¥</span>
                                    <input type="number" name="amount"
                                        value="{{ old('amount', $fixed_cost->amount) }}" placeholder="0" min="0"
                                        required
                                        class="w-full border border-stone-200 rounded-xl py-3 pl-8 pr-4 text-sm bg-stone-50/50 text-stone-800 font-semibold tracking-wide focus:outline-none focus:border-[#8A9A86] focus:ring-1 focus:ring-[#8A9A86] transition-all">
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-xs font-semibold text-stone-500 tracking-wider">引き落とし日</label>
                                <div class="relative flex items-center">
                                    <input type="number" name="withdrawal_day" min="1" max="31"
                                        value="{{ old('withdrawal_day', $fixed_cost->withdrawal_day) }}"
                                        placeholder="27" required
                                        class="w-full border border-stone-200 rounded-xl py-3 pl-4 pr-8 text-sm bg-stone-50/50 text-stone-700 text-center focus:outline-none focus:border-[#8A9A86] focus:ring-1 focus:ring-[#8A9A86] transition-all">
                                    <span class="absolute right-4 text-stone-400 text-xs">日</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-stone-500 tracking-wider">終了日（任意）</label>
                            <input type="date" name="end_date"
                                value="{{ old('end_date', optional($fixed_cost->end_date)->format('Y-m-d')) }}"
                                class="w-full border border-stone-200 rounded-xl p-3 text-sm bg-stone-50/50 text-stone-700 focus:outline-none focus:border-[#8A9A86] focus:ring-1 focus:ring-[#8A9A86] transition-all">
                        </div>

                        <button type="submit"
                            class="inline-block mt-3 px-5 py-2.5 bg-[#8A9A86] text-white text-sm font-medium rounded-xl hover:bg-[#788874] transition duration-200 text-center">
                            更新する
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
