self.addEventListener("install", e => {
  e.waitUntil(
    caches.open("prosty-cache").then(cache => {
      return cache.addAll(["/", "/index.html", "/checklist.js"]);
    })
  );
});
self.addEventListener("fetch", e => {
  e.respondWith(
    caches.match(e.request).then(response => response || fetch(e.request))
  );
});