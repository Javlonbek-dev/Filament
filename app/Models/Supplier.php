<?php

namespace App\Models;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Supplier extends Model
{
    use HasFactory;

    protected $guarded;
    protected $casts = [
        'id' => 'integer',
        'qualifications' => 'array'
    ];

    const  QUALIFICATIONS = [
        'this is nnnnasaasew options ' => 'this is nnnnew options',
        'thsis sdnsdfksd' => 'this is nnnnew options',
        'new Customer' => 'new Customer',
        'this is nnnnew optionss ' => 'this is nnnnew options',
        'thsis sdnsdfksds' => 'this is nnnnew options',
        'new Customera' => 'new Customer', 'this is as options ' => 'this is nnnnew options',
        'thsis sdnsdfksdsa' => 'this is nnnnew options',
        'new Customerasasas' => 'new Customer', 'this is nnnnew options ' => 'this is nnnnew options',
        'thsis sdnsdfksdass' => 'this is nnnnew options',
        'new Customeras' => 'new Customer',
    ];

    public static function getForm()
    {
        return
            [
                TextInput::make('name')
                    ->required(),
                FileUpload::make('avatar')
                    ->avatar()
                    ->imageEditor()
                    ->directory('suppliers')
                    ->preserveFilenames()
                    ->maxSize(1024 * 1024 * 10),
                TextInput::make('phone')
                    ->tel(),
                CheckboxList::make('qualifications')
                    ->searchable()
                    ->bulkToggleable()
                    ->columnSpanFull()
                    ->columns(3)
                    ->options(self::QUALIFICATIONS),
                TextInput::make('current_locate')
            ];
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }

    public function order_details()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
