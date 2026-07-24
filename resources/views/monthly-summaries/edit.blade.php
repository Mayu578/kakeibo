<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-stone-100">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <span class="text-2xl">✏️</span>
                            <h3 class="text-lg font-bold text-gray-800">{{ $monthlyComment->month }} のコメントを編集</h3>
                        </div>
                        <a href="{{ route('monthly-comments.index', $monthlyComment->month) }}"
                            class="inline-block px-5 py-2.5 bg-stone-50 border border-stone-200 text-stone-500 text-sm font-medium rounded-xl hover:bg-stone-100 transition duration-200 text-center">
                            一覧へ戻る
                        </a>
                    </div>

                    <form method="POST" action="{{ route('monthly-comments.updateComment', $monthlyComment) }}">
                        @csrf
                        @method('PATCH')
                        <textarea name="comment" rows="4"
                            class="w-full border border-stone-200 rounded-lg p-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#8A9A86] focus:border-transparent">{{ old('comment', $monthlyComment->comment) }}</textarea>
                        @error('comment')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
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