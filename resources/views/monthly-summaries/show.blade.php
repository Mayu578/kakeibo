{{-- resources/views/monthly-summaries/show.blade.php --}}
<section class="mt-8">
    <h2 class="text-lg font-bold mb-2">{{ $month }} のコメント</h2>

    <ul class="space-y-3 mb-4">
        @foreach ($comments as $comment)
            <li class="border rounded p-3">
                <p class="text-sm text-gray-500">
                    {{ $comment->user->name }} - {{ $comment->created_at->format('Y/m/d H:i') }}
                </p>
                <p>{{ $comment->comment }}</p>
                @can('delete', $comment)
                    <form method="POST" action="{{ route('monthly-comments.destroy', $comment) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 text-sm">削除</button>
                    </form>
                @endcan
            </li>
        @endforeach
    </ul>

    <form method="POST" action="{{ route('monthly-comments.store', $month) }}">
        @csrf
        <textarea name="comment" rows="3" class="w-full border rounded p-2" placeholder="今月の振り返りをメモ"></textarea>
        @error('comment')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
        <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">投稿する</button>
    </form>
    <a href="{{ route('dashboard') }}"
        class="px-5 py-2.5 bg-stone-50 border border-stone-200 text-stone-500 text-sm rounded-xl hover:bg-stone-100 transition-colors">
        ダッシュボードへ
    </a>
</section>
