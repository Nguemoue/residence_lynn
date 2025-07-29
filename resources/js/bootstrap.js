import axios from 'axios';
/*import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';*/

// Register any Alpine directives, components, or plugins here...

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/*Alpine.plugin(persist);
Alpine.start();*/
