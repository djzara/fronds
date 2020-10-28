import {Fronds} from "./fronds";
import {Menu} from "./menu";

/**
 * @type {{string,Menu}}
 */
const registry = {};
/**
 *
 * @type {null|Menu}
 */
let currentlyDisplayedMenu;
export class MenuManager extends Fronds {

    constructor() {
        super({});
    }
    /**
     * Either register an existing menu, or create and register a new one.
     * Menus that are registered should automatically have events bound
     * @param {string|Menu} menuLinkName The name given to the control that will access this manager
     * @param {string|null} [menuName=""] The name given to the actual menu we're going to manage
     * @return {void}
     */
    registerMenu(menuLinkName, menuName) {
        if (menuLinkName instanceof Menu) {
            registry[menuLinkName.linkName] = menuLinkName;
        }
        else if (menuName === null) {
            throw new Error("Invalid menu");
        }
        else {
            registry[menuLinkName] = new Menu(menuLinkName, menuName);
        }
        // now that our
    }

    /**
     *
     * @param {string} menuTitle The menu title
     * @returns {Menu} An existing managed menu
     */
    getMenuByName(menuTitle) {
        return registry[menuTitle];
    }

    /**
     * @returns {number} The number of registered menus being managed
     */
    get length() {
        return Object.entries(registry).length;
    }

    /**
     * Whatever menu is currently displaying, useful to determine what to hide/show, or
     * really any action that needs to be performed on a single menu
     * @returns {Menu} The currently visible menu when viewed one at a time
     */
    get currentMenu() {
        return currentlyDisplayedMenu;
    }

    /*
    The menu title comes in as the value of the menu attribute, denoted with data-menu.
    For example, A menu link to display the manage pages interface might be showFromMenu("pages")
    if pages is the value of data-menu within the pages.blade.php action view
    Same applies to hiding
     */

    /**
     * lookup the specified menu in the registry and if it's display none, set to blank
     * @param {string} menuTitle The title used to identify this menu within the manager
     * @returns {void}
     */
    showFromMenu(menuTitle) {
        const menuToShow = registry[menuTitle];
        menuToShow.show();
        currentlyDisplayedMenu = menuToShow;
    }

    /**
     * lookup the specified menu in the registry and just set display none, simple
     * @param {string} menuTitle The title of the menu within the manager
     * @returns {void}
     */
    hideFromMenu(menuTitle) {
        const menuToShow = registry[menuTitle];
        menuToShow.hide();
    }

    bindMenuEvents(usableElement, eventName, callback) {
        usableElement.addEventListener(eventName, callback);
    }

    commit() {
        Object.entries(registry).forEach(menuItem => {
            const menuName = menuItem[0],
                menu = menuItem[1];
            this.bindMenuEvents(
                Fronds.getFirstByDataName("shows-menu", menuName),
                "click",
                () => {
                    this.hideAllBut(menu);
                    currentlyDisplayedMenu = menu;
                    menu.show();
                }
            );
        });
    }

    hideAllBut(me) {
        Object.values(registry).forEach(menuItem => {
            if (menuItem.menuName !== me.menuName) {
                menuItem.hide();
            }
        });
    }
}