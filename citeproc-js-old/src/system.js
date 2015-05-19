/*global CSL: true */

var XML_PARSING;
if ("undefined" !== typeof CSL_IS_NODEJS) {
    XML_PARSING = CSL_NODEJS;
} else if ("undefined" !== typeof CSL_E4X) {
    XML_PARSING = CSL_E4X;
} else if ("undefined" !== typeof CSL_JSON) {
    XML_PARSING = CSL_JSON;
} else {
    XML_PARSING = CSL_CHROME;
}
CSL.System = {};
CSL.System.Xml = {
    "Parsing": XML_PARSING
};
