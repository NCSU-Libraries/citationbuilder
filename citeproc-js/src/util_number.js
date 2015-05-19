/*global CSL: true */

CSL.Util.padding = function (num) {
    var m = num.match(/\s*(-{0,1}[0-9]+)/);
    if (m) {
        num = parseInt(m[1], 10);
        if (num < 0) {
            num = 99999999999999999999 + num;
        }
        num = "" + num;
        while (num.length < 20) {
            num = "0" + num;
        }
    }
    return num;
};

CSL.Util.LongOrdinalizer = function () {};

CSL.Util.LongOrdinalizer.prototype.init = function (state) {
    this.state = state;
};

CSL.Util.LongOrdinalizer.prototype.format = function (num, gender) {
    if (num < 10) {
        num = "0" + num;
    }
    // Argument true means "loose".
    var ret = CSL.Engine.getField(
        CSL.LOOSE, 
        this.state.locale[this.state.opt.lang].terms,
        "long-ordinal-" + num,
        "long", 
        0, 
        gender
    );
    if (!ret) {
        ret = this.state.fun.ordinalizer.format(num, gender);
    }
    // Probably too optimistic -- what if only renders in _sort?
    this.state.tmp.cite_renders_content = true;
    return ret;
};


CSL.Util.Ordinalizer = function (state) {
    this.state = state;
    this.suffixes = {};
};

CSL.Util.Ordinalizer.prototype.init = function () {
    if (!this.suffixes[this.state.opt.lang]) {
        this.suffixes[this.state.opt.lang] = {};
        for (var i = 0, ilen = 3; i < ilen; i += 1) {
            var gender = [undefined, "masculine", "feminine"][i];
            this.suffixes[this.state.opt.lang][gender] = [];
            for (var j = 1; j < 5; j += 1) {
                var ordinal = this.state.getTerm("ordinal-0" + j, "long", false, gender);
                if ("undefined" === typeof ordinal) {
                    delete this.suffixes[this.state.opt.lang][gender];
                    break;
                }
                this.suffixes[this.state.opt.lang][gender].push(ordinal);
            }
        }
    }
};

CSL.Util.Ordinalizer.prototype.format = function (num, gender) {
    var str;
    num = parseInt(num, 10);
    str = "" + num;
    var suffix = "";
    var trygenders = [];
    if (gender) {
        trygenders.push(gender);
    }
    trygenders.push("neuter");
    if (this.state.locale[this.state.opt.lang].ord["1.0.1"]) {
        suffix = this.state.getTerm("ordinal",false,0,gender);
        var trygender;
        for (var i = 0, ilen = trygenders.length; i < ilen; i += 1) {
            trygender = trygenders[i];
            var ordinfo = this.state.locale[this.state.opt.lang].ord["1.0.1"];
            if (ordinfo["whole-number"][str] && ordinfo["whole-number"][str][trygender]) {
                suffix = this.state.getTerm(this.state.locale[this.state.opt.lang].ord["1.0.1"]["whole-number"][str][trygender],false,0,gender);
            } else if (ordinfo["last-two-digits"][str.slice(str.length - 2)] && ordinfo["last-two-digits"][str.slice(str.length - 2)][trygender]) {
                suffix = this.state.getTerm(this.state.locale[this.state.opt.lang].ord["1.0.1"]["last-two-digits"][str.slice(str.length - 2)][trygender],false,0,gender);
            } else if (ordinfo["last-digit"][str.slice(str.length - 1)] && ordinfo["last-digit"][str.slice(str.length - 1)][trygender]) {
                suffix = this.state.getTerm(this.state.locale[this.state.opt.lang].ord["1.0.1"]["last-digit"][str.slice(str.length - 1)][trygender],false,0,gender);
            }
            if (suffix) {
                break;
            }
        }
    } else {
        if (!gender) {
            // XXX hack to prevent crash on CSL 1.0 styles.
            // Reported by Carles.
            gender = undefined;
        }
        this.state.fun.ordinalizer.init();
        if ((num / 10) % 10 === 1 || (num > 10 && num < 20)) {
            suffix = this.suffixes[this.state.opt.lang][gender][3];
        } else if (num % 10 === 1 && num % 100 !== 11) {
            suffix = this.suffixes[this.state.opt.lang][gender][0];
        } else if (num % 10 === 2 && num % 100 !== 12) {
            suffix = this.suffixes[this.state.opt.lang][gender][1];
        } else if (num % 10 === 3 && num % 100 !== 13) {
            suffix = this.suffixes[this.state.opt.lang][gender][2];
        } else {
            suffix = this.suffixes[this.state.opt.lang][gender][3];
        }
    }
    str = str += suffix;
    return str;
};

