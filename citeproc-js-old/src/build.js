/*global CSL: true */

CSL.Engine = function (sys, style, lang, forceLang) {
    var attrs, langspec, localexml, locale;
    this.processor_version = CSL.PROCESSOR_VERSION;
    this.csl_version = "1.0";
    this.sys = sys;
    // XXX This may be excess code. Given the normalization performed on
    // XXX the output queue before variableWrapper() is run, a single
    // XXX space should be the most cruft that we ever see before a variable.
    if (sys.variableWrapper) {
        CSL.VARIABLE_WRAPPER_PREPUNCT_REX = new RegExp('^([' + [" "].concat(CSL.SWAPPING_PUNCTUATION).join("") + ']*)(.*)');
    }
    this.sys.xml = new CSL.System.Xml.Parsing();
    // XXXX This should be restored -- temporarily suspended for testing of JSON style support.
    if ("undefined" === typeof CSL_JSON && "string" !== typeof style) {
        style = "";
    }
    if (CSL.getAbbreviation) {
        this.sys.getAbbreviation = CSL.getAbbreviation;
    }
    if (this.sys.stringCompare) {
        CSL.stringCompare = this.sys.stringCompare;
    }
    this.sys.AbbreviationSegments = CSL.AbbreviationSegments;
    this.parallel = new CSL.Parallel(this);
    //this.parallel.use_parallels = true;

    this.transform = new CSL.Transform(this);
    // true or false
    this.setParseNames = function (val) {
        this.opt['parse-names'] = val;
    };
    
    this.opt = new CSL.Engine.Opt();
    this.tmp = new CSL.Engine.Tmp();
    this.build = new CSL.Engine.Build();
    this.fun = new CSL.Engine.Fun(this);

    this.configure = new CSL.Engine.Configure();
    // Build citation before citation_sort in order to pick up
    // state.opt.update_mode, needed it determine whether
    // a grouped sort should be performed.
    this.citation_sort = new CSL.Engine.CitationSort();
    this.bibliography_sort = new CSL.Engine.BibliographySort();
    this.citation = new CSL.Engine.Citation(this);
    this.bibliography = new CSL.Engine.Bibliography();

    this.output = new CSL.Output.Queue(this);

    //this.render = new CSL.Render(this);
    //
    // This latter queue is used for formatting date chunks
    // before they are folded back into the main queue.
    //
    this.dateput = new CSL.Output.Queue(this);

    this.cslXml = this.sys.xml.makeXml(style);

    if (this.opt.development_extensions.csl_reverse_lookup_support || this.sys.csl_reverse_lookup_support) {
        this.build.cslNodeId = 0;
        this.setCslNodeIds = function(myxml, nodename) {
            var children = this.sys.xml.children(myxml);
            this.sys.xml.setAttribute(myxml, 'cslid', this.build.cslNodeId);
            this.opt.nodenames.push(nodename);
            this.build.cslNodeId += 1;
            for (var i = 0, ilen = this.sys.xml.numberofnodes(children); i < ilen; i += 1) {
                nodename = this.sys.xml.nodename(children[i]);
                if (nodename) {
                    this.setCslNodeIds(children[i], nodename);
                }
            }
        };
        this.setCslNodeIds(this.cslXml, "style");
    }
    this.sys.xml.addMissingNameNodes(this.cslXml);
    this.sys.xml.addInstitutionNodes(this.cslXml);
    this.sys.xml.insertPublisherAndPlace(this.cslXml);
    this.sys.xml.flagDateMacros(this.cslXml);

    //
    // Note for posterity: tried manipulating the XML here to insert
    // a list of the upcoming date-part names.  The object is apparently
    // read-only.  Don't know why, can't find any reference to this
    // problem on the Net (other than casual mentions that it works,
    // which it doesn't, at least in Rhino).  Turning to add this info
    // in the compile phase, in the flattened version of the style,
    // which should be simpler anyway.
    //

    attrs = this.sys.xml.attributes(this.cslXml);
    if ("undefined" === typeof attrs["@sort-separator"]) {
        this.sys.xml.setAttribute(this.cslXml, "sort-separator", ", ");
    }

    //if ("undefined" === typeof attrs["@name-delimiter"]) {
    //    this.sys.xml.setAttribute(this.cslXml, "name-delimiter", ", ");
    //}

    this.opt["initialize-with-hyphen"] = true;

    //
    // implicit default, "en"
    //
    // We need to take this in layered functions.  This function goes
    // once, right here, with the lang argument.  It calls a function
    // that resolves the lang argument into a full two-part language
    // entry.  It calls a function that (1) checks to see if
    // the two-part target language is available on the CSL.locale
    // branch, and (2) if not, sets from ultimate default, then (3) from
    // single-term language (if available), then (4) from two-term language.
    // It does this all twice, once for locale files, then for locales inside
    // the style file.
    //
    // So functions needed are ... ?
    //
    // setLocale(rawLang) [top-level]
    //   localeResolve(rawLang)
    //   [function below is not run for external locales
    //   if two-part lang exists in CSL.locale; it is always
    //   run for in-CSL locale data, if it exists.]
    //   localeSetFromXml(lang,localeHandler)
    //
    // (getHandler arg is a function with two methods, one to
    // get XML from disk file, or from CSL, and another to store
    // locale data on CSL.locale or on state.locale, depending
    // on its source.)
    //
    // (note that getLocale must fail gracefully
    // if no locale of the exact lang in the first
    // arg is available.)
    //
    // (note that this will require that the hard-coded locale
    // be recorded on CSL.locale, and that ephemeral locale
    // overlay data bet recorded on state.locale, and that
    // getTerm implement overlay behavior.)
    //

    // Refactored locale resolution
    //
    // (1) Get three locale strings 
    //     -- default-locale (stripped)
    //     -- processor-locale
    //     -- en_US
    
    this.setStyleAttributes();

    this.opt.xclass = sys.xml.getAttributeValue(this.cslXml, "class");
    this.opt.styleID = this.sys.xml.getStyleId(this.cslXml);
    this.opt.styleName = this.sys.xml.getStyleId(this.cslXml, true);

    if (CSL.getSuppressJurisdictions) {
        this.opt.suppressJurisdictions = CSL.getSuppressJurisdictions(this.opt.styleID);
    }

    if (this.opt.version.slice(0,4) === "1.1m") {
        this.opt.development_extensions.static_statute_locator = true;
        this.opt.development_extensions.handle_parallel_articles = true;
        this.opt.development_extensions.main_title_from_short_title = true;
        this.opt.development_extensions.strict_page_numbers = true;
        this.opt.development_extensions.rtl_support = true;
        this.opt.development_extensions.expect_and_symbol_form = true;
        this.opt.development_extensions.require_explicit_legal_case_title_short = true;
    }
    // We seem to have two language specs flying around:
    //   this.opt["default-locale"], and this.opt.lang
    // Keeping them aligned for safety's sake, pending
    // eventual cleanup.
    if (lang) {
        lang = lang.replace("_", "-");
    }
    if (this.opt["default-locale"][0]) {
        this.opt["default-locale"][0] = this.opt["default-locale"][0].replace("_", "-");
    }
    if (lang && forceLang) {
        this.opt["default-locale"] = [lang];
    }
    if (lang && !forceLang && this.opt["default-locale"][0]) {
        lang = this.opt["default-locale"][0];
    }
    if (this.opt["default-locale"].length === 0) {
        if (!lang) {
            lang = "en-US";
        }
        this.opt["default-locale"].push("en-US");
    }
    if (!lang) {
        lang = this.opt["default-locale"][0];
    }
    langspec = CSL.localeResolve(lang);
    this.opt.lang = langspec.best;
    this.opt["default-locale"][0] = langspec.best;
    this.locale = {};
    if (!this.opt["default-locale-sort"]) {
        this.opt["default-locale-sort"] = this.opt["default-locale"][0];
    }
    this.localeConfigure(langspec);

    // Build skip-word regexp
    function makeRegExp(lst) {
        var lst = lst.slice();
        var ret = new RegExp( "((?:[?!:]*\\s+|-|^)(?:" + lst.join("|") + ")(?=[!?:]*\\s+|-|$))" );
        return ret;
    }
    this.locale[this.opt.lang].opts["skip-words-regexp"] = makeRegExp(this.locale[this.opt.lang].opts["skip-words"]);

    this.output.adjust = new CSL.Output.Queue.adjust(this.getOpt('punctuation-in-quote'));

    this.registry = new CSL.Registry(this);

    this.buildTokenLists("citation");

    this.buildTokenLists("bibliography");

    this.configureTokenLists();

    this.disambiguate = new CSL.Disambiguation(this);

    this.splice_delimiter = false;

    //
    // date parser
    //
    this.fun.dateparser = new CSL.DateParser();
    //
    // flip-flopper for inline markup
    //
    this.fun.flipflopper = new CSL.Util.FlipFlopper(this);
    //
    // utility functions for quotes
    //
    this.setCloseQuotesArray();
    //
    // configure ordinal numbers generator
    //
    this.fun.ordinalizer.init(this);
    //
    // configure long ordinal numbers generator
    //
    this.fun.long_ordinalizer.init(this);
    //
    // set up page mangler
    //
    this.fun.page_mangler = CSL.Util.PageRangeMangler.getFunction(this, "page");
    this.fun.year_mangler = CSL.Util.PageRangeMangler.getFunction(this, "year");

    this.setOutputFormat("html");
};

