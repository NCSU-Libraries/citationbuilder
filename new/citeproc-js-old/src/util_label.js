/*global CSL: true */

CSL.evaluateLabel = function (node, state, Item, item) {
    var myterm;
    if ("locator" === node.strings.term) {
        if (item && item.label) {
            if (item.label === "sub verbo") {
                myterm = "sub-verbo";
            } else {
                myterm = item.label;
            }
        }
        if (!myterm) {
            myterm = "page";
        }
    } else {
        myterm = node.strings.term;
    }
    
    // Plurals detection.
    var plural = node.strings.plural;
    if (item && "number" === typeof item.force_pluralism) {
        plural = item.force_pluralism;
    } else if ("number" !== typeof plural) {
        if ("locator" === node.strings.term) {
            if (item && item.locator) {
                if (state.opt.development_extensions.locator_parsing_for_plurals) {
                    if (!state.tmp.shadow_numbers.locator) {
                        state.processNumber(false, item, "locator", Item.type);
                    }
                    plural = state.tmp.shadow_numbers.locator.plural;
                } else {
                    plural = CSL.evaluateStringPluralism(item.locator);
                }
            }
        } else if (["page", "page-first"].indexOf(node.variables[0]) > -1) {
            state.processNumber(false, Item, myterm, Item.type);
            plural = state.tmp.shadow_numbers[myterm].plural;
            myterm = state.tmp.shadow_numbers[myterm].label;
        } else {
            if (!state.tmp.shadow_numbers[myterm]) {
                state.processNumber(false, Item, myterm, Item.type);
            }
            plural = state.tmp.shadow_numbers[myterm].plural;
        }
        if (node.decorations && (state.opt.development_extensions.csl_reverse_lookup_support || state.sys.csl_reverse_lookup_support)) {
            node.decorations.reverse();
            node.decorations.push(["@showid","true", node.cslid]);
            node.decorations.reverse();
        }
    }
    return CSL.castLabel(state, node, myterm, plural, CSL.TOLERANT);
};

CSL.evaluateStringPluralism = function (str) {
    if (str) {
        var m = str.match(/(?:[0-9],\s*[0-9]|\s+and\s+|&|([0-9]+)\s*[\-\u2013]\s*([0-9]+))/);
        if (m && (!m[1] || parseInt(m[1], 10) < parseInt(m[2], 10))) {
            return 1;
        }
    }
    return 0;
};

CSL.castLabel = function (state, node, term, plural, mode) {
    var label_form = node.strings.form;
    if (state.tmp.group_context.value()[5]) {
        label_form = state.tmp.group_context.value()[5];
    }
    var ret = state.getTerm(term, label_form, plural, false, mode);
    // XXXXX Cut-and-paste code in multiple locations. This code block should be
    // collected in a function.
    // Tag: strip-periods-block
    if (state.tmp.strip_periods) {
        ret = ret.replace(/\./g, "");
    } else {
        for (var i = 0, ilen = node.decorations.length; i < ilen; i += 1) {
            if ("@strip-periods" === node.decorations[i][0] && "true" === node.decorations[i][1]) {
                ret = ret.replace(/\./g, "");
                break;
            }
        }
    }
    return ret;
};
