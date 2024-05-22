<?php

namespace App\Models;

use App\Region;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $guarded;
    protected $casts = [
        'id' => 'integer',
        'price' => 'float',
        'region' => Region::class,
        'customer_id' => 'integer',
        'supplier_id' => 'integer',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function suppliers(): BelongsToMany
    {
        return $this->belongsToMany(Supplier::class);
    }

    public function attendees():HasMany
    {
        return $this->hasMany(Attendee::class);
    }
    public static function getForm()
    {
        return [
            Tabs::make()
                ->columnSpanFull()
                ->tabs([
                    Tabs\Tab::make('Order Details')
                        ->columnSpanFull()
                        ->schema([
                            TextInput::make('name')
                                ->required()
                                ->columnSpanFull(),
                            TextInput::make('description')
                                ->required()
                                ->maxLength(55)
                                ->columnSpanFull(),
                            TextInput::make('amount')
                                ->required()
                                ->numeric(),
                            Select::make('status')
                                ->options([
                                    'draft' => 'Draft',
                                    'confirmed' => 'Confirmed',
                                    'processing' => 'Processing',
                                    'shipped' => 'Shipped',
                                ]),
                            Fieldset::make("Status")
                                ->columns(1)
                                ->schema([
                                    TextInput::make('price')
                                        ->required()
                                        ->numeric()
                                        ->prefix('$'),
                                    CheckboxList::make('suppliers')
                                        ->relationship('suppliers', 'name')
                                        ->searchable()
                                        ->columnSpanFull()
                                        ->bulkToggleable()
                                        ->options(Supplier::all()->pluck('name', 'id'))
                                        ->columns(3)
                                ])
                        ]),
                    Tabs\Tab::make('Location')
                        ->columnSpanFull()
                        ->schema([
                            Select::make('region')
                                ->live()
                                ->options(Region::class)
                                ->enum(Region::class),
                            Select::make('customer_id')
                                ->searchable()
                                ->preload()
                                ->createOptionForm(Customer::getForm())
                                ->editOptionForm(Customer::getForm())
                                ->relationship('customer', 'firstname', modifyQueryUsing: function (Builder $query, Get $get) {
                                    return $query->where('region', $get('region'));
                                }),
                        ]),
                ]),

            Actions::make([
                Action::make('star')
                    ->label('Fill with factory data')
                    ->icon('heroicon-m-star')
                    ->visible(function (string $operations) {
                        if ($operations !== 'create') {
                            return false;
                        }
                        if (!app()->environment('local')) {
                            return false;
                        }
                        return true;
                    })
                    ->action(function ($livewire) {
                        $data = Order::factory()->make()->toArray();
                        $livewire->form->fill($data);
                    }),
            ]),
        ];
    }
}
