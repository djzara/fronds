/* eslint no-undef: off, no-unused-vars: off */

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

window.Vue = require('vue');

// individual local vue libs
require("./lib/vue/fa");
// end individual local vue libs

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// local bootstrap plugins and components
import BootstrapVue from "bootstrap-vue";
Vue.use(BootstrapVue);

import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
Vue.component("font-awesome-icon", FontAwesomeIcon);
// end local bootstrap plugins and components


/**
 * We need to grab anything in the fronds library too
 */
require("./fronds");
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const fronds = new Vue({
    el: '#fronds'
});
