<?php

namespace App\Widgets;

use Fadion\Fixerio\Currency;
use Fadion\Fixerio\Exchange;
use Arrilot\Widgets\AbstractWidget;

class ExchangeRate extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];
    public $cacheTime = 60;

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        try {
            $exchange = new Exchange();
            $exchange->base(Currency::USD);
            $exchange->symbols(
                Currency::IDR,
                Currency::AUD,
                Currency::BGN,
                Currency::BRL,
                Currency::CAD,
                Currency::CHF,
                Currency::CNY,
                Currency::CZK,
                Currency::DKK,
                Currency::EUR,
                Currency::GBP
            );

            $data['rates'] = $exchange->get();
        } catch (Exception $e) {
            $data['rates'] = [];
        }

        return view('_widgets.exchange_rate', $data);
    }
}
