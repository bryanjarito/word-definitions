import App from './vue/app'
import WordResults from './vue/components/word-results'
import PreviousResults from './vue/components/previous-results'


export const routes = [
    { path: '/',component: App },
    { path: '/previous-results', component: PreviousResults },
    { path: '/word-results/:id', component: WordResults },
]