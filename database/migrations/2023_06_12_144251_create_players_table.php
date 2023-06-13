<?php

use App\Models\Country;
use App\Models\Team;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('age');
            $table->bigInteger('market_value');
            $table->integer('type');
            $table->foreignId('country_id')->constrained((new Country())->getTable());
            $table->foreignId('team_id')->constrained((new Team())->getTable());
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
