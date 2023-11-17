'use strict';

if (typeof exports === "undefined") {
    var exports = {};
}

if (typeof module === "undefined") {
   var module = {};
}

Object.defineProperty(exports, '__esModule', {
    value: true
});

var _createClass = (function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ('value' in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

var hasBlobConstructor = typeof Blob !== 'undefined' && (function () {
    try {
        return Boolean(new Blob());
    } catch (e) {
        return false;
    }
})();

var hasArrayBufferViewSupport = hasBlobConstructor && typeof Uint8Array !== 'undefined' && (function () {
    try {
        return new Blob([new Uint8Array(100)]).size === 100;
    } catch (e) {
        return false;
    }
})();

var hasToBlobSupport = typeof HTMLCanvasElement !== "undefined" ? HTMLCanvasElement.prototype.toBlob : false;

var hasBlobSupport = hasToBlobSupport || typeof Uint8Array !== 'undefined' && typeof ArrayBuffer !== 'undefined' && typeof atob !== 'undefined';

var hasReaderSupport = typeof FileReader !== 'undefined' || typeof URL !== 'undefined';

var ImageTools = (function () {
    function ImageTools() {
        _classCallCheck(this, ImageTools);
    }

    _createClass(ImageTools, null, [{
        key: 'resize',
        value: function resize(file, maxFileSize, callback) {
            if (!ImageTools.isSupported() || !file.type.match(/image.*/)) {
                callback(file, false, 'Sorry. This operation is not supported by your device.');
                return false;
            }

            if (file.type.match(/image\/gif/)) {
                // Not attempting, could be an animated gif
                callback(file, false, 'Please choose a JPG or PNG image.');
                return false;
            }

	    if (file.size <= maxFileSize) {
                // early exit; no need to resize
                callback(file, true, 'No need to resize.');
                return;
            }

            var image = document.createElement('img');
              
            image.onload = function (imgEvt) {
		// Approximate file.size = H x W x D (doesn't include image header).  Since we scale H and W equally to preserve aspect ratio, scale by sqrt(scale factor).
		var scale = Math.sqrt(file.size / maxFileSize);

                var height = Math.ceil(image.height / scale);
                var width = Math.ceil(image.width / scale);

                var canvas = document.createElement('canvas');
                canvas.width = width;
                canvas.height = height;

                var ctx = canvas.getContext('2d');
		// High image quality
		ctx.imageSmoothingEnabled = true;
		ctx.imageSmoothingQuality = 'high';

		EXIF.getData(image, function() {
			var orientation = EXIF.getTag(this, 'Orientation');

	        	switch (Number(orientation)) {
				case 1:
					break;

            			case 2:
                			ctx.translate(width, 0);
                			ctx.scale(-1, 1);
                			break;

            			case 3:
                			ctx.translate(width, height);
                			ctx.rotate((180 / 180) * Math.PI);
                			break;

            			case 4:
                			ctx.translate(0, height);
                			ctx.scale(1, -1);
                			break;

            			case 5:
					// rotating 90deg, so transpose canvas height and width
					canvas.width = height;
					canvas.height = width;
                			ctx.rotate((90 / 180) * Math.PI);
                			ctx.scale(1, -1);
                			break;

            			case 6:
					canvas.width = height;
					canvas.height = width;
                			ctx.rotate((90 / 180) * Math.PI);
                			ctx.translate(0, -height);
                			break;

            			case 7:
					canvas.width = height;
					canvas.height = width;
                			ctx.rotate((270 / 180) * Math.PI);
                			ctx.translate(-width, height);
                			ctx.scale(1, -1);
                			break;

            			case 8:
					canvas.width = height;
					canvas.height = width;
                			ctx.translate(0, width);
                			ctx.rotate((270 / 180) * Math.PI);
                			break;

            			default:
                			break;
        		}

                	ctx.drawImage(image, 0, 0, width, height);

                	if (hasToBlobSupport) {
                    		canvas.toBlob(function (blob) {
                        		callback(blob, true, 'Resized.  No errors.');
                    		}, file.type);
                	} else {
                    		var blob = ImageTools._toBlob(canvas, file.type);
                    		callback(blob, true, 'Resized.  No errors.');
                	}
		   }); // EXIF.getData(img, function() {
        	}; // image.onload = function (imgEvt) {

        	ImageTools._loadImage(image, file);

        	return true;
        }
    }, {
        key: '_toBlob',
        value: function _toBlob(canvas, type) {
            var dataURI = canvas.toDataURL(type);
            var dataURIParts = dataURI.split(',');
            var byteString = undefined;
            if (dataURIParts[0].indexOf('base64') >= 0) {
                // Convert base64 to raw binary data held in a string:
                byteString = atob(dataURIParts[1]);
            } else {
                // Convert base64/URLEncoded data component to raw binary data:
                byteString = decodeURIComponent(dataURIParts[1]);
            }
            var arrayBuffer = new ArrayBuffer(byteString.length);
            var intArray = new Uint8Array(arrayBuffer);

            for (var i = 0; i < byteString.length; i += 1) {
                intArray[i] = byteString.charCodeAt(i);
            }

            var mimeString = dataURIParts[0].split(':')[1].split(';')[0];
            var blob = null;

            if (hasBlobConstructor) {
                blob = new Blob([hasArrayBufferViewSupport ? intArray : arrayBuffer], { type: mimeString });
            } else {
                var bb = new BlobBuilder();
                bb.append(arrayBuffer);
                blob = bb.getBlob(mimeString);
            }

            return blob;
        }
    }, {
        key: '_loadImage',
        value: function _loadImage(image, file, callback) {
            if (typeof URL === 'undefined') {
                var reader = new FileReader();
                reader.onload = function (evt) {
                    image.src = evt.target.result;
                    if (callback) {
                        callback();
                    }
                };
                reader.readAsDataURL(file);
            } else {
                image.src = URL.createObjectURL(file);
                if (callback) {
                    callback();
                }
            }
        }
    }, {
        key: 'isSupported',
        value: function isSupported() {
            return typeof HTMLCanvasElement !== 'undefined' && hasBlobSupport && hasReaderSupport;
        }
    }]);

    return ImageTools;
})();

exports['default'] = ImageTools;
module.exports = exports['default'];
