<?php

use App\Enums\TransferTypes;
use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')
                ->constrained((new Player())->getTable());
            $table->foreignId('buyer_id')
                ->nullable()
                ->constrained((new Team())->getTable());
            $table->bigInteger('price');
            $table->integer('type')->default(TransferTypes::OPEN->value);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
