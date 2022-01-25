<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $user->name . __(' Profile') }}
        </h2>
    </x-slot>

    <div class="p-12">
        <div class="mx-auto sm:px-6 lg:px-8 py-6 rounded-xl">
            @foreach($threads as $thread)
                <div class="mt-4 p-6 border border-gray-100">
                    <div class="border-b border-gray-300 bg-white py-4 px-3 flex">
                        <p class="flex-1 text-green-600"> {{ $user->name }} posted: <a
                                href="{{ $thread->path() }}">{{ $thread->title }}</a></p>
                        <small>{{$thread->created_at->diffForHumans()}}</small>
                    </div>
                    <div class="bg-white py-6 px-3">
                        {{ $thread->body }}
                    </div>
                </div>
            @endforeach
            {{ $threads->links() }}
        </div>
    </div>
</x-app-layout>
