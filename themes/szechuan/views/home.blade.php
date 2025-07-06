<div>
    <div class="flex flex-col gap-6">
        <div class="mx-auto container bg-background-secondary p-4 rounded-md">
            <article class="prose dark:prose-invert max-w-full">
                {!! Str::markdown(theme('home_page_text', 'Welcome to Paymenter'), [
                'allow_unsafe_links' => false,
                ]) !!}
            </article>
        </div>
        <div class="mx-auto container rounded-md grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-4">
            @foreach ($categories as $category)
                <div class="group relative flex flex-col bg-background-secondary hover:bg-background-secondary/90 border border-neutral rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                    @if ($category->image)
                        <div class="relative overflow-hidden {{ theme('small_images', false) ? 'h-20' : 'h-48' }}">
                            <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}"
                                class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-300">
                            @if(!theme('small_images', false))
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                            @endif
                        </div>
                    @endif
                    
                    <div class="flex-1 p-6 flex flex-col">
                        @if(theme('small_images', false) && $category->image)
                            <div class="flex items-center gap-4 mb-4">
                                <div class="flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden">
                                    <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}"
                                        class="w-full h-full object-cover">
                                </div>
                                <h2 class="text-xl font-bold text-foreground group-hover:text-primary transition-colors">
                                    {{ $category->name }}
                                </h2>
                            </div>
                        @else
                            <h2 class="text-xl font-bold text-foreground group-hover:text-primary transition-colors mb-3">
                                {{ $category->name }}
                            </h2>
                        @endif
                        
                        @if(theme('show_category_description', true))
                            <div class="flex-1 mb-4">
                                <article class="prose dark:prose-invert prose-sm text-muted-foreground line-clamp-3">
                                    {!! $category->description !!}
                                </article>
                            </div>
                        @endif
                        
                        <div class="mt-auto">
                            <a href="{{ route('category.show', ['category' => $category->slug]) }}" wire:navigate 
                               class="inline-block w-full">
                                <x-button.primary class="w-full justify-center group-hover:bg-primary/90 transition-colors">
                                    <span class="flex items-center gap-2">
                                        {{ __('general.view') }}
                                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </span>
                                </x-button.primary>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    {!! hook('pages.home') !!}
</div>
