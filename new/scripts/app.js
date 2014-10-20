var app = {
    cite : '',style : '',form : '',

    init : function(){
        //citation select
        $('#cite-select select').change(function(e){
            app.cite = $(this).val();
            app.loadForm();
        })

        // citation style select
        $('#cite-style-select select').change(function(e){
            app.style = $(this).val();
            app.loadForm();
        })

        app.checkFormOnLoad();
        app.activateMediumButtons();
        app.getMedium();
        app.handleMediumFields();
        app.setFormType();
        app.activateContributorButtons();
        app.handleDatePicker();

        data.init();

    },

    checkFormOnLoad : function(){
        app.cite = $('#cite-select select').val();
        app.style = $('#cite-style-select select').val();
        app.loadForm();
    },

    loadForm : function(){
        $('.form-parent').hide();
        $('.form-child').hide();
        $('#'+app.cite).show();
        $('.'+app.style).show();
        app.form = '#'+app.cite+' .'+app.style;

        app.activateMediumButtons();
        app.getMedium();
        app.handleMediumFields();
        app.handleDatePicker();

    },

    showForm : function(){
        $('.citation-form').show();
    },

    hideForm : function(){
        $('.citation-form').hide();
    },

    setFormType : function(){
        $('.citation-form #form-type').val(app.cite);
    },

    activateMediumButtons : function(){
        //citation medium
        $('#'+app.cite+' .'+app.style+' .cite-medium li a').click(function(e){
            $('#'+app.cite+' .'+app.style+' .cite-medium li a').removeClass('active');
            $(this).addClass('active');
            app.medium = $(this).data('medium');
            app.handleMediumFields();

            e.preventDefault();
        })
    },

    getMedium : function(){
        $('#'+app.cite+' .'+app.style+' .cite-medium li').each(function(){
            var elem = $(this).find('a');

            if($(elem).hasClass('active')){
                app.medium = $(elem).data('medium');
            }
        });

    },

    handleMediumFields : function(){
        $('.citation-form .field').hide();
        $('.citation-form .'+app.medium).show();
    },

    activateContributorButtons : function(){
        $('.add-contributor a').click(function(e){
            app.addContributor();

            e.preventDefault();
        })

        app.countContributor();
    },

    addContributor : function(){
        $(app.form+' .contributor-container').append($('.contributor')[0].outerHTML);

        $('.remove-contributor a').click(function(e){
            app.removeContributor($(this));

            e.preventDefault();
        })

        app.countContributor();

    },

    removeContributor : function(elem){
        $(elem).parent().parent().parent().parent().remove();
        app.countContributor();
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

        $(app.form+' .fdatepicker').click(function(e){

            $(this).fdatepicker({
                onRender: function (date) {
                    return date.valueOf() > now.valueOf() ? 'disabled' : '';
                }
            });

            $(this).fdatepicker('show');
        })
    }
}


$(function(){
    app.init();
})