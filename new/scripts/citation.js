var cite = {

	citeprocSys : {
	    // Given a language tag in RFC-4646 form, this method retrieves the
	    // locale definition file.  This method must return a valid *serialized*
	    // CSL locale. (In other words, an blob of XML as an unparsed string.  The
	    // processor will fail on a native XML object or buffer).
	    retrieveLocale: function (lang){
	        var xhr = new XMLHttpRequest();
	        xhr.open('GET', 'citeproc-js/locales-' + lang + '.xml', false);
	        xhr.send(null);
	        return xhr.responseText;
	    },

	    // Given an identifier, this retrieves one citation item.  This method
	    // must return a valid CSL-JSON object.
	    retrieveItem: function(id){
	        return cite.citations[id];
	    }
	},

	init : function(json, csl){
		cite.csl = csl;
		cite.citations = json;

		return cite.renderBib();
	},

	getProcessor : function(styleID) {
	    // Get the CSL style as a serialized string of XML
	    var xhr = new XMLHttpRequest();
	    xhr.open('GET', 'csl/'+styleID+'.csl', false);
	    xhr.send(null);
	    var styleAsText = xhr.responseText;

	    // Instantiate and return the engine
	    var citeproc = new CSL.Engine(cite.citeprocSys, styleAsText);
	    return citeproc;
	},

	renderBib : function(){

        var citeproc = cite.getProcessor(cite.csl);
        var itemIDs = [];
        for (var key in cite.citations) {
            itemIDs.push(key);
        }
        citeproc.updateItems(itemIDs);
        var bibResult = citeproc.makeBibliography();

	    var bib = bibResult[1].join('\n');

	    if(bib.indexOf('CSL STYLE ERROR') > 0){
	    	return "You literally entered nothing into the form.";
	    } else{
	    	return bib;
	    }
	},

	capitalise : function(str){
	    return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
	}

}

