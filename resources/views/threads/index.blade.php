<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All Threads') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @foreach($threads as $thread)
                <div class="p-6 bg-white border-b border-gray-200 mt-6">
                    <p><a href="{{ $thread->path() }}">{{ $thread->title }}</a></p>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
