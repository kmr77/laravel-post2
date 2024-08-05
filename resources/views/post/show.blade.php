<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            投稿の詳細
        </h2>
        <x-message :message="session('message')" />
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mx-4 sm:p-8">
            <div class="px-10 mt-4">
                <div class="bg-white w-full rounded-2xl px-10 pt-2 pb-8 shadow-lg hover:shadow-2xl transition duration-500">
                    <div class="mt-4">
                        <div class="flex items-center">
                            <div class="rounded-full w-12 h-12">
                                <img src="{{ asset('storage/avatar/' . ($post->user->avatar ?? 'user_default.jpg')) }}" alt="Avatar">
                            </div>
                            <h1 class="text-lg text-gray-700 font-semibold hover:underline cursor-pointer pl-4">
                                {{ $post->title }}
                            </h1>
                        </div>
                        <hr class="w-full mt-4">
                    </div>

                    @can('update', $post)
                    <div class="flex justify-end mt-4">
                        <a href="{{ route('post.edit', $post) }}">
                            <x-primary-button class="bg-teal-700">編集</x-primary-button>
                        </a>
                        <form method="post" action="{{ route('post.destroy', $post) }}">
                            @csrf
                            @method('delete')
                            <x-primary-button class="bg-red-700 ml-4" onclick="return confirm('本当に削除しますか？');">削除</x-primary-button>
                        </form>
                    </div>
                    @endcan

                    <p class="mt-4 text-gray-600 whitespace-pre-line">{{ $post->body }}</p>

                    @if($post->image)
                    <div class="mt-4">
                        (画像ファイル：{{ $post->image }})
                        <img src="{{ asset('storage/images/' . $post->image) }}" class="mx-auto mt-4" style="height:300px;">
                    </div>
                    @endif

                    <div class="text-sm font-semibold flex justify-between mt-4">
                        <p>{{ $post->user->name ?? '削除されたユーザー' }} • {{ $post->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                {{-- コメント表示 --}}
                @foreach ($post->comments as $comment)
                <div class="bg-white w-full rounded-2xl px-10 py-8 shadow-lg mt-8 whitespace-pre-line">
                    {{ $comment->body }}
                    <div class="text-sm font-semibold flex justify-between items-center mt-4">
                        <p>{{ $comment->user->name ?? '削除されたユーザー' }} • {{ $comment->created_at->diffForHumans() }}</p>
                        <span class="rounded-full w-12 h-12">
                            <img src="{{ asset('storage/avatar/' . ($comment->user->avatar ?? 'user_default.jpg')) }}" alt="Avatar">
                        </span>
                    </div>
                </div>
                @endforeach

                {{-- コメント入力 --}}
                <div class="mt-4 mb-12">
                    @auth
                    <form method="post" action="{{ route('comment.store') }}">
                        @csrf
                        <input type="hidden" name='post_id' value="{{ $post->id }}">
                        <textarea name="body" class="bg-white w-full rounded-2xl px-4 py-4 mt-4 shadow-lg" id="body" cols="30" rows="3" placeholder="コメントを入力してください">{{ old('body') }}</textarea>
                        <x-primary-button class="float-right mt-4">コメントする</x-primary-button>
                    </form>
                    @else
                    <p class="text-gray-700">コメントを投稿するには<a href="{{ route('login') }}" class="text-blue-500 underline">ログイン</a>が必要です。</p>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
