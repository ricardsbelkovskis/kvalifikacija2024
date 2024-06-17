<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Blog Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-semibold mb-4">{{ __('Blog Posts') }}</h2>
                    @if (Auth::user()->role === 'company_owner' && $posts->contains('author_id', Auth::user()->id))
                        <a href="{{ route('blog.create') }}" class="inline-flex items-center px-4 py-2 mb-4 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Create New Post') }}
                        </a>
                    @endif
                    <ul class="space-y-4">
                        @foreach($posts as $post)
                            <li class="flex items-center justify-between">
                                <a href="{{ route('blog.show', $post->id) }}" class="text-lg text-indigo-600 dark:text-indigo-400 hover:underline">
                                    {{ $post->title }}
                                </a>
                                <div class="flex space-x-2">
                                    <a href="{{ route('blog.edit', $post->id) }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                        {{ __('View') }}
                                    </a>
                                    @if (Auth::user()->role === 'company_owner' && Auth::user()->id === $post->author_id)
                                        <a href="{{ route('blog.edit', $post->id) }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                            {{ __('Edit') }}
                                        </a>
                                        <form action="{{ route('blog.destroy', $post->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    </div>
                                    @endif
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-4">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
