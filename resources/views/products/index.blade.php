<!DOCTYPE html>
<html>
<head>
    <title>Products and Countries</title>
    <!-- Стандартная ссылка -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body>
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Products and Countries</h1>

    <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
        @foreach ($products as $product)
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <img src="{{ $product->img_url }}" alt="{{ $product->name }}" class="w-full h-70 object-cover">
                <div class="p-4">
                    <h2 class="text-xl font-semibold">{{ $product->name }}</h2>
                    <p class="text-gray-500">{{ $product->sku }}</p>
                    <p class="text-gray-500">{{ $product->good_url }}</p>
                    <p class="text-gray-500">{{ $product->country->name }}</p>
                    <div class="mt-2">

                            @foreach ($product->categories as $category)
                                {{ $category->name }},
                            @endforeach

                    </div>
                    <div class="mt-2">

                            @foreach ($product->fabrics as $fabric)
                                <li>{{ $fabric->name }}</li>
                            @endforeach

                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
</body>
</html>
