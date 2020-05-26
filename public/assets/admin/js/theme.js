"use strict";

var _this = this;

function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

/*-----------------------------------------------
|   Theme Configuration
-----------------------------------------------*/
var storage = {
  isDark: true
};
/*-----------------------------------------------
|   Utilities
-----------------------------------------------*/

var utils = function ($) {
  var grays = function grays() {
    var colors = {
      white: '#fff',
      100: '#f9fafd',
      200: '#edf2f9',
      300: '#d8e2ef',
      400: '#b6c1d2',
      500: '#9da9bb',
      600: '#748194',
      700: '#5e6e82',
      800: '#4d5969',
      900: '#344050',
      1000: '#232e3c',
      1100: '#0b1727',
      black: '#000'
    };

    if (storage.isDark) {
      colors = {
        white: '#0e1c2f',
        100: '#132238',
        200: '#061325',
        300: '#344050',
        400: '#4d5969',
        500: '#5e6e82',
        600: '#748194',
        700: '#9da9bb',
        800: '#b6c1d2',
        900: '#d8e2ef',
        1000: '#edf2f9',
        1100: '#f9fafd',
        black: '#fff'
      };
    }

    return colors;
  };

  var themeColors = function themeColors() {
    var colors = {
      primary: '#2c7be5',
      secondary: '#748194',
      success: '#00d27a',
      info: '#27bcfd',
      warning: '#f5803e',
      danger: '#e63757',
      light: '#f9fafd',
      dark: '#0b1727'
    };

    if (storage.isDark) {
      colors.light = grays()['100'];
      colors.dark = grays()['1100'];
    }

    return colors;
  };

  var pluginSettings = function pluginSettings() {
    var settings = {
      tinymce: {
        theme: 'oxide'
      },
      chart: {
        borderColor: 'rgba(255, 255, 255, 0.8)'
      }
    };

    if (storage.isDark) {
      settings.tinymce.theme = 'oxide-dark';
      settings.chart.borderColor = themeColors().primary;
    }

    return settings;
  };

  var Utils = {
    $window: $(window),
    $document: $(document),
    $html: $('html'),
    $body: $('body'),
    $main: $('main'),
    isRTL: function isRTL() {
      return this.$html.attr('dir') === 'rtl';
    },
    location: window.location,
    nua: navigator.userAgent,
    breakpoints: {
      xs: 0,
      sm: 576,
      md: 768,
      lg: 992,
      xl: 1200,
      xxl: 1400
    },
    colors: themeColors(),
    grays: grays(),
    offset: function offset(element) {
      var rect = element.getBoundingClientRect();
      var scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;
      var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
      return {
        top: rect.top + scrollTop,
        left: rect.left + scrollLeft
      };
    },
    isScrolledIntoViewJS: function isScrolledIntoViewJS(element) {
      var windowHeight = window.innerHeight;
      var elemTop = this.offset(element).top;
      var elemHeight = element.offsetHeight;
      var windowScrollTop = window.scrollY;
      return elemTop <= windowScrollTop + windowHeight && windowScrollTop <= elemTop + elemHeight;
    },
    isScrolledIntoView: function isScrolledIntoView(el) {
      var $el = $(el);
      var windowHeight = this.$window.height();
      var elemTop = $el.offset().top;
      var elemHeight = $el.height();
      var windowScrollTop = this.$window.scrollTop();
      return elemTop <= windowScrollTop + windowHeight && windowScrollTop <= elemTop + elemHeight;
    },
    getCurrentScreanBreakpoint: function getCurrentScreanBreakpoint() {
      var _this2 = this;

      var currentScrean = '';
      var windowWidth = this.$window.width();
      $.each(this.breakpoints, function (index, value) {
        if (windowWidth >= value) {
          currentScrean = index;
        } else if (windowWidth >= _this2.breakpoints.xl) {
          currentScrean = 'xl';
        }
      });
      return {
        currentScrean: currentScrean,
        currentBreakpoint: this.breakpoints[currentScrean]
      };
    },
    hexToRgb: function hexToRgb(hexValue) {
      var hex;
      hexValue.indexOf('#') === 0 ? hex = hexValue.substring(1) : hex = hexValue; // Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")

      var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
      var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex.replace(shorthandRegex, function (m, r, g, b) {
        return r + r + g + g + b + b;
      }));
      return result ? [parseInt(result[1], 16), parseInt(result[2], 16), parseInt(result[3], 16)] : null;
    },
    rgbColor: function rgbColor(color) {
      if (color === void 0) {
        color = '#fff';
      }

      return "rgb(" + this.hexToRgb(color) + ")";
    },
    rgbaColor: function rgbaColor(color, alpha) {
      if (color === void 0) {
        color = '#fff';
      }

      if (alpha === void 0) {
        alpha = 0.5;
      }

      return "rgba(" + this.hexToRgb(color) + ", " + alpha + ")";
    },
    rgbColors: function rgbColors() {
      var _this3 = this;

      return Object.keys(this.colors).map(function (color) {
        return _this3.rgbColor(_this3.colors[color]);
      });
    },
    rgbaColors: function rgbaColors() {
      var _this4 = this;

      return Object.keys(this.colors).map(function (color) {
        return _this4.rgbaColor(_this4.colors[color]);
      });
    },
    settings: pluginSettings(_this),
    isIterableArray: function isIterableArray(array) {
      return Array.isArray(array) && !!array.length;
    },
    setCookie: function setCookie(name, value, expire) {
      var expires = new Date();
      expires.setTime(expires.getTime() + expire);
      document.cookie = name + "=" + value + ";expires=" + expires.toUTCString();
    },
    getCookie: function getCookie(name) {
      var keyValue = document.cookie.match("(^|;) ?" + name + "=([^;]*)(;|$)");
      return keyValue ? keyValue[2] : keyValue;
    }
  };
  return Utils;
}(jQuery);
/*-----------------------------------------------
|   Top navigation opacity on scroll
-----------------------------------------------*/


