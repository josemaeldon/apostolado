{{-- Render custom positioned items (sections or cards) --}}
@foreach($items as $item)
    @if($item['type'] === 'section')
        {{-- Render Homepage Section --}}
        <div class="py-12 sm:py-16 lg:py-24 bg-gradient-to-br from-primary-50 to-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12 sm:mb-16">
                    <h3 class="text-3xl sm:text-4xl font-extrabold text-neutral-900 mb-4">
                        {{ $item['data']->title }}
                    </h3>
                    @if($item['data']->subtitle)
                    <p class="text-base sm:text-lg text-neutral-600">
                        {{ $item['data']->subtitle }}
                    </p>
                    @endif
                </div>
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
