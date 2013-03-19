$(document).ready(function() {
    $(document).on("blockEditing", function(event, element, blockType){
        if (blockType != 'BootstrapThumbnailBlock') {
            return;
        }
        
        $(element)
            .find('.al-thumbnail-list')
            .inlinelist('start', { addValue: '{"operation": "add", "value": { "width": "span3" }}'     })
        ;
    });
    
    $(document).on("blockStopEditing", function(event, element, blockType){ 
        if (blockType != 'BootstrapThumbnailBlock') {
            return;
        }
                
        $(element)
            .find('.al-thumbnail-list')
            .inlinelist('stop')
        ;
    });
});
