let CACHE_NAME = "my-site-cache-v1";
let urlsToCache = [
	"/",
	"/login/",
	"/register",
	"/change/password/",
	"/post/add/",
	"/browserconfig.xml",
	"/manifest.json",
	"/contacts/",
	"/public/css/api.css",
	"/public/css/api.min.css",
	"/public/css/config.css",
	"/public/css/config.min.css",
	"/public/css/dark.css",
	"/public/css/dark.min.css",
	"/public/css/framework.css",
	"/public/css/framework.min.css",
	"/public/css/index.css",
	"/public/css/index.min.css",
	"/public/css/main.css",
	"/public/css/main.min.css",
	"/public/css/others.css",
	"/public/css/others.min.css",
	"/public/css/posts.css",
	"/public/css/posts.min.css",
	"/public/scripts/categories.js",
	"/public/scripts/categories.min.js",
	"/public/scripts/main.js",
	"/public/scripts/main.min.js",
	"/public/scripts/primary.js",
	"/public/scripts/primary.min.js",
	"/public/scripts/tiny_mce/languages/uk.js",
	"/public/scripts/tiny_mce/languages/es_MX.js",
];

self.addEventListener( "install", function ( event ) {
	// Perform install steps
	event.waitUntil(
		caches.open( CACHE_NAME )
			.then( function ( cache ) {
				console.log( "Opened cache" );
				return cache.addAll( urlsToCache );
			} ),
	);
} );

self.addEventListener( "fetch", function ( event ) {
	event.respondWith(
		caches.match( event.request )
			.then( function ( response ) {
				// Cache hit - return response
				if ( response ) {
					return response;
				}

				return fetch( event.request ).then(
					function ( response ) {
						// Check if we received a valid response
						if ( ! response || response.status !== 200 || response.type !== "basic" ) {
							return response;
						}

						// IMPORTANT: Clone the response. A response is a stream
						// and because we want the browser to consume the response
						// as well as the cache consuming the response, we need
						// to clone it so we have two streams.
						let responseToCache = response.clone();

						caches.open( CACHE_NAME )
							.then( function ( cache ) {
								cache.put( event.request, responseToCache );
							} );

						return response;
					},
				);
			} ),
	);
} );