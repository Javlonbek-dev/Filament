<?php

namespace App\Livewire;

use App\Models\Attendee;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Illuminate\Support\HtmlString;
use Livewire\Component;


class OrderSignUpPage extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    public int $orderId;
    public int $price = 5000;

    public function mount()
    {
        $this->orderId = 1;
    }

    public function signUpAction(): Action
    {
        return Action::make('signUp')
            ->slideOver()
            ->form([
                Placeholder::make('total_price')
                    ->hiddenLabel()
                    ->content(function (Get $get) {
                        return '$' . count($get('attendee')) * 500;
                    }),
                Repeater::make('attendee')
                    ->schema(Attendee::getForm())
            ])
            ->action(function (array $data) {
                collect($data['attendee'])->each(function ($data) {
                    Attendee::create([
                        'order_id' => $this->orderId,
                        'ticket_cost' => $this->price,
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'is_paid' => true,
                    ]);
                });
            })
            ->after(function (){
                Notification::make()->success()->title('Success')
                    ->body(new HtmlString('You have signed up successfully.'))->send();
            });
    }

    public function render()
    {
        return view('livewire.order-sign-up-page');
    }
}
