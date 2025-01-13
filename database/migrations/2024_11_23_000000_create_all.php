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
        $this->create();
    }


    private function create(): void {

        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('role');
            $table->string('user_code');
            $table->string('academic_career');
            $table->integer('total_point')->default(0);
            $table->dateTime('completion_date')->nullable();
            $table->integer('semester');
            $table->string('gender');
            $table->string('email');
            $table->string('password');
            $table->string('profile_picture')->nullable();
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });

        Schema::create('campuses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('campus_name');
            $table->string('description');
            $table->integer('minimum_semester')->nullable();
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });

        Schema::create('campus_progress', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('campus_id');
            $table->boolean('is_locked')->default(true);
            $table->boolean('is_story_locked')->default(true);
            $table->boolean('is_semester_locked');
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });

        Schema::create('rooms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('campus_id');
            $table->string('room_name');
            $table->string('type');
            $table->string('background');
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });

        Schema::create('characters', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('campus_id')->nullable();
            $table->string('character_name');
            $table->string('character_image')->nullable();
            $table->json('roles');
            $table->string('description');
            $table->string('gender');
            $table->json('likes');
            $table->json('dislikes');
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });

        Schema::create('quests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('description');
            $table->uuid('unlock_campus_id')->nullable();
            $table->uuid('unlock_quest_id')->nullable();
            $table->uuid('unlock_activity_id')->nullable();
            $table->integer('completion_point')->default(0);
            $table->dateTime('date_start')->nullable();
            $table->dateTime('date_end')->nullable();
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });

        Schema::create('quest_progress', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('status');
            $table->boolean('is_completed')->default(false);
            $table->dateTime('completion_date')->nullable();
            $table->uuid('quest_id');
            $table->uuid('user_id');
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });

        Schema::create('activities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('activity_name');
            $table->string("type");
            $table->string('description');
            $table->boolean('is_repeatable');
            $table->integer('completion_point');
            $table->integer('priority')->default(1);
            $table->uuid('quest_id')->nullable();
            $table->uuid('room_id')->nullable();
            $table->uuid('unlock_activity_id')->nullable();
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });

        Schema::create('activity_progress', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('status');
            $table->boolean('is_completed')->default(false);
            $table->dateTime('completion_date')->nullable();
            $table->uuid('activity_id');
            $table->uuid('user_id');
            $table->uuid('last_scene_id')->nullable();
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });

        Schema::create('scenes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('background')->nullable();
            $table->boolean('is_start_scene')->default(false);
            $table->boolean('is_end_scene')->default(false);
            $table->uuid('next_scene_id')->nullable();
            $table->uuid('activity_id');
            $table->uuid('sceneable_id')->nullable();
            $table->string('sceneable_type')->nullable();
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });

        Schema::create('dialogues', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('dialogue_text');
            $table->uuid('character_id')->nullable();
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });

        Schema::create('dialogue_options', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('option_text');
            $table->uuid('dialogue_id');
            $table->uuid('next_scene_id')->nullable();
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });

        Schema::create('events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('event_name');
            $table->string('event_type');
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });

        Schema::create('minigames', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('minigame_name');
            $table->string('instruction');
            $table->integer('maximum_point_reward');
            $table->integer('minimum_passing_point')->default(0);
            $table->uuid('minigameable_id')->nullable();
            $table->string('minigameable_type')->nullable();
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });

        Schema::create('quizzes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('quiz_type');
            $table->string('quiz_topic');
            $table->string('hint')->nullable();
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });
        
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('question_title');
            $table->string('question_type');
            $table->integer('question_point');
            $table->uuid('quiz_id');
            $table->uuid('character_id')->nullable();
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });

        Schema::create('quiz_choices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('choice_text');
            $table->boolean('is_correct')->default(false);
            $table->uuid('question_id');
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });

        Schema::create('quiz_steps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('step_text');
            $table->integer('step_order');
            $table->uuid('question_id');
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });

        Schema::create('crosswords', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('theme');
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });

        Schema::create('crossword_words', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('word_answer');
            $table->string('clue');
            $table->string('direction');
            $table->integer('col_start_idx');
            $table->integer('row_start_idx');
            $table->uuid('crossword_id');
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });

        Schema::create('drum_puzzles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('total_hit');
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });

        Schema::create('minigame_attempts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('total_point')->default(0);
            $table->string('status');
            $table->uuid('minigame_id');
            $table->uuid('user_id');
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });

        Schema::create('minigame_answers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('answer_point')->default(0);
            $table->string('status');
            $table->uuid('minigame_attempt_id');
            $table->uuid('answerable_id')->nullable();
            $table->string('answerable_type')->nullable();
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });

        Schema::create('quiz_multiple_choice_answers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('question_id');
            $table->uuid('answer_choice_id');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });

        Schema::create('quiz_order_steps_answers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('question_id');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });

        Schema::create('quiz_order_steps_answer_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('answer_step_id');
            $table->uuid('user_answer_id');
            $table->integer('answer_step_order');
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });

        Schema::create('crossword_answers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('word_id');
            $table->string('word_answer');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });

        Schema::create('drum_puzzle_answers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->json('pattern_answer');
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });

        Schema::create('user_point_progress', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('status');
            $table->integer('point_gained')->default(0);
            $table->string('point_source');
            $table->uuid('user_id');
            $table->uuid('quest_progress_id')->nullable();
            $table->uuid('activity_progress_id')->nullable();
            $table->uuid('minigame_attempt_id')->nullable();
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_point_progress');
        Schema::dropIfExists('quiz_order_steps_answer_details');
        Schema::dropIfExists('quiz_order_steps_answers');
        Schema::dropIfExists('quiz_multiple_choice_answers');
        Schema::dropIfExists('drum_puzzle_answers');
        Schema::dropIfExists('crossword_answers');
        Schema::dropIfExists('minigame_answers');
        Schema::dropIfExists('minigame_attempts');
        Schema::dropIfExists('drum_puzzles');
        Schema::dropIfExists('crossword_words');
        Schema::dropIfExists('crosswords');
        Schema::dropIfExists('quiz_steps');
        Schema::dropIfExists('quiz_choices');
        Schema::dropIfExists('quiz_questions');
        Schema::dropIfExists('quizzes');
        Schema::dropIfExists('minigames');
        Schema::dropIfExists('events');
        Schema::dropIfExists('dialogue_options');
        Schema::dropIfExists('dialogues');
        Schema::dropIfExists('scenes');
        Schema::dropIfExists('activity_progress');
        Schema::dropIfExists('activities');
        Schema::dropIfExists('quest_progress');
        Schema::dropIfExists('quests');
        Schema::dropIfExists('characters');
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('campus_progress');
        Schema::dropIfExists('campuses');
        Schema::dropIfExists('users');
    }
};
