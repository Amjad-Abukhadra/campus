@php
    $isMe = $message->sender_id === auth()->id();
@endphp

<div class="d-flex {{ $isMe ? 'justify-content-end' : 'justify-content-start' }} mb-2 animate-fadeIn"
    data-message-id="{{ $message->id }}">

    <div class="d-flex flex-column {{ $isMe ? 'align-items-end' : 'align-items-start' }}" style="max-width: 60%;">

        {{-- Message Bubble --}}
        <div class="message-bubble px-2 rounded-4 shadow-sm transition-all
            {{ $isMe
    ? 'bg-primary text-white rounded-end-0'
    : 'bg-light text-dark rounded-start-0'
            }}">

            <div class="message-text">
                {!! nl2br(e($message->content)) !!}
            </div>
        </div>

        {{-- Timestamp & Status --}}
        <div class="d-flex align-items-center mt-1 gap-2 small text-muted message-meta
            {{ $isMe ? 'justify-content-end' : 'justify-content-start' }}">

            <span class="fw-medium">
                {{ $message->created_at->format('H:i') }}
            </span>

            @if($isMe)
                <div class="d-flex align-items-center gap-1">
                    @if($message->is_read)
                        <i class="bi bi-check2-all text-primary"></i>
                    @else
                        <i class="bi bi-check2 text-muted"></i>
                    @endif
                    <span class="time-ago">
                        {{ $message->created_at->diffForHumans() }}
                    </span>
                </div>
            @else
                <span class="time-ago">
                    {{ $message->created_at->diffForHumans() }}
                </span>
            @endif

        </div>
    </div>
</div>

<style>
    .message-bubble {
        align-self: flex-start;
        max-width: 100%;
        max-height: 60%;
    }

    .message-text {
        word-wrap: break-word;
        white-space: pre-wrap;
        font-size: 0.85rem;
        line-height: 1.3;
        text-align: left;
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(6px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fadeIn {
        animation: fadeIn 0.25s ease-out;
    }

    .message-meta {
        opacity: 0.65;
        transition: opacity 0.2s ease;
    }

    .animate-fadeIn:hover .message-meta {
        opacity: 1;
    }

    .transition-all {
        transition: all 0.2s ease;
    }

    .animate-fadeIn:hover .transition-all {
        transform: scale(1.01);
    }

    .time-ago {
        font-size: 0.7rem;
    }

    @media (max-width: 640px) {
        .animate-fadeIn>div {
            max-width: 75% !important;
        }
    }
</style>