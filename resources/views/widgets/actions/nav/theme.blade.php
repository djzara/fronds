@component('components.action-panel-nav')
    @slot('navLabel')
        {{ __('widgets.action.panels.theme.title') }}
    @endslot
    @slot('targetId')
        {{ __('widgets.action.panels.theme.title') }}
    @endslot
@endcomponent