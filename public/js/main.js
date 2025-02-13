// Burger menus
document.addEventListener('DOMContentLoaded', function () {
    // open
    const burger = document.querySelectorAll('.navbar-burger');
    const menu = document.querySelectorAll('.navbar-menu');

    if (burger.length && menu.length) {
        for (var i = 0; i < burger.length; i++) {
            burger[i].addEventListener('click', function () {
                for (var j = 0; j < menu.length; j++) {
                    menu[j].classList.toggle('hidden');
                }
            });
        }
    }

    // close
    const close = document.querySelectorAll('.navbar-close');
    const backdrop = document.querySelectorAll('.navbar-backdrop');

    if (close.length) {
        for (var i = 0; i < close.length; i++) {
            close[i].addEventListener('click', function () {
                for (var j = 0; j < menu.length; j++) {
                    menu[j].classList.toggle('hidden');
                }
            });
        }
    }

    if (backdrop.length) {
        for (var i = 0; i < backdrop.length; i++) {
            backdrop[i].addEventListener('click', function () {
                for (var j = 0; j < menu.length; j++) {
                    menu[j].classList.toggle('hidden');
                }
            });
        }
    }
});

// Choose langages
$('#chooseLang').change(function () {
    // set the window's location property to the value of the option the user has selected
    window.location = `?change_language=` + $(this).val();
});

// QR Code Text
// Set default
function hideGradientElements() {
    "use strict";
    var list, index;
    list = document.getElementsByClassName("gradient-form-group");
    for (index = 0; index < list.length; ++index) {
        list[index].classList.add('d-none');
    }
}

// Check color type
function checkColor(color) {
    "use strict";
    // Value
    var getColor = color.value;

    // Check value is gradient
    if (getColor == "gradient") {
        // Disable foreground color in value (color)
        var list, index;
        list = document.getElementsByClassName("color-form-group");
        for (index = 0; index < list.length; ++index) {
            list[index].classList.add('d-none');
        }

        // Enable gradient fields
        var list, index;
        list = document.getElementsByClassName("gradient-form-group");
        for (index = 0; index < list.length; ++index) {
            list[index].classList.remove('d-none');
        }
    }

    // Check value is color
    if (getColor == "color") {
        // Disable color fields
        var list, index;
        list = document.getElementsByClassName("gradient-form-group");
        for (index = 0; index < list.length; ++index) {
            list[index].classList.add('d-none');
        }

        // Enable foreground color in value (color)
        var list, index;
        list = document.getElementsByClassName("color-form-group");
        for (index = 0; index < list.length; ++index) {
            list[index].classList.remove('d-none');
        }
    }
}

// Check eyes color type
function checkEyeColor(eyesColor) {
    "use strict";
    // Value
    var getEyesColor = eyesColor;

    // Check value is 1
    if (getEyesColor == "1") {
        // Disable foreground color in value (color)
        var list, index;
        list = document.getElementsByClassName("eyes_control");
        for (index = 0; index < list.length; ++index) {
            list[index].classList.remove('d-none');
        }
    }

    // Check value is 0
    if (getEyesColor == "0") {
        // Disable color fields
        var list, index;
        list = document.getElementsByClassName("eyes_control");
        for (index = 0; index < list.length; ++index) {
            list[index].classList.add('d-none');
        }
    }
}

// Check current color type
function currentColor(color) {
    "use strict";
    // Value
    var getColor = color;

    // Check value is gradient
    if (getColor == "gradient") {
        // Disable foreground color in value (color)
        var list, index;
        list = document.getElementsByClassName("color-form-group");
        for (index = 0; index < list.length; ++index) {
            list[index].classList.add('d-none');
        }

        // Enable gradient fields
        var list, index;
        list = document.getElementsByClassName("gradient-form-group");
        for (index = 0; index < list.length; ++index) {
            list[index].classList.remove('d-none');
        }
    }

    // Check value is color
    if (getColor == "color") {
        // Disable color fields
        var list, index;
        list = document.getElementsByClassName("gradient-form-group");
        for (index = 0; index < list.length; ++index) {
            list[index].classList.add('d-none');
        }

        // Enable foreground color in value (color)
        var list, index;
        list = document.getElementsByClassName("color-form-group");
        for (index = 0; index < list.length; ++index) {
            list[index].classList.remove('d-none');
        }
    }
}