utils.$document.ready(function () {
  var $navbar = $('.navbar-theme');

  if ($navbar.length) {
    var windowHeight = utils.$window.height();
    utils.$window.scroll(function () {
      var scrollTop = utils.$window.scrollTop();
      var alpha = scrollTop / windowHeight * 2;
      alpha >= 1 && (alpha = 1);
      $navbar.css({
        'background-color': "rgba(11, 23, 39, " + alpha + ")"
      });
    }); // Fix navbar background color [after and before expand]

    var classList = $navbar.attr('class').split(' ');
    var breakpoint = classList.filter(function (c) {
      return c.indexOf('navbar-expand-') >= 0;
    })[0].split('navbar-expand-')[1];
    utils.$window.resize(function () {
      if (utils.$window.width() > utils.breakpoints[breakpoint]) {
        return $navbar.removeClass('bg-dark');
      }

      if (!$navbar.find('.navbar-toggler').hasClass('collapsed')) {
        return $navbar.addClass('bg-dark');
      }

      return null;
    }); // Top navigation background toggle on mobile

    $navbar.on('show.bs.collapse hide.bs.collapse', function (e) {
      $(e.currentTarget).toggleClass('bg-dark');
    });
  }
});
/*-----------------------------------------------
|   Select menu [bootstrap 4]
-----------------------------------------------*/

utils.$document.ready(function () {
  // https://getbootstrap.com/docs/4.0/getting-started/browsers-devices/#select-menu
  // https://github.com/twbs/bootstrap/issues/26183
  window.is.android() && $('select.form-control').removeClass('form-control').css('width', '100%');
});
/*-----------------------------------------------
|   Detector
-----------------------------------------------*/

utils.$document.ready(function () {
  if (window.is.opera()) utils.$html.addClass('opera');
  if (window.is.mobile()) utils.$html.addClass('mobile');
  if (window.is.firefox()) utils.$html.addClass('firefox');
  if (window.is.safari()) utils.$html.addClass('safari');
  if (window.is.ios()) utils.$html.addClass('ios');
  if (window.is.iphone()) utils.$html.addClass('iphone');
  if (window.is.ie()) utils.$html.addClass('ie');
  if (window.is.edge()) utils.$html.addClass('edge');
  if (window.is.chrome()) utils.$html.addClass('chrome');
  if (utils.nua.match(/puppeteer/i)) utils.$html.addClass('puppeteer');
  if (window.is.mac()) utils.$html.addClass('osx');
  if (window.is.windows()) utils.$html.addClass('windows');
  if (navigator.userAgent.match('CriOS')) utils.$html.addClass('chrome');
});
/*
  global Stickyfill
*/

/*-----------------------------------------------
|   Sticky fill
-----------------------------------------------*/

utils.$document.ready(function () {
  Stickyfill.add($('.sticky-top'));
  Stickyfill.add($('.sticky-bottom'));
});
/*-----------------------------------------------
|   Sticky Kit
-----------------------------------------------*/

utils.$document.ready(function () {
  var stickyKits = $('.sticky-kit');

  if (stickyKits.length) {
    stickyKits.each(function (index, value) {
      var $this = $(value);

      var options = _objectSpread({}, $this.data('options'));

      $this.stick_in_parent(options);
    });
  }
});
/*-----------------------------------------------
|   Tootltip [bootstrap 4]
-----------------------------------------------*/

utils.$document.ready(function () {
  // https://getbootstrap.com/docs/4.0/components/tooltips/#example-enable-tooltips-everywhere
  $('[data-toggle="tooltip"]').tooltip();
  $('[data-toggle="popover"]').popover();
  $('body').tooltip({
    selector: '[data-toggle=tooltip]'
  });
});
/*-----------------------------------------------
|   Navbar
-----------------------------------------------*/

window.utils.$document.ready(function () {
  var _window = window,
      utils = _window.utils;
  var $window = utils.$window,
      breakpoints = utils.breakpoints;
  var navDropShadowFlag = true;
  var ClassName = {
    SHOW: 'show',
    NAVBAR_GLASS_SHADOW: 'navbar-glass-shadow',
    NAVBAR_VERTICAL_COLLAPSED: 'navbar-vertical-collapsed',
    NAVBAR_VERTICAL_COLLAPSE_HOVER: 'navbar-vertical-collapsed-hover'
  };
  var Selector = {
    HTML: 'html',
    NAVBAR: '.navbar:not(.navbar-vertical)',
    NAVBAR_VERTICAL: '.navbar-vertical',
    NAVBAR_VERTICAL_TOGGLE: '.navbar-vertical-toggle',
    NAVBAR_VERTICAL_COLLAPSE: '#navbarVerticalCollapse',
    NAVBAR_VERTICAL_COLLAPSED: '.navbar-vertical-collapsed',
    NAVBAR_VERTICAL_DROPDOWN_NAV: '.navbar-vertical .navbar-collapse .nav',
    NAVBAR_VERTICAL_COLLAPSED_DROPDOWN_NAV: '.navbar-vertical-collapsed .navbar-vertical .navbar-collapse .nav',
    MAIN_CONTENT: '.main .content',
    NAVBAR_TOP: '.navbar-top',
    OWL_CAROUSEL: '.owl-carousel',
    ECHART_RESPONSIVE: '[data-echart-responsive]'
  };
  var Events = {
    LOAD_SCROLL: 'load scroll',
    SCROLL: 'scroll',
    CLICK: 'click',
    RESIZE: 'resize',
    SHOW_BS_COLLAPSE: 'show.bs.collapse',
    HIDDEN_BS_COLLAPSE: 'hidden.bs.collapse'
  };
  var $html = $(Selector.HTML);
  var $navbar = $(Selector.NAVBAR);
  var $navbarVerticalCollapse = $(Selector.NAVBAR_VERTICAL_COLLAPSE);
  var breakPoint;
  var navbarVerticalClass = $(Selector.NAVBAR_VERTICAL).attr('class');

  if (navbarVerticalClass) {
    breakPoint = breakpoints[navbarVerticalClass.split(' ').filter(function (cls) {
      return cls.indexOf('navbar-expand-') === 0;
    }).pop().split('-').pop()];
  }

  var setDropShadow = function setDropShadow($elem) {
    if ($elem.scrollTop() > 0 && navDropShadowFlag) {
      $navbar.addClass(ClassName.NAVBAR_GLASS_SHADOW);
    } else {
      $navbar.removeClass(ClassName.NAVBAR_GLASS_SHADOW);
    }
  };

  $window.on(Events.LOAD_SCROLL, function () {
    return setDropShadow($window);
  });
  $navbarVerticalCollapse.on(Events.SCROLL, function () {
    navDropShadowFlag = true;
    setDropShadow($navbarVerticalCollapse);
  });
  $navbarVerticalCollapse.on(Events.SHOW_BS_COLLAPSE, function () {
    if ($window.width() < breakPoint) {
      navDropShadowFlag = false;
      setDropShadow($window);
    }
  });
  $navbarVerticalCollapse.on(Events.HIDDEN_BS_COLLAPSE, function () {
    if ($navbarVerticalCollapse.hasClass(ClassName.SHOW) && $window.width() < breakPoint) {
      navDropShadowFlag = false;
    } else {
      navDropShadowFlag = true;
    }

    setDropShadow($window);
  }); // Expand or Collapse vertical navbar on mouse over and out

  $navbarVerticalCollapse.hover(function (e) {
    setTimeout(function () {
      if ($(e.currentTarget).is(':hover')) {
        $(Selector.NAVBAR_VERTICAL_COLLAPSED).addClass(ClassName.NAVBAR_VERTICAL_COLLAPSE_HOVER);
      }
    }, 100);
  }, function () {
    $(Selector.NAVBAR_VERTICAL_COLLAPSED).removeClass(ClassName.NAVBAR_VERTICAL_COLLAPSE_HOVER);
  }); // Set navbar top width from content

  var setNavbarWidth = function setNavbarWidth() {
    var contentWidth = $(Selector.MAIN_CONTENT).width() + 30;
    $(Selector.NAVBAR_TOP).outerWidth(contentWidth);
  }; // Toggle navbar vertical collapse on click


  $(document).on(Events.CLICK, Selector.NAVBAR_VERTICAL_TOGGLE, function () {
    // Set collapse state on localStorage
    var isNavbarVerticalCollapsed = JSON.parse(localStorage.getItem('isNavbarVerticalCollapsed'));
    localStorage.setItem('isNavbarVerticalCollapsed', !isNavbarVerticalCollapsed); // Toggle class

    $html.toggleClass(ClassName.NAVBAR_VERTICAL_COLLAPSED); // Set navbar top width

    setNavbarWidth(); // Refresh owlCarousel

    var $owlCarousel = $(Selector.OWL_CAROUSEL);

    if ($owlCarousel.length) {
      $owlCarousel.owlCarousel('refresh');
    }
  }); // Set navbar top width on window resize
  // $window.on(Events.RESIZE, () => { setNavbarWidth(); })
});
/*-----------------------------------------------
|   Bootstrap Wizard
-----------------------------------------------*/

