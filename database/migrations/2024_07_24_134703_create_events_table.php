<?php

use App\Enums\RecurringTypes;
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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->time('start_time');
            $table->time('end_time');
            $table->tinyInteger('day_of_the_week')->nullable();
            $table->enum('recurring', [
                RecurringTypes::NONE->value,
                RecurringTypes::WEEKLY->value,
                RecurringTypes::EVEN_WEEKLY->value,
                RecurringTypes::ODD_WEEKLY->value
            ])->default(RecurringTypes::NONE->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
