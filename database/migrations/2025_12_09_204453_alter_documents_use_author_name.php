<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            // new free-text author column
            $table->string('author_name')->nullable()->after('title');
        });

        // If you already have data and an authors table, migrate names across
        if (Schema::hasTable('authors') && Schema::hasColumn('documents', 'author_id')) {
            DB::table('documents')
                ->join('authors', 'documents.author_id', '=', 'authors.id')
                ->update([
                    'documents.author_name' => DB::raw('authors.name'),
                ]);
        }

        // Drop the foreign key and author_id column (if they exist)
        Schema::table('documents', function (Blueprint $table) {
            if (Schema::hasColumn('documents', 'author_id')) {
                // foreign key name may differ – adjust if your name is custom
                try {
                    $table->dropForeign(['author_id']);
                } catch (\Throwable $e) {
                    // ignore if FK name is different / already dropped
                }

                $table->dropColumn('author_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            // recreate author_id (nullable for safety)
            $table->unsignedBigInteger('author_id')->nullable()->after('title');
        });

        // Optional: re-add FK if you still keep authors table
        Schema::table('documents', function (Blueprint $table) {
            if (Schema::hasTable('authors')) {
                $table->foreign('author_id')->references('id')->on('authors')->nullOnDelete();
            }
        });

        // best-effort: don't try to perfectly restore names → ids
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('author_name');
        });
    }
};
