const attachSym = Symbol("attachEventTo"),
    ofTypeSym = Symbol("ofType"),
    withMethodSym = Symbol("withMethod"),
    eventBuild = {};
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