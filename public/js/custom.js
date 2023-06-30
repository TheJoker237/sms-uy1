/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/custom.js":
/*!********************************!*\
  !*** ./resources/js/custom.js ***!
  \********************************/
/***/ (() => {

$(function () {
  manageFiliere();
  manageCourse();
  manageAcademicYear();
  manageDoyen();
  manageExamenFiliere();
  // manageExamenCourse();
});

function manageFiliere() {
  $($('.filiere-add')[0]).hide();
  $('.filiere-edit').click(function () {
    var tr = $($($($(this).parent().get(0)).parent().get(0)).parent().get(0));
    var $id = $(tr).children('.id')[0];
    $id = $($id).text();
    var faculty = $(tr.find('td.filiere-faculty')[0]).text();
    var filiere = $(tr.find('td.filiere-title')[0]).text();
    var formId = '#filiere-form';
    $(formId + ' select.faculty-field').val(faculty);
    $(formId + ' input.filiere-field').val(filiere);
    $(formId + ' input[name="id"]').val($id);
    var link = $(formId).attr('action');
    if (/save/.test(link)) {
      link = link.replace('save', 'edit');
    }
    $(formId).attr('action', link);
    $($('.filiere-info')[0]).text('Filiere Edit');
    $($('.filiere-add')[0]).show();
  });

  // Add Filiere
  $('.filiere-add').click(function () {
    var formId = '#filiere-form';
    var link = $(formId).attr('action');
    if (/edit/.test(link)) {
      link = link.replace(/edit\/\d*/, 'save');
    }
    $(formId).attr('action', link);
    $($('.filiere-info')[0]).text('Filiere Save');
    $($(this)[0]).hide();

    //Reset Form Records
    $(formId + ' select.faculty-field').val("Select Faculty");
    $(formId + ' input.filiere-field').val('');
  });
}
function manageCourse() {
  $($('.course-add')[0]).hide();
  $('.course-edit').click(function () {
    var tr = $($($($(this).parent().get(0)).parent().get(0)).parent().get(0));
    var $id = $(tr).children('.id')[0];
    $id = $($id).text();
    var filiere = $(tr.find('td.filiere')[0]).text();
    var code = $(tr.find('td.course-code')[0]).text();
    var title = $(tr.find('td.course-title')[0]).text();
    var formId = '#course-form';
    $(formId + ' select.filiere-field').val(filiere);
    $(formId + ' input.code-field').val(code);
    $(formId + ' input.title-field').val(title);
    $(formId + ' input[name="id"]').val($id);
    var link = $(formId).attr('action');
    if (/save/.test(link)) {
      link = link.replace('save', 'edit');
    }
    $(formId).attr('action', link);
    $($('.course-info')[0]).text('Course Update');
    $($('.course-add')[0]).show();
  });

  // Add Course
  $('.course-add').click(function () {
    var formId = '#course-form';
    var link = $(formId).attr('action');
    if (/edit/.test(link)) {
      link = link.replace(/edit/, 'save');
    }
    $(formId).attr('action', link);
    $($('.course-info')[0]).text('Course Create');
    $($(this)[0]).hide();

    //Reset Form Records
    $(formId + ' select.filiere-field').val('Select Filiere');
    $(formId + ' input.code-field').val('');
    $(formId + ' input.title-field').val('');
  });
}
function manageAcademicYear() {
  $($('.academicYear-add')[0]).hide();
  $('.academicYear-edit').click(function () {
    var tr = $($($($(this).parent().get(0)).parent().get(0)).parent().get(0));
    var $id = $(tr).children('.id')[0];
    $id = $($id).text();
    shortYear = $(tr.find('td.year')[0]).text();
    //  var year = new Date($(tr.find('td.year')[0]).text());
    //  var shortYear = year.getDay() + '-' + year.getMonth() + '-' + year.getFullYear();
    var formId = '#academicYear-form';
    $(formId + ' input.year-filed').val(shortYear);
    $(formId + ' input[name="id"]').val($id);
    var link = $(formId).attr('action');
    if (/save/.test(link)) {
      link = link.replace('save', 'edit');
    }
    $(formId).attr('action', link);
    $($('.academicYear-info')[0]).text('Academic Year Edit');
    $($('.academicYear-add')[0]).show();
  });

  // Add Academic Year
  $('.academicYear-add').click(function () {
    var formId = '#academicYear-form';
    var link = $(formId).attr('action');
    if (/edit/.test(link)) {
      link = link.replace(/edit/, 'save');
    }
    $(formId).attr('action', link);
    $($('.academicYear-info')[0]).text('Academic Year Create');
    $($(this)[0]).hide();

    //Reset Form Records
    $(formId + ' input.year-field').val('');
  });
}
function manageDoyen() {
  // ! Check if Doyen already exist
  if ($('.doyen-set')[0] != null) {
    var formId = '#doyen-form';
    $($('.doyen-info')[0]).text('List Teacher');
    $($('.doyen-submit')[0]).hide();
    // ! If the link has previously changed we restore it
    var formId = '#doyen-form';
    var link = $(formId).attr('action');
    if (/\/doyen\/change/.test(link)) {
      link = link.replace(/\/doyen\/change/, '/doyen/set');
    }
    $(formId).attr('action', link);
  }
  $('.doyen-edit').click(function () {
    var tr = $($($($(this).parent().get(0)).parent().get(0)).parent().get(0));
    var $id = $(tr).children('.id-teacher')[0];
    $idTeacher = $($id).text();
    //  doyen = $(tr.find('td a.doyen')[0]).text();
    $(formId + ' select.doyen-field').val($idTeacher);
    $(formId + ' input[name="id"]').val($idTeacher);
    var link = $(formId).attr('action');
    if (/\/doyen\/set/.test(link)) {
      link = link.replace('/doyen/set', '/doyen/change');
    }
    $(formId).attr('action', link);
    $($('.doyen-info')[0]).text('Doyen Change');
    $($('.doyen-submit')[0]).show();
  });

  // Doyen reset after Submit
  $('.doyen-submit').click(function () {
    // ? Reset Form Records
    $(formId + ' input.doyen-field').val('');
  });
}
function manageExamenFiliere() {
  var defaultSelect = "<option disabled>Select Filiere</option>";
  var formId = '#examen-form';
  //Toggle Exam Type
  $('#examen-form select[name="session"]').prop('disabled', 'true');
  $('#examen-form select[name="type"]').change(function () {
    if ($(this).val() == "Session Normale") $('#examen-form select[name="session"]').prop('disabled', '');else {
      $('#examen-form select[name="session"]').prop('disabled', 'true');
    }
  });
  $(formId + ' select[name="faculte[]"]').change(function () {
    if ($(this).val() != "") {
      /**
       * % Ajax Request
       */
      // CREATE
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
      });
      var formData = {
        facultes: $(this).val()
      };
      var type = "POST";
      var ajaxurl = "http://127.0.0.1:8000/examen/manage-filiere";
      $.ajax({
        type: type,
        url: ajaxurl,
        data: formData,
        dataType: 'json',
        success: function success(data) {
          $('#filiere').empty();
          $('#filiere').append(defaultSelect);
          data.forEach(function (element) {
            var opt = "<option value=" + element['id'] + ">" + element['title'] + "</option>";
            $('#filiere').append(opt);
          });
          manageExamenCourse();
        },
        error: function error(data) {
          console.log(data);
        }
      });
    } else {
      $('#filiere').empty();
      $('#filiere').append(defaultSelect);
    }
  });
}
function manageExamenCourse() {
  var defaultSelect = "<option disabled>Select Course</option>";
  var formId = '#examen-form';
  $(formId + ' select[name="filiere[]"]').change(function () {
    if ($(this).val() != "") {
      /**
       * % Ajax Request
       */
      // CREATE
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
      });
      var formData = {
        Idfilieres: $(this).val()
      };
      var type = "POST";
      var ajaxurl = "http://127.0.0.1:8000/examen/manage-course";
      $.ajax({
        type: type,
        url: ajaxurl,
        data: formData,
        dataType: 'json',
        success: function success(data) {
          $('#course').empty();
          $('#course').append(defaultSelect);
          data.forEach(function (element) {
            var opt = "<option value=" + element['id'] + ">" + element['title'] + "</option>";
            $('#course').append(opt);
          });
        },
        error: function error(data) {
          console.log(data);
        }
      });
    } else {
      $('#course').empty();
      $('#course').append(defaultSelect);
    }
  });
}

/***/ }),

/***/ "./resources/css/app.css":
/*!*******************************!*\
  !*** ./resources/css/app.css ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/js/custom": 0,
/******/ 			"css/app": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/js/custom.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/css/app.css")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;