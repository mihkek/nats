import Vue from 'vue';
//import Vuetify  from 'vuetify/lib';
import Vuetify from 'vuetify'
//import 'vuetify/dist/vuetify.min.css'


//import VuetifyGoogleAutocomplete from 'vuetify-google-autocomplete';
Vue.use(Vuetify);
import ru from 'vuetify/es5/locale/ru'
/*import fr from 'vuetify/es5/locale/fr'*/

export default new Vuetify({
  theme: {
      options: {
        customProperties: true,
      },
    themes: {
      light: {
        primary: '#7CB342',
        secondary: '#fbebf6',
        accent: '#82B1FF',
        error: '#FF5252',
        info: '#2196F3',
        success: '#4CAF50',
        warning: '#FFC107'
      },
      dark: {
        primary: '#7CB342',
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
    locales: { ru }, //fr
    current: document.querySelector('meta[property="lang"]').getAttribute('content'),
  },
});
