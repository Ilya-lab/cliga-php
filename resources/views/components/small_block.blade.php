<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <a class="noline" href="{{ $url }}">
    <div class="tile-stats blue">
        <div class="icon"><i class="fa {{ $icon }}"></i>
        </div>
        <div class="count">{{ $title }}</div>
        <h3>{{ $description }}</h3>
        {{ $slot }}
    </div>
    </a>
</div>
