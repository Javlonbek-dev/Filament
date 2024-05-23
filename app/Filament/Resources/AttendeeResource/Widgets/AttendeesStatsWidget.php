<?php

namespace App\Filament\Resources\AttendeeResource\Widgets;

use App\Filament\Resources\AttendeeResource\Pages\ListAttendees;
use App\Models\Attendee;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AttendeesStatsWidget extends BaseWidget
{
    use  InteractsWithPageTable;
    protected function getColumns(): int
    {
        return 2;
    }


    public function getTablePage():string
    {
        return ListAttendees::class;
    }
    protected function getStats(): array
    {
        return [
            Stat::make('Attendee Count', $this->getPageTableQuery()->count())
                ->description('Total number of attendees')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('success')
                ->chart([1, 2, 3, 4, 5,1,1]),
            Stat::make('Total Revenue', $this->getPageTableQuery()->sum('ticket_cost')),
        ];
    }
}
