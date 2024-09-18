@foreach ($guides as $guide)
    <div class="bg-gray-700 p-4 rounded-lg shadow-lg">
        <h3 class="text-xl font-semibold">{{ $guide['title'] }}</h3>
        <p class="text-gray-400 mt-1">{{ $guide['summary'] }}</p>
        <a href="{{ $guide['url'] }}" class="mt-2 inline-block text-blue-400 hover:underline">Read more</a>
    </div>
@endforeach
