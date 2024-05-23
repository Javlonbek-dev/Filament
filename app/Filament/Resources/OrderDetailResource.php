<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderDetailResource\Pages;
use App\Filament\Resources\OrderDetailResource\RelationManagers;
use App\Models\OrderDetail;
use App\OrderDetailLength;
use App\OrderDetailStatus;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class OrderDetailResource extends Resource
{
    protected static ?string $model = OrderDetail::class;

//    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'First Group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(OrderDetail::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->persistFiltersInSession()
            ->filtersTriggerAction(function ($action) {
                return $action->button()->label('Filter');
            })
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->description(function (OrderDetail $order) {
                        return Str::of($order->info);
                    }),

                Tables\Columns\ImageColumn::make('supplier_avatar')
                    ->circular()
                    ->label('Speaker Avatar')
                    ->defaultImageUrl(function ($record) {
                        return 'https://ui-avatars.com/api/?backround=0d8abc&color=fff&name=' . urldecode($record->supplier->name);
                    }),
                Tables\Columns\TextColumn::make('supplier.name')
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('ordered'),
                Tables\Columns\TextColumn::make('status')
                    ->searchable()
                    ->badge()
                    ->color(function ($state) {
                        return $state->getColor();
                    }),
                Tables\Columns\IconColumn::make('length')
                    ->icon(function ($state) {
                        return match ($state) {
                            OrderDetailLength::NORMAL => 'heroicon-o-megaphone',
                            OrderDetailLength::LIGHTNING => 'heroicon-o-bolt',
                            OrderDetailLength::KEYNOTE => 'heroicon-o-key',
                        };
                    })

            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('ordered'),
                Tables\Filters\SelectFilter::make('supplier')
                    ->relationship('supplier', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                Tables\Filters\Filter::make('has_avatar')
                    ->toggle()
                    ->label('Show Only Supplier Avatar')
                    ->query(function ($query) {
                        $query->whereHas('supplier', function (Builder $query) {
                            $query->whereNotNull('avatar');
                        });
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->slideOver(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('approved')
//                        ->visible(function ($record){
//                            return $record->status===OrderDetailStatus::SUBMITTED;
//                        })
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function (OrderDetail $record) {
                            return $record->approved();
                        })->after(function () {
                            Notification::make()->success()->title('Order Approved')
                                ->duration(1000)
                                ->body('The order has been approved successfully .')
                                ->send();
                        }),
                    Tables\Actions\Action::make('rejected')
                        ->icon('heroicon-o-no-symbol')
                        ->color('danger')
                        ->requiresConfirmation()
//                        ->visible(function ($record){
//                            return $record->status === OrderDetailStatus::SUBMITTED;
//                        })
                        ->action(function (OrderDetail $record) {
                            return $record->reject();
                        })->after(function () {
                            Notification::make()->danger()->title('Order Details Rejected ')
                                ->duration(1000)
                                ->body('The order details has been rejected successfully .')
                                ->send();
                        })
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('approve')
            ->action(function (Collection $query){
                $query->each->approved();
            }),
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make()
                ]),
            ])
            ->headerActions([
                Tables\Actions\Action::make('export')
                ->action(function ($livewire){
                    return $livewire->getFilteredTableQuery();
                })
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrderDetails::route('/'),
            'create' => Pages\CreateOrderDetail::route('/create'),
            'edit' => Pages\EditOrderDetail::route('/{record}/edit'),
        ];
    }
}
