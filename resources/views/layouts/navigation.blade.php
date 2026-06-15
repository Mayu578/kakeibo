<style>
    /* 北欧風の、穏やかでゆっくりとした波の動き（高さを抑えて上品に） */
    @keyframes nordicWave {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-3px); /* 6pxから3pxに抑え、静かな波の揺れを表現 */
        }
    }

    .animate-wave {
        display: inline-block !important;
        animation: nordicWave 2.6s ease-in-out infinite; /* 2sから2.6sへ、よりゆったりと */
    }
</style>

<nav x-data="{ open: false }" class="bg-white/95 backdrop-blur-sm border border-stone-200/60 rounded-2xl shadow-[0_4px_20px_rgba(138,154,134,0.04)] sticky top-4 z-50 mx-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 relative items-center w-full">
            
            <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-lg font-bold tracking-[0.15em] text-[#8A9A86] select-none flex">
                @foreach (str_split('Kakeibo') as $index => $char)
                    <span class="animate-wave" style="animation-delay: {{ $index * 0.12 }}s;">{{ $char }}</span>
                @endforeach
            </div>

            <div class="hidden space-x-8 sm:-my-px sm:flex">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-stone-500 hover:text-stone-800 transition-colors">
                    {{ __('Dashboard') }}
                </x-nav-link>

                <x-nav-link :href="route('fixed-costs.index')" :active="request()->routeIs('fixed-costs.*')" class="text-stone-500 hover:text-stone-800 transition-colors">
                    固定費一覧
                </x-nav-link>

                <x-nav-link :href="route('transactions.index')" :active="request()->routeIs('transactions.*')" class="text-stone-500 hover:text-stone-800 transition-colors">
                    取引一覧
                </x-nav-link>
            </div>

            <div class="flex items-center">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                </form>
            </div>

        </div>
    </div>
</nav>