<div class="flex flex-col lg:grid lg:grid-cols-4 gap-4 lg:gap-6">
    <div class="lg:col-span-1 flex flex-col gap-4">
        <!-- Category Header -->
        <div class="bg-background-secondary border border-neutral rounded-lg lg:rounded-xl p-4 lg:p-6">
            <h1 class="text-2xl lg:text-3xl font-bold text-foreground mb-2 lg:mb-3">{{ $category->name }}</h1>
            @if($category->description)
                <article class="prose dark:prose-invert prose-sm text-muted-foreground">
                    {!! $category->description !!}
                </article>
            @endif
        </div>

        <!-- Categories Navigation -->
        <div class="bg-background-secondary border border-neutral rounded-lg lg:rounded-xl overflow-hidden">
            <div class="p-3 lg:p-4 border-b border-neutral bg-background-secondary/50">
                <h2 class="text-base lg:text-lg font-semibold text-foreground">Categories</h2>
            </div>
            <div class="divide-y divide-neutral">
                @foreach ($categories as $ccategory)
                    <a href="{{ route('category.show', ['category' => $ccategory->slug]) }}" wire:navigate
                       class="block px-3 lg:px-4 py-2 lg:py-3 text-sm transition-all duration-200 hover:bg-background-secondary/60 hover:pl-5 lg:hover:pl-6 
                              {{ $category->id == $ccategory->id ? 'bg-primary/10 text-primary font-semibold border-r-2 border-primary' : 'text-muted-foreground hover:text-foreground' }}">
                        <div class="flex items-center gap-2">
                            @if($category->id == $ccategory->id)
                                <svg class="w-3 h-3 lg:w-4 lg:h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            @endif
                            {{ $ccategory->name }}
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    <div class="lg:col-span-3 flex flex-col gap-6 lg:gap-8">
        @if (count($childCategories) >= 1)
            <div class="space-y-3 lg:space-y-4">
                <h2 class="text-xl lg:text-2xl font-bold text-foreground px-2 lg:px-0">Subcategories</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
                    @foreach ($childCategories as $childCategory)
                        <div class="group relative flex flex-col bg-background-secondary hover:bg-background-secondary/90 border border-neutral rounded-lg lg:rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                            @if ($childCategory->image)
                                <div class="relative overflow-hidden {{ theme('small_images', false) ? 'h-16 sm:h-20' : 'h-32 sm:h-40' }}">
                                    <img src="{{ Storage::url($childCategory->image) }}" alt="{{ $childCategory->name }}"
                                        class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-300">
                                    @if(!theme('small_images', false))
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                                    @endif
                                </div>
                            @endif
                            
                            <div class="flex-1 p-4 lg:p-5 flex flex-col">
                                @if(theme('small_images', false) && $childCategory->image)
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="flex-shrink-0 w-10 h-10 lg:w-12 lg:h-12 rounded-lg overflow-hidden">
                                            <img src="{{ Storage::url($childCategory->image) }}" alt="{{ $childCategory->name }}"
                                                class="w-full h-full object-cover">
                                        </div>
                                        <h3 class="text-base lg:text-lg font-bold text-foreground group-hover:text-primary transition-colors">
                                            {{ $childCategory->name }}
                                        </h3>
                                    </div>
                                @else
                                    <h3 class="text-base lg:text-lg font-bold text-foreground group-hover:text-primary transition-colors mb-3">
                                        {{ $childCategory->name }}
                                    </h3>
                                @endif
                                
                                @if(theme('show_category_description', true))
                                    <div class="flex-1 mb-4">
                                        <article class="prose dark:prose-invert prose-sm text-muted-foreground line-clamp-2">
                                            {!! $childCategory->description !!}
                                        </article>
                                    </div>
                                @endif
                                
                                <div class="mt-auto">
                                    <a href="{{ route('category.show', ['category' => $childCategory->slug]) }}" wire:navigate 
                                       class="inline-block w-full">
                                        <x-button.primary class="w-full justify-center text-sm">
                                            <span class="flex items-center gap-2">
                                                {{ __('general.view') }}
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
        @endif
        <div class="space-y-3 lg:space-y-4">
            <h2 class="text-xl lg:text-2xl font-bold text-foreground px-2 lg:px-0">Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
                @foreach ($products as $product)
                    <div class="group relative flex flex-col bg-background-secondary hover:bg-background-secondary/90 border border-neutral rounded-lg lg:rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        @if ($product->image)
                            <div class="relative overflow-hidden {{ theme('small_images', false) ? 'h-16 sm:h-20' : 'h-32 sm:h-40' }}">
                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-300 {{ $product->stock === 0 ? 'grayscale opacity-75' : '' }}">
                                @if(!theme('small_images', false))
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                                @endif
                                
                                <!-- Stock Status Badge -->
                                @if ($product->stock === 0)
                                    <div class="absolute top-2 right-2">
                                        <span class="inline-flex items-center gap-1 text-xs font-medium px-2 py-1 rounded-full bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 shadow-sm">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                            Out of Stock
                                        </span>
                                    </div>
                                @elseif($product->stock > 0 && $product->stock <= 5)
                                    <div class="absolute top-2 right-2">
                                        <span class="inline-flex items-center gap-1 text-xs font-medium px-2 py-1 rounded-full bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300 shadow-sm">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            Low Stock
                                        </span>
                                    </div>
                                @endif
                            </div>
                        @endif
                        
                        <div class="flex-1 p-4 lg:p-5 flex flex-col">
                            @if(theme('small_images', false) && $product->image)
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="flex-shrink-0 w-10 h-10 lg:w-12 lg:h-12 rounded-lg overflow-hidden relative">
                                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                                            class="w-full h-full object-cover {{ $product->stock === 0 ? 'grayscale opacity-75' : '' }}">
                                        @if ($product->stock === 0)
                                            <div class="absolute inset-0 bg-red-500/20 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-base lg:text-lg font-bold text-foreground group-hover:text-primary transition-colors {{ $product->stock === 0 ? 'text-muted-foreground' : '' }}">
                                            {{ $product->name }}
                                        </h3>
                                        @if ($product->stock === 0)
                                            <span class="text-xs text-red-600 dark:text-red-400 font-medium">Out of Stock</span>
                                        @elseif($product->stock > 0 && $product->stock <= 5)
                                            <span class="text-xs text-orange-600 dark:text-orange-400 font-medium">Only {{ $product->stock }} left</span>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1">
                                        <h3 class="text-base lg:text-lg font-bold text-foreground group-hover:text-primary transition-colors {{ $product->stock === 0 ? 'text-muted-foreground' : '' }}">
                                            {{ $product->name }}
                                        </h3>
                                    </div>
                                    @if ($product->stock === 0)
                                        <span class="inline-flex items-center gap-1 text-xs font-medium px-2 py-1 rounded-full bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 ml-2 flex-shrink-0">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                            Out of Stock
                                        </span>
                                    @elseif($product->stock > 0 && $product->stock <= 5)
                                        <span class="inline-flex items-center gap-1 text-xs font-medium px-2 py-1 rounded-full bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300 ml-2 flex-shrink-0">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            Only {{ $product->stock }} left
                                        </span>
                                    @endif
                                </div>
                            @endif
                            
                            @if(theme('direct_checkout', false) && $product->description) 
                                <div class="flex-1 mb-3 lg:mb-4">
                                    <article class="prose dark:prose-invert prose-sm text-muted-foreground line-clamp-2">
                                        {!! $product->description !!}
                                    </article>
                                </div>
                            @endif
                            
                            <div class="mb-3 lg:mb-4">
                                <div class="text-lg lg:text-xl font-bold text-primary">
                                    {{ $product->price() }}
                                </div>
                            </div>
                            
                            <div class="mt-auto">
                                @if (($product->stock > 0 || !$product->stock) && $product->price()->available && theme('direct_checkout', false))
                                    <a href="{{ route('products.checkout', ['category' => $category, 'product' => $product->slug]) }}"
                                        wire:navigate class="inline-block w-full">
                                        <x-button.primary class="w-full justify-center text-sm">
                                            <span class="flex items-center gap-2">
                                                <span class="hidden sm:inline">{{ __('product.add_to_cart') }}</span>
                                                <span class="sm:hidden">Add</span>
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m0 0h10"></path>
                                                </svg>
                                            </span>
                                        </x-button.primary>
                                    </a>
                                @elseif ($product->stock === 0)
                                    <button disabled class="w-full cursor-not-allowed opacity-50">
                                        <x-button.secondary class="w-full justify-center text-sm pointer-events-none">
                                            <span class="flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                </svg>
                                                Out of Stock
                                            </span>
                                        </x-button.secondary>
                                    </button>
                                @else
                                    <a href="{{ route('products.show', ['category' => $product->category, 'product' => $product->slug]) }}"
                                        wire:navigate class="inline-block w-full">
                                        <x-button.primary class="w-full justify-center text-sm">
                                            <span class="flex items-center gap-2">
                                                {{ __('general.view') }}
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </span>
                                        </x-button.primary>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
