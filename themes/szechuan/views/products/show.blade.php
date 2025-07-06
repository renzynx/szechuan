<div class="space-y-6">
    <!-- Breadcrumb Navigation -->
    <nav class="flex items-center space-x-2 text-sm text-muted-foreground">
        <a href="{{ route('home') }}" wire:navigate class="hover:text-foreground transition-colors">
            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            Home
        </a>
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
        </svg>
        <a href="{{ route('category.show', ['category' => $category->slug]) }}" wire:navigate class="hover:text-foreground transition-colors">
            {{ $category->name }}
        </a>
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
        </svg>
        <span class="text-foreground font-medium">{{ $product->name }}</span>
    </nav>

    <!-- Product Details -->
    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-8 lg:gap-16 bg-background-secondary border border-neutral rounded-xl overflow-hidden shadow-sm">
        @if ($product->image)
            <div class="relative bg-background/50">
                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                    class="w-full h-64 sm:h-80 lg:h-96 object-contain object-center">
                <div class="absolute inset-0 bg-gradient-to-t from-black/5 to-transparent"></div>
            </div>
        @endif
        
        <div class="flex flex-col p-6 lg:p-8">
            <!-- Stock Status -->
            @if ($product->stock === 0)
                <span class="inline-flex items-center gap-2 text-xs font-medium px-3 py-1.5 rounded-full bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 w-fit mb-4">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    {{ __('product.out_of_stock', ['product' => $product->name]) }}
                </span>
            @elseif($product->stock > 0)
                <span class="inline-flex items-center gap-2 text-xs font-medium px-3 py-1.5 rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 w-fit mb-4">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    {{ __('product.in_stock') }}
                </span>
            @endif

            <!-- Product Info Header -->
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
                <div class="space-y-2">
                    <h1 class="text-2xl lg:text-3xl font-bold text-foreground">{{ $product->name }}</h1>
                    <div class="text-2xl lg:text-3xl font-bold text-primary">
                        {{ $product->price() }}
                    </div>
                </div>
                @if ($product->stock !== 0 && $product->price()->available)
                    <div class="flex-shrink-0">
                        <button class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-primary/10 text-primary hover:bg-primary/20 transition-colors">
                            <x-ri-shopping-bag-4-fill class="w-6 h-6" />
                        </button>
                    </div>
                @endif
            </div>

            <!-- Product Description -->
            @if($product->description)
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-foreground mb-3">Description</h3>
                    <article class="prose dark:prose-invert prose-sm max-w-none text-muted-foreground">
                        {!! $product->description !!}
                    </article>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="mt-8 pt-6 border-t border-neutral space-y-4">
                @if ($product->stock !== 0 && $product->price()->available)
                    <a href="{{ route('products.checkout', ['category' => $category, 'product' => $product->slug]) }}"
                        wire:navigate class="inline-block w-full">
                        <x-button.primary class="w-full justify-center py-3 text-base font-semibold">
                            <span class="flex items-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m0 0h10"></path>
                                </svg>
                                {{ __('product.add_to_cart') }}
                            </span>
                        </x-button.primary>
                    </a>
                @else
                    <div class="text-center p-4 bg-muted/20 rounded-lg border border-muted">
                        <p class="text-muted-foreground">This product is currently unavailable</p>
                    </div>
                @endif
                
                <!-- Back to Category Button -->
                <a href="{{ route('category.show', ['category' => $category->slug]) }}" wire:navigate class="inline-block w-full">
                    <x-button.secondary class="w-full justify-center py-2">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to {{ $category->name }}
                        </span>
                    </x-button.secondary>
                </a>
            </div>
        </div>
    </div>
</div>
