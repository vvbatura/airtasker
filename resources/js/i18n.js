import Vue from 'vue'
import VueI18n from 'vue-i18n'
import en from './lang/en'
import de from './lang/de'

Vue.use(VueI18n);

const i18n = new VueI18n({
    locale: 'en',
    fallbackLocale: 'de',
    messages: {en, de}
});

export default i18n
