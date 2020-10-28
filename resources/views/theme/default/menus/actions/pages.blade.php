@component('components.action-panel')

    @slot('panelHeader')
        <span>{{ __('widgets.action.panels.pages.title') }}</span>
        <fronds-button btn-text="Add Page"
                       btn-event-name="fronds-add-page-modal"
                       btn-type="a"
                       btn-id="fronds-page-add-btn"
                       :btn-styles="{color: '#1BC215', display:'inline-block', marginRight: '10px;'}"
                       :btn-outer-styles="{backgroundColor: 'transparent', display: 'inline'}">
            <font-awesome-icon size="1x" :icon="['fas','plus-circle']"></font-awesome-icon>
        </fronds-button>
    @endslot

    @slot('slot')
        <pages-action data-comp="pages-action" dusk="manage-page-component-name"
                      endpoint-uri="{{ url('api/v1/page') }}"></pages-action>
        <asset-list :deletes-rows="true" triggers-event-named="fronds-edit-page-modal"
                    triggers-delete-event-named="fronds-delete-page" id="fronds-pages-action-asset-list"
                    :list='@json($pageList, JSON_THROW_ON_ERROR)'></asset-list>
    @endslot

    @slot('panelFooter')

    @endslot

@endcomponent
