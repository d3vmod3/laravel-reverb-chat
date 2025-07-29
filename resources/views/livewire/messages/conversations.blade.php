<div class="flex items-start max-md:flex-col h-1/2">
    <div class="me-10 w-full pb-4 md:w-[220px]">
        Your friends list here
        <flux:navlist>
            {{$number}}
            @if($users)
            @foreach($users as $user)
                <flux:navlist.item class="cursor-pointer" wire:navigate wire:click="viewConversation({{$user->id}})">
                    {{$user->name}}
                </flux:navlist.item>
            @endforeach
            @endif
        </flux:navlist>
    </div>

    <flux:separator class="md:hidden" />

    <div class="flex-1 self-stretch max-md:pt-6">
        <flux:heading>{{ $heading ?? '' }}</flux:heading>
        <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>
        @if($current_conversation_id)
        <div class="mt-5">
            @livewire('messages.conversation', ['conversation_id' => $current_conversation_id], key($current_conversation_id))
        </div>
        @endif
    </div>
</div>
