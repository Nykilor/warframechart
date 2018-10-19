"use strict";
var cache_id = "app-v3-1";
self.addEventListener('install', function (event) {
  event.waitUntil(caches.open(cache_id).then((cache) => {
      return cache.addAll([
        "/",
        "img/axi.png",
        "img/meso.png",
        "img/neo.png",
        "img/lith.png",
        "img/bg-custom.png",
        "css/app-3.css",
        "js/jquery-3.2.1.min.js",
        "js/app-3.js"
      ]).then(() => self.skipWaiting());
    }))
});

self.addEventListener('fetch', function (event) {
  event.respondWith(
    // Open the cache created when install
    caches.open(cache_id).then(function(cache) {
      // Go to the network to ask for that resource
      return fetch(event.request).then(function(networkResponse) {
        // Add a copy of the response to the cache (updating the old version)
        cache.put(event.request, networkResponse.clone());
        // Respond with it
        return networkResponse;
      }).catch(function() {
        // If there is no internet connection, try to match the request
        // to some of our cached resources
        return cache.match(event.request);
      })
    })
  );
});
