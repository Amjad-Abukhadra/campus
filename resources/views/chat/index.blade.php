@extends('layouts.app')

@section('content')
    <div class="py-4 py-md-5" style="position: relative; z-index: 1;">
        <div class="container-xl">
            <div class="row g-0 bg-white rounded-4 shadow-lg overflow-hidden" style="height: 85vh; max-height: 800px; position: relative; z-index: 1;">
                
                {{-- ============== SIDEBAR (Conversations List) ============== --}}
                <div class="col-md-4 border-end border-light d-flex flex-column bg-light">
                    
                    {{-- Header --}}
                    <div class="p-4 border-bottom border-light sticky-top bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="fw-bold mb-1">
                                    <i class="bi bi-chat-dots text-primary me-2"></i>Messages
                                </h4>
                                <small class="text-muted d-block">Chat List</small>
                            </div>
                            <button class="btn btn-light rounded-3 p-2" title="Start new chat">
                                <i class="bi bi-pencil-square text-primary fs-5"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Conversations List --}}
                    <div class="flex-grow-1 overflow-y-auto" style="min-height: 0;">
                        @forelse($conversations as $conv)
                            @php
                                $otherUser = $conv->other_user;
                                $lastMsg = $conv->messages->last();
                                $unreadCount = $conv->messages->where('is_read', false)->where('sender_id', '!=', auth()->id())->count();
                                $isActive = isset($conversation) && $conversation->id === $conv->id;
                            @endphp
                            <a href="{{ route('chat.show', $conv) }}"
                                class="d-flex align-items-center gap-3 px-3 py-3 mx-2 mb-2 rounded-3 text-decoration-none transition-all {{ $isActive ? 'bg-white shadow-sm border border-primary border-2' : 'bg-white-50 border border-transparent' }} group position-relative"
                                style="cursor: pointer;">
                                
                                {{-- User Avatar with Unread Indicator --}}
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
                                        <span class="fw-bold text-dark text-truncate">
                                            {{ $otherUser->name }}
                                        </span>
                                        @if($lastMsg)
                                            <small class="text-muted ms-2">
                                                {{ $lastMsg->created_at->diffForHumans(null, true) }}
                                            </small>
                                        @endif
                                    </div>
                                    <small class="d-block text-truncate {{ $unreadCount > 0 ? 'fw-bold text-dark' : 'text-muted' }}">
                                        {{ $lastMsg ? ($lastMsg->sender_id === auth()->id() ? 'You: ' : '') . $lastMsg->content : 'Start a conversation' }}
                                    </small>
                                </div>
                            </a>
                        @empty
                            <div class="text-center p-5 mt-5">
                                <div class="bg-white rounded-4 shadow-sm d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                                    <i class="bi bi-chat-quote text-primary fs-2"></i>
                                </div>
                                <h5 class="fw-bold text-dark">No Messages</h5>
                                <small class="text-muted d-block mt-2">Connect with others to start chatting.</small>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- ============== CHAT AREA (On the Right) ============== --}}
                <div class="col-md-8 d-flex flex-column position-relative bg-white" style="overflow: hidden;">
                    
                    @if(isset($conversation))
                        {{-- Chat Header --}}
                        <div class="border-bottom border-light p-4 bg-white shadow-sm">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <img class="rounded-circle border-2 border-light shadow-sm"
                                        src="{{ $conversation->other_user->image ? asset('storage/' . $conversation->other_user->image) : 'https://ui-avatars.com/api/?name=' . urlencode($conversation->other_user->name) . '&background=random' }}"
                                        alt="{{ $conversation->other_user->name }}"
                                        style="width: 48px; height: 48px; object-fit: cover;">
                                    <div>
                                        <h6 class="fw-bold mb-0">{{ $conversation->other_user->name }}</h6>
                                        <small class="text-muted">
                                            <i class="bi bi-dot text-success"></i>Active now
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
                                        <i class="bi bi-three-dots-vertical text-primary"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Messages Container --}}
                        <div id="messages-container-{{ $conversation->id }}" class="flex-grow-1 overflow-y-auto p-4 bg-light" style="min-height: 0;">
                            <div class="mx-auto" style="max-width: 55%;">
                            @forelse($conversation->messages as $message)
                                @include('chat.partials.message', ['message' => $message])
                            @empty
                                <div class="m-auto text-center">
                                    <div class="bg-white rounded-4 d-inline-flex align-items-center justify-content-center mb-4" style="width: 100px; height: 100px;">
                                        <i class="bi bi-chat text-primary" style="font-size: 3rem;"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark">Start the conversation</h6>
                                    <small class="text-muted">Be the first to send a message</small>
                                </div>
                            @endforelse
                            </div>
                        </div>

                        {{-- Message Input --}}
                        <div class="border-top border-light p-4 bg-white">
                            <form id="chat-form-{{ $conversation->id }}" action="{{ route('chat.send', $conversation) }}" method="POST" class="d-flex gap-2 align-items-center" data-no-loader>
                                @csrf
                                <div class="flex-grow-1 bg-light rounded-4 d-flex align-items-center px-3">
                                    <textarea id="message-input-{{ $conversation->id }}" name="content" rows="1"
                                        class="form-control bg-transparent border-0 shadow-none py-2 resize-none"
                                        placeholder="Type a message..." 
                                        style="max-height: 120px; min-height: 44px;"
                                        required></textarea>
                                </div>
                                <button type="submit" id="send-btn-{{ $conversation->id }}" 
                                    class="btn btn-primary rounded-3 p-2 opacity-50"
                                    disabled>
                                    <i class="bi bi-send"></i>
                                </button>
                            </form>
                        </div>

                    @else
                        {{-- Empty Chat State --}}
                        <div class="d-flex flex-column align-items-center justify-content-center flex-grow-1 text-center p-5">
                            <div class="bg-light rounded-4 d-inline-flex align-items-center justify-content-center mb-5" style="width: 120px; height: 120px;">
                                <i class="bi bi-send text-primary" style="font-size: 4rem;"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-2">Select a Chat</h4>
                            <p class="text-muted">Pick a conversation from the sidebar to continue your discussions.</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <style>
        .row > .col-md-4, .row > .col-md-8 {
            overflow: hidden;
        }
        
        /* Custom scrollbar */
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

        .resize-none {
            resize: none;
        }

        #messages-container-{{ isset($conversation) ? $conversation->id : '' }} {
            scroll-behavior: smooth;
        }
    </style>

    @if(isset($conversation))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const conversationId = {{ $conversation->id }};
            const messagesContainer = document.getElementById('messages-container-' + conversationId);
            const chatForm = document.getElementById('chat-form-' + conversationId);
            const messageInput = document.getElementById('message-input-' + conversationId);
            const sendBtn = document.getElementById('send-btn-' + conversationId);

            // Auto-scroll to bottom
            const scrollToBottom = () => {
                if (messagesContainer) {
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }
            };
            scrollToBottom();

            // Toggle Send Button based on input
            if (messageInput) {
                messageInput.addEventListener('input', function() {
                    if (this.value.trim().length > 0) {
                        sendBtn.classList.remove('opacity-50');
                        sendBtn.removeAttribute('disabled');
                    } else {
                        sendBtn.classList.add('opacity-50');
                        sendBtn.setAttribute('disabled', 'disabled');
                    }
                    
                    // Auto-resize textarea
                    this.style.height = 'auto';
                    this.style.height = Math.min(this.scrollHeight, 120) + 'px';
                });

                // Send on Enter (Shift+Enter for new line)
                messageInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' && !e.shiftKey) {
                        e.preventDefault();
                        if (this.value.trim().length > 0) {
                            chatForm.requestSubmit();
                        }
                    }
                });
            }

            // AJAX Form Submit
            if (chatForm) {
                chatForm.addEventListener('submit', async function (e) {
                    e.preventDefault();
                    const content = messageInput.value.trim();
                    if (!content) return;

                    const formData = new FormData(chatForm);
                    messageInput.value = '';
                    messageInput.style.height = 'auto';
                    sendBtn.classList.add('opacity-50');
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
                                const messageList = messagesContainer.querySelector('.mx-auto');
                                if (messageList) {
                                    messageList.insertAdjacentHTML('beforeend', data.html);
                                    scrollToBottom();
                                }
                            }
                        }
                    } catch (error) {
                        console.error('Error sending message:', error);
                    }
                });
            }

            // Real-Time Messaging with Echo (WebSocket) + Polling Fallback
            let lastMessageId = {{ isset($conversation) && $conversation->messages->last() ? $conversation->messages->last()->id : 0 }};
            let pollingInterval;
            let usingEcho = false;

            // Try to use Echo for instant real-time messaging
            if (typeof Echo !== 'undefined') {
                usingEcho = true;
                console.log('✅ Using Echo for instant real-time messaging');
                
                Echo.private(`conversation.${conversationId}`)
                    .listen('MessageSent', (e) => {
                        fetch(`/chat/message-partial/${e.message.id}`)
                            .then(res => res.text())
                            .then(html => {
                                const messageList = messagesContainer.querySelector('.mx-auto');
                                if (messageList) {
                                    messageList.insertAdjacentHTML('beforeend', html);
                                    scrollToBottom();
                                    lastMessageId = e.message.id;
                                }
                            });
                    });
            } else {
                // Fallback to polling if Echo is not available
                console.log('⚠️ Echo not available, using polling (3-second delay)');
                
                function pollForNewMessages() {
                    fetch(`/chat/${conversationId}/poll?last_message_id=${lastMessageId}`, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.has_new && data.html) {
                            const messageList = messagesContainer.querySelector('.mx-auto');
                            if (messageList) {
                                messageList.insertAdjacentHTML('beforeend', data.html);
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
    @endif
@endsection