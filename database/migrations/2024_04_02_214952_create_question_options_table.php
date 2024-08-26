<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('question_options', function (Blueprint $table) {
			$table->id();
			$table->text('option');
			$table->boolean('is_correct')->default(false);
			$table->foreignId('quiz_question_id')->constrained()->cascadeOnDelete();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('question_options');
	}
};
