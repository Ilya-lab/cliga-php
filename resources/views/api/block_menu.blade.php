<ul class="devsite-breadcrumb-list">
    <li class="devsite-breadcrumb-item">
        <a href="/" class="devsite-breadcrumb-link gc-analytics-event"
           data-category="Site-Wide Custom Events"
           data-label="Breadcrumbs"
           data-value="1">Главная</a>
    </li>
    <li class="devsite-breadcrumb-item">
        <div class="devsite-breadcrumb-guillemet material-icons" aria-hidden="true"></div>
        <a href="{{ route('api_doc') }}" class="devsite-breadcrumb-link gc-analytics-event"
           data-category="Site-Wide Custom Events"
           data-label="Breadcrumbs"
           data-value="2">API</a>
    </li>
    @foreach($menu as $m)
    <li class="devsite-breadcrumb-item">
        <div class="devsite-breadcrumb-guillemet material-icons" aria-hidden="true"></div>
        <a href="{{ $m['url'] }}" class="devsite-breadcrumb-link gc-analytics-event"
           data-category="Site-Wide Custom Events"
           data-label="Breadcrumbs"
           data-value="3">{{ $m['name'] }}</a>
    </li>
    @endforeach
</ul>
