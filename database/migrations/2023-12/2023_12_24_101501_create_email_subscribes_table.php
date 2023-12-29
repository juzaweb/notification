<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(
            'jw_notification_email_subscribes',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid();
                $table->string('name')->nullable();
                $table->string('email')->index();
                $table->unsignedBigInteger('site_id')->default(0)->index();
                $table->unique(['email', 'site_id']);
                $table->unique(['uuid', 'site_id']);
                $table->boolean('active')->default(false);
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('jw_notification_email_subscribes');
    }
};
