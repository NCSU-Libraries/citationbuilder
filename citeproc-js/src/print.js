/*global CSL: true */

if ("object" === typeof console && "function" === typeof console.log) {
    CSL.debug = function (str) {
        console.log("CSL: " + str);
    };
    CSL.error = function (str) {
        console.log("CSL error: " + str);
    };
} else {
    CSL.debug = function () {};
    CSL.error = function (str) {
        throw "CSL error: " + str;
    };
}
