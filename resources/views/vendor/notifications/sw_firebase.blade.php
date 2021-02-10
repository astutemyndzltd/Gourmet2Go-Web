importScripts('https://www.gstatic.com/firebasejs/8.2.5/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.2.5/firebase-messaging.js');

@include('vendor.notifications.init_firebase')

const messaging = firebase.messaging();
let channelPort2;

console.log('welcome to the jungle');

self.addEventListener('install', event => {
    // Activate worker immediately
    event.waitUntil(self.skipWaiting()); 
});

self.addEventListener('activate', event => {
    // Become available to all pages
    event.waitUntil(self.clients.claim()); 
});

self.addEventListener('message', event => {
  if (event.data && event.data.type === 'INIT_PORT') {
    channelPort2 = event.ports[0];
    channelPort2.postMessage({});
  } 
});


messaging.onBackgroundMessage((payload) => {

    console.log('[firebase-messaging-sw.js] Received background message ', payload);

    // Customize notification here
    const notificationTitle = payload.data.title;
    const notificationOptions = {
      body: payload.data.body,
      icon: payload.data.icon,
    };

    channelPort2.postMessage({});

    console.log('port -> ', channelPort2);

    self.registration.showNotification(notificationTitle,notificationOptions);

});


// {{env('APP_NAME')}}
