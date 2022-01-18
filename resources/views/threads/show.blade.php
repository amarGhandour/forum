<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All Threads') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white border-b border-gray-200 mt-6">
                <p> Thread title: {{ $thread->title }}</p>
                <p> Thread body: {{ $thread->body }}</p>

            </div>
            @foreach($thread->replies as $reply)
                <div class="p-6 bg-white border-b border-gray-200 mt-6">
                    <p>Said by: {{ $reply->owner->name }}</p>
                    <p> {{ $reply->body  }}</p>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
