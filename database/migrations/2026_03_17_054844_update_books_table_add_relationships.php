<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->foreignId('author_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('publisher_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();

            $table->dropColumn(['author', 'publisher', 'category']);
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('author')->nullable();
            $table->string('publisher')->nullable();
            $table->string('category')->nullable();

            $table->dropConstrainedForeignId('author_id');
            $table->dropConstrainedForeignId('publisher_id');
            $table->dropConstrainedForeignId('category_id');
        });
    }
};