utils.$document.ready(function () {
  var Selector = {
    DATA_WIZARD: '[data-wizard]',
    PREVIOUS_BUTTON: '.previous .btn',
    TAB_PANE: '.tab-pane',
    FORM_VALIDATION: '.form-validation',
    NAV_ITEM_CIRCLE: '.nav-item-circle',
    NAV_ITEM: '.nav-item',
    NAV_LINK: '.nav-link',
    WIZARD_LOTTIE: '.wizard-lottie'
  };
  var ClassName = {
    ACTIVE: 'active',
    DONE: 'done',
    NAV: 'nav'
  };
  var DATA_KEY = {
    OPTIONS: 'options',
    WIZARD_STATE: 'wizard-state',
    CONTROLLER: 'controller',
    ERROR_MODAL: 'error-modal'
  };
  var wizards = $(Selector.DATA_WIZARD);

  var isFormValidate = function isFormValidate($currentTab) {
    var $currentTabForms = $currentTab.find(Selector.FORM_VALIDATION);
    var isValidate = false;
    $currentTabForms.each(function (i, v) {
      isValidate = $(v).valid();
      return isValidate;
    });
    return isValidate;
  };

  !!wizards.length && wizards.each(function (index, value) {
    var $this = $(value);
    var controller = $this.data(DATA_KEY.CONTROLLER);
    var $controller = $(controller);
    var $buttonPrev = $controller.find(Selector.PREVIOUS_BUTTON);
    var $modal = $($this.data(DATA_KEY.ERROR_MODAL));
    var $lottie = $(value).find(Selector.WIZARD_LOTTIE);
    var options = $.extend({
      container: value.querySelector(Selector.WIZARD_LOTTIE),
      renderer: 'svg',
      loop: true,
      autoplay: false,
      name: 'Hello World'
    }, $lottie.data(DATA_KEY.OPTIONS));
    var animation = window.bodymovin.loadAnimation(options);
    $this.bootstrapWizard({
      tabClass: ClassName.NAV,
      onNext: function onNext(tab, navigation, idx) {
        var $currentTab = $this.find(Selector.TAB_PANE).eq(idx - 1);
        return isFormValidate($currentTab);
      },
      onTabClick: function onTabClick(tab, navigation, idx, clickedIndex) {
        var stepDone = $this.find(".nav-item:nth-child(" + (clickedIndex + 1) + ") .nav-link").data(DATA_KEY.WIZARD_STATE);

        if (stepDone === 'done') {
          $modal.modal('show');
          return false;
        }

        if (clickedIndex <= idx) {
          return true;
        }

        var isValid = true;
        $this.find(Selector.TAB_PANE).each(function (tabIndex, tabValue) {
          if (tabIndex < clickedIndex) {
            $this.bootstrapWizard('show', tabIndex);
            isValid = isFormValidate($(tabValue));
          }

          return isValid;
        });
        return isValid;
      },
      onTabShow: function onTabShow(tab, navigation, idx) {
        var length = navigation.find('li').length - 1;
        idx === 0 ? $buttonPrev.hide() : $buttonPrev.show();
        idx === length && setTimeout(function () {
          return animation.play();
        }, 300);
        $this.find(Selector.NAV_LINK).removeClass(ClassName.DONE);
        $this.find(Selector.NAV_ITEM).each(function (i, v) {
          var link = $(v).find(Selector.NAV_LINK);

          if (idx === length && !link.hasClass(ClassName.ACTIVE)) {
            link.attr('data-wizard-state', 'done');
          }

          if (!link.hasClass(ClassName.ACTIVE)) {
            link.addClass(ClassName.DONE);
            return true;
          }

          if (idx === length) {
            link.addClass(ClassName.DONE);
            $controller.hide();
          }

          return false;
        });
      }
    });
  });
});
/*-----------------------------------------------
|   Bulk Actions
-----------------------------------------------*/

