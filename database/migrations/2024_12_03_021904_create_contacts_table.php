<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        
        Schema::create('contacts', function (Blueprint $table) {  
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->string('nom')->nullable();
            $table->text('prenom')->nullable();
            $table->string('image')->nullable();
            $table->string('email')->nullable();
            $table->integer('numeroTelephone')->nullable(); 
            $table->boolean('is_favorite')->default(false);  
            $table->timestamps();  
        });  
    }

    
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
