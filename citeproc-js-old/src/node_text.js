/*global CSL: true */

CSL.Node.text = {
    build: function (state, target) {
        var variable, func, form, plural, id, num, number, formatter, firstoutput, specialdelimiter, label, myname, names, name, year, suffix, term, dp, len, pos, n, m, value, flag;
        if (this.postponed_macro) {
            //func = function(state, Item) {
            //    print("XXX macro_name: "+this.postponed_macro);
            //}
            //this.execs.push(func);
            return CSL.expandMacro.call(state, this);
        } else {
            CSL.Util.substituteStart.call(this, state, target);
            // ...
            //
            // Do non-macro stuff
            
            // Guess again. this.variables is ephemeral, adjusted by an initial
            // function set on the node via @variable attribute setup.
            //variable = this.variables[0];
            
            if (!this.variables_real) {
                this.variables_real = [];
            }
            if (!this.variables) {
                this.variables = [];
            }

            form = "long";
            plural = 0;
            if (this.strings.form) {
                form = this.strings.form;
            }
            if (this.strings.plural) {
                plural = this.strings.plural;
            }
            if ("citation-number" === this.variables_real[0] || "year-suffix" === this.variables_real[0] || "citation-label" === this.variables_real[0]) {
                //
                // citation-number and year-suffix are super special,
                // because they are rangeables, and require a completely
                // different set of formatting parameters on the output
                // queue.
                if (this.variables_real[0] === "citation-number") {
                    if (state.build.root === "citation") {
                        state.opt.update_mode = CSL.NUMERIC;
                    }
                    if (state.build.root === "bibliography") {
                        state.opt.bib_mode = CSL.NUMERIC;
                    }
                    if (state.build.area === "bibliography_sort") {
                        state.opt.citation_number_sort_used = true;
                    }
                    //this.strings.is_rangeable = true;
                    if ("citation-number" === state[state.tmp.area].opt.collapse) {
                        this.range_prefix = state.getTerm("citation-range-delimiter");
                    }
                    this.successor_prefix = state[state.build.area].opt.layout_delimiter;
                    this.splice_prefix = state[state.build.area].opt.layout_delimiter;
                    func = function (state, Item, item) {
                        id = "" + Item.id;
                        if (!state.tmp.just_looking) {
                            if (item && item["author-only"]) {
                                state.tmp.element_trace.replace("do-not-suppress-me");
                                var reference_term = state.getTerm("reference", "long", "singular");
                                if ("undefined" === typeof reference_term) {
                                    reference_term = "reference";
                                }
                                term = CSL.Output.Formatters["capitalize-first"](state, reference_term);
                                state.output.append(term + " ");
                                state.tmp.last_element_trace = true;
                            }
                            if (item && item["suppress-author"]) {
                                if (state.tmp.last_element_trace) {
                                    state.tmp.element_trace.replace("suppress-me");
                                }
                                state.tmp.last_element_trace = false;
                            }
                            num = state.registry.registry[id].seq;
                            if (state.opt.citation_number_slug) {
                                state.output.append(state.opt.citation_number_slug, this);
                            } else {
                                number = new CSL.NumericBlob(num, this, Item.id);
                                state.output.append(number, "literal");
                            }
                        }
                    };
                    this.execs.push(func);
                } else if (this.variables_real[0] === "year-suffix") {

                    state.opt.has_year_suffix = true;

                    if (state[state.tmp.area].opt.collapse === "year-suffix-ranged") {
                        //this.range_prefix = "-";
                        this.range_prefix = state.getTerm("citation-range-delimiter");
                    }
                    this.successor_prefix = state[state.build.area].opt.layout_delimiter;
                    if (state[state.tmp.area].opt["year-suffix-delimiter"]) {
                        this.successor_prefix = state[state.build.area].opt["year-suffix-delimiter"];
                    }
                    func = function (state, Item) {
                        if (state.registry.registry[Item.id] && state.registry.registry[Item.id].disambig.year_suffix !== false && !state.tmp.just_looking) {
                            //state.output.append(state.registry.registry[Item.id].disambig[2],this);
                            num = parseInt(state.registry.registry[Item.id].disambig.year_suffix, 10);
                            number = new CSL.NumericBlob(num, this, Item.id);
                            formatter = new CSL.Util.Suffixator(CSL.SUFFIX_CHARS);
                            number.setFormatter(formatter);
                            state.output.append(number, "literal");
                            //
                            // don't ask :)
                            // obviously the variable naming scheme needs
                            // a little touching up
                            firstoutput = false;
                            len = state.tmp.group_context.mystack.length;
                            for (pos = 0; pos < len; pos += 1) {
                                flag = state.tmp.group_context.mystack[pos];
                                if (!flag[2] && (flag[1] || (!flag[1] && !flag[0]))) {
                                    firstoutput = true;
                                    break;
                                }
                            }
                            // firstoutput = state.tmp.group_context.mystack.indexOf(true) === -1;
                            specialdelimiter = state[state.tmp.area].opt["year-suffix-delimiter"];
                            if (firstoutput && specialdelimiter && !state.tmp.sort_key_flag) {
                                state.tmp.splice_delimiter = state[state.tmp.area].opt["year-suffix-delimiter"];
                            }
                        }
                    };
                    this.execs.push(func);
                } else if (this.variables_real[0] === "citation-label") {
                    state.opt.has_year_suffix = true;
                    func = function (state, Item) {
                        label = Item["citation-label"];
                        if (!label) {
                            label = state.getCitationLabel(Item);
                        }
                        if (!state.tmp.just_looking) {
                            suffix = "";
                            if (state.registry.registry[Item.id] && state.registry.registry[Item.id].disambig.year_suffix !== false) {
                                num = parseInt(state.registry.registry[Item.id].disambig.year_suffix, 10);
                                suffix = state.fun.suffixator.format(num);
                            }
                            label += suffix;
                        }
                        state.output.append(label, this);
                    };
                    this.execs.push(func);
                }
            } else {
                if (this.strings.term) {
                    
                    // printterm
                    func = function (state, Item, item) {
                        var gender = state.opt.gender[Item.type];
                        var term = this.strings.term;
                        term = state.getTerm(term, form, plural, gender, false, ("accessed" === term));
                        var myterm;
                        // if the term is not an empty string, say
                        // that we rendered a term
                        if (term !== "") {
                            flag = state.tmp.group_context.value();
                            //print("setting TERM to true [0]");
                            flag[0] = true;
                            state.tmp.group_context.replace(flag);
                        }
                        
                        // capitalize the first letter of a term, if it is the
                        // first thing rendered in a citation (or if it is
                        // being rendered immediately after terminal punctuation,
                        // I guess, actually).
                        if (!state.tmp.term_predecessor && !(state.opt["class"] === "in-text" && state.tmp.area === "citation")) {
                            myterm = CSL.Output.Formatters["capitalize-first"](state, term);
                            //CSL.debug("Capitalize");
                        } else {
                            myterm = term;
                        }
                        
                        // XXXXX Cut-and-paste code in multiple locations. This code block should be
                        // collected in a function.
                        // Tag: strip-periods-block
                        if (state.tmp.strip_periods) {
                            myterm = myterm.replace(/\./g, "");
                        } else {
                            for (var i = 0, ilen = this.decorations.length; i < ilen; i += 1) {
                                if ("@strip-periods" === this.decorations[i][0] && "true" === this.decorations[i][1]) {
                                    myterm = myterm.replace(/\./g, "");
                                    break;
                                }
                            }
                        }
                        state.output.append(myterm, this);
                    };
                    this.execs.push(func);
                    state.build.term = false;
                    state.build.form = false;
                    state.build.plural = false;
                } else if (this.variables_real.length) {
                    func = function (state, Item, item) {
                        var parallel_variable = this.variables[0];
                        
                        if (parallel_variable === "title" 
                            && (form === "short" || Item["title-short"])) { 
                            // Only if not main_title_from_short_title
                            parallel_variable = "title-short";
                        }
                        state.parallel.StartVariable(parallel_variable);
                        state.parallel.AppendToVariable(Item[parallel_variable],parallel_variable);
                    };
                    this.execs.push(func);

                    // plain string fields

                    // Deal with multi-fields and ordinary fields separately.
                    if (CSL.MULTI_FIELDS.indexOf(this.variables_real[0]) > -1) {
                        // multi-fields
                        // Initialize transform factory according to whether
                        // abbreviation is desired.
                        var abbrevfam = this.variables[0];
                        var abbrfall = false;
                        var altvar = false;
                        var transfall = false;
                        if (form === "short") {
                            if (this.variables_real[0] === "container-title") {
                                altvar = "journalAbbreviation";
                            } else if (this.variables_real[0] === "title") {
                                altvar = "title-short";
                            }
                        } else {
                            abbrevfam = false;
                        }
                        if (state.build.extension) {
                            // multi-fields for sorting get a sort transform,
                            // (abbreviated if the short form was selected)
                            transfall = true;
                        } else {
                            transfall = true;
                            abbrfall = true;
						}

                        func = state.transform.getOutputFunction(this.variables, abbrevfam, abbrfall, altvar, transfall);
                    } else {
                        // ordinary fields
                        if (CSL.CITE_FIELDS.indexOf(this.variables_real[0]) > -1) {
                            // per-cite fields are read from item, rather than Item
                            func = function (state, Item, item) {
                                if (item && item[this.variables[0]]) {
                                    // Code copied to page variable as well; both
                                    // become cs:number in MLZ extended schema
                                    var value = "" + item[this.variables[0]];
                                    value = value.replace(/([^\\])--*/g,"$1"+state.getTerm("page-range-delimiter"));
                                    value = value.replace(/\\-/g,"-");
                                    // true is for non-suppression of periods
                                    state.output.append(value, this, false, false, true);
                                    if (this.variables[0] === "locator-revision") { 
                                        state.tmp.done_vars.push("locator-revision");
                                    }
                                }
                            };
                        } else if (this.variables_real[0] === "page-first") {
                            // page-first is a virtual field, consisting
                            // of the front slice of page.
                            func = function (state, Item) {
                                var idx, value;
                                value = state.getVariable(Item, "page-first", form);
                                if (value) {
                                    value = value.replace("\\", "");
                                    state.output.append(value, this, false, false, true);
                                }
                            };
                        } else  if (this.variables_real[0] === "page") {
                            // page gets mangled with the correct collapsing
                            // algorithm
                            func = function (state, Item) {
                                var value = state.getVariable(Item, "page", form);
                                if (value) {
                                    value = ""+value;
                                    value = value.replace(/([^\\])--*/g,"$1"+state.getTerm("page-range-delimiter"));
                                    value = value.replace(/\\-/g,"-");
                                    value = state.fun.page_mangler(value);
                                    // true is for non-suppression of periods
                                    state.output.append(value, this, false, false, true);
                                }
                            };
                        } else if (this.variables_real[0] === "volume") {
                            func = function (state, Item) {
                                if (this.variables[0]) {
                                    var value = state.getVariable(Item, this.variables[0], form);
                                    if (value) {
                                        state.output.append(value, this);
                                    }
                                }
                            };
                        } else if (["URL", "DOI"].indexOf(this.variables_real[0]) > -1) {
                            func = function (state, Item) {
                                var value;
                                if (this.variables[0]) {
                                    value = state.getVariable(Item, this.variables[0], form);
                                    if (value) {
                                        // true is for non-suppression of periods
                                        if (state.opt.development_extensions.wrap_url_and_doi) {
                                            if (!this.decorations.length || this.decorations[0][0] !== "@" + this.variables[0]) {
                                                this.decorations = [["@" + this.variables[0], "true"]].concat(this.decorations);
                                            }
                                        } else {
                                            if (this.decorations.length && this.decorations[0][0] === "@" + this.variables[0]) {
                                                this.decorations = this.decorations.slice(1);
                                            }
                                        }
                                        state.output.append(value, this, false, false, true);
                                    }
                                }
                            };
                        } else if (this.variables_real[0] === "section") {
                            // Sections for statutes are special. This is an uncommon
                            // variable, so we save the cost of the runtime check
                            // unless it's being used.
                            func = function (state, Item) {
                                var value;
                                value = state.getVariable(Item, this.variables[0], form);
                                if (value) {
                                    state.output.append(value, this);
                                }
                            };
                        } else if (this.variables_real[0] === "hereinafter") {
                            func = function (state, Item) {
                                var value = state.transform.abbrevs["default"]["hereinafter"][Item.id];
                                if (value) {
                                    state.output.append(value, this);
                                    state.tmp.group_context.value()[2] = true;
                                }
                            }
                        } else {
                            // anything left over just gets output in the normal way.
                            func = function (state, Item) {
                                var value;
                                if (this.variables[0]) {
                                    value = state.getVariable(Item, this.variables[0], form);
                                    if (value) {
                                        value = "" + value;
                                        value = value.replace("\\", "", "g");
                                        state.output.append(value, this);
                                    }
                                }
                            };
                        }
                    }
                    this.execs.push(func);
                    func = function (state, Item) {
                        state.parallel.CloseVariable("text");
                    };
                    this.execs.push(func);
                } else if (this.strings.value) {
                    // for the text value attribute.
                    func = function (state, Item) {
                        var flag;
                        flag = state.tmp.group_context.value();
                        // say that we rendered a term
                        //print("  setting [0] to true based on: " + this.strings.value);
                        flag[0] = true;
                        state.tmp.group_context.replace(flag);
                        state.output.append(this.strings.value, this);
                    };
                    this.execs.push(func);
                    // otherwise no output
                }
            }
            target.push(this);
            CSL.Util.substituteEnd.call(this, state, target);
        }
    }
};


