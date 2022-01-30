import {bootstrap} from "aurelia-bootstrapper";
import {Aurelia, PLATFORM} from 'aurelia-framework';

declare var PRODUCTION:boolean;

bootstrap((aurelia: Aurelia) => {
    aurelia.use
        .standardConfiguration()
        .plugin(PLATFORM.moduleName('attributes'))
        .plugin(PLATFORM.moduleName('components'))
    ;
    if (PRODUCTION == false) {
        aurelia.use.developmentLogging();
    }
    /* enhance aurelia app */
    // @ts-ignore
    aurelia.start().then(() =>
        aurelia.enhance(document)
    );

    if (!Element.prototype.matches) {
        // @ts-ignore
        Element.prototype.matches = Element.prototype.msMatchesSelector || Element.prototype.webkitMatchesSelector;
    }
    if (!Element.prototype.closest) {
        Element.prototype.closest = (s:any) => {
            let el = this;
            // @ts-ignore
            if (!document.documentElement.contains(el)) return null;
            do {
                // @ts-ignore
                if (el.matches(s)) return el;
                // @ts-ignore
                el = el.parentElement || el.parentNode;
            // @ts-ignore
            } while (el !== null && el.nodeType == 1);
            return null;
        };
    }
});
