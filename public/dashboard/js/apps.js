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
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/apps.js":
/*!******************************!*\
  !*** ./resources/js/apps.js ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports) {

/*
 Template Name: Foxia - Responsive Bootstrap 4 Admin Dashboard
 Author: Themesbrand
 File: Main js
 */
!function ($) {
  "use strict";

  var MainApp = function MainApp() {};

  MainApp.prototype.initNavbar = function () {
    $('.navbar-toggle').on('click', function (event) {
      $(this).toggleClass('open');
      $('#navigation').slideToggle(400);
    });
    $('.navigation-menu>li').slice(-1).addClass('last-elements');
    $('.navigation-menu li.has-submenu a[href="#"]').on('click', function (e) {
      if ($(window).width() < 992) {
        e.preventDefault();
        $(this).parent('li').toggleClass('open').find('.submenu:first').toggleClass('open');
      }
    });
  }, MainApp.prototype.initLoader = function () {
    $(window).on('load', function () {
      $('#status').fadeOut();
      $('#preloader').delay(350).fadeOut('slow');
      $('body').delay(350).css({
        'overflow': 'visible'
      });
    });
  }, MainApp.prototype.initScrollbar = function () {
    $('.slimscroll-noti').slimScroll({
      height: '208px',
      position: 'right',
      size: "5px",
      color: '#98a6ad',
      wheelStep: 10
    });
  }; // === fo,llowing js will activate the menu in left side bar based on url ====

  MainApp.prototype.initMenuItem = function () {
    $(".navigation-menu a").each(function () {
      var pageUrl = window.location.href.split(/[?#]/)[0];

      if (this.href == pageUrl) {
        $(this).parent().addClass("active"); // add active to li of the current link

        $(this).parent().parent().parent().addClass("active"); // add active class to an anchor

        $(this).parent().parent().parent().parent().parent().addClass("active"); // add active class to an anchor
      }
    });
  }, MainApp.prototype.initComponents = function () {
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();
  }, MainApp.prototype.initToggleSearch = function () {
    $('.toggle-search').on('click', function () {
      var targetId = $(this).data('target');
      var $searchBar;

      if (targetId) {
        $searchBar = $(targetId);
        $searchBar.toggleClass('open');
      }
    });
  }, MainApp.prototype.init = function () {
    this.initNavbar();
    this.initLoader();
    this.initScrollbar();
    this.initMenuItem();
    this.initComponents();
    this.initToggleSearch();
  }, //init
  $.MainApp = new MainApp(), $.MainApp.Constructor = MainApp;
}(window.jQuery), //initializing
function ($) {
  "use strict";

  $.MainApp.init();
}(window.jQuery);

/***/ }),

/***/ "./resources/sass/themes/style.scss":
/*!******************************************!*\
  !*** ./resources/sass/themes/style.scss ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!***********************************************************************!*\
  !*** multi ./resources/js/apps.js ./resources/sass/themes/style.scss ***!
  \***********************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /Users/cocoa/__thunderlab/THUNDER-SALES/resources/js/apps.js */"./resources/js/apps.js");
module.exports = __webpack_require__(/*! /Users/cocoa/__thunderlab/THUNDER-SALES/resources/sass/themes/style.scss */"./resources/sass/themes/style.scss");


/***/ })

/******/ });