<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MarketTicker;
use App\Models\Symbol;
use App\Models\Setting;
use App\Models\CustomToken;

class WebController extends Controller
{
    public function __construct()
    {
        $this->userId = 1;
    }

    public function index(Request $request)
    {
        $data = $request->all();
        $user_id = $this->userId;
        $setting = Setting::where('user_id', $user_id)->first();
        $symbols = Symbol::all();

        $customTokens = CustomToken::where('user_id', $user_id)->get();

        if (!empty($setting)) {
            $setting = $setting->toArray();
            $setting = json_decode($setting['setting'], true);
        }

        return view('index3', compact('setting', 'symbols', 'customTokens'));
    }

    public function index2(Request $request)
    {
        $data = $request->all();
        $user_id = $this->userId;
        $setting = Setting::where('user_id', $user_id)->first();
        $symbols = Symbol::all();

        $customTokens = CustomToken::where('user_id', $user_id)->get();

        if (!empty($setting)) {
            $setting = $setting->toArray();
            $setting = json_decode($setting['setting'], true);
        }

        return view('index', compact('setting', 'symbols', 'customTokens'));
    }

    public function batch(Request $request)
    {
        $data = $request->all();
        $user_id = $this->userId;
        $setting = Setting::where('user_id', $user_id)->first();
        $symbols = Symbol::all();

        if (!empty($setting)) {
            $setting = $setting->toArray();
            $setting = json_decode($setting['setting'], true);
        }

        return view('index', compact('setting', 'symbols'));
    }

    public function collect(Request $request)
    {
        return view('collect');
    }

    public function saveSettings(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        $user_id = $this->userId;
        
        $data = json_encode($data);

        $setting = Setting::updateOrCreate(['user_id' => $user_id], ['setting' => $data]);

        return response()->json(['success' => true]);
    }

    public function list(Request $request)
    {
        $data = $request->all();
        $html = "";
        $user_id = $this->userId;

        $setting = Setting::where('user_id', $user_id)->first();
        $setting = json_decode($setting['setting'], true);

        // $percentage = (int)$setting['percent_qualifier'] ?? 0;
        $percentage = 0;
        // $options = (int)$setting['options'] ?? 10; 
        $options = 0;

        $pre = (int)$setting['pre_qualifying'] ?? 10;
        $qualifying = (int)$setting['qualifying'] ?? 10;
        $sub = ($pre + $qualifying);

        $startTime = $setting['start_time'] ?? 60;
        $startTimeUnit = $setting['start_time_unit'] ?? 'seconds';

        $duration = $setting['duration'] ?? 60;
        $durationUnit = $setting['duration_unit'] ?? 'seconds';

        $live = $setting['live_averaging_time'] ?? 60;
        $liveUnit = $setting['live_averaging_time_unit'] ?? 'seconds';

        $start = [ 'unit' => $startTimeUnit, 'duration' => $startTime ];
        $duration = [ 'unit' => $durationUnit, 'duration' => $duration ];
        $live = [ 'unit' => $liveUnit, 'duration' => $live ];

        $start = self::processTime($start);
        $duration = self::processTime($duration);
        $live = self::processTime($live) * 1000;
        $now = strtotime(now());

        $symbol = strtoupper($data['symbol']) ?? 'ALL';
        $symbols = Symbol::when(!empty($symbol) && $symbol !== 'ALL', function($query) use ($symbol){
                            $query->where('symbol', 'LIKE', "%{$symbol}");
                        })->get()
                        ->toArray();
        $sym = $symbol;
        
        $query = MarketTicker::selectRaw('AVG(volume) AS volume, symbol, latest_price')
                            ->when(!empty($symbol) && $symbol !== 'ALL', function($query) use ($symbol){
                                $query->where('symbol', 'LIKE', "%{$symbol}");
                            })
                            ->groupBy('symbol');
        
        $start = $now - $start;
        $duration = $now - $duration;

        // $tickers = $query->whereBetween('dt', [$start, $now])
        //                 ->get()
        //                 ->toArray();

        $tickers2 = $query->whereBetween('dt', [$duration, $now])
                        ->get()
                        ->toArray();

        $tickers = $query->get()->toArray();
        

        $first = [];
        $second = [];
        $result = [];

        // foreach ($tickers as $tickerValue) {
        //     $first[$tickerValue['symbol']] = $tickerValue;
        // }

        // foreach ($tickers2 as $ticker2Value) {
        //     $second[$ticker2Value['symbol']] = $ticker2Value;
        // }


        // foreach ($symbols as $symbol) {
        //     $symbol = $symbol['symbol'];

        //     $initialVolume = $first[$symbol]['volume'] ?? 0;
        //     $finalVolume = $second[$symbol]['volume'] ?? 0;
        //     // Percentage Increase | Decrease for VOLUME
        //     $result[$symbol]['volume'] = (double)self::percentageChange($initialVolume, $finalVolume);
        // }



        $html = view('list', compact('tickers', 'result', 'percentage', 'options', 'live', 'sym', 'symbols', 'sub'))->render();
        return $html;
    }

