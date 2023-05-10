import Vue from 'vue';
import Vuetify  from 'vuetify/lib';
//import VuetifyGoogleAutocomplete from 'vuetify-google-autocomplete';
Vue.use(Vuetify);
import ru from 'vuetify/es5/locale/ru'
import fr from 'vuetify/es5/locale/fr'
/*Vue.use(VuetifyGoogleAutocomplete, {
  apiKey: 'AIzaSyBFPbarJFXmMECiIuYX8jLdcLwYCa2CAr8', // Can also be an object. E.g, for Google Maps Premium API, pass `{ client: <YOUR-CLIENT-ID> }`
  version: '', // Optional
  language: 'en', // Optional
});*/
export default new Vuetify({
  theme: {
      options: {
        customProperties: true,
      },
    themes: {
      light: {
        primary: '#5D6160',
        secondary: '#fbebf6',
        accent: '#82B1FF',
        error: '#FF5252',
        info: '#2196F3',
        success: '#4CAF50',
        warning: '#FFC107'
      },
      dark: {
        primary: '#5D6160',
        secondary: '#f8e2f2',
        accent: '#82B1FF',
        error: '#FF5252',
        info: '#2196F3',
        success: '#4CAF50',
        warning: '#FFC107'
      },
    }, 
  },
  icons: {
    iconfont: 'mdi',
  },
  lang: {
    locales: { ru, fr },
    current: document.querySelector('meta[property="lang"]').getAttribute('content'),
  },
});
