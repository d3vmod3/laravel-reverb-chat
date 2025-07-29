<?php

namespace App\Livewire\Messages;

use Livewire\Component;
use App\Models\Message;
use App\Models\ConversationParticipant;
use Auth;
use App\Events\SendRealtimeMessage;
use App\Events\TypingEvent;
use Livewire\Attributes\On;
use Livewire\WithBroadcasting;


class Conversation extends Component
{
    public $conversation_id;
    public $content='';
    public $message_type="text";
    public $conversation;
    public $messages=[];
    public $message;
    public $conversation_with_name;
    public $who_is_typing;
    public $receiver_id;



    public function mount($conversation_id)
    {
        $this->conversation_id = $conversation_id;
        $this->getConversation();
        $this->getConversationWithName();
        
    }

    public function getConversationWithName()
    {
        $participants = ConversationParticipant::where('conversation_id', $this->conversation_id)->get();
        foreach ($participants as $participant) {
            if ($participant->user->id !== Auth::id())
            {
                $this->conversation_with_name = $participant->user->name;
                $this->receiver_id = $participant->user->id;
            }
        }
    }
    public function getConversation()
    {
        if($this->conversation_id){
            $this->messages = Message::where('conversation_id', $this->conversation_id)->get()->map(fn($m) => $m->toArray())->all();

            // dd($messages);
        }
    }

    public function render()
    {
        return view('livewire.messages.conversation');
    }
    public function sendMessage()
    {
        $sender_id = Auth::user()->id; //get current logged in user id

        //create new message
        $message = new Message;
        $message->sender_id = $sender_id;
        $message->content = $this->content;
        $message->message_type = $this->message_type;
        $message->conversation_id = $this->conversation_id;
        
        $message->save();
        
        // $this->message = $message;
        $this->content = "";
        broadcast(new \App\Events\TypingEvent(null));
        event(new SendRealtimeMessage($message));
    }
    
    #[On('echo:private-message-channel,SendRealtimeMessage')]
    public function messageReceived($payload)
    {
        // dd($payload['message']);
        $this->messages[] = $payload['message'];
        // $this->messages[] = new Message($payload['message']);
    }

    public function updateIsTyping()
    {
        if(strlen($this->content) !== 0)
        {
            broadcast(new \App\Events\TypingEvent(auth()->user()));
        }
        else
        {
            broadcast(new \App\Events\TypingEvent(null));
        }
    }
    #[On('echo:private-message-channel,TypingEvent')]
    public function isTyping($payload)
    {
        if($payload)
        {
            $this->who_is_typing = $payload['name'];
        }
        else
        {
            $this->who_is_typing = null;
        }
        
    }
    
}