    public function list2(Request $request)
    {
        $data = $request->all();
        $html = "";
        $user_id = $this->userId;

        $setting = Setting::where('user_id', $user_id)->first();
        $setting = json_decode($setting['setting'], true);


        $symbol = strtoupper($data['symbol']) ?? 'ALL';
        $symbols = Symbol::when(!empty($symbol) && $symbol !== 'ALL', function($query) use ($symbol){
                            $query->where('symbol', 'LIKE', "%{$symbol}");
                        })->get()
                        ->toArray();
        $sym = $symbol;

        $html = view('list2', compact('sym', 'symbols'))->render();
        return $html;
    }

    public function calculate(Request $request)
    {
        $data = $request->all();
        $list = $data['list'] == 'true' ?? false;
        $user_id = $this->userId;
        $setting = Setting::where('user_id', $user_id)->first();
        $setting = json_decode($setting['setting'], true);

        $startTime = $setting['start_time'] ?? 60;
        $startTimeUnit = $setting['start_time_unit'] ?? 'seconds';

        $duration = $setting['duration'] ?? 60;
        $durationUnit = $setting['duration_unit'] ?? 'seconds';

        $live = $setting['live_averaging_time'] ?? 60;
        $liveUnit = $setting['live_averaging_time_unit'] ?? 'seconds';

        $srfTime = $setting['srf_time'] ?? 60;
        $srfUnit = $setting['srf_time_unit'] ?? 'seconds';

        $start = [ 'unit' => $startTimeUnit, 'duration' => $startTime ];
        $duration = [ 'unit' => $durationUnit, 'duration' => $duration ];
        $live = [ 'unit' => $liveUnit, 'duration' => $live ];
        $screenRefresh = [ 'unit' => $srfUnit, 'duration' => $srfTime ];

        $start = self::processTime($start);
        $duration = self::processTime($duration);
        $live = self::processTime($live);
        $screenRefresh = self::processTime($screenRefresh);

        $toggleVolume = !empty($setting['toggle_volume']) && $setting['toggle_volume'] == 'on' ?? false;
        $togglePrice = !empty($setting['toggle_price']) && $setting['toggle_price'] == 'on' ?? false;
        $toggleTrades = !empty($setting['toggle_trades']) && $setting['toggle_trades'] == 'on' ?? false;

        $symbol = $data['symbol'] ?? '';
        $symbols = Symbol::when(!empty($symbol), function($query) use ($symbol){
                        $query->where('symbol', 'LIKE', "%{$symbol}");
                    })
                    ->get()
                    ->toArray();

        $now = strtotime(now());
        
        $query = MarketTicker::when($toggleVolume, function($query){
                                $query->selectRaw('AVG(volume) AS volume');
                            })
                            ->when($togglePrice, function($query){
                                $query->selectRaw('AVG(weighted_average_price) AS price');
                            })
                            ->when($toggleTrades, function($query){
                                $query->selectRaw('AVG(number_of_trades) AS trades');
                            })
                            ->selectRaw('symbol AS symbol')
                            ->when(!empty($symbol), function($query) use ($symbol){
                                $query->where('symbol', 'LIKE', "%{$symbol}");
                            })
                            ->groupBy('symbol');
        
        $start = $now - $start;
        $duration = $now - $duration;
        $live = $now - $live;

        $tickers = $query->whereBetween('dt', [$start, $live])
                        ->get()
                        ->toArray();

        $tickers2 = $query->whereBetween('dt', [$duration, $now])
                        ->get()
                        ->toArray();
        
        $tickers3 = $query->whereBetween('dt', [$live, $now])
                        ->get()
                        ->toArray();

        $first = [];
        $second = [];
        $third = [];
        $result = [];
        $result2 = [];

        foreach ($tickers as $tickerValue) {
            $first[$tickerValue['symbol']] = $tickerValue;
        }

        foreach ($tickers2 as $ticker2Value) {
            $second[$ticker2Value['symbol']] = $ticker2Value;
        }

        foreach ($tickers3 as $ticker3Value) {
            $third[$ticker3Value['symbol']] = $ticker3Value;
        }
        
        foreach ($symbols as $symbol) {
            $symbol = $symbol['symbol'];
            $result2[$symbol]['wfn'] = (int)$setting['wfn'];

            if ($togglePrice) {
                $initialPrice = $first[$symbol]['price'] ?? 0;
                $finalPrice = $second[$symbol]['price'] ?? 0;
                $livePrice = $third[$symbol]['price'] ?? 0;

                // Percentage Increase | Decrease for PRICE
                $result[$symbol]['price'] = (double)self::percentageChange($initialPrice, $finalPrice);
                $result2[$symbol]['price'] = (double)self::percentageChange($initialPrice, $livePrice);
            }

            if ($toggleVolume) {
                
                $initialVolume = $first[$symbol]['volume'] ?? 0;
                $finalVolume = $second[$symbol]['volume'] ?? 0;
                $liveVolume = $third[$symbol]['volume'] ?? 0;
                
                // Percentage Increase | Decrease for VOLUME
                $result[$symbol]['volume'] = (double)self::percentageChange($initialVolume, $finalVolume);
                $result2[$symbol]['volume'] = (double)self::percentageChange($initialVolume, $liveVolume);
            }

            if ($toggleTrades) {
                $initialTrades = $first[$symbol]['trades'] ?? 0;
                $finalTrades = $second[$symbol]['trades'] ?? 0;
                $liveTrades = $third[$symbol]['trades'] ?? 0;
                
                // Percentage Increase | Decrease for TRADES
                $result[$symbol]['trades'] = (double)self::percentageChange($initialTrades, $finalTrades);
                $result2[$symbol]['trades'] = (double)self::percentageChange($initialTrades, $liveTrades);
            }
        }

        if ($list) {
            $control = [
                'toggleVolume' => $toggleVolume,
                'togglePrice' => $togglePrice,
                'toggleTrades' => $toggleTrades,
                'setting' => $setting,
            ];
            // return view('list', compact('tickers', 'control', 'result')); // remove | test

            $html = view('list', compact('tickers', 'control', 'result'))->render();

            return response()->json(['html' => $html, 'screenRefresh' => ($screenRefresh * 1000)]);
        }
        
        return response()->json(['tickers' => $result2]);
    }

