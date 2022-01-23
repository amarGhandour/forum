<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $thread->title }}
        </h2>
    </x-slot>

    <div class="flex">

        <aside class="w-48 flex-shrink-0  bg-white border-b border-gray-200 mt-8">
            <p>created at: {{ $thread->created_at->diffForHumans() }}</p>
            <p>Number of
                comments: {{ $thread->replies_count }}  {{ Str::plural('comment', $thread->replies_count ) }}</p>
            <p>created by: <a href="#"> {{ $thread->creator->name}}</a>
            </p>

        </aside>

        <div class="py-12 flex-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 bg-white border-b border-gray-200 mt-6">
                    <p> Thread title: {{ $thread->title }}</p>
                    <p> Thread body: {{ $thread->body }}</p>

                </div>
                @foreach($replies as $reply)
                    <div class="p-6 bg-white border-b border-gray-200 mt-6">
                        <p>Said by: <a href="#">{{ $reply->owner->name }}</a></p>
                        <p> {{ $reply->body  }}</p>
                    </div>
                @endforeach
                {{ $replies->links() }}
                @auth
                    <div class="mt-6">
                        <form action="{{$thread->path()}}/replies" method="POST">
                            @csrf

                            <x-form.text-area name="body" class="w-full">{{ old('body') }}</x-form.text-area>

                        <x-button type="submit">Reply</x-button>

                    </form>
                </div>
            @endauth

            @guest
                <p class="text-center mt-4"><a href="{{ route('login') }}" class="text-indigo-600">Login </a> or <a
                        href="{{ route('register') }}" class="text-indigo-600">register</a> to be
                    able to reply</p>
            @endguest

            </div>


        </div>
    </div>
</x-app-layout>
