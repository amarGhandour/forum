<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Thread') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="bg-white sm:max-w-md mx-auto sm:px-6 lg:px-8 py-6 rounded-xl">
            <form method="POST" action="{{ route('threads.store') }}">
                @csrf

                <div class="mt-4">
                    <x-label for="title" :value="__('Title')"/>

                    <x-input id="title" class="block mt-1 w-full"
                             type="text"
                             name="title"/>
                </div>

                <div class="mt-4">
                    <x-label for="body" :value="__('Body')"/>

                    <x-form.text-area
                        class="block mt-1 w-full"
                        name="body"
                        id="body"
                    >{{ old('body') }}</x-form.text-area>
                </div>


                <div class="flex items-center justify-end mt-4">
                    <x-button class="ml-3">
                        {{ __('Post') }}
                    </x-button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