    public static function percentageChange($initial = 0, $final = 0)
    {
        $difference = ($final - $initial);

        if ($difference == 0) {
            return 0;
        }
        
        $difference = ($difference / $initial);
        $difference = $difference * 100;
        return number_format($difference);
    }

    public static function processTime($setting = [])
    {
        $unit = $setting['unit'] ?? 'seconds';
        $duration = $setting['duration'] ?? 60;

        switch ($unit) {
            case 'seconds':
                $time = $duration; // seconds
                break;
            case 'minutes':
                $time = $duration * 60; // minutes to seconds
                break;
            case 'hours':
                $time = $duration * 3600; // hours to seconds
                break;
            default:
                $time = 60;
                break;
        }

        return (int)$time;
    }

    // "e": "24hrTicker",  // Event type
    // "E": 1672515782136, // Event time
    // "s": "BNBBTC",      // Symbol
    // "p": "0.0015",      // Price change
    // "P": "250.00",      // Price change percent
    // "w": "0.0018",      // Weighted average price
    // "x": "0.0009",      // First trade(F)-1 price (first trade before the 24hr rolling window)
    // "c": "0.0025",      // Last price
    // "Q": "10",          // Last quantity
    // "b": "0.0024",      // Best bid price
    // "B": "10",          // Best bid quantity
    // "a": "0.0026",      // Best ask price
    // "A": "100",         // Best ask quantity
    // "o": "0.0010",      // Open price
    // "h": "0.0025",      // High price
    // "l": "0.0010",      // Low price
    // "v": "10000",       // Total traded base asset volume
    // "q": "18",          // Total traded quote asset volume
    // "O": 0,             // Statistics open time
    // "C": 86400000,      // Statistics close time
    // "F": 0,             // First trade ID
    // "L": 18150,         // Last trade Id
    // "n": 18151          // Total number of trades

