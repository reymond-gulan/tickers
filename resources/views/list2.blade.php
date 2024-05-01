{{--
<table class="w-100 bg-transparent text-xs" id="table">
    <thead style="cursor:pointer;">
        <tr id="list-header" class="border-bottom border-secondary">
            <th></th>
            <th class="sym">SYMBOL</th>
            <th>CURRENT PRICE</th>
            <th>%</th>
        </tr>
    </thead>
    <tbody class="symbols-body" id="zero-tokens">
        @foreach($symbols as $symbol)
            @php
                $symbol = $symbol['symbol'];
            @endphp
            <tr data-symbol="{{ $symbol }}" id="symbol-{{ $symbol }}" class="symbols border-bottom border-secondary">
                <td></td>
                <td class="text-center">
                    <b>
                    <a target="_blank" style="width:150px !important;" href="https://www.binance.com/en/trade/{{ $symbol }}?type=spot">
                        @if (!empty($sym) && $sym !== "ALL")
                            {{ str_replace($sym, "", $symbol) }}
                        @else
                            {{ $symbol }}
                        @endif
                    </a>
                    </b>
                </td>
                <td class="text-center symbol-{{ $symbol }}-current-price" id="symbol-{{ $symbol }}-current-price"></td>
                <td class="text-center symbol-{{ $symbol }}-price-change-percent" id="symbol-{{ $symbol }}-price-change-percent"></td>
            </tr>
        @endforeach
    </tbody>
</table>
--}}