window.utils.$document.ready(function () {
  var checkboxBulkSelects = $('.checkbox-bulk-select');

  if (checkboxBulkSelects.length) {
    var Event = {
      CLICK: 'click'
    };
    var Selector = {
      CHECKBOX_BULK_SELECT_CHECKBOX: '.checkbox-bulk-select-target'
    };
    var ClassName = {
      D_NONE: 'd-none'
    };
    var DATA_KEY = {
      CHECKBOX_BODY: 'checkbox-body',
      CHECKBOX_ACTIONS: 'checkbox-actions',
      CHECKBOX_REPLACED_ELEMENT: 'checkbox-replaced-element'
    };
    var Attribute = {
      CHECKED: 'checked',
      INDETERMINATE: 'indeterminate'
    };
    checkboxBulkSelects.each(function (index, value) {
      var checkboxBulkAction = $(value);
      var bulkActions = $(checkboxBulkAction.data(DATA_KEY.CHECKBOX_ACTIONS));
      var replacedElement = $(checkboxBulkAction.data(DATA_KEY.CHECKBOX_REPLACED_ELEMENT));
      var rowCheckboxes = $(checkboxBulkAction.data(DATA_KEY.CHECKBOX_BODY)).find(Selector.CHECKBOX_BULK_SELECT_CHECKBOX);
      checkboxBulkAction.on(Event.CLICK, function () {
        if (checkboxBulkAction.attr(Attribute.INDETERMINATE) === Attribute.INDETERMINATE) {
          bulkActions.addClass(ClassName.D_NONE);
          replacedElement.removeClass(ClassName.D_NONE);
          checkboxBulkAction.prop(Attribute.INDETERMINATE, false).attr(Attribute.INDETERMINATE, false);
          checkboxBulkAction.prop(Attribute.CHECKED, false).attr(Attribute.CHECKED, false);
          rowCheckboxes.prop(Attribute.CHECKED, false).attr(Attribute.CHECKED, false);
        } else {
          bulkActions.toggleClass(ClassName.D_NONE);
          replacedElement.toggleClass(ClassName.D_NONE);

          if (checkboxBulkAction.attr(Attribute.CHECKED)) {
            checkboxBulkAction.prop(Attribute.CHECKED, false).attr(Attribute.CHECKED, false);
          } else {
            checkboxBulkAction.prop(Attribute.CHECKED, true).attr(Attribute.CHECKED, true);
          }

          rowCheckboxes.each(function (i, v) {
            var $this = $(v);

            if ($this.attr(Attribute.CHECKED)) {
              $this.prop(Attribute.CHECKED, false).attr(Attribute.CHECKED, false);
            } else {
              $this.prop(Attribute.CHECKED, true).attr(Attribute.CHECKED, true);
            }
          });
        }
      });
      rowCheckboxes.on(Event.CLICK, function (e) {
        var $this = $(e.target);

        if ($this.attr(Attribute.CHECKED)) {
          $this.prop(Attribute.CHECKED, false).attr(Attribute.CHECKED, false);
        } else {
          $this.prop(Attribute.CHECKED, true).attr(Attribute.CHECKED, true);
        }

        rowCheckboxes.each(function (i, v) {
          var $elem = $(v);

          if ($elem.attr(Attribute.CHECKED)) {
            checkboxBulkAction.prop(Attribute.INDETERMINATE, true).attr(Attribute.INDETERMINATE, Attribute.INDETERMINATE);
            bulkActions.removeClass(ClassName.D_NONE);
            replacedElement.addClass(ClassName.D_NONE);
            return false;
          }

          if (i === checkboxBulkAction.length) {
            checkboxBulkAction.prop(Attribute.INDETERMINATE, false).attr(Attribute.INDETERMINATE, false);
            checkboxBulkAction.prop(Attribute.CHECKED, false).attr(Attribute.CHECKED, false);
            bulkActions.addClass(ClassName.D_NONE);
            replacedElement.removeClass(ClassName.D_NONE);
          }

          return true;
        });
      });
    });
  }
});
/*-----------------------------------------------
|   Copy link
-----------------------------------------------*/

utils.$document.ready(function () {
  $('#copyLinkModal').on('shown.bs.modal', function () {
    $('.invitation-link').focus().select();
  });
  utils.$document.on('click', '[data-copy]', function (e) {
    var $this = $(e.currentTarget);
    var targetID = $this.data('copy');
    $(targetID).focus().select();
    document.execCommand('copy');
    $this.attr('title', 'Copied!').tooltip('_fixTitle').tooltip('show').attr('title', 'Copy to clipboard').tooltip('_fixTitle');
  });
});
/*-----------------------------------------------
|   Count Up
-----------------------------------------------*/

utils.$document.ready(function () {
  var $counters = $('[data-countup]');

  if ($counters.length) {
    $counters.each(function (index, value) {
      var $counter = $(value);
      var counter = $counter.data('countup');

      var toAlphanumeric = function toAlphanumeric(num) {
        var number = num;
        var abbreviations = {
          k: 1000,
          m: 1000000,
          b: 1000000000,
          t: 1000000000000
        };

        if (num < abbreviations.m) {
          number = (num / abbreviations.k).toFixed(2) + "k";
        } else if (num < abbreviations.b) {
          number = (num / abbreviations.m).toFixed(2) + "m";
        } else if (num < abbreviations.t) {
          number = (num / abbreviations.b).toFixed(2) + "b";
        } else {
          number = (num / abbreviations.t).toFixed(2) + "t";
        }

        return number;
      };

      var toComma = function toComma(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
      };

      var toSpace = function toSpace(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
      };

      var playCountUpTriggered = false;

      var countUP = function countUP() {
        if (utils.isScrolledIntoView(value) && !playCountUpTriggered) {
          if (!playCountUpTriggered) {
            $({
              countNum: 0
            }).animate({
              countNum: counter.count
            }, {
              duration: counter.duration || 1000,
              easing: 'linear',
              step: function step() {
                $counter.text((counter.prefix ? counter.prefix : '') + Math.floor(this.countNum));
              },
              complete: function complete() {
                switch (counter.format) {
                  case 'comma':
                    $counter.text((counter.prefix ? counter.prefix : '') + toComma(this.countNum));
                    break;

                  case 'space':
                    $counter.text((counter.prefix ? counter.prefix : '') + toSpace(this.countNum));
                    break;

                  case 'alphanumeric':
                    $counter.text((counter.prefix ? counter.prefix : '') + toAlphanumeric(this.countNum));
                    break;

                  default:
                    $counter.text((counter.prefix ? counter.prefix : '') + this.countNum);
                }
              }
            });
            playCountUpTriggered = true;
          }
        }

        return playCountUpTriggered;
      };

      countUP();
      utils.$window.scroll(function () {
        countUP();
      });
    });
  }
});
/*-----------------------------------------------
|   Countdown
-----------------------------------------------*/