    public function marketTicker(Request $request)
    {
        $data = $request->all();

        $data = json_decode($data['ticker']);

        foreach ($data as $ticker) {
            $tickers = collect($ticker)->toArray();
            $data = [
                'symbol' => $tickers['s'], // Symbol
                'price_change' => $tickers['p'], // Price Change
                'price_change_percentage' => $tickers['P'], // Price Change Percentage
                'weighted_average_price' => $tickers['w'], // Weighted Average Price
                'open_time' => $tickers['O'], // Open Time
                'close_time' => $tickers['C'], // Close Time
                'number_of_trades' => $tickers['n'], // Number of Trades
                'latest_price' => $tickers['c'], // Last Price | Latest Price
                'volume' => $tickers['v'], // Last Price | Latest Price
                'dt' => strtotime(now())
            ];

            MarketTicker::create($data);

            Symbol::updateOrCreate([
                'symbol' => $tickers['s']
            ],[
                'symbol' => $tickers['s']
            ]);

        }
        $dt = now()->format('F j, Y h:i:sa');
        $timestamp = strtotime($dt);
        return response()->json([ "API feeds saved ({$dt})  -- {$timestamp} <br />" ]);
    }

    public function getData(Request $request)
    {
        $column = (string)$request->get('column');
        $symbol = (string)$request->get('symbol');
        $duration = (int)$request->get('duration');
        $now = (string)now()->format("Y-m-d H:i:s");
        $date = (string)now()->subSeconds($duration)->format("Y-m-d H:i:s");

        $ticker = MarketTicker::where('symbol', $symbol)
                                // ->whereBetween('created_at', [ $now, $date ])
                                ->avg($column);

        return response()->json([ 'value' => $ticker]);
    }

    public function customTokenSave(Request $request)
    {
        $data = $request->all();
        $user_id = $this->userId;
        $symbol = $data['symbol'] ?? '';

        if (!empty($symbol)) {
            CustomToken::updateOrCreate(
                [
                    'symbol' => $symbol,
                    'user_id' => $user_id
                ],
                [
                    'symbol' => $symbol
                ]
            );

            return true;
        }
        return false;
    }

    public function customTokenRemove(Request $request)
    {
        $data = $request->all();
        $user_id = $this->userId;
        $symbol = $data['symbol'] ?? '';

        if (!empty($symbol)) {
            CustomToken::where('symbol', $symbol)
                        ->where('user_id', $user_id)
                        ->delete();

            return true;
        }
        return false;
    }
}
