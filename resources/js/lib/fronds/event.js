const attachSym = Symbol("attachEventTo");
const ofTypeSym = Symbol("ofType");
const withMethodSym = Symbol("withMethod");
const eventBuild = {};
class Event {
    constructor() {
        eventBuild[attachSym].addEventListener(eventBuild[ofTypeSym], eventBuild[withMethodSym]);
    }
}

export class EventBuilder {
    ofType(eventName) {
        eventBuild[ofTypeSym] = eventName;
        return this;
    }

    /**
     *
     * @param {Element} attachTo
     * @returns {EventBuilder}
     */
    attachEventTo(attachTo) {
        eventBuild[attachSym] = attachTo;
        return this;
    }

    withMethod(callback) {
        eventBuild[withMethodSym] = callback;
        return this;
    }

    create() {
        return new Event();
    }
}