<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
<title>残高修正</title>
</head>

<div class="min-h-screen flex items-center justify-center bg-[#F4F3EF] px-4 py-12 font-sans antialiased text-stone-700" style="font-family: 'Poppins', 'Noto Sans JP', sans-serif;">
    
    <div class="w-full max-w-md bg-white p-6 md:p-8 rounded-2xl md:rounded-3xl shadow-[0_8px_30px_rgba(138,154,134,0.06)] border border-stone-200/60">
        
        <h2 class="text-xl font-bold text-stone-800 text-center mb-8 tracking-wide">
            残高修正
        </h2>

        <form action="{{ route('accounts.updateBalance', $account) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="bg-stone-50 border border-stone-200/60 rounded-xl p-4 flex justify-between items-center">
                <span class="text-xs font-semibold text-stone-400 tracking-wider">対象口座</span>
                <span class="text-sm font-bold text-stone-700">{{ $account->name }}</span>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-semibold text-stone-500 tracking-wider">修正後の残高</label>
                <div class="relative flex items-center">
                    <span class="absolute left-4 text-stone-400 font-medium text-sm">¥</span>
                    <input type="number" name="balance" step="0.01" value="{{ $account->balance }}" placeholder="0" required 
                        class="w-full border border-stone-200 rounded-xl py-3 pl-8 pr-4 text-sm bg-stone-50/30 text-stone-800 font-semibold tracking-wide focus:outline-none focus:border-[#8A9A86] focus:ring-1 focus:ring-[#8A9A86] transition-all">
                </div>
            </div>

            <div class="pt-2 space-y-3">
                <button type="submit" class="w-full py-3 bg-[#8A9A86] text-white text-sm font-semibold rounded-xl shadow-sm hover:bg-[#788874] transition-colors duration-200 tracking-wider">
                    更新する
                </button>
                
                <div class="text-center">
                    <a href="{{ route('dashboard') }}" class="inline-block text-xs text-stone-400 hover:text-stone-600 transition-colors py-1">
                        ダッシュボードへ戻る
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>