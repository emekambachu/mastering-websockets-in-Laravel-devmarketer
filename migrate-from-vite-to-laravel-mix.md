**Migrating from Vite to Laravel Mix**
Install Laravel Mix

First, you will need to install Laravel Mix using your npm package manager of choice:

npm install --save-dev laravel-mix

Configure Mix

Create a webpack.mix.js file in the root of your project:

const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);

Update NPM scripts

Update your NPM scripts in package.json:

  "scripts": {
-     "dev": "vite",
-     "build": "vite build"
+     "dev": "npm run development",
+     "development": "mix",
+     "watch": "mix watch",
+     "watch-poll": "mix watch -- --watch-options-poll=1000",
+     "hot": "mix watch --hot",
+     "prod": "npm run production",
+     "production": "mix --production"
  }

Inertia

Vite requires a helper function to import page components which is not required with Laravel Mix. You can remove this as follows:

- import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

  createInertiaApp({
      title: (title) => `${title} - ${appName}`,
-     resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
+     resolve: (name) => require(`./Pages/${name}.vue`),
      setup({ el, app, props, plugin }) {
          return createApp({ render: () => h(app, props) })
              .use(plugin)
              .mixin({ methods: { route } })
              .mount(el);
      },
  });

Update environment variables

You will need to update the environment variables that are explicitly exposed in your .env files and in hosting environments such as Forge to use the MIX_ prefix instead of VITE_:

- VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
- VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
+ MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
+ MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

You will also need to update these references in your JavaScript code to use the new variable name and Node syntax:

-    key: import.meta.env.VITE_PUSHER_APP_KEY,
-    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
+    key: process.env.MIX_PUSHER_APP_KEY,
+    cluster: process.env.MIX_PUSHER_APP_CLUSTER,

Remove CSS imports from your JavaScript entry point(s)

If you are importing your CSS via JavaScript, you will need to remove these statements:

- import '../css/app.css';

Replace @vite with mix()

You will need to replace the @vite Blade directive with <script> and <link rel="stylesheet"> tags and the mix() helper:

- @viteReactRefresh
- @vite('resources/js/app.js')
+ <link rel="stylesheet" href="{{ mix('css/app.css') }}">
+ <script src="{{ mix('js/app.js') }}" defer></script>

Remove Vite and the Laravel Plugin

Vite and the Laravel Plugin can now be uninstalled:

npm remove vite laravel-vite-plugin

Next, you may remove your Vite configuration file:

rm vite.config.js

You may also wish to remove any .gitignore paths you are no longer using:

- /bootstrap/ssr
- /public/build
