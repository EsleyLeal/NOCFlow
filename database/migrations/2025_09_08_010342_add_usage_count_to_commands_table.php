<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::table('commands', function (Blueprint $table) {
      $table->unsignedBigInteger('usage_count')->default(0)->index();
    });
  }
  public function down(): void {
    Schema::table('commands', function (Blueprint $table) {
      $table->dropColumn('usage_count');
    });
  }
};
