<footer class="bg-neutral-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h4 class="text-xl font-bold mb-4 text-gold-400">{{ $footerTitle }}</h4>
                <p class="text-neutral-400">
                    {{ $footerDescription }}
                </p>
            </div>
            <div>
                <h4 class="text-xl font-bold mb-4 text-gold-400">Links</h4>
                <ul class="space-y-2 text-neutral-400">
                    <li><a href="{{ route('home') }}" class="hover:text-gold-400 transition">Home</a></li>
                    <li><a href="{{ route('public.prayer-intentions') }}" class="hover:text-gold-400 transition">Intenções de Oração</a></li>
                    <li><a href="{{ route('public.articles') }}" class="hover:text-gold-400 transition">Artigos</a></li>
                    <li><a href="{{ route('public.events') }}" class="hover:text-gold-400 transition">Eventos</a></li>
                    <li><a href="{{ route('public.media-gallery') }}" class="hover:text-gold-400 transition">Galeria</a></li>
                    <li><a href="{{ route('member.register') }}" class="hover:text-gold-400 transition">Cadastrar-se</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-xl font-bold mb-4 text-gold-400">Contato</h4>
                <p class="text-neutral-400">
                    Email: {{ $footerEmail }}<br>
                    Tel: {{ $footerPhone }}
                </p>
            </div>
        </div>
        <div class="mt-8 pt-8 border-t border-neutral-800 text-center text-neutral-500">
            <p>&copy; {{ date('Y') }} Apostolado da Oração. Todos os direitos reservados.</p>
        </div>
    </div>
</footer>
