 // Give the service worker access to Firebase Messaging.
 // Note that you can only use Firebase Messaging here. Other Firebase libraries
 // are not available in the service worker.
 importScripts('https://www.gstatic.com/firebasejs/8.2.1/firebase-app.js');
 importScripts('https://www.gstatic.com/firebasejs/8.2.1/firebase-messaging.js');
 // Initialize the Firebase app in the service worker by passing in
 // your app's Firebase config object.
 // https://firebase.google.com/docs/web/setup#config-object
 firebase.initializeApp({
   apiKey: "AIzaSyDNEdS-eaiJrO17RLiI6yNV_1pHuKQMopk",
    authDomain: "salespro-316de.firebaseapp.com",
    projectId: "salespro-316de",
    storageBucket: "salespro-316de.appspot.com",
    messagingSenderId: "929630076899",
    appId: "1:929630076899:web:009a17c42978834f322ad6",
    measurementId: "G-MRMK98KFJR"
 });
 // Retrieve an instance of Firebase Messaging so that it can handle background
 // messages.
 const messaging = firebase.messaging();

// If you would like to customize notifications that are received in the
// background (Web app is closed or not in browser focus) then you should
// implement this optional method.
// [START on_background_message]
messaging.onBackgroundMessage(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  // Customize notification here
  const notificationTitle = payload.title;
  const notificationOptions = {
    body: payload.body,
    icon: 'https://vernon.id/assets/images/favicon.png',
    sound: 'https://sgp1.digitaloceanspaces.com/basilhotel/kontena/audios/PanicButton.mp3'
  };

  self.registration.showNotification(notificationTitle,
    notificationOptions);
});
// [END on_background_message]