CSL.Engine.prototype.setCloseQuotesArray = function () {
    var ret;
    ret = [];
    ret.push(this.getTerm("close-quote"));
    ret.push(this.getTerm("close-inner-quote"));
    ret.push('"');
    ret.push("'");
    this.opt.close_quotes_array = ret;
};

CSL.makeBuilder = function (me) {
    function enterFunc (node) {
        CSL.XmlToToken.call(node, me, CSL.START);
    };
    function leaveFunc (node) {
        CSL.XmlToToken.call(node, me, CSL.END);
    };
    function singletonFunc (node) {
        CSL.XmlToToken.call(node, me, CSL.SINGLETON);
    };
    function buildStyle (node) {
        var starttag, origparent;
        if (me.sys.xml.numberofnodes(me.sys.xml.children(node))) {
            origparent = node;
            enterFunc(origparent);
            for (var i=0;i<me.sys.xml.numberofnodes(me.sys.xml.children(origparent));i+=1) {
                node = me.sys.xml.children(origparent)[i];
                if (me.sys.xml.nodename(node) === null) {
                    continue;
                }
                if (me.sys.xml.nodename(node) === "date") {
                    CSL.Util.fixDateNode.call(me, origparent, i, node)
                    node = me.sys.xml.children(origparent)[i];
                }
                buildStyle(node, enterFunc, leaveFunc, singletonFunc);
            }
            leaveFunc(origparent);
        } else {
            singletonFunc(node);
        }
    }
    return buildStyle;
};


