importScripts('//www.gstatic.com/firebasejs/7.2.0/firebase-app.js');
importScripts('//www.gstatic.com/firebasejs/7.2.0/firebase-messaging.js');

@include('vendor.notifications.init_firebase')

const messaging = firebase.messaging();
let channelPort2;

self.addEventListener("message", event => {
  if (event.data && event.data.type === 'INIT_PORT') {
    channelPort2 = event.ports[0];
  } 
});


messaging.setBackgroundMessageHandler(function(payload) {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
    // Customize notification here
    const notificationTitle = payload.data.title;
    const notificationOptions = {
    body: payload.data.body,
    icon: payload.data.icon,
};

channelPort2.postMessage({});

return self.registration.showNotification(notificationTitle,notificationOptions);

});
// {{env('APP_NAME')}}
