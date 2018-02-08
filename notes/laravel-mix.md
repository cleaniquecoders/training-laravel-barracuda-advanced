# Laravel Mix

Make sure to install NodeJs and NPM.

```
$ node -v
$ npm -v
```

## Installing Package

Packages available at [NPM](https://www.npmjs.com/).

### Font Awesome 5

```
$ npm i @fortawesome/fontawesome @fortawesome/fontawesome-free-solid @fortawesome/fontawesome-free-regular @fortawesome/fontawesome-free-brands --save-dev
```

Create `resources/assets/js/font-awesome.js` and in `resources/assets/js/font-awesome.js` add the following:

```js
let fontawesome = require('@fortawesome/fontawesome');
let solid       = require('@fortawesome/fontawesome-free-solid').default;
let regular     = require('@fortawesome/fontawesome-free-regular');
let brands      = require('@fortawesome/fontawesome-free-brands');

fontawesome.library.add(solid);
fontawesome.library.add(regular);
fontawesome.library.add(brands);
```

Next, in `webpack.mix.js`, add the following:

```js
mix.js('resources/assets/js/app.js', 'public/js')
	.js('resources/assets/js/font-awesome.js', 'public/js')
   	.sass('resources/assets/sass/app.scss', 'public/css');
```

**Versioning and Cache Busting**

Allow versioning and cache busting.

```js
mix.version();
```

In terminal run `npm run production`.

## References

1. [Collect.js](https://www.siterocket.com/blog/2017/08/10/laravel-routes-in-your-javascript-files/)