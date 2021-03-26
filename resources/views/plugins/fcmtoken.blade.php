
<!-- Manifest -->
<link rel="manifest" href="{{ asset('manifest.json') }}">
<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.2.1/firebase-app.js"></script>
<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<script src="https://www.gstatic.com/firebasejs/8.2.1/firebase-messaging.js"></script>

<script>
    // Your web app's Firebase configuration
    // For Firebase JS SDK v7.20.0 and later, measurementId is optional
    var firebaseConfig = {
        apiKey: "AIzaSyDNEdS-eaiJrO17RLiI6yNV_1pHuKQMopk",
        authDomain: "salespro-316de.firebaseapp.com",
        projectId: "salespro-316de",
        storageBucket: "salespro-316de.appspot.com",
        messagingSenderId: "929630076899",
        appId: "1:929630076899:web:009a17c42978834f322ad6",
        measurementId: "G-MRMK98KFJR"
    };    
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);

    // Retrieve Firebase Messaging object.
    const messaging = firebase.messaging();
    messaging.requestPermission().then(function() {
      console.log('Notification permission granted.');
      // TODO(developer): Retrieve an Instance ID token for use with FCM.
      // ...
    }).catch(function(err) {
      console.log('Unable to get permission to notify.', err);
    });

    // Get Instance ID token. Initially this makes a network call, once retrieved
    // subsequent calls to getToken will return from cache.
    messaging.getToken().then(function(currentToken) {
      if (currentToken) {
        console.log('We found your fcm token');
        updateUIForFCMToken(currentToken);
      } else {
        // Show permission request.
        console.log('No Instance ID token available. Request permission to generate one.');
      }
    }).catch(function(err) {
      console.log('An error occurred while retrieving token. ', err);
    });

    function updateUIForFCMToken(token) {
      $('#fcmtoken').val(token);
    }

    function playAudio(){
      //here goes code
    }

    messaging.onMessage((payload) => {
      playAudio();
      alertify.error(payload.notification.title, 5);
    });
</script>