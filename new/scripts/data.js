var data = {

    init: function(){
        var activeForm = $('select[name*="citation-style"]').val();

        $('.citation-form').submit(function(e){
            data.activateForm(e.currentTarget);
            e.preventDefault();
        })
    },

    activateForm : function(form){
        data.form = form;
        data.formData = $(form).serializeArray();
        data.csl = $(form).data('csl');
        data.json = data.buildJson();

        $('#citation-content').html(cite.init(data.json, data.csl));
        $('#citation-modal').foundation('reveal', 'open');
    },

    buildJson : function(){

        form = data.form;
        var json = {"Item-1": {}};
        var contribObj = {};
        var contribAry = [];

        // collect contributor data
        $('.contributor:visible').each(function(i){
            var contrib = $(this).find('select[name*="contributor"]').val();
            var given = $(this).find('input[name*="given"]').val();
            var middle = $(this).find('input[name*="givenMiddle"]').val();
            var last = $(this).find('input[name*="family"]').val();

            //build contributor object
            if(given + middle + last != ''){
                if(contribAry.indexOf(contrib)){
                    json['Item-1'][contrib] = [{'given':given+' '+middle, 'family':last}];
                } else{
                    json['Item-1'][contrib].push({'given':given+' '+middle, 'family':last});
                }
            }

            contribAry.push(contrib);
        })

        for(var obj in data.formData) {
            json['Item-1']['id'] = 'Item-1';
            var name = data.formData[obj].name, val = data.formData[obj].value;

            if($('input[name*="'+name+'"]').parent().is(':visible') || $('select[name*="'+name+'"]').parent().is(':visible')){
                json['Item-1'][name] = val;

                // exception for fields who have mult values that need to be consolidated
                if(name == 'year'){json['Item-1']['issued'] = {'date-parts' : [[val]]};}
                if(name == 'accessed'){
                    var str = val.split('-');
                    json['Item-1'][name] = {'date-parts' : [[str[2],str[1],str[0]]]};
                }

                if(name == 'issued'){
                    var str = val.split('-');
                    json['Item-1'][name] = {'date-parts' : [[str[2],str[1],str[0]]]};
                    // json['Item-1'][name] = {'date-parts' : [[str[2]]]};
                }

                // month/year inputs
                if(name == 'issued-month' || name == 'issued-year'){
                    var month = $(data.form).find('select[name*="issued-month"]').val();
                    var year = $(data.form).find('input[name*="issued-year"]').val();

                    json['Item-1']['issued'] = {'date-parts' : [[year,month]]};
                }
            }
        }
        console.log(json);
        return json;
    }
}

$(function(){
    data.init();
})
