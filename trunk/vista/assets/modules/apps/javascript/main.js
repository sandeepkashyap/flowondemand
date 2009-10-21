App.apps = {
	controllers : {},	
	models      : {}
};

/**
 * Assignments controller behavior
 */
App.apps.controllers.application = {
  
  /**
   * Assignments index page
   */
	index : function() {
    	$(document).ready(function() {
    		$('#id_application').change(function() {
    			window.location = App.data.application_image_url + '/' + $(this).val();
    		});    		
		});
  	}
  
};