utils.$document.ready(function () {
  var $dataCountdowns = $('[data-countdown]');
  var DATA_KEY = {
    FALLBACK: 'countdown-fallback',
    COUNTDOWN: 'countdown'
  };

  if ($dataCountdowns.length) {
    $dataCountdowns.each(function (index, value) {
      var $dateCountdown = $(value);
      var date = $dateCountdown.data(DATA_KEY.COUNTDOWN);
      var fallback;

      if (_typeof($dateCountdown.data(DATA_KEY.FALLBACK)) !== _typeof(undefined)) {
        fallback = $dateCountdown.data(DATA_KEY.FALLBACK);
      }

      $dateCountdown.countdown(date, function (event) {
        if (event.elapsed) {
          $dateCountdown.text(fallback);
        } else {
          $dateCountdown.text(event.strftime('%D days %H:%M:%S'));
        }
      });
    });
  }
});
/*-----------------------------------------------
|   Documentation and Component Navigation
-----------------------------------------------*/

utils.$document.ready(function () {
  var $componentNav = $('#components-nav');

  if ($componentNav.length) {
    var loc = window.location.href;

    var _loc$split = loc.split('#');

    loc = _loc$split[0];
    var location = loc.split('/');
    var url = location[location.length - 2] + "/" + location.pop();
    var urls = $componentNav.children('li').children('a');

    for (var i = 0, max = urls.length; i < max; i += 1) {
      var dom = urls[i].href.split('/');
      var domURL = dom[dom.length - 2] + "/" + dom.pop();

      if (domURL === url) {
        var $targetedElement = $(urls[i]);
        $targetedElement.removeClass('text-800');
        $targetedElement.addClass('font-weight-medium');
        break;
      }
    }
  }
});
/*-----------------------------------------------
|   Draggable
-----------------------------------------------*/

utils.$document.ready(function () {
  var Selectors = {
    BODY: 'body',
    KANBAN_ITEMS_CONTAINER: '.kanban-items-container',
    KANBAN_ITEM: '.kanban-item',
    KANBAN_COLLAPSE: "[data-collapse='kanban']",
    PS_RAILS: '.ps__rail-x, .ps__rail-y' // Perfect scrollbar rails in IE

  };
  var Events = {
    DRAG_START: 'drag:start',
    DRAG_STOP: 'drag:stop'
  };
  var columns = document.querySelectorAll(Selectors.KANBAN_ITEMS_CONTAINER);

  if (columns.length) {
    // Initialize Sortable
    var sortable = new window.Draggable.Sortable(columns, {
      draggable: Selectors.KANBAN_ITEM,
      delay: 200,
      mirror: {
        appendTo: Selectors.BODY,
        constrainDimensions: true
      }
    }); // Hide form when drag start

    sortable.on(Events.DRAG_START, function () {
      $(Selectors.KANBAN_COLLAPSE).collapse('hide');
    }); // Place forms and other contents bottom of the sortable container

    sortable.on(Events.DRAG_STOP, function (e) {
      var $this = $(e.data.source);
      var $itemContainer = $this.closest(Selectors.KANBAN_ITEMS_CONTAINER);
      var $collapse = $this.closest(Selectors.KANBAN_ITEMS_CONTAINER).find(Selectors.KANBAN_COLLAPSE);
      $this.is(':last-child') && $itemContainer.append($collapse); // For IE

      if (window.is.ie()) {
        var $rails = $itemContainer.find(Selectors.PS_RAILS);
        $itemContainer.append($rails);
      }
    });
  }
});
/*-----------------------------------------------
|   Dashboard Table dropdown
-----------------------------------------------*/

window.utils.$document.ready(function () {
  // Only for ios
  if (window.is.ios()) {
    var Event = {
      SHOWN_BS_DROPDOWN: 'shown.bs.dropdown',
      HIDDEN_BS_DROPDOWN: 'hidden.bs.dropdown'
    };
    var Selector = {
      TABLE_RESPONSIVE: '.table-responsive',
      DROPDOWN_MENU: '.dropdown-menu'
    };
    $(Selector.TABLE_RESPONSIVE).on(Event.SHOWN_BS_DROPDOWN, function dashboardTableDropdown(e) {
      var t = $(this);
      var m = $(e.target).find(Selector.DROPDOWN_MENU);
      var tb = t.offset().top + t.height();
      var mb = m.offset().top + m.outerHeight(true);
      var d = 20; // Space for shadow + scrollbar.

      if (t[0].scrollWidth > t.innerWidth()) {
        if (mb + d > tb) {
          t.css('padding-bottom', mb + d - tb);
        }
      } else {
        t.css('overflow', 'visible');
      }
    }).on(Event.HIDDEN_BS_DROPDOWN, function (e) {
      var $this = $(e.currentTarget);
      $this.css({
        'padding-bottom': '',
        overflow: ''
      });
    });
  }
}); // Reference
// https://github.com/twbs/bootstrap/issues/11037#issuecomment-274870381

/*-----------------------------------------------
|   Documentation and Component Navigation
-----------------------------------------------*/

utils.$document.ready(function () {
  var Selector = {
    NAVBAR_THEME_DROPDOWN: '.navbar-theme .dropdown',
    DROPDOWN_ON_HOVER: '.dropdown-on-hover',
    DROPDOWN_MENU: '.dropdown-menu',
    DATA_TOGGLE_DROPDOWN: '[data-toggle="dropdown"]',
    BODY: 'body',
    DROPDOWN_MENU_ANCHOR: '.dropdown-menu a'
  };
  var ClassName = {
    DROPDOWN_ON_HOVER: 'dropdown-on-hover',
    SHOW: 'show'
  };
  var Event = {
    CLICK: 'click',
    MOUSE_LEAVE: 'mouseleave',
    MOUSE_EVENT: 'mouseenter mouseleave'
  };
  var Attribute = {
    ARIA_EXPANDED: 'aria-expanded'
  };
  var $navbarDropdown = $(Selector.NAVBAR_THEME_DROPDOWN);

  if (!window.is.mobile()) {
    $navbarDropdown.addClass(ClassName.DROPDOWN_ON_HOVER);
  } else {
    $navbarDropdown.removeClass(ClassName.DROPDOWN_ON_HOVER);
  }

  var toggleDropdown = function toggleDropdown(e) {
    var $el = $(e.target);
    var dropdown = $el.closest(Selector.DROPDOWN_ON_HOVER);
    var dropdownMenu = $(Selector.DROPDOWN_MENU, dropdown);
    setTimeout(function () {
      var shouldOpen = e.type !== Event.CLICK && dropdown.is(':hover');
      dropdownMenu.toggleClass(ClassName.SHOW, shouldOpen);
      dropdown.toggleClass(ClassName.SHOW, shouldOpen);
      $(Selector.DATA_TOGGLE_DROPDOWN, dropdown).attr(Attribute.ARIA_EXPANDED, shouldOpen);
    }, e.type === Event.MOUSE_LEAVE ? 100 : 0);
  };

  $(Selector.BODY).on(Event.MOUSE_EVENT, Selector.DROPDOWN_ON_HOVER, toggleDropdown).on(Event.CLICK, Selector.DROPDOWN_MENU_ANCHOR, toggleDropdown);
});
/*-----------------------------------------------
|   On page scroll for #id targets
-----------------------------------------------*/

