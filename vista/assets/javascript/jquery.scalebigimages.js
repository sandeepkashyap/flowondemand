/**
 * Walk through images in a wrapper and make sure that they are not wider than 
 * the wrapper itself
 */
jQuery.fn.scaleBigImages = function() {
  return this.each(function() {
    var wrapper = $(this);
    var wrapper_width = wrapper.width();
    
    wrapper.find('img').each(function() {
      var image = $(this);
      var width = image.width();
      
      if(width > wrapper_width) {
        var scale = wrapper_width / width;
        
        image.css('height', Math.round(image.height() * scale));
        image.css('width', wrapper_width);
      } // if
    });
  });
};