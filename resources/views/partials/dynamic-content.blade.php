{{-- Render custom positioned items (sections or cards) --}}
@foreach($items as $item)
    @if($item['type'] === 'section')
        {{-- Render Homepage Section with associated cards --}}
        @php
            $section = $item['data'];
            $sectionCards = $section->featureCards ?? collect();
            $bgColor = e($section->background_color ?? '#f0f5ff');
        @endphp
        <div class="py-12 sm:py-16 lg:py-24" style="background: linear-gradient(to bottom right, {{ $bgColor }}, #ffffff);">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12 sm:mb-16">
                    <h3 class="text-3xl sm:text-4xl font-extrabold text-neutral-900 mb-4">
                        {{ $section->title }}
                    </h3>
                    @if($section->subtitle)
                    <p class="text-base sm:text-lg text-neutral-600">
                        {{ $section->subtitle }}
                    </p>
                    @endif
                </div>
                
                {{-- Render associated cards if any --}}
                @if($sectionCards->count() > 0)
                    @php
                        $useCarousel = $sectionCards->count() > 6;
                        $carouselId = 'section-cards-' . ($section->id ?? \Illuminate\Support\Str::slug($section->title));
                        $gridCols = $sectionCards->count() === 1 ? 'md:grid-cols-1' : 
                                   ($sectionCards->count() === 2 ? 'md:grid-cols-2' : 'md:grid-cols-3');
                    @endphp
                    @if($useCarousel)
                    <div class="relative">
                        <div id="{{ $carouselId }}" class="flex overflow-x-auto scroll-smooth snap-x snap-mandatory pb-2 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                            @foreach($sectionCards->chunk(6) as $cardsChunk)
                                <div class="w-full min-w-full snap-start flex-shrink-0">
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                                        @foreach($cardsChunk as $card)
                                            @php
                                                $classes = $card->getCssClasses();
                                            @endphp
                                            <div class="{{ $classes['gradient'] }} {{ $classes['border'] }} p-6 sm:p-8 rounded-2xl shadow-lg hover:shadow-xl transition" style="{{ $classes['style'] ?? '' }}">
                                                @if($card->featured_image)
                                                    <div class="mb-4 rounded-lg overflow-hidden">
                                                        <img src="{{ \App\Helpers\ImageHelper::storageUrl($card->featured_image) }}"
                                                             alt="{{ $card->title }}"
                                                             class="w-full h-48 object-cover">
                                                    </div>
                                                @endif
                                                <div class="text-4xl sm:text-5xl mb-4">{{ $card->icon }}</div>
                                                <h4 class="text-xl sm:text-2xl font-bold {{ $classes['text'] }} mb-3" style="{{ $classes['text_style'] ?? '' }}">{{ $card->title }}</h4>
                                                <p class="text-sm sm:text-base text-neutral-700">
                                                    {{ $card->description }}
                                                </p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button onclick="scrollCards('{{ $carouselId }}', -1)" class="absolute left-0 top-1/2 transform -translate-y-1/2 -translate-x-2 sm:-translate-x-4 bg-white hover:bg-neutral-100 text-neutral-800 p-2 sm:p-3 rounded-full shadow-xl transition z-10" aria-label="Cards anteriores">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button onclick="scrollCards('{{ $carouselId }}', 1)" class="absolute right-0 top-1/2 transform -translate-y-1/2 translate-x-2 sm:translate-x-4 bg-white hover:bg-neutral-100 text-neutral-800 p-2 sm:p-3 rounded-full shadow-xl transition z-10" aria-label="Próximos cards">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                    @else
                    <div class="grid grid-cols-1 {{ $gridCols }} gap-6 sm:gap-8">
                        @foreach($sectionCards as $card)
                            @php
                                $classes = $card->getCssClasses();
                            @endphp
                            <div class="{{ $classes['gradient'] }} {{ $classes['border'] }} p-6 sm:p-8 rounded-2xl shadow-lg hover:shadow-xl transition" style="{{ $classes['style'] ?? '' }}">
                                @if($card->featured_image)
                                    <div class="mb-4 rounded-lg overflow-hidden">
                                        <img src="{{ \App\Helpers\ImageHelper::storageUrl($card->featured_image) }}"
                                             alt="{{ $card->title }}"
                                             class="w-full h-48 object-cover">
                                    </div>
                                @endif
                                <div class="text-4xl sm:text-5xl mb-4">{{ $card->icon }}</div>
                                <h4 class="text-xl sm:text-2xl font-bold {{ $classes['text'] }} mb-3" style="{{ $classes['text_style'] ?? '' }}">{{ $card->title }}</h4>
                                <p class="text-sm sm:text-base text-neutral-700">
                                    {{ $card->description }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                    @endif
                @endif
            </div>
        </div>
    @elseif($item['type'] === 'card')
        {{-- Render Feature Card as standalone section --}}
        @php
            $classes = $item['data']->getCssClasses();
        @endphp
        <div class="py-8 sm:py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-md mx-auto">
                    <div class="{{ $classes['gradient'] }} {{ $classes['border'] }} p-6 sm:p-8 rounded-2xl shadow-lg hover:shadow-xl transition" style="{{ $classes['style'] ?? '' }}">
                        @if($item['data']->featured_image)
                            <div class="mb-4 rounded-lg overflow-hidden">
                                <img src="{{ \App\Helpers\ImageHelper::storageUrl($item['data']->featured_image) }}" 
                                     alt="{{ $item['data']->title }}" 
                                     class="w-full h-48 object-cover">
                            </div>
                        @endif
                        <div class="text-4xl sm:text-5xl mb-4 text-center">{{ $item['data']->icon }}</div>
                        <h4 class="text-xl sm:text-2xl font-bold {{ $classes['text'] }} mb-3 text-center" style="{{ $classes['text_style'] ?? '' }}">{{ $item['data']->title }}</h4>
                        <p class="text-sm sm:text-base text-neutral-700 text-center">
                            {{ $item['data']->description }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