utils.$document.ready(function ($) {
  $('a[data-fancyscroll]').click(function scrollTo(e) {
    // const $this = $(e.currentTarget);
    var $this = $(this);

    if (utils.location.pathname === $this[0].pathname && utils.location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && utils.location.hostname === this.hostname) {
      e.preventDefault();
      var target = $(this.hash);
      target = target.length ? target : $("[name=" + this.hash.slice(1) + "]");

      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top - ($this.data('offset') || 0)
        }, 400, 'swing', function () {
          var hash = $this.attr('href');
          window.history.pushState ? window.history.pushState(null, null, hash) : window.location.hash = hash;
        });
        return false;
      }
    }

    return true;
  });
  var hash = window.location.hash;

  if (hash && document.getElementById(hash.slice(1))) {
    var $this = $(hash);
    $('html,body').animate({
      scrollTop: $this.offset().top - $("a[href='" + hash + "']").data('offset')
    }, 400, 'swing', function () {
      window.history.pushState ? window.history.pushState(null, null, hash) : window.location.hash = hash;
    });
  }
});
/*-----------------------------------------------
|   Incrment/Decrement Input Fields
-----------------------------------------------*/

utils.$document.ready(function () {
  var Selector = {
    DATA_FIELD: '[data-field]',
    INPUT_GROUP: '.input-group'
  };
  var DATA_KEY = {
    FIELD: 'field',
    TYPE: 'type'
  };
  var Events = {
    CLICK: 'click'
  };
  var Attributes = {
    MIN: 'min'
  };
  utils.$document.on(Events.CLICK, Selector.DATA_FIELD, function (e) {
    var $this = $(e.target);
    var inputField = $this.data(DATA_KEY.FIELD);
    var $inputField = $this.parents(Selector.INPUT_GROUP).children("." + inputField);
    var $btnType = $this.data(DATA_KEY.TYPE);
    var value = parseInt($inputField.val(), 10);
    var min = $inputField.attr(Attributes.MIN);

    if (min) {
      min = parseInt(min, 10);
    } else {
      min = 0;
    }

    if ($btnType === 'plus') {
      value += 1;
    } else if (value > min) {
      value -= 1;
    }

    $inputField.val(value);
  });
});
/*-----------------------------------------------
|   Lightbox
-----------------------------------------------*/

/*
  global lightbox
*/

utils.$document.ready(function () {
  if ($('[data-lightbox]').length) {
    lightbox.option({
      resizeDuration: 400,
      wrapAround: true,
      fadeDuration: 300,
      imageFadeDuration: 300
    });
  }
});
/*-----------------------------------------------
|   Lottie
-----------------------------------------------*/

window.utils.$document.ready(function () {
  var lotties = $('.lottie');

  if (lotties.length) {
    lotties.each(function (index, value) {
      var $this = $(value);
      var options = $.extend({
        container: value,
        path: '../img/animated-icons/warning-light.json',
        renderer: 'svg',
        loop: true,
        autoplay: true,
        name: 'Hello World'
      }, $this.data('options'));
      window.bodymovin.loadAnimation(options);
    });
  }
});
/*-----------------------------------------------
|   Modal
-----------------------------------------------*/

utils.$document.ready(function () {
  var Selector = {
    MODAL_THEME: '.modal-theme'
  };
  var DataKey = {
    OPTIONS: 'options'
  };
  var Events = {
    HIDDEN_BS_MODAL: 'hidden.bs.modal'
  };
  var modals = $(Selector.MODAL_THEME);
  var showModal = true;

  if (modals.length) {
    modals.each(function (index, value) {
      var $this = $(value);
      var userOptions = $this.data(DataKey.OPTIONS);
      var options = $.extend({
        autoShow: false,
        autoShowDelay: 0,
        showOnce: false
      }, userOptions);

      if (options.showOnce) {
        var modal = utils.getCookie('modal');
        showModal = modal === null;
      }

      if (options.autoShow && showModal) {
        setTimeout(function () {
          $this.modal('show');
        }, options.autoShowDelay);
      }
    });
  }

  $(Selector.MODAL_THEME).on(Events.HIDDEN_BS_MODAL, function (e) {
    var $this = $(e.currentTarget);
    var userOptions = $this.data(DataKey.OPTIONS);
    var options = $.extend({
      cookieExpireTime: 7200000,
      showOnce: false
    }, userOptions);
    options.showOnce && utils.setCookie('modal', false, options.cookieExpireTime);
  });
});
/*-----------------------------------------------
|   Cookie Notice
-----------------------------------------------*/

utils.$document.ready(function () {
  var Selector = {
    NOTICE: '.notice'
  };
  var DataKeys = {
    OPTIONS: 'options'
  };
  var CookieNames = {
    COOKIE_NOTICE: 'cookieNotice'
  };
  var Events = {
    HIDDEN_BS_TOAST: 'hidden.bs.toast'
  };
  var $notices = $(Selector.NOTICE);
  var defaultOptions = {
    autoShow: false,
    autoShowDelay: 0,
    showOnce: false,
    cookieExpireTime: 3600000
  };
  $notices.each(function (index, value) {
    var $this = $(value);
    var options = $.extend(defaultOptions, $this.data(DataKeys.OPTIONS));
    var cookieNotice;

    if (options.showOnce) {
      cookieNotice = utils.getCookie(CookieNames.COOKIE_NOTICE);
    }

    if (options.autoShow && cookieNotice === null) {
      setTimeout(function () {
        return $this.toast('show');
      }, options.autoShowDelay);
    }
  });
  $(Selector.NOTICE).on(Events.HIDDEN_BS_TOAST, function (e) {
    var $this = $(e.currentTarget);
    var options = $.extend(defaultOptions, $this.data(DataKeys.OPTIONS));
    options.showOnce && utils.setCookie(CookieNames.COOKIE_NOTICE, false, options.cookieExpireTime);
  });
  utils.$document.on('click', "[data-toggle='notice']", function (e) {
    e.preventDefault();
    var $this = $(e.currentTarget);
    var $target = $($this.attr('href'));

    if ($target.hasClass('show')) {
      $target.toast('hide');
    } else {
      $target.toast('show');
    }
  });
});
/*-----------------------------------------------
|   Owl Carousel
-----------------------------------------------*/