CSL.Engine.prototype.buildTokenLists = function (area) {
    var builder = CSL.makeBuilder(this);
    var area_nodes;
    area_nodes = this.sys.xml.getNodesByName(this.cslXml, area);
    if (!this.sys.xml.getNodeValue(area_nodes)) {
        return;
    }
    this.build.area = area;
    var mynode = area_nodes[0];
    builder(mynode);
};


CSL.Engine.prototype.setStyleAttributes = function () {
    var dummy, attr, key, attributes, attrname;
    dummy = {};
    // Protect against DOM engines that deliver a top-level document
    // (needed for createElement) that does not contain our top-level node.
    // 
    // The string coercion on this.cslXml.tagName addresses a bizarre
    // condition on the top-level node in jsdom running under node.js, in which:
    //   (1) typeof this.cslXml.tagName === "undefined"; and
    //   (2) !this.cslXml.tagName === false
    // Coerced, it becomes an empty string.
    var cslXml = this.cslXml;

    // Some releases of citeproc-node call the top-level node "cslstyle":
    //   https://bitbucket.org/fbennett/citeproc-js/issue/165/citeproc-now-failing-to-run-on-nodejs
	var tagName = this.cslXml.tagName ? ("" + this.cslXml.tagName).toLowerCase() : "";
    if (tagName !== 'style' && tagName !== 'cslstyle') {
        if (this.cslXml.getElementsByTagName) {
            var cslXml = this.cslXml.getElementsByTagName('style')[0];
        }
    }
    dummy.name = this.sys.xml.nodename(cslXml);
    //
    // Xml: more of it
    //
    attributes = this.sys.xml.attributes(cslXml);
    for (attrname in attributes) {
        if (attributes.hasOwnProperty(attrname)) {
            // attr = attributes[key];
            CSL.Attributes[attrname].call(dummy, this, attributes[attrname]);
        }
    }
};

