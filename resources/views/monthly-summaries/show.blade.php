<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- コメント一覧カード -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-stone-100">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <span class="text-2xl">💬</span>
                            <h3 class="text-lg font-bold text-gray-800">{{ $month }} のコメント</h3>
                        </div>
                        <a href="{{ route('dashboard') }}"
                            class="inline-block px-5 py-2.5 bg-stone-50 border border-stone-200 text-stone-500 text-sm font-medium rounded-xl hover:bg-stone-100 transition duration-200 text-center">
                            ダッシュボードへ
                        </a>
                    </div>

                    <p class="text-gray-600 text-sm mb-6">この月に投稿された振り返りメモの一覧です。</p>

                    <ul class="space-y-3 mb-8">
                        @forelse ($comments as $comment)
                            <li class="bg-stone-50 rounded-lg p-4 border border-stone-100">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="text-xs text-gray-500">
                                        {{ $comment->user->name }} - {{ $comment->created_at->format('Y/m/d H:i') }}
                                    </p>
                                    @can('delete', $comment)
                                        <form method="POST" action="{{ route('monthly-comments.destroy', $comment) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-xs text-red-500 hover:text-red-700 transition duration-200">
                                                削除
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                                <p class="text-sm text-gray-800 whitespace-pre-wrap">{{ $comment->comment }}</p>
                            </li>
                        @empty
                            <li class="text-sm text-gray-400">この月のコメントはまだありません</li>
                        @endforelse
                    </ul>

                    <!-- 投稿フォーム -->
                    <div class="border-t border-stone-100 pt-6">
                        <form method="POST" action="{{ route('monthly-comments.store', $month) }}">
                            @csrf
                            <textarea name="comment" rows="3"
                                class="w-full border border-stone-200 rounded-lg p-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#8A9A86] focus:border-transparent"
                                placeholder="今月の振り返りをメモ"></textarea>
                            @error('comment')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <button type="submit"
                                class="inline-block mt-3 px-5 py-2.5 bg-[#8A9A86] text-white text-sm font-medium rounded-xl hover:bg-[#788874] transition duration-200 text-center">
                                投稿する
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>