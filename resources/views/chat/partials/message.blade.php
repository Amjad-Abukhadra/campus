@php
    $isMe = $message->sender_id === auth()->id();
@endphp

<div class="d-flex {{ $isMe ? 'justify-content-end' : 'justify-content-start' }} mb-3 animate-fadeIn">
    <div class="position-relative" style="max-width: 75%;">
        {{-- Message Bubble --}}
        <div class="px-4 py-3 rounded-4 shadow-sm transition-all
            {{ $isMe 
                ? 'bg-primary text-white rounded-end-0' 
                : 'bg-light text-dark rounded-start-0' 
            }}">
            <div class="lh-base" style="word-wrap: break-word; white-space: pre-wrap;">
                {!! nl2br(e($message->content)) !!}
            </div>
        </div>

        {{-- Timestamp & Status --}}
        <div class="d-flex align-items-center mt-1 gap-2 small text-muted message-meta {{ $isMe ? 'justify-content-end' : 'justify-content-start' }}">
            @if($isMe)
                <span class="fw-medium">
                    {{ $message->created_at->format('H:i') }}
                </span>
                <div class="d-flex align-items-center gap-1">
                    @if($message->is_read)
                        <i class="bi bi-check2-all text-primary"></i>
                        <span class="text-muted" style="font-size: 0.75rem;">{{ $message->created_at->diffForHumans() }}</span>
                    @else
                        <i class="bi bi-check2 text-muted"></i>
                        <span class="text-muted" style="font-size: 0.75rem;">{{ $message->created_at->diffForHumans() }}</span>
                    @endif
                </div>
            @else
                <span class="fw-medium">
                    {{ $message->created_at->format('H:i') }}
                </span>
                <span style="font-size: 0.75rem;">
                    {{ $message->created_at->diffForHumans() }}
                </span>
            @endif
        </div>
    </div>
</div>

<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fadeIn {
        animation: fadeIn 0.3s ease-out;
    }

    .message-meta {
        opacity: 0.7;
        transition: opacity 0.2s ease;
    }

    .animate-fadeIn:hover .message-meta {
        opacity: 1;
    }

    .transition-all {
        transition: all 0.2s ease;
    }

    .animate-fadeIn:hover .transition-all {
        transform: scale(1.02);
    }

    @media (max-width: 640px) {
        .d-flex > .position-relative {
            max-width: 85% !important;
        }
    }
</style>