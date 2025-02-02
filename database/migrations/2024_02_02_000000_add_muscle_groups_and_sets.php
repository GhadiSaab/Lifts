<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('exercises', 'muscle_group')) {
            Schema::table('exercises', function (Blueprint $table) {
                $table->string('muscle_group')->after('name'); // Chest, Back, Legs, etc.
            });
        }

        Schema::create('exercise_sets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exercise_progress_id')->constrained('exercise_progress')->onDelete('cascade');
            $table->decimal('weight', 5, 2);
            $table->integer('reps');
            $table->integer('rest_time')->nullable(); // in seconds
            $table->integer('set_number');
            $table->timestamps();
        });

        // Move existing exercise_progress data to sets
        DB::statement('
            INSERT INTO exercise_sets (exercise_progress_id, weight, reps, set_number, created_at, updated_at)
            SELECT id, weight, reps, 1, created_at, updated_at FROM exercise_progress
        ');

        // Remove weight and reps from exercise_progress since they're now in sets
        Schema::table('exercise_progress', function (Blueprint $table) {
            $table->dropColumn(['weight', 'reps']);
        });
    }

    public function down()
    {
        Schema::table('exercise_progress', function (Blueprint $table) {
            $table->decimal('weight', 5, 2);
            $table->integer('reps');
        });

        // Move data back from first set
        DB::statement('
            UPDATE exercise_progress ep
            JOIN exercise_sets es ON ep.id = es.exercise_progress_id AND es.set_number = 1
            SET ep.weight = es.weight, ep.reps = es.reps
        ');

        Schema::dropIfExists('exercise_sets');

        Schema::table('exercises', function (Blueprint $table) {
            $table->dropColumn('muscle_group');
        });
    }
};
