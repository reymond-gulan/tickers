
<input type="hidden" id="block-count" value="{{ $options ?? 10 }}" readonly>
<table class="bg-transparent" id="table">
    <thead style="cursor:pointer;">
        <tr id="list-header" class="border-bottom border-secondary">
            <th style="width:100px;"></th>
            <th style="width:100px;" class="d-none"></th>
            <th style="width:100px;">SYMBOL</th>
            {{--<th style="width:150px !important;">VOL %</th>--}}
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
                <td class="d-none">
                    <button type="button" class="btn btn-sm badge bg-danger text-sm remove" data-symbol="{{ $symbol }}">remove</button>
                </td>
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
                    <input class="form-control" id="symbol-{{ $symbol }}-live-price" class="live-price">
                </td>
                <td class="text-right" id="symbol-{{ $symbol }}-price"></td>
                <td><span class="badge bg-secondary">{{ now()->format('h:i:s a') }}</span></td>
                <td class="text-right d-none" id="symbol-{{ $symbol }}-latest-price"></td>
                @for($i = 1; $i <= $options;$i++)
                    <td class="text-center p-0">
                        <span class="w-100" id="symbol-{{ $symbol }}-option{{$i}}"></span>
                    </td>
                @endfor
            </tr>
            {{--@endif--}}
        @endforeach
    </tbody>
</table>