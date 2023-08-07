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

    <table class="w-full">
        <tr>
            <th class="bg-gray-100 px-4 py-2">Product Name</th>
            <th class="bg-gray-100 px-4 py-2">Country Name</th>
            <th class="bg-gray-100 px-4 py-2">Country ID</th>
            <th class="bg-gray-100 px-4 py-2">Good URL</th>
            <th class="bg-gray-100 px-4 py-2">Image</th>
        </tr>
        @foreach ($products as $product)
            <tr>
{{--                <td class="border px-4 py-2">--}}
{{--                    <img src="{{ $product->img_url }}" alt="Product Image" class="w-20 h-20">--}}
{{--                </td>--}}
                <td class="border px-4 py-2">{{ $product->name }}</td>
                <td class="border px-4 py-2">{{ $product->country ? $product->country->name : 'N/A' }}</td>
                <td class="border px-4 py-2">{{ $product->country ? $product->country->id : 'N/A' }}</td>
                <td class="border px-4 py-2">
                    <a href="{{ $product->good_url }}" class="text-blue-500 hover:underline">Good URL</a>
                </td>

            </tr>
        @endforeach
    </table>
</div>
</body>
</html>
