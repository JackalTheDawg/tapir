<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use App\Orchid\Layouts\Examples\ExampleElements;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;

use GuzzleHttp\Client;
use Exceptions;

class Resend extends Screen
{
    public $data;

    public function __construct(){
        $this -> data = null;
    }


    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        $this -> data = request() -> route() -> parameters();
        return [
            "data" => $this -> data
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Повторная отправка';
    }

    public function description(): ?string {
        return 'Проверьте данные для отправки в CRM';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        try{
            return [
                Layout::rows([
                    Group::make([
                        Input::make('phone')
                            ->title('Телефон')
                            ->value("{$this -> data['phone']}")
                            ->placeholder("{$this -> data['phone']}")
                            ->horizontal(),
    
                        Input::make('vin')
                            ->title('VIN')
                            ->value("{$this -> data['vin']}")
                            ->placeholder("{$this -> data['vin']}")
                            ->horizontal(),
                    ]),
    
                    Button::make('Отправить')
                    ->method('resendBid')
                    ->type(Color::BASIC),
                ])
            ];
        } catch(\Exception $e){
            abort(404);
        }
    }

    public function resendBid(){
        $client = new Client();
        try{
            $response = $client -> request("POST", config("URL_CRM"), [
                "json" => [
                    "phone" => $this -> data["phone"],
                    "VIN" => $this -> data["vin"]
                ]
            ]);
            if($response -> getStatusCode() === 200){
                Alert::success('Отправка завершена');
            }
        } catch (\Exception $e){
            Alert::error('Ошибка: '.$e -> getMessage());
        }
    }
}
