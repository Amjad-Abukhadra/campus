@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-center" style="min-height: calc(100vh - 120px); padding: 1rem 0; position: relative; z-index: 1;">
        <div class="container-xl">
            <div class="row g-0 bg-white rounded-4 shadow-lg overflow-hidden" style="height: 85vh; max-height: 800px; min-height: 500px; position: relative; z-index: 1;">
                
                {{-- ============== SIDEBAR (Conversations List) ============== --}}
                <div class="col-md-4 border-end border-light d-none d-md-flex flex-column bg-light" style="height: 100%; overflow: hidden;">
                    
                    {{-- Header --}}
                    <div class="p-4 border-bottom border-light sticky-top bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="fw-bold mb-1">
                                    <i class="bi bi-chat-dots text-primary me-2"></i>Messages
                                </h5>
                                <small class="text-muted">Chat List</small>
                            </div>
                            <a href="{{ route('chat.index') }}" class="btn btn-light rounded-3 p-2">
                                <i class="bi bi-pencil-square text-primary"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Conversations List --}}
                    <div class="flex-grow-1 overflow-y-auto" style="min-height: 0;">
                        @foreach($conversations as $conv)
                            @php
                                $otherUser = $conv->other_user;
                                $lastMsg = $conv->messages->last();
                                $unreadCount = $conv->messages->where('is_read', false)->where('sender_id', '!=', auth()->id())->count();
                                $isActive = $conversation->id === $conv->id;
                            @endphp
                            <a href="{{ route('chat.show', $conv) }}"
                                class="d-flex align-items-center gap-3 px-3 py-3 mx-2 mb-2 rounded-3 text-decoration-none transition-all {{ $isActive ? 'bg-white shadow-sm border border-primary border-2' : 'bg-white-50 border border-transparent' }}"
                                style="cursor: pointer;">
                                
                                {{-- User Avatar --}}
                                <div class="position-relative flex-shrink-0">
                                    <div class="rounded-circle {{ $unreadCount > 0 ? 'border border-3 border-primary' : '' }}" style="padding: 2px;">
                                        <img class="rounded-circle border-2 border-white shadow-sm"
                                            src="{{ $otherUser->image ? asset('storage/' . $otherUser->image) : 'https://ui-avatars.com/api/?name=' . urlencode($otherUser->name) . '&background=random' }}"
                                            alt="{{ $otherUser->name }}"
                                            style="width: 56px; height: 56px; object-fit: cover;">
                                    </div>
                                    @if($unreadCount > 0)
                                        <span class="position-absolute top-0 end-0 badge bg-primary border-2 border-white" style="font-size: 9px; padding: 4px 6px;">
                                            {{ $unreadCount }}
                                        </span>
                                    @endif
                                </div>

                                {{-- User Info --}}
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="fw-bold text-dark text-truncate {{ $isActive ? 'text-primary' : '' }}">
                                            {{ $otherUser->name }}
                                        </span>
                                        @if($lastMsg)
                                            <small class="text-muted ms-2">
                                                {{ $lastMsg->created_at->diffForHumans(null, true) }}
                                            </small>
                                        @endif
                                    </div>
                                    <small class="d-block text-truncate {{ $unreadCount > 0 ? 'fw-bold text-dark' : 'text-muted' }}">
                                        {{ $lastMsg ? $lastMsg->content : 'Start a conversation' }}
                                    </small>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- ============== CHAT AREA ============== --}}
                <div class="col-md-8 d-flex flex-column position-relative bg-white" style="height: 100%; overflow: hidden;">
                    
                    {{-- Chat Header --}}
                    <div class="border-bottom border-light p-4 bg-white shadow-sm flex-shrink-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <a href="{{ route('chat.index') }}" class="d-md-none btn btn-link text-gray-500 p-0 me-2">
                                    <i class="bi bi-chevron-left fs-5"></i>
                                </a>
                                <div class="position-relative">
                                    <img class="rounded-3 border-2 border-light shadow-sm"
                                        src="{{ $conversation->other_user->image ? asset('storage/' . $conversation->other_user->image) : 'https://ui-avatars.com/api/?name=' . urlencode($conversation->other_user->name) . '&background=random' }}"
                                        alt="{{ $conversation->other_user->name }}"
                                        style="width: 48px; height: 48px; object-fit: cover;">
                                    <span class="position-absolute bottom-0 end-0 badge bg-success border-2 border-white" style="width: 12px; height: 12px; padding: 0;"></span>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">{{ $conversation->other_user->name }}</h6>
                                    <small class="text-success">
                                        <i class="bi bi-dot"></i>Online
                                    </small>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-light rounded-3 p-2" title="Call">
                                    <i class="bi bi-telephone text-primary"></i>
                                </button>
                                <button class="btn btn-light rounded-3 p-2" title="Video call">
                                    <i class="bi bi-camera-video text-primary"></i>
                                </button>
                                <button class="btn btn-light rounded-3 p-2" title="More options">
                                    <i class="bi bi-info-circle text-primary"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Messages Container --}}
                    <div id="messages-container" class="flex-grow-1 overflow-y-auto p-4 bg-light" style="min-height: 0;">
                        <div class="mx-auto p-4" >
                            @php $lastDate = null; @endphp
                            @foreach($messages as $message)
                                @php $currentDate = $message->created_at->format('Y-m-d'); @endphp
                                @if($lastDate !== $currentDate)
                                    <div class="d-flex justify-content-center my-4">
                                        <span class="px-3 py-1 bg-white text-muted small fw-bold rounded-pill border border-light">
                                            {{ $message->created_at->isToday() ? 'Today' : ($message->created_at->isYesterday() ? 'Yesterday' : $message->created_at->format('M d, Y')) }}
                                        </span>
                                    </div>
                                    @php $lastDate = $currentDate; @endphp
                                @endif
                                @include('chat.partials.message', ['message' => $message])
                            @endforeach
                        </div>
                    </div>

                    {{-- Message Input Area --}}
                    <div class="p-4 bg-white border-top border-light flex-shrink-0">
                        <form id="chat-form" action="{{ route('chat.send', $conversation) }}" method="POST" class="d-flex gap-2 align-items-flex-end" data-no-loader>
                            @csrf
                            <input type="file" id="file-input" class="d-none" multiple>
                            
                            <button type="button" id="plus-btn" class="btn btn-light rounded-3 p-2" title="Attach files">
                                <i class="bi bi-plus-circle-fill text-primary"></i>
                            </button>

                            <div class="flex-grow-1 bg-light rounded-4 d-flex align-items-center px-3">
                                <textarea id="message-content" name="content" rows="1"
                                    class="form-control bg-transparent border-0 shadow-none py-2 resize-none"
                                    placeholder="Type a message..." 
                                    style="max-height: 120px; min-height: 44px;"
                                    required></textarea>
                                <button type="button" id="emoji-btn" class="btn btn-link text-muted p-2 ms-2" title="Emoji">
                                    <i class="bi bi-emoji-smile"></i>
                                </button>
                            </div>

                            <button type="submit" id="send-button"
                                class="btn btn-primary rounded-3 p-2 opacity-50 disabled"
                                disabled>
                                <i class="bi bi-send"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        
        ::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.08);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.12);
        }

        #message-content:focus {
            outline: none !important;
            box-shadow: none !important;
        }

        #messages-container {
            scroll-behavior: smooth;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const messagesContainer = document.getElementById('messages-container');
            const chatForm = document.getElementById('chat-form');
            const messageInput = document.getElementById('message-content');
            const sendBtn = document.getElementById('send-button');
            const fileInput = document.getElementById('file-input');
            const plusBtn = document.getElementById('plus-btn');
            const emojiBtn = document.getElementById('emoji-btn');

            const scrollToBottom = () => {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            };
            scrollToBottom();

            {{-- File Picker --}}
            plusBtn.addEventListener('click', () => fileInput.click());
            fileInput.addEventListener('change', () => {
                if (fileInput.files.length > 0) {
                    alert('Attached ' + fileInput.files.length + ' file(s)');
                }
            });

            {{-- Emoji Picker --}}
            emojiBtn.addEventListener('click', () => {
                const emojis = ['😊', '😂', '🔥', '👍', '🙏', '💯', '❤️', '✨'];
                const randomEmoji = emojis[Math.floor(Math.random() * emojis.length)];
                messageInput.value += randomEmoji;
                messageInput.dispatchEvent(new Event('input'));
                messageInput.focus();
            });

            {{-- Toggle Send Button --}}
            messageInput.addEventListener('input', function() {
                if (this.value.trim().length > 0) {
                    sendBtn.classList.remove('opacity-50', 'disabled');
                    sendBtn.removeAttribute('disabled');
                } else {
                    sendBtn.classList.add('opacity-50', 'disabled');
                    sendBtn.setAttribute('disabled', 'disabled');
                }
                
                this.style.height = 'auto';
                this.style.height = Math.min(this.scrollHeight, 120) + 'px';
            });

            {{-- Send on Enter --}}
            messageInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    if (this.value.trim().length > 0) {
                        chatForm.requestSubmit();
                    }
                }
            });

            // Helper to append message safely
            const appendMessage = (html, id) => {
                if (document.querySelector(`[data-message-id="${id}"]`)) return; // Prevent duplicates
                
                const messageList = messagesContainer.querySelector('.mx-auto');
                messageList.insertAdjacentHTML('beforeend', html);
                scrollToBottom();
                
                if (id > lastMessageId) {
                    lastMessageId = id;
                }
            };

            {{-- Form Submit --}}
            chatForm.addEventListener('submit', async function (e) {
                e.preventDefault();
                const content = messageInput.value.trim();
                if (!content) return;

                const formData = new FormData(chatForm);
                messageInput.value = '';
                messageInput.style.height = 'auto';
                sendBtn.classList.add('opacity-50', 'disabled');
                sendBtn.setAttribute('disabled', 'disabled');

                try {
                    const response = await fetch(chatForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });

                    if (response.ok) {
                        const data = await response.json();
                        // Add the message to the chat immediately
                        if (data.html) {
                            // Extract ID from HTML string if not provided in JSON
                            // But usually best if controller returns ID. 
                            // We will try to extract it from the data-message-id attribute in the HTML
                            const tempDiv = document.createElement('div');
                            tempDiv.innerHTML = data.html;
                            const newMsg = tempDiv.firstElementChild;
                            const newId = newMsg.getAttribute('data-message-id');
                            
                            appendMessage(data.html, newId);
                        }
                    }
                } catch (error) {
                    console.error('Error sending message:', error);
                }
            });

            // Real-Time Messaging with Echo (WebSocket) + Polling Fallback
            let lastMessageId = {{ $messages->last() ? $messages->last()->id : 0 }};
            let pollingInterval;
            let usingEcho = false;

            // Try to use Echo for instant real-time messaging
            if (typeof Echo !== 'undefined') {
                usingEcho = true;
                console.log('✅ Using Echo for instant real-time messaging');
                
                Echo.private(`conversation.{{ $conversation->id }}`)
                    .listen('MessageSent', (e) => {
                        // Check duplicate before fetch
                        if (document.querySelector(`[data-message-id="${e.message.id}"]`)) return;

                        fetch(`/chat/message-partial/${e.message.id}`)
                            .then(res => res.text())
                            .then(html => {
                                appendMessage(html, e.message.id);
                            });
                    });
            } else {
                // Fallback to polling if Echo is not available
                console.log('⚠️ Echo not available, using polling (3-second delay)');
                
                function pollForNewMessages() {
                    fetch(`/chat/{{ $conversation->id }}/poll?last_message_id=${lastMessageId}`, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.has_new && data.html) {
                            // The poll might return multiple messages in one HTML block or we might need to handle it.
                            // Assuming backend returns a single block of HTML for all new messages.
                            // We should really strictly check IDs but fast solution:
                            if(data.last_message_id > lastMessageId) {
                                 const messageList = messagesContainer.querySelector('.mx-auto');
                                 messageList.insertAdjacentHTML('beforeend', data.html); // Polling usually guaranteed new by ID
                                 scrollToBottom();
                                 lastMessageId = data.last_message_id;
                            }
                        }
                    })
                    .catch(error => console.error('Polling error:', error));
                }

                // Start polling every 3 seconds
                pollingInterval = setInterval(pollForNewMessages, 3000);

                // Stop polling when page is hidden (save resources)
                document.addEventListener('visibilitychange', function() {
                    if (document.hidden) {
                        clearInterval(pollingInterval);
                    } else {
                        pollingInterval = setInterval(pollForNewMessages, 3000);
                    }
                });
            }
        });
    </script>
@endsection