var $carousel = $('.owl-carousel');
utils.$document.ready(function () {
  if ($carousel.length) {
    var Selector = {
      ALL_TIMELINE: '*[data-zanim-timeline]',
      ACTIVE_ITEM: '.owl-item.active'
    };
    var owlZanim = {
      zanimTimeline: function zanimTimeline($el) {
        return $el.find(Selector.ALL_TIMELINE);
      },
      play: function play($el) {
        if (this.zanimTimeline($el).length === 0) return;
        $el.find(Selector.ACTIVE_ITEM + " > " + Selector.ALL_TIMELINE).zanimation(function (animation) {
          animation.play();
        });
      },
      kill: function kill($el) {
        if (this.zanimTimeline($el).length === 0) return;
        this.zanimTimeline($el).zanimation(function (animation) {
          animation.kill();
        });
      }
    };
    $carousel.each(function (index, value) {
      var $this = $(value);
      var options = $this.data('options') || {};
      utils.isRTL() && (options.rtl = true);
      options.navText || (options.navText = ['<span class="fas fa-angle-left"></span>', '<span class="fas fa-angle-right"></span>']);
      options.touchDrag = true;
      $this.owlCarousel($.extend(options || {}, {
        onInitialized: function onInitialized(event) {
          owlZanim.play($(event.target));
        },
        onTranslate: function onTranslate(event) {
          owlZanim.kill($(event.target));
        },
        onTranslated: function onTranslated(event) {
          owlZanim.play($(event.target));
        }
      }));
    });
  }

  var $controllers = $('[data-owl-carousel-controller]');

  if ($controllers.length) {
    $controllers.each(function (index, value) {
      var $this = $(value);
      var $thumbs = $($this.data('owl-carousel-controller'));
      $thumbs.find('.owl-item:first-child').addClass('current');
      $thumbs.on('click', '.item', function (e) {
        var thumbIndex = $(e.target).parents('.owl-item').index();
        $('.owl-item').removeClass('current');
        $(e.target).parents('.owl-item').addClass('current');
        $this.trigger('to.owl.carousel', thumbIndex, 500);
      });
      $this.on('changed.owl.carousel', function (e) {
        var itemIndex = e.item.index;
        var item = itemIndex + 1;
        $('.owl-item').removeClass('current');
        $thumbs.find(".owl-item:nth-child(" + item + ")").addClass('current');
        $thumbs.trigger('to.owl.carousel', itemIndex, 500);
      });
    });
  }
});
/*-----------------------------------------------
|   Perfect Scrollbar
-----------------------------------------------*/

window.utils.$document.ready(function () {
  if (window.is.ie() || window.is.edge()) {
    var scrollbars = document.querySelectorAll('.perfect-scrollbar');

    if (scrollbars.length) {
      $.each(scrollbars, function (item, value) {
        var $this = $(value);
        var userOptions = $this.data('options');
        var options = $.extend({
          wheelPropagation: true,
          suppressScrollX: true,
          suppressScrollY: false
        }, userOptions);
        var ps = new PerfectScrollbar(value, options);
        ps.update();
      });
    }
  }
});
/*-----------------------------------------------
|   Inline Player [plyr]
-----------------------------------------------*/

/*
  global Plyr
*/

utils.$document.ready(function () {
  var $players = $('.player');

  if ($players.length) {
    $players.each(function (index, value) {
      return new Plyr($(value), {
        captions: {
          active: true
        }
      });
    });
  }

  return false;
});
/*
 global ProgressBar
*/

utils.$document.ready(function () {
  var merge = window._.merge; // progressbar.js@1.0.0 version is used
  // Docs: http://progressbarjs.readthedocs.org/en/1.0.0/

  /*-----------------------------------------------
  |   Progress Circle
  -----------------------------------------------*/

  var progresCircle = $('.progress-circle');

  if (progresCircle.length) {
    progresCircle.each(function (index, value) {
      var $this = $(value);
      var userOptions = $this.data('options');
      var defaultOptions = {
        strokeWidth: 2,
        trailWidth: 2,
        trailColor: utils.grays['200'],
        easing: 'easeInOut',
        duration: 3000,
        svgStyle: {
          'stroke-linecap': 'round',
          display: 'block',
          width: '100%'
        },
        text: {
          autoStyleContainer: false
        },
        // Set default step function for all animate calls
        step: function step(state, circle) {
          // Change stroke color during progress
          // circle.path.setAttribute('stroke', state.color);
          // Change stroke width during progress
          // circle.path.setAttribute('stroke-width', state.width);
          var percentage = Math.round(circle.value() * 100);
          circle.setText("<span class='value'>" + percentage + "<b>%</b></span> <span>" + (userOptions.text || '') + "</span>");
        }
      }; // Assign default color for IE

      var color = userOptions.color && userOptions.color.includes('url');

      if (window.is.ie() && color) {
        userOptions.color = utils.colors.primary;
      }

      var options = merge(defaultOptions, userOptions);
      var bar = new ProgressBar.Circle(value, options);
      var linearGradient = "<defs>\n          <linearGradient id=\"gradient\" x1=\"0%\" y1=\"0%\" x2=\"100%\" y2=\"0%\" gradientUnits=\"userSpaceOnUse\">\n            <stop offset=\"0%\" stop-color='#1970e2' />\n            <stop offset=\"100%\" stop-color='#4695ff' />\n          </linearGradient>\n        </defs>"; // Disable gradient color in IE

      !window.is.ie() && bar.svg.insertAdjacentHTML('beforeEnd', linearGradient);
      var playProgressTriggered = false;

      var progressCircleAnimation = function progressCircleAnimation() {
        if (!playProgressTriggered) {
          if (utils.isScrolledIntoView(value) || utils.nua.match(/puppeteer/i)) {
            bar.animate(options.progress / 100);
            playProgressTriggered = true;
          }
        }

        return playProgressTriggered;
      };

      progressCircleAnimation();
      utils.$window.scroll(function () {
        progressCircleAnimation();
      });
    });
  }
  /*-----------------------------------------------
  |   Progress Line
  -----------------------------------------------*/


  var progressLine = $('.progress-line');

  if (progressLine.length) {
    progressLine.each(function (index, value) {
      var $this = $(value);
      var options = $this.data('options');
      var bar = new ProgressBar.Line(value, {
        strokeWidth: 1,
        easing: 'easeInOut',
        duration: 3000,
        color: '#333',
        trailColor: '#eee',
        trailWidth: 1,
        svgStyle: {
          width: '100%',
          height: '0.25rem',
          'stroke-linecap': 'round',
          'border-radius': '0.125rem'
        },
        text: {
          style: {
            transform: null
          },
          autoStyleContainer: false
        },
        from: {
          color: '#aaa'
        },
        to: {
          color: '#111'
        },
        step: function step(state, line) {
          line.setText("<span class='value'>" + Math.round(line.value() * 100) + "<b>%</b></span> <span>" + options.text + "</span>");
        }
      });
      var playProgressTriggered = false;

      var progressLineAnimation = function progressLineAnimation() {
        if (!playProgressTriggered) {
          if (utils.isScrolledIntoView(value) || utils.nua.match(/puppeteer/i)) {
            bar.animate(options.progress / 100);
            playProgressTriggered = true;
          }
        }

        return playProgressTriggered;
      };

      progressLineAnimation();
      utils.$window.scroll(function () {
        progressLineAnimation();
      });
    });
  }
});
/*-----------------------------------------------
|   Tabs
-----------------------------------------------*/

