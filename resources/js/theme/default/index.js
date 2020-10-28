import {MenuManager} from "../../lib/fronds/menu-manager";
const Fronds = {};
(function() {
    Fronds.getMenuManager = function() {
        return new MenuManager();
    };
})();
window.Fronds = Fronds;
// eslint-disable-next-line no-prototype-builtins
if (window.hasOwnProperty("defaultBooted")) {
    window.defaultBooted();
}
