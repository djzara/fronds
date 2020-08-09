@component('components.action-panel-nav')
    @slot('navLabel')
        {{ __('widgets.action.panels.content.title') }}
    @endslot
    @slot('targetId')
        {{ __('widgets.action.panels.content.title') }}
    @endslot
@endcomponent