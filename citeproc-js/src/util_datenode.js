/*global CSL: true */

CSL.Util.fixDateNode = function (parent, pos, node) {
    var form, variable, datexml, subnode, partname, attr, val, prefix, suffix, children, key, subchildren, kkey, display, cslid;
    
    // Raise date flag, used to control inclusion of year-suffix key in sorts
    // This may be a little reckless: not sure what happens on no-date conditions
    this.build.date_key = true;

    form = this.sys.xml.getAttributeValue(node, "form");
    var lingo;
    if ("accessed" === this.sys.xml.getAttributeValue(node, "variable")) {
        lingo = this.opt["default-locale"][0];
    } else {
        lingo = this.sys.xml.getAttributeValue(node, "lingo");
    }

    if (!this.getDate(form)) {
        return parent;
    }

    var dateparts = this.sys.xml.getAttributeValue(node, "date-parts");

    variable = this.sys.xml.getAttributeValue(node, "variable");
    prefix = this.sys.xml.getAttributeValue(node, "prefix");
    suffix = this.sys.xml.getAttributeValue(node, "suffix");
    display = this.sys.xml.getAttributeValue(node, "display");
    cslid = this.sys.xml.getAttributeValue(node, "cslid");
    
    //
    // Xml: Copy a node
    //
    datexml = this.sys.xml.nodeCopy(this.getDate(form, ("accessed" === variable)));
    this.sys.xml.setAttribute(datexml, 'lingo', this.opt.lang);
    this.sys.xml.setAttribute(datexml, 'form', form);
    this.sys.xml.setAttribute(datexml, 'date-parts', dateparts);
    this.sys.xml.setAttribute(datexml, "cslid", cslid);
    //
    // Xml: Set attribute
    //
    this.sys.xml.setAttribute(datexml, 'variable', variable);
    //
    // Xml: Set flag
    //
    if (prefix) {
        //
        // Xml: Set attribute
        //
        this.sys.xml.setAttribute(datexml, "prefix", prefix);
    }
    if (suffix) {
        //
        // Xml: Set attribute
        //
        this.sys.xml.setAttribute(datexml, "suffix", suffix);
    }
    if (display) {
        //
        // Xml: Set attribute
        //
        this.sys.xml.setAttribute(datexml, "display", display);
    }
    //
    // Step through any date-part children of the layout date node,
    // and lay their attributes onto the corresponding node in the
    // locale template node copy.
    //
    // tests: language_BaseLocale
    // tests: date_LocalizedTextInStyleLocaleWithTextCase
    // 
    children = this.sys.xml.children(node);
    for (key in children) {
        // Ah. Object children is XML. Can pass it along,
        // but hasOwnProperty() won't work on it.
        //if (children.hasOwnProperty(key)) {
            // lie to jslint
            subnode = children[key];
            if ("date-part" === this.sys.xml.nodename(subnode)) {
                partname = this.sys.xml.getAttributeValue(subnode, "name");
                subchildren = this.sys.xml.attributes(subnode);
                for (attr in subchildren) {
                    if (subchildren.hasOwnProperty(attr)) {
                        if ("@name" === attr) {
                            continue;
                        }
                        if (lingo && lingo !== this.opt.lang) {
                            if (["@suffix", "@prefix", "@form"].indexOf(attr) > -1) {
                                continue;
                            }
                        }
                        val = subchildren[attr];
                        this.sys.xml.setAttributeOnNodeIdentifiedByNameAttribute(datexml, "date-part", partname, attr, val);
                    }
                }
            }
            //}
    }
    
    if ("year" === this.sys.xml.getAttributeValue(node, "date-parts")) {

        //
        // Xml: Find one node by attribute and delete
        //
        this.sys.xml.deleteNodeByNameAttribute(datexml, 'month');
        //
        // Xml: Find one node by attribute and delete
        //
        this.sys.xml.deleteNodeByNameAttribute(datexml, 'day');
        
    } else if ("year-month" === this.sys.xml.getAttributeValue(node, "date-parts")) {
        //
        // Xml: Find one node by attribute and delete
        //
        this.sys.xml.deleteNodeByNameAttribute(datexml, 'day');
    }
    return this.sys.xml.insertChildNodeAfter(parent, node, pos, datexml);
};
