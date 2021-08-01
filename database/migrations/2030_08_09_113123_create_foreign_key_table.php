<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('areas', function (Blueprint $table) {
            $table->foreign('city_id')->references('id')->on('cities')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->foreign('area_id')->references('id')->on('areas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->foreign('city_id')->references('id')->on('cities')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('hotels', function (Blueprint $table) {
            $table->foreign('area_id')->references('id')->on('areas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('hotels', function (Blueprint $table) {
            $table->foreign('city_id')->references('id')->on('cities')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('hotels', function (Blueprint $table) {
            $table->foreign('place_id')->references('id')->on('places')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('places', function (Blueprint $table) {
            $table->foreign('area_id')->references('id')->on('areas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('places', function (Blueprint $table) {
            $table->foreign('city_id')->references('id')->on('cities')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('places', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('dialogs', function (Blueprint $table) {
            $table->foreign('client_id')->references('id')->on('clients')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->foreign('dialog_id')->references('id')->on('dialogs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->foreign('area_id')->references('id')->on('areas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->foreign('city_id')->references('id')->on('cities')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        // Schema::table('tokens', function (Blueprint $table) {
        //     $table->foreign('customer_id')->references('id')->on('clients')
        //         ->onDelete('cascade')
        //         ->onUpdate('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('areas', function (Blueprint $table) {
            $table->dropForeign('areas_city_id_foreign');
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->dropForeign('clients_area_id_foreign');
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->dropForeign('clients_city_id_foreign');
        });

        Schema::table('hotels', function (Blueprint $table) {
            $table->dropForeign('hotels_area_id_foreign');
        });

        Schema::table('hotels', function (Blueprint $table) {
            $table->dropForeign('hotels_city_id_foreign');
        });

        Schema::table('hotels', function (Blueprint $table) {
            $table->dropForeign('hotels_place_id_foreign');
        });

        Schema::table('places', function (Blueprint $table) {
            $table->dropForeign('places_area_id_foreign');
        });

        Schema::table('places', function (Blueprint $table) {
            $table->dropForeign('places_city_id_foreign');
        });

        Schema::table('places', function (Blueprint $table) {
            $table->dropForeign('places_category_id_foreign');
        });

        Schema::table('dialogs', function (Blueprint $table) {
            $table->dropForeign('dialogs_client_id_foreign');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign('messages_dialogs_id_foreign');
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign('notifications_area_id_foreign');
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign('notifications_city_id_foreign');
        });

        // Schema::table('tokens', function (Blueprint $table) {
        //     $table->dropForeign('tokens_customer_id_foreign');
        // });
    }
}
