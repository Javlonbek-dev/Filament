<?php

namespace App\Models;

use App\Region;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Customer extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected  $guarded;
    protected $casts = [
        'id' => 'integer',
        'region'=>Region::class,
        'is_active'
    ];

    public static function getForm()
    {
        return [
            TextInput::make('firstname')
                ->required(),
            TextInput::make('lastname')
                ->required()
                ->maxLength(55),
            TextInput::make('phone')
                ->required()
                ->tel(),
            TextInput::make('email')
                ->required()
                ->email(),
            Select::make('region')
                ->enum(Region::class)
                ->options(Region::class),
            Toggle::make('is_published')
                ->default(false),
            SpatieMediaLibraryFileUpload::make('images')
            ->collection('customer-images')
            ->multiple()
            ->image()
        ];
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
