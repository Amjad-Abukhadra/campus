@extends('layouts.app')

@section('content')
    <div class="py-5">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-xl flex h-[750px] border border-gray-200 dark:border-gray-800">
                <!-- Sidebar -->
                <div class="w-1/3 border-r border-gray-200 dark:border-gray-800 flex flex-col bg-white dark:bg-gray-900">
                    <div
                        class="p-4 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center h-[70px]">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ auth()->user()->name }}</h2>
                        <button class="text-gray-600 dark:text-gray-400 hover:text-gray-900">
                            <i class="bi bi-pencil-square fs-5"></i>
                        </button>
                    </div>

                    <div class="px-4 py-3">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100">Messages</h3>
                    </div>

                    <div class="flex-1 overflow-y-auto custom-scrollbar">
                        @forelse($conversations as $conv)
                            @php
                                $otherUser = $conv->other_user;
                                $lastMsg = $conv->messages->last();
                                $unreadCount = $conv->messages->where('is_read', false)->where('sender_id', '!=', auth()->id())->count();
                            @endphp
                            <a href="{{ route('chat.show', $conv) }}"
                                class="flex items-center px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors {{ isset($conversation) && $conversation->id === $conv->id ? 'bg-gray-100 dark:bg-gray-800' : '' }}">
                                <div class="relative flex-shrink-0">
                                    <img class="h-14 w-14 rounded-full object-cover p-0.5 border border-gray-200 dark:border-gray-700"
                                        src="{{ $otherUser->image ? asset('storage/' . $otherUser->image) : 'https://ui-avatars.com/api/?name=' . urlencode($otherUser->name) . '&background=random' }}"
                                        alt="">
                                    @if($unreadCount > 0)
                                        <span
                                            class="absolute top-0 right-0 block h-3.5 w-3.5 rounded-full bg-blue-500 border-2 border-white dark:border-gray-900"></span>
                                    @endif
                                </div>
                                <div class="ml-3 overflow-hidden flex-1">
                                    <div class="flex justify-between items-baseline">
                                        <div
                                            class="text-sm {{ $unreadCount > 0 ? 'font-bold' : 'font-medium' }} text-gray-900 dark:text-gray-100 truncate">
                                            {{ $otherUser->name }}
                                        </div>
                                    </div>
                                    <div
                                        class="flex items-center text-xs {{ $unreadCount > 0 ? 'font-bold text-gray-900 dark:text-white' : 'text-gray-500' }} truncate mt-0.5">
                                        <span
                                            class="truncate">{{ $lastMsg ? $lastMsg->content : 'Start a conversation' }}</span>
                                        @if($lastMsg)
                                            <span class="mx-1 text-[8px] opacity-50">&bull;</span>
                                            <span
                                                class="whitespace-nowrap">{{ $lastMsg->created_at->diffForHumans(null, true) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="p-8 text-center mt-10">
                                <div
                                    class="w-20 h-20 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="bi bi-chat-dots text-gray-400 text-3xl"></i>
                                </div>
                                <h4 class="font-bold text-gray-900 dark:text-gray-100">Direct Messages</h4>
                                <p class="text-gray-500 text-sm mt-1">Send private photos and messages to a friend or group.</p>
                                <button class="mt-4 text-blue-500 font-bold text-sm hover:text-blue-600">Send Message</button>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Chat Area (Placeholder for Index) -->
                <div class="w-2/3 flex flex-col items-center justify-center bg-white dark:bg-gray-900">
                    <div class="text-center p-8">
                        <div
                            class="w-24 h-24 border-2 border-gray-900 dark:border-white rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="bi bi-send text-4xl text-gray-900 dark:text-white rotate-12"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Your Messages</h3>
                        <p class="mt-2 text-sm text-gray-500 max-w-xs mx-auto">Send private photos and messages to a friend
                            or group.</p>
                        <button
                            class="mt-6 bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-lg font-bold text-sm transition-all shadow-sm">
                            Send Message
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #dbdbdb;
            border-radius: 10px;
        }

        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #363636;
        }

        /* Tailwind-like utils if missing in project */
        .w-1\/3 {
            width: 33.333333%;
        }

        .w-2\/3 {
            width: 66.666667%;
        }

        .space-x-2>*+* {
            margin-left: 0.5rem;
        }
    </style>
@endpush