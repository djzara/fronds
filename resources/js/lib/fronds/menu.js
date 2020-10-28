import {Fronds} from "./fronds";

const menuLinkName = Symbol("menu_link_name"),
    menuName = Symbol("menu_name"),
    ref = Symbol("ref"),
    linkRef = Symbol("ref");

export class Menu extends Fronds {


    constructor(link, name) {
        super();
        this[menuLinkName] = link;
        this[menuName] = name;
        this[ref] = Fronds.getFirstByDataName("menu-name", name);
        this[linkRef] = Fronds.getFirstByDataName("shows-menu", link);
    }

    get linkName() {
        return this[menuLinkName];
    }

    get menuName() {
        return this[menuName];
    }

    get ref() {
        return this[ref];
    }

    get visible() {
        return this[ref].style.display === "";
    }

    makeActive() {
        this[linkRef].classList.add("fronds-nav-active");
    }

    makeInactive() {
        this[linkRef].classList.remove("fronds-nav-active");
    }

    hide() {
        this[ref].style.display = "none";
        this.makeInactive();
    }

    show() {
        this[ref].style.display = "";
        this.makeActive();
    }
}