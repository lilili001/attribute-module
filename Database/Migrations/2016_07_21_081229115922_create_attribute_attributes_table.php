<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAttributeAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute__attributes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('namespace');
            $table->string('key');
            $table->string('type');
            $table->boolean('is_for_sku');
            $table->boolean('is_for_sale');
            $table->integer('attrset_id');
            $table->tinyInteger('is_filterable')->default(0);
            $table->tinyInteger('is_visible_on_front')->default(0);
            $table->integer('position')->default(0);
            $table->text('options')->nullable();
            $table->boolean('is_enabled');
            $table->boolean('has_translatable_values');
            $table->timestamps();
        });

        Schema::create('attribute__attribute_values', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('attribute_id')->unsigned();
            $table->string('entity_type');
            $table->integer('entity_id')->unsigned();
            $table->text('value');
            $table->timestamps();

            $table->index('attribute_id');
            $table->index('entity_type');
            $table->index('entity_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('attribute__attribute_values');
        Schema::drop('attribute__attributes');
    }
}
