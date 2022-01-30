import { FrameworkConfiguration, PLATFORM } from 'aurelia-framework';

export function configure(configure: FrameworkConfiguration) {
    configure.globalResources([
        // PLATFORM.moduleName('./yyy'),
    ]);
}