CSL.Engine.prototype.getTerm = function (term, form, plural, gender, mode, forceDefaultLocale) {
    if (term && term.match(/[A-Z]/) && term === term.toUpperCase()) {
        CSL.debug("Warning: term key is in uppercase form: "+term);
        term = term.toLowerCase();
    }
    var lang;
    if (forceDefaultLocale) {
        lang = this.opt["default-locale"][0];
    } else {
        lang = this.opt.lang;
    }
    var ret = CSL.Engine.getField(CSL.LOOSE, this.locale[lang].terms, term, form, plural, gender);
    // XXXXX Temporary, until locale term is deployed in CSL.
    if (!ret && term === "range-delimiter") {
        ret = "\u2013";
    }
    // XXXXX Not so good: can be neither strict nor tolerant
    if (typeof ret === "undefined") {
        if (mode === CSL.STRICT) {
            throw "Error in getTerm: term \"" + term + "\" does not exist.";
        } else if (mode === CSL.TOLERANT) {
            ret = "";
        }
    }
    if (ret) {
        this.tmp.cite_renders_content = true;
    }
    return ret;
};

CSL.Engine.prototype.getDate = function (form, forceDefaultLocale) {
    var lang;
    if (forceDefaultLocale) {
        lang = this.opt["default-locale"];
    } else {
        lang = this.opt.lang;
    }
    if (this.locale[lang].dates[form]) {
        return this.locale[lang].dates[form];
    } else {
        return false;
    }
};

CSL.Engine.prototype.getOpt = function (arg) {
    if ("undefined" !== typeof this.locale[this.opt.lang].opts[arg]) {
        return this.locale[this.opt.lang].opts[arg];
    } else {
        return false;
    }
};



CSL.Engine.prototype.getVariable = function (Item, varname, form, plural) {
    return CSL.Engine.getField(CSL.LOOSE, Item, varname, form, plural);
};

CSL.Engine.prototype.getDateNum = function (ItemField, partname) {
    if ("undefined" === typeof ItemField) {
        return 0;
    } else {
        return ItemField[partname];
    }
};

CSL.Engine.getField = function (mode, hash, term, form, plural, gender) {
    var ret, forms, f, pos, len, hashterm;
    ret = "";
    if ("undefined" === typeof hash[term]) {
        if (mode === CSL.STRICT) {
            throw "Error in getField: term \"" + term + "\" does not exist.";
        } else {
            return undefined;
        }
    }
    if (gender && hash[term][gender]) {
        hashterm = hash[term][gender];
    } else {
        hashterm = hash[term];
    }
    forms = [];
    if (form === "symbol") {
        forms = ["symbol", "short"];
    } else if (form === "verb-short") {
        forms = ["verb-short", "verb"];
    } else if (form !== "long") {
        forms = [form];
    }
    forms = forms.concat(["long"]);
    len = forms.length;
    for (pos = 0; pos < len; pos += 1) {
        f = forms[pos];
        if ("string" === typeof hashterm || "number" === typeof hashterm) {
            ret = hashterm;
        } else if ("undefined" !== typeof hashterm[f]) {
            if ("string" === typeof hashterm[f] || "number" === typeof hashterm[f]) {
                ret = hashterm[f];
            } else {
                if ("number" === typeof plural) {
                    ret = hashterm[f][plural];
                } else {
                    ret = hashterm[f][0];
                }
            }
            break;
        }
    }
    return ret;
};

