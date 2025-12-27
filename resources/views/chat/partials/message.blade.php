<div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }} mb-1">
    <div class="max-w-[70%] group relative">
        <div class="px-4 py-2 text-sm {{ $message->sender_id === auth()->id()
    ? 'bg-blue-500 text-white rounded-[20px] rounded-br-[4px]'
    : 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-[20px] rounded-bl-[4px]' }}">
            {!! nl2br(e($message->content)) !!}
        </div>
        <div
            class="text-[10px] text-gray-400 mt-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity absolute {{ $message->sender_id === auth()->id() ? 'right-0' : 'left-0' }} -bottom-4 bg-white dark:bg-gray-900 z-10 rounded shadow-sm">
            {{ $message->created_at->format('H:i') }}
        </div>
    </div>
</div>