<div class="m-3">
    <table class="w-100">
        <tr>
            <th class="text-center"></th>
            <th class="text-center">Мин</th>
            <th class="text-center">Игрок</th>
            <th class="text-center"></th>
        </tr>
        <tbody>
        @php
        $homeScore = 0; $awayScore = 0;
        @endphp
        @foreach($events as $event)
            @php
            if ($event->team_id == $match->home_id) {
                 if ($event->event_id >= 4 && $event->event_id <= 5) $homeScore++;
                 elseif ($event->event_id == 6) $awayScore++;
            } elseif ($event->team_id == $match->away_id) {
                if ($event->event_id >= 4 && $event->event_id <= 5) $awayScore++;
                elseif ($event->event_id == 6) $homeScore++;
            }
            @endphp
            <tr class="border-top @if($loop->index % 2 == 0) bg-light @endif " data-event-id="{{ $event->id }}">
                <td class="text-center p-2">@if($event->event_id == 4)<img src="{{ asset('/images/icons/ball_16.png') }}" alt="{{ $event->eventname }}">@elseif($event->event_id == 5) <img src="{{ asset('/images/icons/penaltyball.png') }}" alt="{{ $event->eventname }}">@elseif($event->event_id == 6) <img src="{{ asset('/images/icons/agball.png') }}" alt="{{ $event->eventname }}"> @elseif($event->event_id == 1) <img src="{{ asset('/images/icons/yellow.png') }}" alt="{{ $event->eventname }}"> @elseif($event->event_id == 2) <img src="{{ asset('/images/icons/yellow2.png') }}" alt="{{ $event->eventname }}"> @elseif($event->event_id == 3) <img src="{{ asset('/images/icons/red.png') }}" alt="{{ $event->eventname }}"> @endif</td>
                <td class="text-center p-2"><strong>{{ $event->minute }}'</strong></td>
                @if($event->event_id >= 4 && $event->event_id <= 6)
                <td class="text-left">{{ $event->number }} - {{ $event->family . ' ' . $event->name }} @if($event->team_id == $match->home_id) <small class="blue">({{ $match->home->name }})</small> @endif @if($event->team_id == $match->away_id) <small class="green">({{ $match->away->name }})</small> @endif<br><small>@if($event->assist_id > 0) с пер. {{ $event->assist_number }} - {{ $event->assist_family . ' ' . $event->assist_name }}@if($event->opponent_id > 0), @endif @endif @if($event->opponent_id > 0) вр. {{ $event->gk_number }} - {{ $event->gk_family . ' ' . $event->gk_name }} @endif</small></td>
                @else
                <td class="text-left">{{ $event->number }} - {{ $event->family . ' ' . $event->name }} @if($event->team_id == $match->home_id) <small class="blue">({{ $match->home->name }})</small> @endif @if($event->team_id == $match->away_id) <small class="green">({{ $match->away->name }})</small> @endif<br>
                </td>
                @endif
                <td class="text-center remove"><i class="fa fa-close" title="Удалить событие"></i></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <p>Счёт по голам: <span class="red">{{ $homeScore }} : {{ $awayScore }}</span></p>
</div>
