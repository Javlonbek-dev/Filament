<?php

namespace App\Models;

use Filament\Forms\Components\Group;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendee extends Model
{
    use HasFactory;
    protected $guarded;

    public function order():BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public static function getForm()
    {
        return [
            Group::make()
            ->columns(2)
            ->schema([
                TextInput::make('name')
                    ->required()->maxLength(255),
                TextInput::make('email')
                    ->required()->maxLength(255),
            ])
        ];
    }
}
