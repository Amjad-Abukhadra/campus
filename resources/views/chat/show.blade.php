@extends('layouts.app')

@section('content')
    <div class="py-5">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-xl flex h-[750px] border border-gray-200 dark:border-gray-800">
                <!-- Sidebar -->
                <div class="w-1/3 border-r border-gray-200 dark:border-gray-800 flex flex-col bg-white dark:bg-gray-900 overflow-hidden">
                    <div class="p-4 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center h-[70px]">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 truncate flex-1 mr-2">{{ auth()->user()->name }}</h2>
                        <a href="{{ route('chat.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 transition-colors">
                            <i class="bi bi-pencil-square fs-5"></i>
                        </a>
                    </div>
                    
                    <div class="px-4 py-3">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100">Messages</h3>
                    </div>

                    <div class="flex-1 overflow-y-auto custom-scrollbar">
                        @foreach($conversations as $conv)
                            @php
                                $otherUser = $conv->other_user;
                                $lastMsg = $conv->messages->last();
                                $unreadCount = $conv->messages->where('is_read', false)->where('sender_id', '!=', auth()->id())->count();
                                $isActive = $conversation->id === $conv->id;
                            @endphp
                            <a href="{{ route('chat.show', $conv) }}"
                                class="flex items-center px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors {{ $isActive ? 'bg-gray-100 dark:bg-gray-800' : '' }}">
                                <div class="relative flex-shrink-0">
                                    <img class="h-14 w-14 rounded-full object-cover p-0.5 border border-gray-200 dark:border-gray-700"
                                        src="{{ $otherUser->image ? asset('storage/' . $otherUser->image) : 'https://ui-avatars.com/api/?name=' . urlencode($otherUser->name) . '&background=random' }}"
                                        alt="">
                                    @if($unreadCount > 0)
                                        <span class="absolute top-0 right-0 block h-3.5 w-3.5 rounded-full bg-blue-500 border-2 border-white dark:border-gray-900"></span>
                                    @endif
                                </div>
                                <div class="ml-3 overflow-hidden flex-1">
                                    <div class="flex justify-between items-baseline">
                                        <div class="text-sm {{ $unreadCount > 0 ? 'font-bold' : 'font-medium' }} text-gray-900 dark:text-gray-100 truncate">
                                            {{ $otherUser->name }}
                                        </div>
                                    </div>
                                    <div class="flex items-center text-xs {{ $unreadCount > 0 ? 'font-bold text-gray-900 dark:text-white' : 'text-gray-500' }} truncate mt-0.5">
                                        <span class="truncate">{{ $lastMsg ? $lastMsg->content : 'Start a conversation' }}</span>
                                        @if($lastMsg)
                                            <span class="mx-1 text-[8px] opacity-50">&bull;</span>
                                            <span class="whitespace-nowrap">{{ $lastMsg->created_at->diffForHumans(null, true) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Chat Area -->
                <div class="w-2/3 flex flex-col bg-white dark:bg-gray-900 relative">
                    <!-- Chat Header -->
                    <div class="p-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between h-[70px] px-6">
                        <div class="flex items-center">
                            <div class="relative">
                                <img class="h-10 w-10 rounded-full object-cover border border-gray-100 dark:border-gray-800"
                                    src="{{ $conversation->other_user->image ? asset('storage/' . $conversation->other_user->image) : 'https://ui-avatars.com/api/?name=' . urlencode($conversation->other_user->name) . '&background=random' }}"
                                    alt="">
                                <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full bg-green-500 border-2 border-white dark:border-gray-900"></span>
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-bold text-gray-900 dark:text-gray-100">
                                    {{ $conversation->other_user->name }}</div>
                                <div class="text-[11px] text-gray-500 font-medium">Active now</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4 text-gray-600 dark:text-gray-400">
                            <button class="hover:text-gray-900 dark:hover:text-white"><i class="bi bi-telephone fs-5"></i></button>
                            <button class="hover:text-gray-900 dark:hover:text-white"><i class="bi bi-camera-video fs-5"></i></button>
                            <button class="hover:text-gray-900 dark:hover:text-white"><i class="bi bi-info-circle fs-5"></i></button>
                        </div>
                    </div>

                    <!-- Messages Container -->
                    <div id="messages-container"
                        class="flex-1 p-6 overflow-y-auto custom-scrollbar flex flex-col-reverse bg-white dark:bg-gray-900">
                        {{-- We use flex-col-reverse for Instagram-like bottom-anchored scroll --}}
                        <div class="w-full space-y-2 py-4">
                            @foreach($messages as $message)
                                @include('chat.partials.message', ['message' => $message])
                            @endforeach
                        </div>
                    </div>

                    <!-- Input Area -->
                    <div class="p-5">
                        <form id="chat-form" action="{{ route('chat.send', $conversation) }}" method="POST"
                            class="relative flex items-center border border-gray-200 dark:border-gray-700 rounded-full bg-gray-50 dark:bg-gray-800 px-5 py-2 group focus-within:ring-1 focus-within:ring-gray-300 transition-all">
                            @csrf
                            <button type="button" class="text-gray-500 hover:text-gray-800 mr-3">
                                <i class="bi bi-emoji-smile fs-5"></i>
                            </button>
                            <textarea id="message-content" name="content" rows="1"
                                class="flex-1 bg-transparent border-none focus:ring-0 text-sm py-1 dark:text-gray-200 resize-none max-h-32"
                                placeholder="Message..." required></textarea>
                            <div class="flex items-center ml-2">
                                <button type="button" class="text-gray-500 hover:text-gray-800 mx-1 px-1">
                                    <i class="bi bi-image fs-5"></i>
                                </button>
                                <button type="button" class="text-gray-500 hover:text-gray-800 mx-1 px-1">
                                    <i class="bi bi-heart fs-5"></i>
                                </button>
                                <button type="submit" id="send-button"
                                    class="text-blue-500 hover:text-blue-600 font-bold text-sm ml-2 opacity-0 pointer-events-none transition-opacity group-focus-within:opacity-100 group-focus-within:pointer-events-auto">
                                    Send
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #dbdbdb; border-radius: 10px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #363636; }
        
        #messages-container {
            display: flex;
            flex-direction: column;
        }

        /* Override basic textarea styles */
        textarea:focus { outline: none !important; box-shadow: none !important; }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const messagesContainer = document.getElementById('messages-container');
            const chatForm = document.getElementById('chat-form');
            const messageInput = document.getElementById('message-content');
            const sendBtn = document.getElementById('send-button');

            const scrollToBottom = () => {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            };
            scrollToBottom();

            // Toggle Send button visibility
            messageInput.addEventListener('input', function() {
                if (this.value.trim().length > 0) {
                    sendBtn.style.opacity = '1';
                    sendBtn.style.pointerEvents = 'auto';
                } else {
                    sendBtn.style.opacity = '0';
                    sendBtn.style.pointerEvents = 'none';
                }
            });

            // Handle Form Submit
            chatForm.addEventListener('submit', async function (e) {
                e.preventDefault();
                const content = messageInput.value.trim();
                if (!content) return;

                const formData = new FormData(chatForm);
                messageInput.value = '';
                messageInput.style.height = 'auto';
                sendBtn.style.opacity = '0';

                try {
                    const response = await fetch(chatForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                } catch (error) {
                    console.error('Error sending message:', error);
                }
            });

            // Echo Integration
            if (typeof Echo !== 'undefined') {
                Echo.private(`conversation.${@json($conversation->id)}`)
                    .listen('MessageSent', (e) => {
                        fetch(`/chat/message-partial/${e.message.id}`)
                            .then(res => res.text())
                            .then(html => {
                                // Insert into the list child of the flex container
                                const messageList = messagesContainer.querySelector('.w-full');
                                messageList.insertAdjacentHTML('beforeend', html);
                                scrollToBottom();
                            });
                    });
            }

            // Auto-resize textarea
            messageInput.addEventListener('input', function () {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        });
    </script>
@endpush
