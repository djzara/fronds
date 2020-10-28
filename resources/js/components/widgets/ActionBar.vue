<template>
    <b-navbar dusk="fronds-action-bar" :toggleable="toggleableSize" :type="navbarType" :variant="navbarVariant">
        <span v-if="logoSrc !== null">
            <img :src="logoSrc" class="fronds-logo" alt="logo" />
        </span>
        <span v-else>
            {{ logoText }}
        </span>

        <b-navbar-nav v-for="(actionItem, $index) in filteredActions" :key="$index">
            <b-nav-item
                v-if="actionItem.link && !actionItem.isDropdown"
                :key="$index"
                :href="actionItem.href"
            >
                {{ actionItem.text }}
            </b-nav-item>
            <b-nav-item-dropdown v-else-if="actionItem.isDropdown" :text="actionItem.text">
                <b-dropdown-item v-for="(child, $ind) in actionItem.children" :key="$ind"
                                 :href="child.href"
                >
                    {{ child.text }}
                </b-dropdown-item>
            </b-nav-item-dropdown>
        </b-navbar-nav>
    </b-navbar>
</template>

<script>

    import { BNavbar, BNavbarNav, BNavItem,
             BNavItemDropdown, BDropdownItem } from "bootstrap-vue";

    export default {
        name: "ActionBar",
        components: {
            BNavbar, BNavbarNav, BNavItem, BDropdownItem, BNavItemDropdown
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
        },
        data() {
            return {
                toggleableSize: "md",
                navbarType: "dark",
                navbarVariant: "info"
            };
        },
        computed: {
            filteredActions() {

                return this.actionItems.map((item, index) => {
                    return {
                        // eslint-disable-next-line no-prototype-builtins
                        link: item.hasOwnProperty("href") && item.href !== "",
                        text: item.text,
                        href: item.href,
                        key: index,
                        children: item.children,
                        isDropdown: item.dropdown
                    };
                });
            }
        }
    };
</script>

