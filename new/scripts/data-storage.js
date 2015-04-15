var c = {
    string : [], fromstring : [],
    init : function(){
        c.readCookie();
    },

    readCookie : function(){
        c.initCookie();
        var cookie = document.cookie.split('; ');
        for(i=0;i<cookie.length-1;i++){
            var name = cookie[i].split('=');
            if(name[0] == 'citationbuilder'){
                var vals = name[1];
                c.fromstring = vals.split(',');
            }
        }

        c.writeFromCookie();
    },

    initCookie : function(){
        $('input:visible').blur(function(){
            // build ary of data to save
            var name = $(this).attr('name');
            var value = $(this).val();

            if( $.inArray(name+'|'+value, c.string) == -1){
                c.string.push(name+'|'+value);
            } else{
                var index = $.inArray(name+'|'+value, c.string);
                c.string.splice(index, 1);
                c.string.push(name+'|'+value);
            }

            c.writeToCookie();
        })
    },

    writeFromCookie : function(){
        var ary = c.fromstring;
        for(i=0;i<ary.length-1;i++){
            var split = ary[i].split('|');
            $('input[name='+split[0]+']').val(split[1]);
        }
    },

    writeToCookie : function(){
        var tostring = c.string.toString();
        document.cookie="citationbuilder="+tostring+"; Path=/citationbuilder; max-age=86400"; //expire in 24 hours
    }
}

$(function(){
    c.init();
})