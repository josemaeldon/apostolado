{{-- Render custom positioned items (sections or cards) --}}
@foreach($items as $item)
    @if($item['type'] === 'section')
        {{-- Render Homepage Section with associated cards --}}
        @php
            $section = $item['data'];
            $sectionCards = $section->featureCards ?? collect();
        @endphp
        <div class="py-12 sm:py-16 lg:py-24 bg-gradient-to-br from-primary-50 to-white">
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
                <div class="grid grid-cols-1 md:grid-cols-{{ min($sectionCards->count(), 3) }} gap-6 sm:gap-8">
                    @foreach($sectionCards as $card)
                        @php
                            $classes = $card->getCssClasses();
                        @endphp
                        <div class="{{ $classes['gradient'] }} p-6 sm:p-8 rounded-2xl shadow-lg hover:shadow-xl transition border {{ $classes['border'] }}">
                            @if($card->featured_image)
                                <div class="mb-4 rounded-lg overflow-hidden">
                                    <img src="{{ asset('storage/' . $card->featured_image) }}" 
                                         alt="{{ $card->title }}" 
                                         class="w-full h-48 object-cover">
                                </div>
                            @endif
                            <div class="text-4xl sm:text-5xl mb-4">{{ $card->icon }}</div>
                            <h4 class="text-xl sm:text-2xl font-bold {{ $classes['text'] }} mb-3">{{ $card->title }}</h4>
                            <p class="text-sm sm:text-base text-neutral-700">
                                {{ $card->description }}
                            </p>
                        </div>
                    @endforeach
                </div>
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
                    <div class="{{ $classes['gradient'] }} p-6 sm:p-8 rounded-2xl shadow-lg hover:shadow-xl transition border {{ $classes['border'] }}">
                        @if($item['data']->featured_image)
                            <div class="mb-4 rounded-lg overflow-hidden">
                                <img src="{{ asset('storage/' . $item['data']->featured_image) }}" 
                                     alt="{{ $item['data']->title }}" 
                                     class="w-full h-48 object-cover">
                            </div>
                        @endif
                        <div class="text-4xl sm:text-5xl mb-4 text-center">{{ $item['data']->icon }}</div>
                        <h4 class="text-xl sm:text-2xl font-bold {{ $classes['text'] }} mb-3 text-center">{{ $item['data']->title }}</h4>
                        <p class="text-sm sm:text-base text-neutral-700 text-center">
                            {{ $item['data']->description }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
