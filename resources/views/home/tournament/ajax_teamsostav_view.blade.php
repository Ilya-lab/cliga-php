<div class="m-3">
    <table class="w-100">
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">Игрок</th>
            <th class="text-center">Позиция</th>
        </tr>
        <tbody>
        @foreach($players as $player)
            <tr class="popoverable border-top @if($loop->index % 2 == 0) bg-light @endif " data-player-id="{{ $player->player_id }}" data-team-id="{{ $player->team_id }}" data-opponent-id="{{ $opponent_id }}" data-player-name="{{ $player->number }}. {{ $player->family . ' ' . $player->name }}" style="cursor: pointer" title="Действия в матче" @if($player->is_goalkeeper ) data-gk="1" @else data-gk="0" @endif>
                <td class="text-center p-2"  @if($player->is_goalkeeper ) style="font-weight: bold;" @endif>{{ $player->number }}</td>
                <td class="text-left" @if($player->is_goalkeeper ) style="font-weight: bold;" @endif>{{ $player->family . ' ' . $player->name }}</td>
                <td class="text-center"  @if($player->is_goalkeeper ) style="font-weight: bold;" @endif>@if($player->is_goalkeeper ) вр @else {{ $player->position_shortname }} @endif</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<p>Итого заявлено на игру: <strong class="red">{{ $players->count() }}</strong></p>
<script>
    memberPlayers[{{ $team_id }}] = {!! $players !!}
    try {
        popover()
    } catch (error) {
        //console.log('Функция не вызвана')
    }
</script>
