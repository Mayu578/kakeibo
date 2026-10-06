 <!-- コメント（Monthly Comments）カード -->
                <div
                    class="h-full bg-white overflow-hidden shadow-sm sm:rounded-lg border border-stone-100 hover:shadow-md transition duration-200">
                    <div class="p-6">
                        <div class="flex items-center space-x-3 mb-4">
                            <span class="text-2xl">💬</span>
                            <h3 class="text-lg font-bold text-gray-800">コメント (Monthly Comments)</h3>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">月ごとの振り返りメモを確認・投稿できます。</p>

                        <ul class="flex flex-wrap gap-2 mb-6">
                            @foreach ($months as $m)
                                <li>
                                    <a href="{{ route('monthly-comments.index', $m) }}"
                                        class="inline-block px-3 py-1.5 bg-stone-50 border border-stone-200 text-stone-600 text-sm rounded-lg hover:bg-stone-100 transition duration-200">
                                        {{ $m }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <!-- 今月の直近コメントをプレビュー -->
                        <div class="border-t border-stone-100 pt-4">
                            <p class="text-xs text-stone-400 mb-2">{{ $month }} の最新メモ</p>
                            @forelse ($comments->take(6) as $comment)
                                <div class="bg-stone-50 rounded-lg p-3 mb-2 text-sm text-gray-700">
                                    <p class="whitespace-pre-wrap">{{ Str::limit($comment->comment, 60) }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $comment->created_at->format('m/d H:i') }}
                                    </p>
                                </div>
                            @empty
                                <p class="text-sm text-gray-400">この月のメモはまだありません</p>
                            @endforelse
                        </div>
                    </div>
                </div>