utils.$document.ready(function () {
  var $fancyTabs = $('.fancy-tab');

  if ($fancyTabs.length) {
    var Selector = {
      TAB_BAR: '.nav-bar',
      TAB_BAR_ITEM: '.nav-bar-item',
      TAB_CONTENTS: '.tab-contents'
    };
    var ClassName = {
      ACTIVE: 'active',
      TRANSITION_REVERSE: 'transition-reverse',
      TAB_INDICATOR: 'tab-indicator'
    };
    /*-----------------------------------------------
    |   Function for active tab indicator change
    -----------------------------------------------*/

    var updateIncicator = function updateIncicator($indicator, $tabs, $tabnavCurrentItem) {
      var _$tabnavCurrentItem$p = $tabnavCurrentItem.position(),
          left = _$tabnavCurrentItem$p.left;

      var right = $tabs.children(Selector.TAB_BAR).outerWidth() - (left + $tabnavCurrentItem.outerWidth());
      $indicator.css({
        left: left,
        right: right
      });
    };

    $fancyTabs.each(function (index, value) {
      var $tabs = $(value);
      var $navBar = $tabs.children(Selector.TAB_BAR);
      var $tabnavCurrentItem = $navBar.children(Selector.TAB_BAR_ITEM + "." + ClassName.ACTIVE);
      $navBar.append("\n        <div class=" + ClassName.TAB_INDICATOR + "></div>\n      ");
      var $indicator = $navBar.children("." + ClassName.TAB_INDICATOR);
      var $preIndex = $tabnavCurrentItem.index();
      updateIncicator($indicator, $tabs, $tabnavCurrentItem);
      $navBar.children(Selector.TAB_BAR_ITEM).click(function (e) {
        $tabnavCurrentItem = $(e.currentTarget);
        var $currentIndex = $tabnavCurrentItem.index();
        var $tabContent = $tabs.children(Selector.TAB_CONTENTS).children().eq($currentIndex);
        $tabnavCurrentItem.siblings().removeClass(ClassName.ACTIVE);
        $tabnavCurrentItem.addClass(ClassName.ACTIVE);
        $tabContent.siblings().removeClass(ClassName.ACTIVE);
        $tabContent.addClass(ClassName.ACTIVE);
        /*-----------------------------------------------
        |   Indicator Transition
        -----------------------------------------------*/

        updateIncicator($indicator, $tabs, $tabnavCurrentItem);

        if ($currentIndex - $preIndex <= 0) {
          $indicator.addClass(ClassName.TRANSITION_REVERSE);
        } else {
          $indicator.removeClass(ClassName.TRANSITION_REVERSE);
        }

        $preIndex = $currentIndex;
      });
      utils.$window.on('resize', function () {
        updateIncicator($indicator, $tabs, $tabnavCurrentItem);
      });
    });
  }
  /*-----------------------------------------------
  |   Product Review Tab
  -----------------------------------------------*/


  var $review = $('[data-tab-target]');
  $review.click(function (e) {
    var $this = $(e.currentTarget);
    var $reviewTab = $($this.data('tab-target'));
    $reviewTab.trigger('click');
  });
});
/*-----------------------------------------------
|   TINYMCE
-----------------------------------------------*/

window.utils.$document.ready(function () {
  var tinymces = $('.tinymce');

  if (tinymces.length) {
    window.tinymce.init({
      selector: '.tinymce',
      height: '50vh',
      menubar: false,
      skin: utils.settings.tinymce.theme,
      content_style: ".mce-content-body { color: " + utils.grays.black + " }",
      mobile: {
        theme: 'mobile',
        toolbar: ['undo', 'bold']
      },
      statusbar: false,
      plugins: 'link,image,lists,table,media',
      toolbar: 'styleselect | bold italic link bullist numlist image blockquote table media undo redo'
    });
  }

  var toggle = $('#progress-toggle-animation');
  toggle.on('click', function () {
    return $('#progress-toggle').toggleClass('progress-bar-animated');
  });
});
/*-----------------------------------------------
|   Toast [bootstrap 4]
-----------------------------------------------*/

utils.$document.ready(function () {
  $('.toast').toast();
});
/*-----------------------------------------------
|   Typed Text
-----------------------------------------------*/

/*
  global Typed
 */

utils.$document.ready(function () {
  var typedText = $('.typed-text');

  if (typedText.length) {
    typedText.each(function (index, value) {
      return new Typed(value, {
        strings: $(value).data('typed-text'),
        typeSpeed: 100,
        loop: true,
        backDelay: 1500
      });
    });
  }
});
/*-----------------------------------------------
|   YTPlayer
-----------------------------------------------*/

utils.$document.ready(function () {
  var Selector = {
    BG_YOUTUBE: '.bg-youtube',
    BG_HOLDER: '.bg-holder'
  };
  var DATA_KEY = {
    PROPERTY: 'property'
  };
  var $youtubeBackground = $(Selector.BG_YOUTUBE);

  if ($youtubeBackground.length) {
    $youtubeBackground.each(function (index, value) {
      var $this = $(value);
      $this.data(DATA_KEY.PROPERTY, $.extend($this.data(DATA_KEY.PROPERTY), {
        showControls: false,
        loop: true,
        autoPlay: true,
        mute: true,
        containment: $this.parent(Selector.BG_HOLDER)
      }));
      $this.YTPlayer();
    });
  }
});