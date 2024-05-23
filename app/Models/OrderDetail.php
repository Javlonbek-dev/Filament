<?php

namespace App\Models;

use App\OrderDetailLength;
use App\OrderDetailStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends Model
{
    use HasFactory;

    protected $guarded;

    protected $casts = [
        'id' => 'integer',
        'supplier_id' => 'integer',
        'status' => OrderDetailStatus::class,
        'length' => OrderDetailLength::class
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function approved(): void
    {
        $this->status = OrderDetailStatus::APPROVED;
        $this->save();
    }

    public function reject(): void
    {
        $this->status = OrderDetailStatus::REJECTED;
        $this->save();
    }

    public static function getForm($supplierId = null): array
    {
        return [
            TextInput::make('name')
                ->required()
                ->maxLength(255),
            DateTimePicker::make('start_date'),
            DateTimePicker::make('end_date'),
            TextInput::make('length')
                ->required()
                ->maxLength(255)
                ->default('Normal-30 minuts'),
            TextInput::make('status')
                ->required()
                ->maxLength(255)
                ->default('SUBMITTED'),
            Select::make('supplier_id')
                ->hidden(function () use ($supplierId) {
                    return $supplierId !== null;
                })
                ->relationship('supplier', 'name')
                ->required(),
        ];
    }
}
