<x-app-layout>
    <div class="max-w-3xl mx-auto py-12 px-4">

        <div class="mb-8">
            <h1 class="text-2xl font-bold text-stone-800 tracking-tight">口座登録</h1>
            <p class="text-stone-500 text-sm mt-1">新しい口座情報を追加します</p>
        </div>

        <div
            class="bg-white p-6 md:p-8 rounded-3xl shadow-[0_4px_24px_rgba(138,154,134,0.06)] border border-stone-200/60">
            <form action="{{ route('accounts.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-stone-600 mb-2">口座名</label>
                    <input type="text" name="name" required placeholder="例：楽天銀行"
                        class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:border-[#8A9A86] focus:ring-1 focus:ring-[#8A9A86] outline-none transition-all bg-stone-50/50">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-stone-600 mb-2">口座の種類</label>
                    <select name="type" required
                        class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:border-[#8A9A86] focus:ring-1 focus:ring-[#8A9A86] outline-none transition-all bg-stone-50/50">
                        <option value="bank">銀行</option>
                        <option value="cash">現金</option>
                        <option value="credit">クレジットカード</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-stone-600 mb-2">初期残高</label>
                    <input type="number" name="balance" step="0.01" required placeholder="0"
                        class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:border-[#8A9A86] focus:ring-1 focus:ring-[#8A9A86] outline-none transition-all bg-stone-50/50">
                </div>

                <div class="pt-4 flex items-center gap-3">
                    <button type="submit"
                        class="flex-1 md:flex-none px-8 py-3 bg-[#8A9A86] text-white font-medium rounded-xl hover:bg-[#788874] shadow-sm transition-colors duration-200">
                        登録する
                    </button>
                    <a href="{{ route('dashboard') }}"
                        class="px-6 py-3 text-stone-500 font-medium rounded-xl hover:bg-stone-100 transition-colors">
                        キャンセル
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
