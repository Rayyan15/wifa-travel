@props(['title', 'desc'])

<div class="flex flex-col items-center text-center p-8 transition duration-500 hover:bg-gray-50/80 hover:-translate-y-2 rounded-[2.5rem] border border-transparent hover:border-wifa-gold/20 hover:shadow-[0_20px_40px_rgba(212,175,55,0.05)] group">
    <div class="w-20 h-20 bg-gray-50 group-hover:bg-wifa-gold/10 text-wifa-gold rounded-full flex items-center justify-center mb-6 transition duration-500 shadow-sm group-hover:shadow-[0_0_20px_rgba(212,175,55,0.2)]">
        <div class="w-10 h-10 opacity-80 group-hover:scale-110 group-hover:opacity-100 transition duration-500 text-wifa-gold">
            {{ $slot }}
        </div>
    </div>
    <h4 class="text-2xl font-black text-gray-800 mb-4 group-hover:text-wifa-dark transition duration-300">{{ $title }}</h4>
    <p class="text-base text-gray-500 leading-relaxed max-w-xs">{{ $desc }}</p>
</div>