CSL.Util.Romanizer = function () {};

CSL.Util.Romanizer.prototype.format = function (num) {
    var ret, pos, n, numstr, len;
    ret = "";
    if (num < 6000) {
        numstr = num.toString().split("");
        numstr.reverse();
        pos = 0;
        n = 0;
        len = numstr.length;
        for (pos = 0; pos < len; pos += 1) {
            n = parseInt(numstr[pos], 10);
            ret = CSL.ROMAN_NUMERALS[pos][n] + ret;
        }
    }
    return ret;
};


/**
 * Create a suffix formed from a list of arbitrary characters of arbitrary length.
 * <p>This is a <i>lot</i> harder than it seems.</p>
 */
CSL.Util.Suffixator = function (slist) {
    if (!slist) {
        slist = CSL.SUFFIX_CHARS;
    }
    this.slist = slist.split(",");
};

/**
 * The format method.
 * <p>This method is used in generating ranges.  Every numeric
 * formatter (of which Suffixator is one) must be an instantiated
 * object with such a "format" method.</p>
 */

CSL.Util.Suffixator.prototype.format = function (N) {
    // Many thanks to Avram Lyon for this code, and good
    // riddance to the several functions that it replaces.
    var X;
    N += 1;
    var key = "";
    do {
        X = ((N % 26) === 0) ? 26 : (N % 26);
        key = this.slist[X-1] + key;
        N = (N - X) / 26;
    } while ( N !== 0 );
    return key;
};