// svg base64 data to any image format convertion in qrcode
// For more reference: https://stackoverflow.com/questions/46814480/how-can-convert-a-base64-svg-image-to-base64-image-png
// https://stackoverflow.com/questions/14011021/how-to-download-a-base64-encoded-image

function svgToQrCodeDownload(svgString, qrcodeFormat, qrcodeName, qrcodeSize) {
    "use strict";
    // set default for format parameter
    qrcodeFormat = qrcodeFormat ? qrcodeFormat : 'png';
    // SVG data URL from SVG string
    var svgData = svgString;
    // create canvas in memory(not in DOM)
    var canvas = document.createElement('canvas');
    // get canvas context for drawing on canvas
    var context = canvas.getContext('2d');
    // Setting Download File name
    var fileName = qrcodeName + "." + qrcodeFormat;
    // set canvas size
    canvas.width = qrcodeSize;
    canvas.height = qrcodeSize;

    if (qrcodeFormat == "svg") {
        // Hidden download link generate
        var downloadLink = document.createElement('a');
        document.body.appendChild(downloadLink);

        downloadLink.href = svgData;
        downloadLink.style.display = 'none';
        downloadLink.download = fileName;
        downloadLink.click();
        downloadLink.remove();
    } else {
        // create image in memory(not in DOM)
        var image = new Image();
        // later when image loads run this
        image.onload = function () {
            // clear canvas
            context.clearRect(0, 0, qrcodeSize, qrcodeSize);
            // draw image with SVG data to canvas
            context.drawImage(image, 0, 0, qrcodeSize, qrcodeSize);
            // snapshot canvas as png
            var QrCodePngData = canvas.toDataURL('image/' + qrcodeFormat);

            // Hidden download link generate
            var downloadLink = document.createElement('a');
            document.body.appendChild(downloadLink);

            downloadLink.href = QrCodePngData;
            downloadLink.style.display = 'none';
            downloadLink.download = fileName;
            downloadLink.click();
            downloadLink.remove();
        }

    }

    // start loading SVG data into in memory image
    image.src = svgData;
}

// svg base64 data to any image format convertion in barcode
// For more reference: https://stackoverflow.com/questions/46814480/how-can-convert-a-base64-svg-image-to-base64-image-png
// https://stackoverflow.com/questions/14011021/how-to-download-a-base64-encoded-image

function svgToBarcodeDownload(svgString, barcodeFormat, barcodeName, barcodeWidth, barcodeHeight) {
    "use strict";
    // set default for format parameter
    barcodeFormat = barcodeFormat ? barcodeFormat : 'png';
    // SVG data URL from SVG string
    var barcodeData = svgString;
    // create canvas in memory(not in DOM)
    var canvas = document.createElement('canvas');
    // get canvas context for drawing on canvas
    var context = canvas.getContext('2d');
    // Setting Download File name
    var fileName = barcodeName + "." + barcodeFormat;
    // set canvas width & height
    canvas.width = barcodeWidth;
    canvas.height = barcodeHeight;

    if (barcodeFormat == "svg") {
        // Hidden download link generate
        var downloadLink = document.createElement('a');
        document.body.appendChild(downloadLink);

        downloadLink.href = barcodeData;
        downloadLink.style.display = 'none';
        downloadLink.download = fileName;
        downloadLink.click();
        downloadLink.remove();
    } else {
        // create image in memory(not in DOM)
        var image = new Image();
        // later when image loads run this
        image.onload = function () {
            // clear canvas
            context.clearRect(0, 0, barcodeWidth, barcodeHeight);
            // draw image with SVG data to canvas
            context.drawImage(image, 0, 0, barcodeWidth, barcodeHeight);
            // snapshot canvas as png
            var BarcodePngData = canvas.toDataURL('image/' + barcodeFormat);

            // Hidden download link generate
            var downloadLink = document.createElement('a');
            document.body.appendChild(downloadLink);

            downloadLink.href = BarcodePngData;
            downloadLink.style.display = 'none';
            downloadLink.download = fileName;
            downloadLink.click();
            downloadLink.remove();
        }

    }

    // start loading SVG data into in memory image
    image.src = barcodeData;
}

// Print function
function doPrint() {
    "use strict";
    // Printable area
    var printContents = $('.printable-area').html();

    // replace body
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    // Print
    window.print();
    document.body.innerHTML = originalContents;
}


function prevent() {
    "use strict";
    window.alert = function () { };
}