<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    const ON_DELETE_SET_NULL = 'set null';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->create();
        $this->alter();
    }


    private function create(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('role');
            $table->string('user_code');
            $table->string('academic_areer');
            $table->integer('total_point')->default(0);
            $table->dateTime('completion_date')->nullable();
            $table->integer('semester');
            $table->string('gender');
            $table->string('email');
            $table->rememberToken();
            $table->timestamp('created_at')->nullable()->default(now());
            $table->string('created_by')->nullable();
            $table->timestamp('last_updated_at')->nullable()->default(now());
            $table->string('last_updated_by')->nullable();
        });

        Schema::create('campuses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('campus_name');
            $table->string('description');
            $table->timestamp('created_at')->nullable()->default(now());
            $table->string('created_by')->nullable();
            $table->timestamp('last_updated_at')->nullable()->default(now());
            $table->string('last_updated_by')->nullable();
        });

        Schema::create('campus_progress', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('campus_id');
            $table->boolean('is_locked')->default(true);
            $table->boolean('is_story_locked')->default(true);
            $table->boolean('is_semester_locked');
            $table->timestamp('created_at')->nullable()->default(now());
            $table->string('created_by')->nullable();
            $table->timestamp('last_updated_at')->nullable()->default(now());
            $table->string('last_updated_by')->nullable();
        });

        Schema::create('rooms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('campus_id');
            $table->string('room_name');
            $table->string('type');
            $table->timestamp('created_at')->nullable()->default(now());
            $table->string('created_by')->nullable();
            $table->timestamp('last_updated_at')->nullable()->default(now());
            $table->string('last_updated_by')->nullable();
        });

        Schema::create('characters', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('campus_id');
            $table->string('character_name');
            $table->string('role');
            $table->string('description');
            $table->string('gender');
            $table->json('likes');
            $table->json('dislikes');
            $table->timestamp('created_at')->nullable()->default(now());
            $table->string('created_by')->nullable();
            $table->timestamp('last_updated_at')->nullable()->default(now());
            $table->string('last_updated_by')->nullable();
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
            $table->timestamp('created_at')->nullable()->default(now());
            $table->string('created_by')->nullable();
            $table->timestamp('last_updated_at')->nullable()->default(now());
            $table->string('last_updated_by')->nullable();
        });

        Schema::create('quest_progress', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('status');
            $table->boolean('is_completed')->default(false);
            $table->dateTime('completion_date')->nullable();
            $table->uuid('quest_id');
            $table->uuid('user_id');
            $table->timestamp('created_at')->nullable()->default(now());
            $table->string('created_by')->nullable();
            $table->timestamp('last_updated_at')->nullable()->default(now());
            $table->string('last_updated_by')->nullable();
        });

        Schema::create('activities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('activity_name');
            $table->string("type");
            $table->string('description');
            $table->boolean('is_repeatable');
            $table->integer('priority')->default(1);
            $table->uuid('quest_id');
            $table->uuid('room_id');
            $table->uuid('scene_start_id')->nullable();
            $table->uuid('unlock_activity_id')->nullable();
            $table->timestamp('created_at')->nullable()->default(now());
            $table->string('created_by')->nullable();
            $table->timestamp('last_updated_at')->nullable()->default(now());
            $table->string('last_updated_by')->nullable();
        });

        Schema::create('activity_progress', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('status');
            $table->boolean('is_locked');
            $table->uuid('activity_id');
            $table->uuid('user_id');
            $table->uuid('last_scene_id')->nullable();
            $table->timestamp('created_at')->nullable()->default(now());
            $table->string('created_by')->nullable();
            $table->timestamp('last_updated_at')->nullable()->default(now());
            $table->string('last_updated_by')->nullable();
        });

        Schema::create('scenes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('background');
            $table->boolean('is_activity_end');
            $table->boolean('is_starting_scene');
            $table->uuid('next_scene_id')->nullable();
            $table->uuid('activity_id');
            $table->timestamp('created_at')->nullable()->default(now());
            $table->string('created_by')->nullable();
            $table->timestamp('last_updated_at')->nullable()->default(now());
            $table->string('last_updated_by')->nullable();
        });

        Schema::create('dialogues', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('character_id')->nullable();
            $table->timestamp('created_at')->nullable()->default(now());
            $table->string('created_by')->nullable();
            $table->timestamp('last_updated_at')->nullable()->default(now());
            $table->string('last_updated_by')->nullable();
        });

        Schema::create('dialogue_options', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('dialogue_text');
            $table->uuid('dialogue_id');
            $table->uuid('next_scene_id')->nullable();
            $table->timestamp('created_at')->nullable()->default(now());
            $table->string('created_by')->nullable();
            $table->timestamp('last_updated_at')->nullable()->default(now());
            $table->string('last_updated_by')->nullable();
        });

        Schema::create('events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('event_name');
            $table->string('event_type');
            $table->timestamp('created_at')->nullable()->default(now());
            $table->string('created_by')->nullable();
            $table->timestamp('last_updated_at')->nullable()->default(now());
            $table->string('last_updated_by')->nullable();
        });

        Schema::create('minigames', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('instruction');
            $table->integer('maximum_point_reward');
            $table->integer('minimum_passing_point')->default(0);
            $table->timestamp('created_at')->nullable()->default(now());
            $table->string('created_by')->nullable();
            $table->timestamp('last_updated_at')->nullable()->default(now());
            $table->string('last_updated_by')->nullable();
        });

        Schema::create('quizzes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('quiz_type');
            $table->timestamp('created_at')->nullable()->default(now());
            $table->string('created_by')->nullable();
            $table->timestamp('last_updated_at')->nullable()->default(now());
            $table->string('last_updated_by')->nullable();
        });
        
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('question_title');
            $table->string('question_description')->nullable();
            $table->string('question_code');
            $table->string('question_type');
            $table->integer('question_point');
            $table->string('hint')->nullable();
            $table->uuid('character_id')->nullable();
            $table->timestamp('created_at')->nullable()->default(now());
            $table->string('created_by')->nullable();
            $table->timestamp('last_updated_at')->nullable()->default(now());
            $table->string('last_updated_by')->nullable();
        });

        Schema::create('quiz_options', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('option_text');
            $table->boolean('is_correct')->default(false);
            $table->uuid('question_id');
            $table->timestamp('created_at')->nullable()->default(now());
            $table->string('created_by')->nullable();
            $table->timestamp('last_updated_at')->nullable()->default(now());
            $table->string('last_updated_by')->nullable();
        });

        Schema::create('quiz_steps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('step_text');
            $table->integer('step_order');
            $table->uuid('question_id');
            $table->timestamp('created_at')->nullable()->default(now());
            $table->string('created_by')->nullable();
            $table->timestamp('last_updated_at')->nullable()->default(now());
            $table->string('last_updated_by')->nullable();
        });

        Schema::create('crosswords', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('grid_size');
            $table->string('theme');
            $table->timestamp('created_at')->nullable()->default(now());
            $table->string('created_by')->nullable();
            $table->timestamp('last_updated_at')->nullable()->default(now());
            $table->string('last_updated_by')->nullable();
        });

        Schema::create('crossword_words', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('word_answer');
            $table->string('clue');
            $table->string('direction');
            $table->integer('col_start_idx');
            $table->integer('col_end_idx');
            $table->integer('row_start_idx');
            $table->integer('row_end_idx');
            $table->uuid('crossword_id');
            $table->timestamp('created_at')->nullable()->default(now());
            $table->string('created_by')->nullable();
            $table->timestamp('last_updated_at')->nullable()->default(now());
            $table->string('last_updated_by')->nullable();
        });

        Schema::create('drum_puzzles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('total_hit');
            $table->timestamp('created_at')->nullable()->default(now());
            $table->string('created_by')->nullable();
            $table->timestamp('last_updated_at')->nullable()->default(now());
            $table->string('last_updated_by')->nullable();
        });

        Schema::create('user_minigame_attempts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('total_point')->default(0);
            $table->string('status');
            $table->string('minigame_type');
            $table->uuid('minigame_id');
            $table->uuid('user_id');
            $table->timestamp('created_at')->nullable()->default(now());
            $table->string('created_by')->nullable();
            $table->timestamp('last_updated_at')->nullable()->default(now());
            $table->string('last_updated_by')->nullable();
        });

        Schema::create('user_minigame_answers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('answer_point')->default(0);
            $table->string('status');
            $table->uuid('user_minigame_attempt_id');
            $table->timestamp('created_at')->nullable()->default(now());
            $table->string('created_by')->nullable();
            $table->timestamp('last_updated_at')->nullable()->default(now());
            $table->string('last_updated_by')->nullable();
        });

        Schema::create('user_quiz_answers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->boolean('is_correct')->default(false);
            $table->string('questionType');
            $table->json('answer_steps_id');
            $table->uuid('option_id')->nullable();
            $table->uuid('question_id')->nullable();
            $table->timestamp('created_at')->nullable()->default(now());
            $table->string('created_by')->nullable();
            $table->timestamp('last_updated_at')->nullable()->default(now());
            $table->string('last_updated_by')->nullable();
        });

        Schema::create('user_crossword_answers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('word_answer');
            $table->boolean('is_correct')->default(false);
            $table->uuid('word_id')->nullable();
            $table->timestamp('created_at')->nullable()->default(now());
            $table->string('created_by')->nullable();
            $table->timestamp('last_updated_at')->nullable()->default(now());
            $table->string('last_updated_by')->nullable();
        });

        Schema::create('user_drum_puzzle_answers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->json('pattern');
            $table->timestamp('created_at')->nullable()->default(now());
            $table->string('created_by')->nullable();
            $table->timestamp('last_updated_at')->nullable()->default(now());
            $table->string('last_updated_by')->nullable();
        });

        Schema::create('user_point_progress', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('status');
            $table->integer('point_gained')->default(0);
            $table->string('point_source');
            $table->uuid('user_id');
            $table->uuid('quest_progress_id');
            $table->uuid('activity_progress_id');
            $table->uuid('user_minigame_attempt_id');
            $table->timestamp('created_at')->nullable()->default(now());
            $table->string('created_by')->nullable();
            $table->timestamp('last_updated_at')->nullable()->default(now());
            $table->string('last_updated_by')->nullable();
        });

    }

    public function alter(): void {
        Schema::table('campus_progress', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');
            $table->foreign('campus_id')->references('id')
                ->on('campuses')->onDelete('cascade');
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->foreign('campus_id')->references('id')
                ->on('campuses')->onDelete('cascade');
        });

        Schema::table('characters', function (Blueprint $table) {
            $table->foreign('campus_id')->references('id')
                ->on('campuses')->onDelete('cascade');
        });

        Schema::table('quests', function (Blueprint $table) {
            $table->foreign('unlock_campus_id')->references('id')
                ->on('campuses')->onDelete(self::ON_DELETE_SET_NULL);
            $table->foreign('unlock_quest_id')->references('id')
                ->on('quests')->onDelete(self::ON_DELETE_SET_NULL);
            $table->foreign('unlock_activity_id')->references('id')
                ->on('activities')->onDelete(self::ON_DELETE_SET_NULL);
        });

        Schema::table('quest_progress', function (Blueprint $table) {
            $table->foreign('quest_id')->references('id')
                ->on('quests')->onDelete('cascade');
            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');
        });

        Schema::table('activities', function (Blueprint $table) {
            $table->foreign('quest_id')->references('id')
            ->on('quests')->onDelete('cascade');
            $table->foreign('room_id')->references('id')
                ->on('rooms')->onDelete('cascade');
            $table->foreign('scene_start_id')->references('id')
                ->on('scenes')->onDelete(self::ON_DELETE_SET_NULL);
            $table->foreign('unlock_activity_id')->references('id')
                ->on('activities')->onDelete(self::ON_DELETE_SET_NULL);
        });

        Schema::table('activity_progress', function (Blueprint $table) {
            $table->foreign('activity_id')->references('id')
                ->on('activities')->onDelete('cascade');
            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');
            $table->foreign('last_scene_id')->references('id')
                ->on('scenes')->onDelete(self::ON_DELETE_SET_NULL);
        });

        Schema::table('scenes', function (Blueprint $table) {
            $table->foreign('next_scene_id')->references('id')
                ->on('scenes')->onDelete(self::ON_DELETE_SET_NULL);
            $table->foreign('activity_id')->references('id')
                ->on('activities')->onDelete('cascade');
        });

        Schema::table('dialogues', function (Blueprint $table) {
            $table->foreign('character_id')->references('id')
                ->on('characters')->onDelete(self::ON_DELETE_SET_NULL);
        });

        Schema::table('dialogue_options', function (Blueprint $table) {
            $table->foreign('dialogue_id')->references('id')
                ->on('dialogues')->onDelete('cascade');
            $table->foreign('next_scene_id')->references('id')
                ->on('scenes')->onDelete(self::ON_DELETE_SET_NULL);
        });

        Schema::table('quiz_questions', function (Blueprint $table) {
            $table->foreign('character_id')->references('id')
                ->on('characters')->onDelete(self::ON_DELETE_SET_NULL);
        });

        Schema::table('quiz_options', function (Blueprint $table) {
            $table->foreign('question_id')->references('id')
                ->on('quiz_questions')->onDelete('cascade');
        });

        Schema::table('quiz_steps', function (Blueprint $table) {
            $table->foreign('question_id')->references('id')
                ->on('quiz_questions')->onDelete('cascade');
        });

        Schema::table('crossword_words', function (Blueprint $table) {
            $table->foreign('crossword_id')->references('id')
                ->on('crosswords')->onDelete('cascade');
        });

        Schema::table('user_minigame_attempts', function (Blueprint $table) {
            $table->foreign('minigame_id')->references('id')
                ->on('minigames')->onDelete('cascade');
            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');
        });

        Schema::table('user_minigame_answers', function (Blueprint $table) {
            $table->foreign('user_minigame_attempt_id')->references('id')
                ->on('user_minigame_attempts')->onDelete('cascade');
        });

        Schema::table('user_quiz_answers', function (Blueprint $table) {
            $table->foreign('option_id')->references('id')
                ->on('quiz_options')->onDelete(self::ON_DELETE_SET_NULL);
            $table->foreign('question_id')->references('id')
                ->on('quiz_questions')->onDelete(self::ON_DELETE_SET_NULL);
        });

        Schema::table('user_crossword_answers', function (Blueprint $table) {
            $table->foreign('word_id')->references('id')
                ->on('crossword_words')->onDelete(self::ON_DELETE_SET_NULL);
        });

        Schema::table('user_point_progress', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('quest_progress_id')->references('id')->on('quest_progress')->onDelete('cascade');
            $table->foreign('activity_progress_id')->references('id')->on('activity_progress')->onDelete('cascade');
            $table->foreign('user_minigame_attempt_id')->references('id')->on('user_minigame_attempts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('campuses');
        Schema::dropIfExists('campus_progress');
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('characters');
        Schema::dropIfExists('quests');
        Schema::dropIfExists('quest_progress');
        Schema::dropIfExists('activities');
        Schema::dropIfExists('activity_progress');
        Schema::dropIfExists('scenes');
        Schema::dropIfExists('dialogues');
        Schema::dropIfExists('dialogue_options');
        Schema::dropIfExists('events');
        Schema::dropIfExists('minigames');
        Schema::dropIfExists('quizzes');
        Schema::dropIfExists('quiz_questions');
        Schema::dropIfExists('quiz_options');
        Schema::dropIfExists('quiz_steps');
        Schema::dropIfExists('crosswords');
        Schema::dropIfExists('crossword_words');
        Schema::dropIfExists('drum_puzzles');
        Schema::dropIfExists('user_minigame_attempts');
        Schema::dropIfExists('user_minigame_answers');
        Schema::dropIfExists('user_quiz_answers');
        Schema::dropIfExists('user_crossword_answers');
        Schema::dropIfExists('user_drum_puzzle_answers');
        Schema::dropIfExists('user_point_progress');
    }
};
