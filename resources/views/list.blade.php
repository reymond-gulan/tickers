
<div class="col-sm-12">
<input type="hidden" id="block-count" value="{{ $options ?? 10 }}" readonly>
<div class="alert alert-success qualifying_status p-0 p-1 text-center" style="font-style:italic;font-weight:bold;"></div>
<table class="bg-transparent tokens-table d-none" id="table">
    <thead style="cursor:pointer;">
        <tr id="list-header" class="border-bottom border-secondary">
            <th style="width:100px;"></th>
            <th style="width:100px;">SYMBOL</th>
            <th class="d-none"></th>
            <th style="width:150px !important;" class="d-none">IV</th>
            <th style="width:150px !important;" class="d-none">FV</th>
            <th style="width:50px !important;">QVPS</th>
            <th style="width:50px !important;">QPPS</th>
            <th class="d-none"></th>
            <th style="width:150px !important;">PRICE</th>
            <th></th>
            <th style="width:100px;" class="sort d-none" data-sort="desc"></th>
            @for($i = 1; $i <= $options;$i++)
                <th style="width:100px;">{{$i}}</th>
            @endfor
        </tr>
    </thead>
    <tbody class="symbols-body">
        @foreach($symbols as $symbol)
            @php
                $symbol = $symbol['symbol'];
            @endphp
            {{--@if (!empty($result[$symbol]['volume']) && $result[$symbol]['volume'] > $percentage)--}}
            <tr data-symbol="{{ $symbol }}" id="symbol-{{ $symbol }}" class="symbols border-bottom border-secondary">
                <td id="symbol-{{ $symbol }}-ranking" class="ranking"></td>
                <td style="width:100px;">
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
                <td class="d-none">
                    <input class="form-control" id="symbol-{{ $symbol }}-volume" class="volume text-xs border-0">
                </td>
                <td class="d-none" id="symbol-{{ $symbol }}-initial-volume-value"><!--- INITIAL VOLUME VALUE --></td>
                <td class="d-none" id="symbol-{{ $symbol }}-final-volume-value"><!--- FINAL VOLUME VALUE --></td>
                <td style="width:50px !important;" class="text-center" id="symbol-{{ $symbol }}-volume-average"><!--- VOLUME AVERAGE (QVPS) --></td>
                <td style="width:50px !important;" class="text-center" id="symbol-{{ $symbol }}-qpps"><!--- VOLUME AVERAGE (QVPS) --></td>
                <td class="d-none">
                    <input class="form-control" id="symbol-{{ $symbol }}-live-price" class="live-price">
                </td>
                <td class="text-right" id="symbol-{{ $symbol }}-price"></td>
                <td><span class="badge bg-secondary">{{ now()->format('h:i:s a') }}</span></td>
                <td class="text-right d-none" id="symbol-{{ $symbol }}-latest-price"></td>
                @for($i = 1; $i <= $options;$i++)
                    <td class="text-center p-0 text-sm">
                        <span class="w-100" id="symbol-{{ $symbol }}-option{{$i}}"></span>
                    </td>
                @endfor
            </tr>
            {{--@endif--}}
        @endforeach
    </tbody>
</table>
</div>