CSL.Engine.prototype.configureTokenLists = function () {
    var dateparts_master, area, pos, token, dateparts, part, ppos, pppos, len, llen, lllen;
    //for each (var area in ["citation", "citation_sort", "bibliography","bibliography_sort"]) {
    dateparts_master = ["year", "month", "day"];
    len = CSL.AREAS.length;
    for (pos = 0; pos < len; pos += 1) {
        //var ret = [];
        area = CSL.AREAS[pos];
        llen = this[area].tokens.length - 1;
        for (ppos = llen; ppos > -1; ppos += -1) {
            token = this[area].tokens[ppos];
            //token.pos = ppos;
            //ret.push(token);
            if ("date" === token.name && CSL.END === token.tokentype) {
                dateparts = [];
            }
            if ("date-part" === token.name && token.strings.name) {
                lllen = dateparts_master.length;
                for (pppos = 0; pppos < lllen; pppos += 1) {
                    part = dateparts_master[pppos];
                    if (part === token.strings.name) {
                        dateparts.push(token.strings.name);
                    }
                }
            }
            if ("date" === token.name && CSL.START === token.tokentype) {
                dateparts.reverse();
                token.dateparts = dateparts;
            }
            token.next = (ppos + 1);
            //CSL.debug("setting: "+(pos+1)+" ("+token.name+")");
            if (token.name && CSL.Node[token.name].configure) {
                CSL.Node[token.name].configure.call(token, this, ppos);
            }
        }
    }
    this.version = CSL.version;
    return this.state;
};


CSL.Engine.prototype.retrieveItems = function (ids) {
    var ret, pos, len;
    ret = [];
    for (var i = 0, ilen = ids.length; i < ilen; i += 1) {
        ret.push(this.retrieveItem("" + ids[i]));
    }
    return ret;
};

CSL.ITERATION = 0;

