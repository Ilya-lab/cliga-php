<!DOCTYPE html>
<head>
    <title>Турниры</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/widgets/standings.css').'?v='.config('app.version') }}" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="{{ asset('/js/widgets/standings.js').'?v='.config('app.version') }}"></script>
    <script>
        var base_meccs_center_url = "{{ route('widgets_tournament') }}"
        getActualTurnNextTurnAndStandings(2)
        var main_class = "cliga_standings"
    </script>
</head>
<body>

<div class="cliga_standings">
    <div class="container">
        <div class="selectbox absolute_select">
            <select class="absolute_select" onchange="getActualTurnNextTurnAndStandings(this.value);" id="kiemeltSelector">
                @foreach($tournaments as $tourn)
                    <option value="{{ $tourn->id }}" >{{ $tourn->name }}</option>
                @endforeach
            </select>
        </div>
        <h1 class="container_title" id="kiemelt_liga_nev"></h1>
        <div class="three-box-container" id="kiemelt_ligak"></div>
    </div>
</div>
</body>
</html>
