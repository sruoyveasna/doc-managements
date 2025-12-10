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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();

            $table->string('title');                         // document name
            $table->year('publication_year')->nullable();   // year of publication
            $table->string('keywords')->nullable();         // comma separated keywords
            $table->string('file_path');                    // storage path for file

            // status: control visibility / workflow
            // draft  -> maybe not visible to students yet
            // published -> visible to everyone
            // archived -> old documents
            $table->enum('status', ['draft', 'published', 'archived'])
                ->default('published');

            // Foreign keys
            $table->foreignId('author_id')
                ->constrained()          // references 'authors'
                ->cascadeOnDelete();

            $table->foreignId('field_id')
                ->constrained()          // references 'fields'
                ->cascadeOnDelete();

            $table->foreignId('genre_id')
                ->constrained()          // references 'genres'
                ->cascadeOnDelete();

            $table->foreignId('uploaded_by')
                ->constrained('users')   // references 'users'
                ->cascadeOnDelete();

            $table->softDeletes();         // 👈 enable soft delete
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
