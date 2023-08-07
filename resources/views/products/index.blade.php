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

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-4">
                    <h1 class="text-2xl font-bold mb-4">Список продуктов</h1>

                    <table class="w-full table-auto hover:table-fixed">
                        <thead>
                        <tr>
                            <th class="py-2 px-4 bg-gray-100 font-semibold uppercase">Название</th>
                            <th class="py-2 px-4 bg-gray-100 font-semibold uppercase">Цена</th>
                            <th class="py-2 px-4 bg-gray-100 font-semibold uppercase">Страна производства</th>
                            <th class="py-2 px-4 bg-gray-100 font-semibold uppercase">Категории</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td class="py-2 px-4">{{ $product->name }}</td>
                                <td class="py-2 px-4">{{ $product->price }}</td>
                                <td class="py-2 px-4">{{ $product->country->name }}</td>
                                <td class="py-2 px-4">
                                    <ul>
                                        @foreach ($product->categories as $category)
                                            <li>{{ $category->name }}  -  {{ $category->id }}</li>

                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Пример: Выводим список продуктов и их категорий -->

{{--    @foreach ($products as $product)--}}
{{--        <h2>{{ $product->name }}</h2>--}}
{{--        <p>Цена: {{ $product->price }}</p>--}}
{{--        <p>Url: {{ $product->good_url }}</p>--}}

{{--        <ul>--}}
{{--            @foreach ($product->categories as $category)--}}
{{--                <li>{{ $category->name }}</li>--}}
{{--            @endforeach--}}
{{--        </ul>--}}
{{--        <hr>--}}
{{--    @endforeach--}}


{{--    <table class="w-full">--}}
{{--        <tr>--}}
{{--            <th class="bg-gray-100 px-4 py-2">Product Name</th>--}}
{{--            <th class="bg-gray-100 px-4 py-2">Country Name</th>--}}
{{--            <th class="bg-gray-100 px-4 py-2">Country ID</th>--}}
{{--            <th class="bg-gray-100 px-4 py-2">Good URL</th>--}}
{{--            <th class="bg-gray-100 px-4 py-2">Image</th>--}}
{{--        </tr>--}}
{{--        @foreach ($products as $product)--}}
{{--            <tr>--}}
{{--                <td class="border px-4 py-2">--}}
{{--                    <img src="{{ $product->img_url }}" alt="Product Image" class="w-20 h-20">--}}
{{--                </td>--}}
{{--                <td class="border px-4 py-2">{{ $product->name }}</td>--}}
{{--                <td class="border px-4 py-2">{{ $product->country ? $product->country->name : 'N/A' }}</td>--}}
{{--                <td class="border px-4 py-2">{{ $product->country ? $product->country->id : 'N/A' }}</td>--}}
{{--                <td class="border px-4 py-2">--}}
{{--                    <a href="{{ $product->good_url }}" class="text-blue-500 hover:underline">Good URL</a>--}}
{{--                </td>--}}

{{--            </tr>--}}
{{--        @endforeach--}}
{{--    </table>--}}
</div>
</body>
</html>
