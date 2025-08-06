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
        Schema::create('event_securities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->string('access_code', 50);
            $table->string('security_type', 50);
            $table->unsignedBigInteger('incident_id')->nullable();
            $table->dateTime('date');
            $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('incident_id')
                ->references('id')
                ->on('event_securities') 
                ->onDelete('set null')  
                ->onUpdate('cascade');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_securities');
    }
};
