var app = {
    cite : '',style : '',

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

    },

    checkFormOnLoad : function(){
        app.cite = $('#cite-select select').val();
        app.style = $('#cite-style-select select').val();
        app.loadForm();
    },

    loadForm : function(){
        $('#form-container').load('includes/'+app.cite+'/'+app.style+'.html', function(){
            app.activateMediumButtons();
            app.getMedium();
            app.handleMediumFields();
            app.setFormType();
            app.activateContributorButtons();
            app.handleDatePicker();

            data.init();
        });
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
        $('.cite-medium li a').click(function(e){
            $('.cite-medium li a').removeClass('active');
            $(this).addClass('active');
            app.medium = $(this).data('medium');
            app.handleMediumFields();

            e.preventDefault();
        })
    },

    getMedium : function(){
        $('.cite-medium li').each(function(){
            if($(this).children().hasClass('active')){
                app.medium = $(this).children().data('medium');
            }
        })
    },

    handleMediumFields : function(){
        $('.citation-form .field').hide();
        $('.citation-form .'+app.medium).show();
    },

    activateContributorButtons : function(){
        $('#add-contributor a').click(function(e){
            app.addContributor();

            e.preventDefault();
        })

        app.countContributor();
    },

    addContributor : function(){
        $('#contributor-container').append($('.contributor')[0].outerHTML);

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
            $('#add-contributor').removeClass('active');
        } else{
            $('.remove-contributor').show();
            $('#add-contributor').addClass('active');
        }
    },

    handleDatePicker : function(){
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

        $('.fdatepicker').click(function(e){
            $('.fdatepicker').fdatepicker({
                onRender: function (date) {
                    return date.valueOf() > now.valueOf() ? 'disabled' : '';
                }
            });
            $('.fdatepicker').fdatepicker('place');
        })
    }
}


$(function(){
    app.init();
})