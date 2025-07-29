<div>
    
    <div class="relative border rounded-xl">
    <h1 class="border-b p-2">{{$conversation_with_name}}</h1>
        <div class="max-h-[600px] overflow-y-auto pb-2 p-2">
            @if($messages)
            @foreach ($messages as $message)
                <div class="flex {{ $message['sender_id'] === Auth::id() ? 'justify-end' : 'justify-start' }}">
                    <div class="border p-2 my-2 rounded-lg">
                        {{ $message['content'] }}
                    </div>
                </div>
            @endforeach
            @endif
            @if($who_is_typing && Auth::user()->name !== $who_is_typing)
                <i class="text-sm">{{$conversation_with_name}} is typing...</i>
            @endif
        </div>
        
    </div>
    <div class="sticky bottom-0 w-full p-2">
        <div class="flex justif-items-between items-center space-x-4">
            <flux:textarea rows="2" placeholder="type something..." wire:model="content" resize="none" wire:keyup.debounce.500ms="updateIsTyping"/>
            <flux:button wire:click="sendMessage" variant="primary" class="py-8" color="zinc">Send</flux:button>
        </div>
    </div>
</div>


