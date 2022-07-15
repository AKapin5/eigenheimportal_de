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
        Schema::create('apartment_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lft');
            $table->unsignedBigInteger('rgt');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->json('name');
            $table->json('alias');
            $table->json('path')->nullable();
            $table->json('description')->nullable();
            $table->json('seo_title')->nullable();
            $table->json('seo_keywords')->nullable();
            $table->json('seo_description')->nullable();
            $table->smallInteger('status')->default(1);
            $table->unsignedBigInteger('sort')->default(0);
            $table->timestamps();

            $table->foreign('parent_id')
                ->references('id')
                ->on('apartment_categories')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
        });

        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->json('name');
            $table->json('alias');
            $table->json('description')->nullable();
            $table->json('seo_title')->nullable();
            $table->json('seo_keywords')->nullable();
            $table->json('seo_description')->nullable();
            $table->decimal('living_space', 10)->default(0);
            $table->integer('construction_year')->nullable();
            $table->integer('rooms_count')->nullable();
            $table->integer('heating')->nullable();
            $table->integer('airport_travel_time')->nullable();
            $table->integer('highway_travel_time')->nullable();
            $table->integer('hospital_travel_time')->nullable();
            $table->integer('school_travel_time')->nullable();
            $table->text('location_map')->nullable();
            $table->string('location_address')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_website')->nullable();
            $table->smallInteger('status')->default(1);
            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')
                ->on('apartment_categories')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartments');
        Schema::dropIfExists('apartment_categories');
    }
};
