<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ゲスト用の投稿の一覧（未ログイン）
        </h2>

        <x-message :message="session('message')" />
    </x-slot>

    {{-- 投稿一覧表示用のコード --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @foreach ($posts as $post)
        {{-- プランの表示制御 --}}
        {{--@if ($post->user->bplan) --}}
            <div class="mx-4 sm:p-8">
                <div class="mt-4">
                    <div class="bg-white w-full rounded-2xl px-10 pt-2 pb-8 shadow-lg hover:shadow-2xl transition duration-500">
                        <div class="mt-4">
                            <div class="flex items-center">
                                <div class="rounded-full w-12 h-12">
                                    {{-- アバター表示 --}}
                                    <img src="{{ asset('storage/avatar/' . ($post->user->avatar ?? 'user_default.jpg')) }}" alt="Avatar">
                                </div>
                                <h1 class="text-lg text-gray-700 font-semibold hover:underline cursor-pointer pl-4">
                                    <a href="{{ route('guest.show', $post) }}">{{ $post->title }}</a>
                                </h1>
                            </div>
                            <hr class="w-full mt-4">
                            <p class="mt-4 text-gray-600">{{ Str::limit($post->body, 100, '...') }}</p>
                            <div class="text-sm font-semibold flex justify-between mt-4">
                                <p>アカウント名<a href="{{ route('profile.show', $post->user->id) }}">【{{ $post->user->name ?? '削除されたユーザー' }}】</a></p>
                                <p>最終更新：{{ $post->created_at->diffForHumans() }} 【{{ $post->user->bplan ?? '別のプランです' }}プラン】</p>
                            </div>
                            <hr class="w-full mt-4 mb-2">
                            <div class="flex items-center justify-between">
                                <div>
                                    @if ($post->comments->count())
                                    <span class="badge">
                                        <a href="{{ route('post.show', $post) }}">返信 {{ $post->comments->count() }} 件</a>
                                    </span>
                                    @else
                                    <span>コメントはまだありません。</span>
                                    @endif
                                </div>
                                <a href="{{ route('post.show', $post) }}">
                                    <x-primary-button>コメントする</x-primary-button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {{--@endif --}}
        @endforeach
    </div>
</x-app-layout>
