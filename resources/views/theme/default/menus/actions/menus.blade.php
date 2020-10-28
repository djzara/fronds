@component('components.action-panel')

    @slot('panelHeader')
        <span>{{ __('widgets.action.panels.menus.title') }}</span>
        <fronds-button btn-text="Add Menu"
                       btn-event-name="fronds-add-menu-modal"
                       btn-type="a"
                       btn-id="fronds-menu-add-btn"
                       :btn-styles="{color: '#1BC215', display:'inline-block', marginRight: '10px;'}"
                       :btn-outer-styles="{backgroundColor: 'transparent', display: 'inline'}">
            <font-awesome-icon size="1x" :icon="['fas','plus-circle']"></font-awesome-icon>
        </fronds-button>
    @endslot

    @slot('slot')
        <menu-action data-comp="menu-action" dusk="manage-menu-component-name"
                      endpoint-uri="{{ url('api/v1/menus') }}"></menu-action>
        <asset-list :deletes-rows="true" triggers-event-named="fronds-edit-menu-modal"
                    triggers-delete-event-named="fronds-delete-menu" id="fronds-menu-action-asset-list"
                    :list='@json($menuList, JSON_THROW_ON_ERROR)'></asset-list>
    @endslot

    @slot('panelFooter')

    @endslot

@endcomponent