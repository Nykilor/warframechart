"use strict";
let cacheId = "app-v4";
self.addEventListener("install", function(event) {
  event.waitUntil(caches.open(cacheId).then((cache) => {
      return cache.addAll([
        "/",
        "img/axi.png",
        "img/meso.png",
        "img/neo.png",
        "img/lith.png",
        "img/bg-custom.png",
        "css/app-3.1.css",
        "js/Bundle.js"
      ]).then(() => self.skipWaiting());
  }));
});

self.addEventListener("fetch", function(event) {
  event.respondWith(
    // Open the cache created when install
    caches.open(cacheId).then(function(cache) {
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
      });
    })
  );
});
