<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\AttendeeResource;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Widgets\Widget;

class TestChart extends Widget implements HasActions, HasForms
{
    use InteractsWithForms, InteractsWithActions;

    protected int|string|array $columnSpan = 'full';
    protected static string $view = 'filament.widgets.test-chart';

    public function callNotification(): Action
    {
        return Action::make('callNotification')
            ->button()
            ->color('warning')
            ->label('Send a notification')
            ->action(function () {
                Notification::make()->warning()->title('You send a notification')
                    ->body('This is a test')
                    ->persistent()
                    ->actions([\Filament\Notifications\Actions\Action::make('goToAttendees')
                        ->button()
                        ->color('primary')
                        ->url(AttendeeResource::getUrl('edit', ['record' => 1])),
                        \Filament\Notifications\Actions\Action::make('undo')
                            ->color('grey')
                            ->link()
                            ->markAsRead()
                            ->action(function () {

                            })
                    ])->send();
            });
    }
}
