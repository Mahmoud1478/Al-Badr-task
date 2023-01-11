<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string("first_name");
            $table->string("mid_name")->nullable();
            $table->string("last_name");
            $table->string("email")->unique();
            $table->string("phone");
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_active')->default(false);
            $table->string('image')->nullable();
            $table->string('drive_licence')->nullable();
            $table->decimal("latitude",10,6)->nullable();
            $table->decimal("longitude",10,6)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
};