CSL.Engine.prototype.processNumber = function (node, ItemObject, variable, type) {
    var num, m, i, ilen, j, jlen;
    var debug = false;

    // XXX short-circuit if object exists: if numeric, set styling, no other action
    if (this.tmp.shadow_numbers[variable]) {
        if (this.tmp.shadow_numbers[variable].numeric) {
            for (var i = 0, ilen = this.tmp.shadow_numbers[variable].values.length; i < ilen; i += 2) {
                this.tmp.shadow_numbers[variable].values[i][2] = node;
            }
        }
        return;
    }
    // This carries value, pluralization and numeric info for use in other contexts.
    // This function does not render.
    this.tmp.shadow_numbers[variable] = {};
    this.tmp.shadow_numbers[variable].values = [];
    this.tmp.shadow_numbers[variable].plural = 0;
    this.tmp.shadow_numbers[variable].numeric = false;
    this.tmp.shadow_numbers[variable].label = false;
    if (!ItemObject) {
        return;
    }

    // Possibly apply multilingual transform
    var languageRole = CSL.LangPrefsMap[variable];
    if (languageRole) {
        var localeType = this.opt["cite-lang-prefs"][languageRole][0];
        num = this.transform.getTextSubField(ItemObject, variable, "locale-"+localeType, true);
        num = num.name;
        // RefMe bug report: print("XX D'oh! (1): "+num);
    } else {
        num = ItemObject[variable];
        // RefMe bug report: print("XX D'oh! (2): "+num);
    }

    // Possibly apply short form.
    // This is done for all number values (it is not controlled by
    // a CSL option).
    // The abbreviation attempt is split into two halves. The first,
    // here, attempts to load an abbreviation, but does not add an
    // abbreviation entry to the UI if none is found. The entry is
    // added only if the is-numeric test later turns up false.
    if (num && this.sys.getAbbreviation) {
        // RefMe bug report: print("XX D'oh! (3): "+num);
        // true as the fourth argument suppresses update of the UI
        num = ("" + num).replace(/^\"/, "").replace(/\"$/, "");
        var jurisdiction = this.transform.loadAbbreviation(ItemObject.jurisdiction, "number", num);
        if (this.transform.abbrevs[jurisdiction].number[num]) {
            num = this.transform.abbrevs[jurisdiction].number[num];
        } else {
            // Strings rendered via cs:number should not be added to the abbreviations
            // UI unless they test non-numeric. The test happens below.
            if ("undefined" !== typeof this.transform.abbrevs[jurisdiction].number[num]) {
                delete this.transform.abbrevs[jurisdiction].number[num];
            }
        }
    }

    //SNIP-START
    if (debug) {
        print("=== "+variable+": "+num+" ===");
    }
    //SNIP-END

    if ("undefined" !== typeof num) {
        if ("number" === typeof num) {
            num = "" + num;
        }
        this.tmp.shadow_numbers[variable].label = variable;
        // Strip off enclosing quotes, if any. Parsing logic
        // does not depend on them, but we'll strip them if found.

        // RefMe bug report: print("XX D'oh! (4): "+num);

        if (num.slice(0, 1) === '"' && num.slice(-1) === '"') {
            num = num.slice(1, -1);
        }

        if (num && ["number-of-volumes","number-of-pages"].indexOf(variable) > -1) {
            var m = num.match(/[^0-9]*([0-9]+).*/);
            if (m) {
                this.tmp.shadow_numbers[variable].numeric = true;
                if (m[1] !== "1") {
                    this.tmp.shadow_numbers[variable].plural = 1;
                }
            }
        }

        // Any & character in the string should force plural.
        // This covers cases like "23 & seq". Cases like "23 et seq"
        // will be caught out; that's for later, if need arises.

        // SUSPEND
        //if (num.indexOf("&") > -1) {
        //    this.tmp.shadow_numbers[variable].plural = 1;
        //}

        // XXX: The attempt at syntactic parsing was crazy.

        // Sequential number blobs should be reserved for year-suffix
        // and year, which may need to collapse during cite
        // composition. For explicit cs:number, we should
        // use simple heuristics to flag multiple
        // values, but respect the user's input format.
        // Ordinals can be applied to pure numeric elements,
        // but that's as far as our fancy processing
        // should go.

        // So.
        
        // ... for locator on bill and legislation, we evaluate only
        // the first element of a split. The lone element will not be
        // used for rendering, (that is handled inside node_number
        // directly), but only for is-numeric evaluation.

        if ("locator" === variable
            && ["bill","gazette","legislation","treaty"].indexOf(type) > -1) {
            num = num.split(CSL.STATUTE_SUBDIV_PLAIN_REGEX)[0];
        }

        var rangeType = "page";
        if (["bill","gazette","legislation","legal_case","treaty"].indexOf(type) > -1
            && variable === "collection-number") {

            rangeType = "year";
        }

        // Works with code in node_number.js
        if (["page", "page-first"].indexOf(variable) > -1) {
            var m = num.split(" ")[0].match(CSL.STATUTE_SUBDIV_GROUPED_REGEX);
            if (m){
                if (this.opt.development_extensions.static_statute_locator) {
                    this.tmp.shadow_numbers[variable].label = CSL.STATUTE_SUBDIV_STRINGS[m[0]];
                }
                var mm = num.match(/[^ ]+\s+(.*)/);
                if (mm) {
                    num = mm[1];
                }
            }
        }

        // (1) Split the string on ", ", "\s*[\-\u2013]\s*" and "&".
        // (2) Set the elements one by one, setting pure numbers
        //     as numeric blobs, and everything else as text,
        //     applying "this" for styling to both, with "empty"
        //     styling on the punctuation elements.
        
        var lst = num.split(/(?:,\s+|\s*\\*[\-\u2013]+\s*|\s*&\s*)/);
        var m = num.match(/(,\s+|\s*\\*[\-\u2013]+\s*|\s*&\s*)/g);
        var elements = [];
        for (var i = 0, ilen = lst.length - 1; i < ilen; i += 1) {
            elements.push(lst[i]);
            elements.push(m[i]);
        }
        elements.push(lst[lst.length - 1]);
        var count = 0;
        var numeric = true;
        for (var i = 0, ilen = elements.length; i < ilen; i += 1) {
            var odd = ((i%2) === 0);
            if (odd) {
                // Rack up as numeric output if pure numeric, otherwise as text.
                if (elements[i]) {
                    if (elements[i].match(/(?:[0-9]|[xivcmlXIVCML])/)) {
                        if (elements[i - 1] && elements[i - 1].match(/^\s*\\*[\-\u2013]+\s*$/)) {
                            var middle = this.tmp.shadow_numbers[variable].values.slice(-1);
                            if (middle[0][1].indexOf("\\") == -1) {
                                if (elements[i - 2] && ("" + elements[i - 2]).match(/(:?[a-zA-Z]*[0-9]+$|^[ivxlcmIVXLCM]+$)/)
                                    && elements[i].match(/(?:^[a-zA-Z]*[0-9]+|^[ivxlcmIVXLCM]+$)/)) {

                                    // Removed from condition to allow manually collapsed
                                    // number ranges to be recognized as plural. Leaf number
                                    // delimiter of hyphen (-) can be specified with \\-
                                    // in the input.
                                    // && parseInt(elements[i - 2]) < parseInt(elements[i].replace(/[^0-9].*/,""))

                                    
                                    var start = this.tmp.shadow_numbers[variable].values.slice(-2);
                                    middle[0][1] = this.getTerm(rangeType + "-range-delimiter");
                                    if (this.opt[rangeType + "-range-format"] ) {
                                        // This is a hack. The page mangler strings were originally
                                        // used directly.
                                        var newstr = this.fun[rangeType + "_mangler"](start[0][1] +"-"+elements[i]);
                                        newstr = newstr.split(this.getTerm(rangeType + "-range-delimiter"));
                                        elements[i] = newstr[1];
                                    }
                                    
                                    count = count + 1;
                                }
                                if (middle[0][1].indexOf("--") > -1) {
                                    middle[0][1] = middle[0][1].replace(/--*/, "\u2013");
                                }
                            } else {
                                middle[0][1] = middle[0][1].replace(/\\/, "", "g");
                            }
                        } else if (elements[i].indexOf(" ") === -1) {
                            count = count + 1;
                        }
                    }
                    var subelements = elements[i].split(/\s+/);
                    for (var j = 0, jlen = subelements.length; j < jlen; j += 1) {
                        if (this.opt.development_extensions.strict_page_numbers
                            && variable === "page"
                            && !subelements[j].match(/^-*[0-9]/)) {
                            numeric = false;
                        } else if (!subelements[j].match(/[-0-9]/)) {
                            numeric = false;
                        }
                    }
                    if (elements[i].match(/^[1-9][0-9]*$/)) {
                        elements[i] = parseInt(elements[i], 10);
                        if (node && "undefined" === typeof node.gender) {
                            node.gender = this.locale[this.opt.lang]["noun-genders"][variable];
                            if (!node.gender) {
                                node.gender = "";
                            }
                        }
                        this.tmp.shadow_numbers[variable].values.push(["NumericBlob", elements[i], node]);
                    } else {
                        var str = elements[i];
                        this.tmp.shadow_numbers[variable].values.push(["Blob", str, node]);
                    }
                }
            } else {
                // Normalize and output as text with "empty" style.
                if (elements[i]) {
                    this.tmp.shadow_numbers[variable].values.push(["Blob", elements[i], undefined]);
                }
            }
        };
        if (this.opt.development_extensions.strict_page_numbers && variable === "page") {
            if (num.indexOf(" ") === -1 && num.match(/^-*[0-9]/)) {
                this.tmp.shadow_numbers[variable].numeric = true;
            } else {
                this.tmp.shadow_numbers[variable].numeric = numeric;
            }
        } else {
            if (num.indexOf(" ") === -1 && num.match(/[0-9]/)) {
                this.tmp.shadow_numbers[variable].numeric = true;
            } else {
                this.tmp.shadow_numbers[variable].numeric = numeric;
            }
        }
        if (!this.tmp.shadow_numbers[variable].numeric) {
            this.transform.loadAbbreviation(ItemObject.jurisdiction, "number", num);
        }
        if (count > 1) {
            this.tmp.shadow_numbers[variable].plural = 1;
        }
        // Force plural/singular if requested (see util_static_locator.js)
        if (ItemObject.force_pluralism === 1) {
            this.tmp.shadow_numbers[variable].plural = 1;
        } else if (ItemObject.force_pluralism === 0) {
            this.tmp.shadow_numbers[variable].plural = 0;
        }
    }
};
