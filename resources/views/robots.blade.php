User-agent: *
@if (App::environment('production'))
Disallow: /login
@else
Disallow: /
@endif