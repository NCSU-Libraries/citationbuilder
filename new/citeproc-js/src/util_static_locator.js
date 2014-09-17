CSL.Engine.prototype.remapSectionVariable = function (inputList) {
    for (var i = 0, ilen = inputList.length; i < ilen; i += 1) {
        var Item = inputList[i][0];
        var item = inputList[i][1];
        var section_label_count = 0;
        var later_label = false;
        var value = false;
        if (["bill","gazette","legislation","treaty"].indexOf(Item.type) > -1) {
            
            // Extract and assemble
            item.force_pluralism = 0;
            if (!item.label) {
                item.label = "page"
            }
            var loci = ["section","","",""];
            var split;
            if (this.opt.development_extensions.static_statute_locator && Item.section) {
                // If section starts with a term, set that in sec_label, otherwise set "section" there
                // Set remainder of section value in sec_label
                splt = Item.section.replace(/^\s+/,"").replace(/\s+$/, "").split(/\s+/);
                if (CSL.STATUTE_SUBDIV_STRINGS[splt[0]]) {
                    loci[0] = " " + splt[0] + " ";
                    loci[1] = splt.slice(1).join(" ");
                } else {
                    loci[0] = " sec. ";
                    loci[1] = splt.slice(0).join(" ");
                }
            } else {
                if (this.opt.development_extensions.clobber_locator_if_no_statute_section) {
                    item.locator = undefined;
                    item.label = undefined;
                }
            }

            if (item.locator) {
                
                // If locator starts with a term, set that in loc_label, otherwise set item.label
                // Set remainder of locator value in loc_locator
                var splt = item.locator.replace(/^\s+/,"").replace(/\s+$/, "").split(/\s+/);
                if (CSL.STATUTE_SUBDIV_STRINGS[splt[0]]) {
                    loci[2] = " " + splt[0] + " ";
                    loci[3] = splt.slice(1).join(" ");
                } else if (item.label) {
                    loci[2] = " " + CSL.STATUTE_SUBDIV_STRINGS_REVERSE[item.label] + " ";
                    loci[3] = splt.slice(0).join(" ");
                } else {
                    loci[3] = splt.join(" ")
                }
                if (loci[3] && loci[3].slice(0,1) === "&") {
                    loci[3] = " " + loci[3];
                }
            }
            
            // Normalize

            if (!loci[2]) {
                // If not loc_label, set loc_label to sec_label
                loci[2] = loci[0];
            }
            if (loci[3]) {
                if (loci[3].match(/^[^0-9a-zA-Z]/)) {
                    // If loc_locator and loc_locator starts with non-[a-zA-Z0-9], set loc_label to nil
                    var loclst = loci[3].split(/\s+/);
                    if (loci[0] === loci[2] && loclst[1] && !CSL.STATUTE_SUBDIV_STRINGS[loclst[1].replace(/\s+/, "").replace(/\s+/, "")]) {
                        item.force_pluralism = 1;
                    }
                    loci[2] = "";
                }
            } else {
                loci[2] = "";
            }
            if (!loci[1]) {
                // If not sec_locator, set sec_label to false
                loci[0] = "";
            }
            // Join list with ""
            var value = loci.join("");
            // Strip
            value = value.replace(/^\s+/,"").replace(/\s+$/, "");
            
            // Parse, store item.label, and evaluate for pluralism

            if (value) {
                splt = value.split(/\s+/);
                if (CSL.STATUTE_SUBDIV_STRINGS[splt[0]]) {
                    // Evaluate pluralism here
                    // (force plural if multiple first-occurring labels)
                    var has_other = false;
                    for (var j = splt.length - 2; j > 0; j += -2) {
                        if (splt[j] === splt[0]) {
                            item.force_pluralism = 1;
                            // Remove embedded labels that match top-level label
                            splt = splt.slice(0,j).concat(splt.slice(j + 1));
                        }
                    }
                    item.label = CSL.STATUTE_SUBDIV_STRINGS[splt[0]];
                    item.locator = splt.slice(1).join(" ");
                    if (item.force_pluralism === 0) {
                        delete item.force_pluralism;
                    }
                } else {
                    item.locator = splt.slice(0).join(" ");
                }
            }
        }
    }
}


CSL.Engine.prototype.setNumberLabels = function (Item) {
    if (Item.number
        && ["bill", "gazette", "legislation", "treaty"].indexOf(Item.type) > -1
        && this.opt.development_extensions.static_statute_locator
        && !this.tmp.shadow_numbers["number"]) {
        
        this.tmp.shadow_numbers["number"] = {};
        this.tmp.shadow_numbers["number"].values = [];
        this.tmp.shadow_numbers["number"].plural = 0;
        this.tmp.shadow_numbers["number"].numeric = false;
        this.tmp.shadow_numbers["number"].label = false;
        
        // Labels embedded in number variable
        var value = "" + Item.number;
        value = value.replace("\\", "", "g");
        // Get first word, parse out labels only if it parses
        var firstword = value.split(/\s/)[0];
        var firstlabel = CSL.STATUTE_SUBDIV_STRINGS[firstword];
        if (firstlabel) {
            // Get list and match
            var m = value.match(CSL.STATUTE_SUBDIV_GROUPED_REGEX);
            var splt = value.split(CSL.STATUTE_SUBDIV_PLAIN_REGEX);
            if (splt.length > 1) {
                // Convert matches to localized form
                var lst = [];
                for (var j=1, jlen=splt.length; j < jlen; j += 1) {
                    var subdiv = m[j - 1].replace(/^\s*/, "");
                    //subdiv = this.getTerm(CSL.STATUTE_SUBDIV_STRINGS[subdiv]);
                    lst.push(subdiv.replace("sec.", "Sec.").replace("ch.", "Ch."));
                    lst.push(splt[j].replace(/\s*$/, "").replace(/^\s*/, ""));
                }
                // Preemptively save to shadow_numbers
                value = lst.join(" ");
            } else {
                value = splt[0];
            }
            this.tmp.shadow_numbers["number"].values.push(["Blob", value, false]);
            this.tmp.shadow_numbers["number"].numeric = false;
        } else {
            this.tmp.shadow_numbers["number"].values.push(["Blob", value, false]);
            this.tmp.shadow_numbers["number"].numeric = true;
        }
    }
}
