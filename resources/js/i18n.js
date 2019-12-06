import Vue from 'vue'
import VueI18n from 'vue-i18n'
import ru from './lang/ru'
import uk from './lang/uk'
import en from './lang/en'

Vue.use(VueI18n);

const i18n = new VueI18n({
    locale: 'en',
    fallbackLocale: 'ru',
    messages: {uk, ru, en}
});

export default i18n
