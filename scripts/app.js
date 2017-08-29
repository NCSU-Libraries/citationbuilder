var app = {
    cite : '',style : '',form : '',

    init : function(){
        //citation select
        $('#cite-select select').change(function(e){
            app.cite = $(this).val();
            app.loadForm();
            c.readCookie();

            // set url
            app.setURL();

            // analytics
            app.logAnalytics();
        })

        // citation style select
        $('#cite-style-select select').change(function(e){
            app.style = $(this).val();
            app.loadForm();
            c.readCookie();

            // set URL
            app.setURL();

            // analytics
            app.logAnalytics();

        })

        app.setFormTypeFromUrl();
        app.checkFormOnLoad();
        app.activateCitationButtons();
        app.getCitation();
        app.handleCitationFields();
        app.activateContributorButtons();
        app.handleDatePicker();

        // add contrib button
        $('.add-contributor a').click(function(e){
            app.addContributor();

            e.preventDefault();
        })

    },

    checkFormOnLoad : function(){
        if(!app.cite){
            app.cite = $('#cite-select select').val();
        }
        if(!app.style){
            app.style = $('#cite-style-select select').val();
        }
        app.loadForm();
    },

    loadForm : function(){
        $('.form-parent').hide();
        $('.form-child').hide();
        $('#'+app.cite).show();
        $('.'+app.style).show();

        app.form = '#'+app.cite+' .'+app.style;
        app.activateCitationButtons();
        app.getCitation();
        app.handleCitationFields();
        app.handleDatePicker();
        app.clearForm();
    },

    showForm : function(){
        $('.citation-form').show();
    },

    hideForm : function(){
        $('.citation-form').hide();
    },

    clearForm : function(){

        if ($('form.citation-form[data-csl="'+app.style+'"] #clear-form').length==0) {
            var clearBtn = '<p><a href="#" id="clear-form" class="button tiny disabled">Clear form</a></p>';
            $('form.citation-form[data-csl="'+app.style+'"] input[type=submit]').parent().after(clearBtn);
            app.initClearFormButton();
        }

    },

    initClearFormButton : function(){
        // init clear form button
        $('form.citation-form[data-csl="'+app.style+'"] #clear-form').click(function(e){
            c.string = [];
            c.writeToCookie();

            // clear actual fields
            // var form = $('form.citation-form[data-csl="'+app.style+'"]:visible *');
            var form = $('form.citation-form *');
            $(form).each(function(){

                var type = $(this).attr('type');
                var tag = $(this).prop('tagName');
                if(type == 'text'){
                    $(this).val('');
                }
                if(tag == 'SELECT'){
                    $(this)[0].selectedIndex = 0;
                }
                // remove added contributors
                if($(this).hasClass('contributor-container')){
                    $(this).find('div.row.contributor').each(function(i){
                        if(i > 0){
                            $(this).remove();
                        }
                    })
                }
            });

            e.preventDefault();
        })
    },

    setFormTypeFromUrl : function(){
        if(window.location.hash){
            var pathArray = window.location.hash.split( '/' );
            app.cite = pathArray[1];
            app.style = pathArray[2];
        }

        // handle select dropdowns
        app.setDropdowns();
    },

    setDropdowns : function(){
        $('#cite-select select').val(app.cite);
        $('#cite-style-select select').val(app.style);
    },

    handleClearButton : function(){
        $('#clear-form').show();
    },

    activateCitationButtons : function(){
        //citation
        $('#'+app.cite+' .'+app.style+' .citation li a').click(function(e){
            $('#'+app.cite+' .'+app.style+' .citation li a').removeClass('active');
            $(this).addClass('active');
            app.citation = $(this).data('citation');
            app.handleCitationFields();

            e.preventDefault();
        })
    },

    getCitation : function(){
        $('#'+app.cite+' .'+app.style+' .citation li').each(function(){
            var elem = $(this).find('a');

            if($(elem).hasClass('active')){
                app.citation = $(elem).data('citation');
            }
        });
    },

    setURL : function(){
        if(app.cite && app.style){
            window.location.hash = '#/'+app.cite+'/'+app.style;
        }
    },

    handleCitationFields : function(){
        $('.citation-form .field').hide();
        $('.citation-form .'+app.citation).show();
    },

    activateContributorButtons : function(){

        $('.remove-contributor a').click(function(e){
            app.removeContributor($(this));

            if($(app.form +' .contributor').length > 1){
                $('.remove-contributor').css('opacity', '1');
            } else{
                $('.remove-contributor').css('opacity', '0.2');
            }

            e.preventDefault();
        })

        if($(app.form +' .contributor').length > 1){
            $('.remove-contributor').css('opacity', '1');
        } else{
            $('.remove-contributor').css('opacity', '0.2');
        }

        app.countContributor();
    },

    addContributor : function(){
        var contr_html = $(app.form+' .contributor-container .contributor')[0].outerHTML;
        $(app.form+' .contributor-container').append(contr_html);

        app.countContributor();
        app.activateContributorButtons();

    },

    removeContributor : function(elem){
        if($(app.form +' .contributor').length > 1){
            $(elem).parent().parent().parent().parent().remove();
            $('.remove-contributor').css('opacity', '1');
        } else{
            $('.remove-contributor').css('opacity', '0.2');
        }
    },

    countContributor : function(){
        if($('.remove-contributor').length < 2){
            $('.remove-contributor').hide();
            $('.add-contributor').removeClass('active');
        } else{
            $('.remove-contributor').show();
            $('.add-contributor').addClass('active');
        }
    },

    handleDatePicker : function(){
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

        $(app.form+' .fdatepicker').fdatepicker({
            onRender: function (date) {
                return date.valueOf() > now.valueOf() ? 'disabled' : '';
            }
        });
        $(app.form+' .fdatepicker-time').fdatepicker({
            format: 'hh:ii',
            pickTime: true,
            startView: 'day'
        });

    },

    logAnalytics : function(){
         // google analytics
            app.citeText = $('#cite-select select option:selected').text();
            app.citeStyleText = $('#cite-style-select select option:selected').text();
            ga('send', 'event', 'CitationBuilder', app.citeStyleText, app.citeText);
    }
}


$(function(){
    app.init();
})
