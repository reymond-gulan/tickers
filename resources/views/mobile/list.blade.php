<div class="container-fluid">
    <div class="negative">
        @foreach($symbols as $symbol)
            @php
                $symbol = $symbol['symbol'];
            @endphp
            <span id="symbol-{{ $symbol }}-negative"></span>
            <span class="d-none" id="symbol-{{ $symbol }}-current-price"></span>
        @endforeach
        <!-- <p class="bg-success" style="width:20%;"></p> -->
    </div>
    <div class="positive">
            @foreach($symbols as $symbol)
                @php
                    $symbol = $symbol['symbol'];
                @endphp
                    <span id="symbol-{{ $symbol }}-positive"></span>
            @endforeach
        <!-- <p class="bg-red" style="width:10%;"></p> -->
    </div>
    
</div>