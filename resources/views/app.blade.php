<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="{{ asset('favicon.png') }}">
  <meta name="theme-color" content="#ffffff">


  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ env('APP_NAME') }}</title>


  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
  <link rel="icon" type="image/png" sizes="196x196" href="{{ asset('favicon.png') }}">

  <!-- Web Application Manifest -->
  <link rel="manifest" href="/manifest.json">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">


  <meta name="apple-mobile-web-app-capable" content="yes">

  <link href="{{ asset('css/lineicons/font-css/LineIcons.css') }}?={{ env('ASSET_V', 1) }}" rel="stylesheet">
  <link href="{{ mix('css/app.css') }}?v={{ env('ASSET_V', 1) }}" rel="stylesheet">
  <link href="{{ mix('css/main.css') }}?={{ env('ASSET_V', 1) }}" rel="stylesheet">

</head>

<body>
  <div class="app-view">
    <div id="app">
      <app></app>
    </div>

  </div>


  <!-- <div class="app-bg"></div> -->

  <script type="text/javascript">
    // Initialize the service worker
    if ('serviceWorker' in navigator) {
      // Versioned SW URL so clients pull updates when ASSET_V changes.
      navigator.serviceWorker.register('/serviceworker.js?v={{ env('
        ASSET_V ', 1) }}', {
          scope: '.'
        }).then(function(registration) {
        // Registration was successful
        console.log('Laravel PWA: ServiceWorker registration successful with scope: ', registration.scope);
      }, function(err) {
        // registration failed :(
        console.log('Laravel PWA: ServiceWorker registration failed: ', err);
      });
    }
  </script>

  <script>
    let installPromptEvent;
    window.addEventListener('beforeinstallprompt', (event) => {
      // Prevent Chrome <= 67 from automatically showing the prompt
      //event.preventDefault();
      // Stash the event so it can be triggered later.
      installPromptEvent = event;
    });
  </script>


  <script defer src="{{ mix('js/app.js') }}?v={{ env('ASSET_V', 2) }}"></script>



  <!--Start of Tawk.to Script-->
  <script type="text/javascript">
    var Tawk_API = Tawk_API || {},
      Tawk_LoadStart = new Date();
    (function() {
      var s1 = document.createElement("script"),
        s0 = document.getElementsByTagName("script")[0];
      s1.async = true;
      s1.src = 'https://embed.tawk.to/68f11e5ef76abd195137795c/1j7mtt89t';
      s1.charset = 'UTF-8';
      s1.setAttribute('crossorigin', '*');
      s0.parentNode.insertBefore(s1, s0);
    })();
  </script>
  <!--End of Tawk.to Script-->
  <script>
    setInterval(findTawkAndRemove, 0);

    function findTawkAndRemove() {
      let parentElement = document.querySelector("iframe[title*=chat]:nth-child(2)");
      if (parentElement) {
        let element = parentElement.contentDocument.querySelector(`a[class*=tawk-branding]`);
        if (element) {
          element.remove();
        }
        let element2 = parentElement.contentDocument.querySelector(`div[class*=tawk-toolbar-menu]`);
        if (element2) {
          element2.remove();
        }
        let element3 = parentElement.contentDocument.querySelector(`div[class*=tawk-text-center]`);
        if (element3) {
          element3.remove();
        }
        let element4 = parentElement.contentDocument.querySelector(`div[class*=tawk-recents-message-section]`);
        if (element4) {
          element4.remove();
        }
      }
    }
  </script>
</body>

</html>