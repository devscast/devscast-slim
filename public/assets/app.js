/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/assets/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./resources/js/index.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/UploadViewer.js":
/*!**************************************!*\
  !*** ./resources/js/UploadViewer.js ***!
  \**************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return UploadViewer; });
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

/*
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * show a preview before the upload
 */
var UploadViewer =
/*#__PURE__*/
function () {
  /**
   * constructor
   * @param elems
   */
  function UploadViewer() {
    var elems = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];

    _classCallCheck(this, UploadViewer);

    this.elem = elems;
    this.IMAGE_MINETYPES = ['images/jpg', 'images/jpeg', 'images/png', 'images/gif'];
    this.AUDIO_MINETYPES = ['audio/mp3', 'audio/mwa', 'audio/ogg'];
  }

  _createClass(UploadViewer, [{
    key: "run",
    value: function run() {
      this.elems.forEach(function (elem) {
        elem.addEventerListener('change', function (e) {
          e.preventDefault();
          window.alert(e.target);
        });
      });
    }
  }]);

  return UploadViewer;
}();



/***/ }),

/***/ "./resources/js/bootstrap.js":
/*!***********************************!*\
  !*** ./resources/js/bootstrap.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

/*
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
$('document').ready(function () {
  Array.from(document.querySelectorAll('video, audio')).forEach(function (node) {
    if (!node.hasAttribute('data-devscast-initialized')) {
      node.setAttribute('data-devscast-initialized', 'true');
      $(node).mediaelementplayer({
        audioWidth: '100%'
      });
    }
  });
  var menu = document.querySelector('.btn-hamburguer-menu');

  if (menu) {
    menu.addEventListener('click', function (e) {
      e.preventDefault();
      $('.navigation').find('.menu').slideToggle();
      this.classList.toggle('active');

      if ($(window).width() <= 991) {
        $('.navigation').find('.dropdown').on('click', function () {
          $(this).find('.droplist').slideToggle();
        });
      }
    });
  }

  Array.from(document.querySelectorAll('.gallery-zoom')).forEach(function (node) {
    if (!node.hasAttribute('data-devscast-initialized')) {
      node.setAttribute('data-devscast-initialized', 'true');
      var settings = {
        type: 'image',
        gallery: {
          enabled: true
        },
        image: {
          titleSrc: 'title'
        },
        zoom: {
          enabled: true,
          duration: 300,
          easing: 'ease-in-out',
          opener: function opener(openerElement) {
            return openerElement.is('img') ? openerElement : openerElement.find('img');
          }
        }
      };
      $(node).magnificPopup(settings);
    }
  });

  if ($('.header.sticky').length) {
    var stickyOffset = $('.header.sticky').attr('data-offset');

    if (_typeof(stickyOffset) !== ( true ? "undefined" : undefined) && stickyOffset !== false) {
      stickyOffset = parseInt(stickyOffset);
    } else {
      stickyOffset = 60;
    }

    $(window).on('scroll', function () {
      var top = $('.header.sticky').offset().top;

      if (top >= stickyOffset) {
        $('.header.sticky').addClass('scrolling');
      } else {
        $('.header.sticky').removeClass('scrolling');
      }
    });
    $(window).trigger('scroll');
  }

  var map = document.querySelector('#map');

  if (map) {
    map.addEventListener('click', function (e) {
      e.preventDefault();

      if (!this.hasAttribute('data-devscast-initialized')) {
        this.setAttribute('data-devscast-initialized', 'true');
        this.classList.add('touch');
      }
    });
  }
});

/***/ }),

/***/ "./resources/js/index.js":
/*!*******************************!*\
  !*** ./resources/js/index.js ***!
  \*******************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _sass_main_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../sass/main.scss */ "./resources/sass/main.scss");
/* harmony import */ var _sass_main_scss__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_sass_main_scss__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _bootstrap__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./bootstrap */ "./resources/js/bootstrap.js");
/* harmony import */ var _bootstrap__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_bootstrap__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _UploadViewer__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./UploadViewer */ "./resources/js/UploadViewer.js");
/*
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */



var viewer = new _UploadViewer__WEBPACK_IMPORTED_MODULE_2__["default"]('.js-upload-viewer');
viewer.run();

/***/ }),

/***/ "./resources/sass/main.scss":
/*!**********************************!*\
  !*** ./resources/sass/main.scss ***!
  \**********************************/
/*! no static exports found */
/***/ (function(module, exports) {

throw new Error("Module build failed (from ./node_modules/css-loader/dist/cjs.js):\nModuleBuildError: Module build failed (from ./node_modules/sass-loader/lib/loader.js):\nError: Node Sass does not yet support your current environment: Linux 64-bit with Unsupported runtime (72)\nFor more information on which environments are supported please see:\nhttps://github.com/sass/node-sass/releases/tag/v4.11.0\n    at module.exports (/home/bernard-ng/dev/projects/devcast-backend/node_modules/node-sass/lib/binding.js:13:13)\n    at Object.<anonymous> (/home/bernard-ng/dev/projects/devcast-backend/node_modules/node-sass/lib/index.js:14:35)\n    at Module._compile (/home/bernard-ng/dev/projects/devcast-backend/node_modules/v8-compile-cache/v8-compile-cache.js:178:30)\n    at Object.Module._extensions..js (internal/modules/cjs/loader.js:787:10)\n    at Module.load (internal/modules/cjs/loader.js:643:32)\n    at Function.Module._load (internal/modules/cjs/loader.js:556:12)\n    at Module.require (internal/modules/cjs/loader.js:683:19)\n    at require (/home/bernard-ng/dev/projects/devcast-backend/node_modules/v8-compile-cache/v8-compile-cache.js:159:20)\n    at Object.sassLoader (/home/bernard-ng/dev/projects/devcast-backend/node_modules/sass-loader/lib/loader.js:46:72)\n    at /home/bernard-ng/dev/projects/devcast-backend/node_modules/webpack/lib/NormalModule.js:301:20\n    at /home/bernard-ng/dev/projects/devcast-backend/node_modules/loader-runner/lib/LoaderRunner.js:367:11\n    at /home/bernard-ng/dev/projects/devcast-backend/node_modules/loader-runner/lib/LoaderRunner.js:233:18\n    at runSyncOrAsync (/home/bernard-ng/dev/projects/devcast-backend/node_modules/loader-runner/lib/LoaderRunner.js:143:3)\n    at iterateNormalLoaders (/home/bernard-ng/dev/projects/devcast-backend/node_modules/loader-runner/lib/LoaderRunner.js:232:2)\n    at /home/bernard-ng/dev/projects/devcast-backend/node_modules/loader-runner/lib/LoaderRunner.js:205:4\n    at /home/bernard-ng/dev/projects/devcast-backend/node_modules/enhanced-resolve/lib/CachedInputFileSystem.js:73:15\n    at processTicksAndRejections (internal/process/task_queues.js:75:11)");

/***/ })

/******/ });
//# sourceMappingURL=app.js.map