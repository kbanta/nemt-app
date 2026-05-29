import './bootstrap'
import Alpine from 'alpinejs'

window.Alpine = Alpine
Alpine.start()

if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js')
        .then(() => console.log('SW registered'))
        .catch(err => console.log('SW error:', err))
}