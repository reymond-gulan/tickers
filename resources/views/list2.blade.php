<div class="row mt-2">
@foreach($symbols as $chunkKey => $symbols)
<div class="col-sm-4 p-1">
    <div class="container p-0 border bg-white">
        <table class="text-xs bg-transparent" id="table">
            <thead style="cursor:pointer;">
                <tr id="list-header">
                    <th style="width:70px;">SYMBOL</th>
                    <th class="d-none" style="width:70px;"></th>
                    <th class="d-none" style="width:70px;"></th>
                    <th style="width:50px;">PRICE %</th>
                    <th></th>
                    <th class="d-none"></th>
                    <th style="width:60px;">VOLUME %</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($symbols as $symbol)
                    <tr data-symbol="{{ $symbol['symbol'] }}" id="symbol-{{ $symbol['symbol'] }}" class="symbols border-bottom border-secondary">
                        <td><b><a target="_blank" style="text-decoration:none;" href="https://www.binance.com/en/trade/{{ $symbol['symbol'] }}?type=spot">{{ $symbol['symbol'] }}</b></td>
                        <td class="d-none" id="symbol-{{ $symbol['symbol'] }}-price-static"></td>
                        <td class="d-none" id="symbol-{{ $symbol['symbol'] }}-price"></td>
                        <td class="text-right" id="symbol-{{ $symbol['symbol'] }}-price_change_percentage_value"></td>
                        <td id="symbol-{{ $symbol['symbol'] }}-price_change_percentage"></td>
                        <td class="d-none">
                            <input class="form-control" id="symbol-{{ $symbol['symbol'] }}-initial-volume">
                        </td>
                        <td class="text-right" id="symbol-{{ $symbol['symbol'] }}-volume-average"></td>
                        <td class="text-right" id="symbol-{{ $symbol['symbol'] }}-volume-average-value"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endforeach
</div>