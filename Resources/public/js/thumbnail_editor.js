$(document).ready(function() {
    $(document).on("blockEditing", function(event, element){
        if (element.attr('data-type') != 'BootstrapThumbnailsBlock') {
            return;
        }
        
        element.inlinelist('start', { addValue: '{"operation": "add", "value": { "type": "BootstrapThumbnailBlock" }}'     });
    });
    
    $(document).on("blockStopEditing", function(event, element){ 
        if (element.attr('data-type') != 'BootstrapThumbnailsBlock') {
            return;
        }
                
        element.inlinelist('stop');
    });
});
