BX.ready(function() {
    BX.bindDelegate(
        document.body, 'click', {className: 'hierarchically__section'},
        function() {
            $(this).parent().find(".hierarchically__elements").slideToggle();s
        }
    );
});