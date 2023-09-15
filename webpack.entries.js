const path = require('path');

module.exports = {
    'app': path.resolve(__dirname, './app/assets/main.js'),
    'page.register': path.resolve(__dirname, './app/assets/register'),
    'page.sign-in': path.resolve(__dirname, './app/assets/sign-in'),
    'page.forgot-password': path.resolve(__dirname, './app/assets/forgot-password'),
    'page.resend-verification': path.resolve(__dirname, './app/assets/resend-verification'),
    'page.set-or-reset-password': path.resolve(__dirname, './app/assets/set-or-reset-password'),
    'page.account-settings': path.resolve(__dirname, './app/assets/account-settings'),
}