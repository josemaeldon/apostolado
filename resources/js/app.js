import './bootstrap';

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import persist from '@alpinejs/persist';

Alpine.plugin(persist);
Alpine.plugin(collapse);

window.Alpine = Alpine;

Alpine.start();
