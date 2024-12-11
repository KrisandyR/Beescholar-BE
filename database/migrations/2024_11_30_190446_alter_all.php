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
        $this->alter();
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
                ->on('campuses')->onDelete('set null');
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
            $table->foreign('id')->references('id')
                ->on('scenes')->onDelete('cascade');
            $table->foreign('character_id')->references('id')
                ->on('characters')->onDelete(self::ON_DELETE_SET_NULL);
        });

        Schema::table('dialogue_options', function (Blueprint $table) {
            $table->foreign('dialogue_id')->references('id')
                ->on('dialogues')->onDelete('cascade');
            $table->foreign('next_scene_id')->references('id')
                ->on('scenes')->onDelete(self::ON_DELETE_SET_NULL);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->foreign('id')->references('id')
                ->on('scenes')->onDelete('cascade');
        });

        Schema::table('minigames', function (Blueprint $table) {
            $table->foreign('id')->references('id')
                ->on('scenes')->onDelete('cascade');
        });

        Schema::table('quizzes', function (Blueprint $table) {
            $table->foreign('id')->references('id')
                ->on('minigames')->onDelete('cascade');
        });

        Schema::table('quiz_questions', function (Blueprint $table) {
            $table->foreign('character_id')->references('id')
                ->on('characters')->onDelete(self::ON_DELETE_SET_NULL);
            $table->foreign('quiz_id')->references('id')
                ->on('quizzes')->onDelete('cascade');
        });

        Schema::table('quiz_options', function (Blueprint $table) {
            $table->foreign('question_id')->references('id')
                ->on('quiz_questions')->onDelete('cascade');
        });

        Schema::table('quiz_steps', function (Blueprint $table) {
            $table->foreign('question_id')->references('id')
                ->on('quiz_questions')->onDelete('cascade');
        });

        Schema::table('crosswords', function (Blueprint $table) {
            $table->foreign('id')->references('id')
                ->on('minigames')->onDelete('cascade');
        });

        Schema::table('crossword_words', function (Blueprint $table) {
            $table->foreign('crossword_id')->references('id')
                ->on('crosswords')->onDelete('cascade');
        });

        Schema::table('drum_puzzles', function (Blueprint $table) {
            $table->foreign('id')->references('id')
                ->on('minigames')->onDelete('cascade');
        });

        Schema::table('minigame_attempts', function (Blueprint $table) {
            $table->foreign('minigame_id')->references('id')
                ->on('minigames')->onDelete('cascade');
            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');
        });

        Schema::table('minigame_answers', function (Blueprint $table) {
            $table->foreign('minigame_attempt_id')->references('id')
                ->on('minigame_attempts')->onDelete('cascade');
        });

        Schema::table('quiz_multiple_choice_answers', function (Blueprint $table) {
            $table->foreign('answer_option_id')->references('id')
                ->on('quiz_options')->onDelete('cascade');
            $table->foreign('id')->references('id')
                ->on('minigame_answers')->onDelete('cascade');
        });

        Schema::table('quiz_order_steps_answers', function (Blueprint $table) {
            $table->foreign('id')->references('id')
                ->on('minigame_answers')->onDelete('cascade');
        });

        Schema::table('quiz_order_steps_answer_details', function (Blueprint $table) {
            $table->foreign('answer_step_id')->references('id')
                ->on('quiz_steps')->onDelete('cascade');
            $table->foreign('user_answer_id')->references('id')
                ->on('quiz_order_steps_answers')->onDelete('cascade');
        });

        Schema::table('crossword_answers', function (Blueprint $table) {
            $table->foreign('word_id')->references('id')
                ->on('crossword_words')->onDelete('cascade');
            $table->foreign('id')->references('id')
                ->on('minigame_answers')->onDelete('cascade');
        });

        Schema::table('drum_puzzle_answers', function (Blueprint $table) {
            $table->foreign('id')->references('id')
                ->on('minigame_answers')->onDelete('cascade');
        });

        Schema::table('user_point_progress', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('quest_progress_id')->references('id')->on('quest_progress')->onDelete('cascade');
            $table->foreign('activity_progress_id')->references('id')->on('activity_progress')->onDelete('cascade');
            $table->foreign('minigame_attempt_id')->references('id')->on('minigame_attempts')->onDelete('cascade');
        });
    }

};