// Wrapper for sys.retrieveItem supplied by calling application.
// Adds experimental fields embedded in the note field for
// style development trial and testing purposes.
CSL.Engine.prototype.retrieveItem = function (id) {
    var Item, m, pos, len, mm;

    if (this.opt.development_extensions.normalize_lang_keys_to_lowercase &&
        "boolean" === typeof this.opt.development_extensions.normalize_lang_keys_to_lowercase) {
        // This is a hack. Should properly be configured by a processor method after build.
        for (var i=0,ilen=this.opt["default-locale"].length; i<ilen; i+=1) {
            this.opt["default-locale"][i] = this.opt["default-locale"][i].toLowerCase();
        }
        for (var i=0,ilen=this.opt["locale-translit"].length; i<ilen; i+=1) {
            this.opt["locale-translit"][i] = this.opt["locale-translit"][i].toLowerCase();
        }
        for (var i=0,ilen=this.opt["locale-translat"].length; i<ilen; i+=1) {
            this.opt["locale-translat"][i] = this.opt["locale-translat"][i].toLowerCase();
        }
        this.opt.development_extensions.normalize_lang_keys_to_lowercase = 100;
    }

    //Zotero.debug("XXX === ITERATION " + CSL.ITERATION + " "+ id +" ===");
    CSL.ITERATION += 1;

    Item = this.sys.retrieveItem("" + id);
    // Optionally normalize keys to lowercase()
    if (this.opt.development_extensions.normalize_lang_keys_to_lowercase) {
        if (Item.multi) {
            if (Item.multi._keys) {
                for (var field in Item.multi._keys) {
                    for (var key in Item.multi._keys[field]) {
                        if (key !== key.toLowerCase()) {
                            Item.multi._keys[field][key.toLowerCase()] = Item.multi._keys[field][key];
                            delete Item.multi._keys[field][key];
                        }
                    }
                }
            }
            if (Item.multi.main) {
                for (var field in Item.multi.main) {
                    Item.multi.main[field] = Item.multi.main[field].toLowerCase();
                }
            }
        }
        for (var i=0, ilen=CSL.CREATORS.length; i>ilen; i+=1) {
            var ctype = CSL.CREATORS[i];
            if (Item[ctype] && Item[ctype].multi) {
                for (var j=0, jlen=Item[ctype].length; j<jlen; j+=1) {
                    var creator = Item[ctype][j];
                    if (creator.multi) {
                        if (creator.multi._key) {
                            for (var key in creator.multi._key) {
                                if (key !== key.toLowerCase()) {
                                    creator.multi._key[key.toLowerCase()] = creator.multi._key[key];
                                    delete creator.multi._key[key];
                                }
                            }
                        }
                        if (creator.multi.main) {
                            creator.multi.main = creator.multi.main.toLowerCase();
                        }
                    }
                }
            }
        }
    }
    // Mandatory data rescue
    // LEX HACK
    //if (Item.type === "bill" && Item.number && !Item.volume && Item.page) {
    //    Item.volume = Item.number;
    //    Item.number = undefined;
    //}
    if (Item.page) {
        Item["page-first"] = Item.page;
        var num = "" + Item.page;
        m = num.split(/\s*(?:&|,|-|\u2013)\s*/);
        if (m[0].slice(-1) !== "\\") {
            Item["page-first"] = m[0];
        }
    }
    // Optional development extensions
    if (this.opt.development_extensions.field_hack && Item.note) {
        //Zotero.debug("XXX   (1): "+Item.note);
        m = Item.note.match(CSL.NOTE_FIELDS_REGEXP);
        if (m) {
            //Zotero.debug("XXX   (2)");
            var names = {};
            for (pos = 0, len = m.length; pos < len; pos += 1) {
                mm = m[pos].match(CSL.NOTE_FIELD_REGEXP);
                //Zotero.debug("XXX   (3)");
                if (!Item[mm[1]] && CSL.DATE_VARIABLES.indexOf(mm[1]) > -1) {
                    Item[mm[1]] = {raw:mm[2]};
                } else if (!Item[mm[1]] && CSL.NAME_VARIABLES.indexOf(mm[1]) > -1) {
                    if (!Item[mm[1]]) {
                        Item[mm[1]] = [];
                    }
                    var lst = mm[2].split(/\s*\|\|\s*/);
                    if (lst.length === 1) {
                        Item[mm[1]].push({family:lst[0],isInstitution:true});
                    } else if (lst.length === 2) {
                        Item[mm[1]].push({family:lst[0],given:lst[1]});
                    }
                } else if (!Item[mm[1]] || mm[1] === "type") {
                    //Zotero.debug("XXX   (4)");
                    Item[mm[1]] = mm[2].replace(/^\s+/, "").replace(/\s+$/, "");
                }
                Item.note.replace(CSL.NOTE_FIELD_REGEXP, "");
            }
        }
    }
    // not including locator-date
    for (var i = 1, ilen = CSL.DATE_VARIABLES.length; i < ilen; i += 1) {
        var dateobj = Item[CSL.DATE_VARIABLES[i]];
        if (dateobj) {
            // raw date parsing is harmless, but can be disabled if desired
            if (this.opt.development_extensions.raw_date_parsing) {
                if (dateobj.raw) {
                    dateobj = this.fun.dateparser.parse(dateobj.raw);
                }
            }
            Item[CSL.DATE_VARIABLES[i]] = this.dateParseArray(dateobj);
        }
    }
    if (this.opt.development_extensions.static_statute_locator) {
        if (Item.type && ["bill","gazette","legislation","treaty"].indexOf(Item.type) > -1) {
            
            var varname;
            var elements = ["type", "title", "jurisdiction", "genre", "volume", "container-title"];
            var legislation_id = [];
            for (i = 0, ilen = elements.length; i < ilen; i += 1) {
                varname = elements[i];
				if (Item[varname]) {
					legislation_id.push(Item[varname]);
				}
			}
            elements = ["original-date", "issued"];
			for (i = 0, elements.length; i < ilen; i += 1) {
                varname = elements[i];
				if (Item[varname] && Item[varname].year) {
					var value = Item[varname].year;
					legislation_id.push(value);
					break;
				}
			}
			Item.legislation_id = legislation_id.join("::");
        }
    }
    // Add getAbbreviation() call for title-short and container-title-short
    if (!Item["title-short"]) {
        Item["title-short"] = Item.shortTitle;
    }
    // Add support for main_title_from_short_title
    if (this.opt.development_extensions.main_title_from_short_title) {
        Item["title-main"] = Item.title;
        Item["title-sub"] = false;
        if (Item.title && Item['title-short']) {
            var shortTitle = Item['title-short'];
            offset = shortTitle.length;
            if (Item.title.slice(0,offset) === shortTitle && Item.title.slice(offset).match(/^\s*:/)) {
                Item["title-main"] = Item.title.slice(0,offset).replace(/\s+$/,"");
                Item["title-sub"] = Item.title.slice(offset).replace(/^\s*:\s*/,"");
            }
        }
    }
    var isLegalType = ["legal_case","legislation","gazette","regulation"].indexOf(Item.type) > -1;
    if (!isLegalType && Item.title && this.sys.getAbbreviation) {
        var noHints = false;
        if (!Item.jurisdiction) {
            noHints = true;
        }
        var jurisdiction = this.transform.loadAbbreviation(Item.jurisdiction, "title", Item.title, Item.type, true);
        if (this.transform.abbrevs[jurisdiction].title) {
            if (this.transform.abbrevs[jurisdiction].title[Item.title]) {
                Item["title-short"] = this.transform.abbrevs[jurisdiction].title[Item.title];
            }
        }
    }
    Item["container-title-short"] = Item.journalAbbreviation;
    if (Item["container-title"] && this.sys.getAbbreviation) {
        var jurisdiction = this.transform.loadAbbreviation(Item.jurisdiction, "container-title", Item["container-title"]);
        if (this.transform.abbrevs[jurisdiction]["container-title"]) {
            if (this.transform.abbrevs[jurisdiction]["container-title"][Item["container-title"]]) {
                Item["container-title-short"] = this.transform.abbrevs[jurisdiction]["container-title"][Item["container-title"]];
            }
        }
    }
    return Item;
};

CSL.Engine.prototype.setOpt = function (token, name, value) {
    if (token.name === "style" || token.name === "cslstyle") {
        this.opt[name] = value;
    } else if (["citation", "bibliography"].indexOf(token.name) > -1) {
        this[token.name].opt[name] = value;
    } else if (["name-form", "name-delimiter", "names-delimiter"].indexOf(name) === -1) {
        token.strings[name] = value;
    }
};

CSL.Engine.prototype.fixOpt = function (token, name, localname) {
    if (["citation", "bibliography"].indexOf(token.name) > -1) {
        if (! this[token.name].opt[name] && "undefined" !== typeof this.opt[name]) {
            this[token.name].opt[name] = this.opt[name];
        }
    }
    if ("name" === token.name || "names" === token.name) {
        if ("undefined" === typeof token.strings[localname] && "undefined" !== typeof this[this.build.root].opt[name]) {
            token.strings[localname] = this[this.build.root].opt[name];
        }
    }
};
