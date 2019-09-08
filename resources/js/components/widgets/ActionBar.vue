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

    import { BNavbar, BNavbarNav, BNavItem,
        BNavItemDropdown, BDropdownItem } from "bootstrap-vue";

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
            BNavbar, BNavbarNav, BNavItem, BDropdownItem, BNavItemDropdown
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

