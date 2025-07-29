<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id(); // Equivalent to SERIAL PRIMARY KEY
            $table->foreignId('conversation_id')
                  ->constrained()
                  ->onDelete('cascade'); // DELETE message if conversation is deleted

            $table->foreignId('sender_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null'); // If user is deleted, keep message but null the sender

            $table->text('content')->nullable();
            $table->string('message_type', 20)->default('text'); // e.g., 'text', 'image', 'file'

            $table->timestamp('created_at')->useCurrent(); // Default to current timestamp
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
