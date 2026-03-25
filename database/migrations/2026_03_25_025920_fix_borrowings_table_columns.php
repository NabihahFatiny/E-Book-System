<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('borrowings')) {
            return;
        }

        Schema::table('borrowings', function (Blueprint $table) {
            if (! Schema::hasColumn('borrowings', 'borrowed_at')) {
                $table->timestamp('borrowed_at')->nullable()->after('book_id');
            }

            if (! Schema::hasColumn('borrowings', 'due_at')) {
                $table->timestamp('due_at')->nullable()->after('borrowed_at');
            }

            if (! Schema::hasColumn('borrowings', 'returned_at')) {
                $table->timestamp('returned_at')->nullable()->after('due_at');
            }

            if (! Schema::hasColumn('borrowings', 'status')) {
                $table->string('status')->default('active')->after('returned_at');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('borrowings')) {
            return;
        }

        Schema::table('borrowings', function (Blueprint $table) {
            if (Schema::hasColumn('borrowings', 'status')) {
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('borrowings', 'returned_at')) {
                $table->dropColumn('returned_at');
            }

            if (Schema::hasColumn('borrowings', 'due_at')) {
                $table->dropColumn('due_at');
            }

            if (Schema::hasColumn('borrowings', 'borrowed_at')) {
                $table->dropColumn('borrowed_at');
            }
        });
    }
};
