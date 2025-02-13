// QR Code Text
// Set default
function hideWebGradientElements() {
    "use strict";
    var list, index;
    list = document.getElementsByClassName("gradient-form-group");
    for (index = 0; index < list.length; ++index) {
        list[index].classList.add('hidden');
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
            list[index].classList.add('hidden');
        }

        // Enable gradient fields
        var list, index;
        list = document.getElementsByClassName("gradient-form-group");
        for (index = 0; index < list.length; ++index) {
            list[index].classList.remove('hidden');
        }
    }

    // Check value is color
    if (getColor == "colors") {
        // Disable color fields
        var list, index;
        list = document.getElementsByClassName("gradient-form-group");
        for (index = 0; index < list.length; ++index) {
            list[index].classList.add('hidden');
        }

        // Enable foreground color in value (color)
        var list, index;
        list = document.getElementsByClassName("color-form-group");
        for (index = 0; index < list.length; ++index) {
            list[index].classList.remove('hidden');
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
            list[index].classList.remove('hidden');
        }
    }

    // Check value is 0
    if (getEyesColor == "0") {
        // Disable color fields
        var list, index;
        list = document.getElementsByClassName("eyes_control");
        for (index = 0; index < list.length; ++index) {
            list[index].classList.add('hidden');
        }
    }
}