<?php

declare(strict_types = 1);

namespace App\Models;

use App\Enums\TransferTypes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $player_id
 * @property int $buyer_id
 * @property int $type
 * @property int $price
 *
 * @property \App\Models\Player $player
 */
class Transfer extends Model
{
    protected $table = 'transfers';

    protected $fillable = [
        'player_id',
        'buyer_id',
        'price',
        'type',
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getPlayerId(): int
    {
        return $this->player_id;
    }

    public function getBuyerId(): int
    {
        return $this->buyer_id;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getFormattedPrice(): string
    {
        return number_format($this->getPrice() / 100, 2);
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getTypeToText(): string
    {
        return TransferTypes::from($this->getType())->toText();
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'buyer_id');
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'player_id');
    }
}
