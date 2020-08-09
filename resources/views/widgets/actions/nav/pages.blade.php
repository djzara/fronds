@component('components.action-panel')

    @slot('panelHeader')
        {{ __('widgets.action.panels.menus.title') }}
        <fronds-button btn-text=""
                       btn-event-name="fronds-add-page-modal"
                       btn-type="a"
                       btn-id="fronds-page-add-btn"
                       :btn-styles="{color: '#1BC215'}"
                       :btn-outer-styles="{backgroundColor: 'transparent',
                       width: 0,
                       height: 0}">
            <font-awesome-icon size="2" :icon="['fas','plus-circle']"></font-awesome-icon>
        </fronds-button>
        <fronds-button btn-text=""
                       btn-event-name="fronds-edit-page-modal"
                       btn-type="a"
                       btn-id="fronds-page-edit-btn"
                       btn-styles="editPageButtonStyles"
                       btn-outer-styles="pageButtonOuterStyles">
            <font-awesome-icon size="editButtonSize" :icon="['fas','edit']"></font-awesome-icon>
        </fronds-button>
    @endslot

    @slot('slot')
        {{-- menus are just a simple form with crud operations. nothing special at this time --}}
        <action-widget data-menu="pages">
            <pages-action endpoint-uri="{{ url('api/v1/page') }}"></pages-action>
        </action-widget>
        <asset-list :list='@json($pageList, JSON_THROW_ON_ERROR, 512)' slot="pages-action-addons"></asset-list>
    @endslot

    @slot('panelFooter')

    @endslot

@endcomponent