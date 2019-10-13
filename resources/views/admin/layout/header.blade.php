<div id="fronds-admin-header">
    <div class="fronds-content-center" id="fronds-admin-header-banner">
        @if(Route::getCurrentRoute()->getName() === 'fronds.admin.manage')
            <h3>{{ __('page.admin.header.home') }}</h3>
        @endif
    </div>
</div>