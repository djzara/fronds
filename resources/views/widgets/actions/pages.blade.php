@component('components.action_panel')

    @slot('panelHeader')
        {{ __('widgets.action.panels.pages.title') }}
    @endslot

    @slot('slot')
        {{-- pages are just a simple modal with crud operations. nothing special at this time --}}
        <action-widget>
            <pages-action data-comp="pages-action" endpoint-uri="{{ url('api/v1/page') }}">
                <asset-list :list='@json($pageList, JSON_THROW_ON_ERROR, 512)' slot="pages-action-addons"></asset-list>
            </pages-action>
        </action-widget>
    @endslot

    @slot('panelFooter')

    @endslot

@endcomponent
