@foreach ($achievements as $achievement)
    <div class="bg-gray-700 p-4 rounded-lg shadow-lg">
        <h3 class="text-xl font-semibold">{{ $achievement['title'] }}</h3>
        <p class="text-gray-400 mt-1">{{ $achievement['description'] }}</p>
        <img src="{{ $achievement['image'] }}" alt="{{ $achievement['title'] }}" class="w-full h-32 object-cover mt-2 rounded-lg">
    </div>
@endforeach
