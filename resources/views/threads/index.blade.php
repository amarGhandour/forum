<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All Threads') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @foreach($threads as $thread)
                <div class="p-6 bg-white border-b border-gray-200 mt-6 flex">
                    <p class="flex-1"><a href="{{ $thread->path() }}">{{ $thread->title }}</a></p>
                    <strong
                        class="text-indigo-600"> {{ $thread->replies_count }} {{ Str::plural('reply', $thread->replies_count) }} </strong>
                </div>


            @endforeach
            <div class="mt-6">
                {{ $threads->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
