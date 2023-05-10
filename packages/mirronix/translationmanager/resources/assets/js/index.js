import { closest } from './dom';
import vuetify from '../plugins/vuetify';
import TranslateString from './components/TranslateString';


const init = () => {
  console.log('translation inited');

  console.log(Lang.messages);

  const handleTranslation = (translationNode) => {
    const placeholder = document.createElement('div');
    translationNode.parentNode.insertBefore(placeholder, translationNode);
    const key = translationNode.getAttribute('data-expression');
    const currentLocale = document.querySelector('meta[property="lang"]').getAttribute('content');

    const app = new Vue({
      vuetify,
      el: placeholder,
      components: { TranslateString },
      render: h => h(TranslateString),
      data: { key, currentLocale }
    })

    app.$on('close', () => {
      app.$destroy();
    });

    app.$on('update', (data) => {
      const currentLocale = document.querySelector('meta[property="lang"]').getAttribute('content');
      document.querySelectorAll(`span[data-expression="${key}"]`).forEach((node) => {
        node.innerHTML = data[currentLocale];
        node.classList.remove('no_translate');
      });

      app.$destroy();
    });
  }

  window.instantTranslate = (el) => {
    handleTranslation(el);
    return false;
  }

  document.addEventListener('click', (e) => {
    const translationNode = closest(e.target, '.no_translate');
    if (!translationNode) return;
    e.preventDefault();
  })

}

export default {
  init,
}