<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $thread->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white border-b border-gray-200 mt-6">
                <p>created by: <a href=" {{ $thread->creator->path()}}"> {{ $thread->creator->name}}</a></p>
                <p> Thread title: {{ $thread->title }}</p>
                <p> Thread body: {{ $thread->body }}</p>

            </div>
            @foreach($thread->replies as $reply)
                <div class="p-6 bg-white border-b border-gray-200 mt-6">
                    <p>Said by: {{ $reply->owner->name }}</p>
                    <p> {{ $reply->body  }}</p>
                </div>
            @endforeach

            @auth
                <div class="mt-6">
                    <form action="/{{$thread->path()}}/replies" method="POST">
                        @csrf

                        <x-form.text-area name="body" class="w-full">{{ old('body') }}</x-form.text-area>

                        <x-button type="submit">Reply</x-button>

                    </form>
                </div>
            @endauth

            @guest
                <p><a href="{{ route('login') }}">Login </a> or <a href="{{ route('register') }}">register</a> to be
                    able to reply</p>
            @endguest

        </div>


    </div>
</x-app-layout>
