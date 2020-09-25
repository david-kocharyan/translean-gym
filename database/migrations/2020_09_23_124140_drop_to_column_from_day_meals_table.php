<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropToColumnFromDayMealsTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('day_meals', 'to')) {
            Schema::table('day_meals', function (Blueprint $table) {
                $table->dropColumn('to');

            });
        }
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        return true;
    }
}
