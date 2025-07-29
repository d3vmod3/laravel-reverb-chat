<?php

namespace App\Livewire\Messages;

use Livewire\Component;
use App\Models\User;
use App\Models\Conversation;
use Auth;
use Illuminate\Support\Facades\Hash;

class Conversations extends Component
{
    public $users;
    public $number;
    public $current_conversation_id=null;
    public function render()
    {
        
        // dd($users[0]);
        $currentUserId = Auth::id();

    $this->users = User::where('id', '!=', $currentUserId)
        ->get()
        ->map(function ($user) use ($currentUserId) {
            // Find existing 1-on-1 conversation
            $conversation = Conversation::where('is_group', false)
                ->whereHas('participants', fn($q) => $q->where('user_id', $currentUserId))
                ->whereHas('participants', fn($q) => $q->where('user_id', $user->id))
                ->withCount('participants')
                ->having('participants_count', 2)
                ->first();

            $user->conversation_id = $conversation?->id ?? null;

            return $user;
        });
        return view('livewire.messages.conversations');
    }
    public function viewConversation($conversationWithId)
    {
        // dd($converstationWithId);
        $count_conversation = Conversation::where('is_group', false)
            ->whereHas('participants', fn($q) => $q->where('user_id', Auth::user()->id))
            ->whereHas('participants', fn($q) => $q->where('user_id', $conversationWithId))
            ->withCount('participants')
            ->having('participants_count', 2)
            ->first();

        if($count_conversation === null)
        {
            $conversation = new Conversation;
            $conversation->name = Hash::make($conversationWithId);
            $conversation->is_group = false;
            $conversation->save();
            $conversationId = $conversation->id;


            $conversation->participants()->attach([
                Auth::id() => ['role' => 'member'],
                $conversationWithId => ['role' => 'member'],
            ]);
            $this->current_conversation_id = $conversationId;
        }
        else
        {
            $this->current_conversation_id = $count_conversation->id;
        }
    }
}
