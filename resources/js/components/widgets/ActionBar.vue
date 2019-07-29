<template>

    <b-navbar dusk="fronds-action-bar" :toggleable="toggleableSize" :type="navbarType" :variant="navbarVariant">
            <span v-if="logoSrc !== null">
                <img :src="logoSrc" class="fronds-logo" alt="logo"/>
            </span>
        <span v-else>
                {{ logoText }}
            </span>

        <b-navbar-nav :key="$index" v-for="(actionItem, $index) in filteredActions">
            <b-nav-item
                    v-if="actionItem.link && !actionItem.isDropdown"
                    :href="actionItem.href"
                    :key="$index">
                {{ actionItem.text }}
            </b-nav-item>
            <b-nav-item-dropdown :text="actionItem.text" v-else-if="actionItem.isDropdown">
                <b-dropdown-item v-for="(child, $index) in actionItem.children" :key="$index"
                                 :href="child.href">{{ child.text }}
                </b-dropdown-item>
            </b-nav-item-dropdown>
        </b-navbar-nav>

    </b-navbar>

</template>

<script>

    import bNavbar from "bootstrap-vue/es/components/navbar/navbar";
    import bNavbarNav from "bootstrap-vue/es/components/navbar/navbar-nav";
    import bNavItem from "bootstrap-vue/es/components/nav/nav-item";
    import bNavItemDropdown from "bootstrap-vue/es/components/nav/nav-item-dropdown";
    import bDropdownItem from "bootstrap-vue/es/components/dropdown/dropdown-item";

    export default {
        name: "action-bar",
        data() {
            return {
                toggleableSize: "md",
                navbarType: "dark",
                navbarVariant: "info"
            }
        },
        components: {
            bNavbar, bNavbarNav, bNavItem, bNavItemDropdown, bDropdownItem
        },
        computed: {
            filteredActions() {

                return this.actionItems.map((item, index) => {
                    return {
                        link: item.hasOwnProperty("href") && item.href !== "",
                        text: item.text,
                        href: item.href,
                        key: index,
                        children: item.children,
                        isDropdown: item.dropdown
                    };
                });
            }
        },
        props: {
            logoSrc: {
                type: String,
                required: false,
                default: null
            },
            logoText: {
                type: String,
                required: false,
                default: ""
            },
            actionItems: {
                type: Array,
                required: true
            }
        }
    }
</script>

