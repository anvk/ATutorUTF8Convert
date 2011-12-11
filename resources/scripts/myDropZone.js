$(function() {
    BrowserDetect.init();
    
    // We cannot use $.bind() since jQuery does not normalize the native events.
    $('#dropzone').get(0).addEventListener('drop', upload, false);
    
    $('#dropzone').get(0).addEventListener('dragenter', function(event) { 
                $('#dropzone').css("background-color", "#ffc");
            }, false);
    
    $('#dropzone').get(0).addEventListener('dragexit', function(event) {
                $('#dropzone').css("background-color", "#fff");
            }, false);
    
    // need to add this one. Otherwise Chrome won't work for me
    $('#dropzone').get(0).addEventListener('dragleave', function(event) {
                $('#dropzone').css("background-color", "#fff");
            }, false);
    
    $('#dropzone').get(0).addEventListener('dragover', function(event) {
                event.preventDefault(); $('#dropzone').css("background-color", "#ffc");
            }, false);
    
    function upload(event) {
        $('#dropzone').empty();		// Clean the div elements since we are going to upload a fresh batch of files
        $('#resultConverstionTxt').empty();
        
        // My fix so that FireFox would not attempt to open a zip file when you drop the file in the area
        if(event.preventDefault) {
        	event.preventDefault();
		}
        
        var that = this;								// EXAMPLE WHERE WE NEED TO USE 'THAT' instead of 'this' in order to make variable accessible in PostBack onload.
        var data = event.dataTransfer;
		
		that.notSupportedFiles = '';					// Store array of files which are not ATutor language packs being dropped in
		
		var validFiles = []								// Let's store only files which are ATutor language packs
		
        // Create a row with a spinner for every good file we drag and dropped.
        var output = [];
        for (var i = 0; i < data.files.length; i++) {
        	var parts = data.files[i].name.split('.');
			var extension = parts[parts.length-1];
			
			// If file is not ATutor laug pack then just add a row into div but without a spinner
			if (extension.toUpperCase() !== 'ZIP') {	// ONLY 1 hardcoded value here. I do not want to start uploading nonsense. PHP has also those checks
				that.notSupportedFiles = that.notSupportedFiles + '<li><strong>' + data.files[i].name + '</strong> - Not ATutor lang pack</li>';
				
				output.push('<li><strong>', data.files[i].name, '</strong> - Not ATutor lang pack </li>');
				continue;
			}
        	
        	validFiles.push(data.files[i]);		// Add file to the array of the good files which will be processed
        	
        	// Add a row with a spinner for the file which will be processed
        	// Do not grab lastModifiedDate in FireFox browser since it is not supported there and it is a known bug
        	if (BrowserDetect.browser === 'Firefox') {
        		output.push('<li><strong>', data.files[i].name, '</strong> (', data.files[i].type || 'n/a', ') - ',
                  data.files[i].size, ' bytes'
                  , '<img src="resources/images/spinner.gif" width="16" height="16" /></li>');
        	} else {
 				localeDate = data.files[i].lastModifiedDate.toLocaleDateString();
 				output.push('<li><strong>', data.files[i].name, '</strong> (', data.files[i].type || 'n/a', ') - ',
                  data.files[i].size, ' bytes, last modified: '
                  , data.files[i].lastModifiedDate.toLocaleDateString()
                  , '<img src="resources/images/spinner.gif" width="16" height="16" /></li>');
        	}
        }
        
        that.notSupportedFiles = '<ul>' + that.notSupportedFiles + '</ul>';						// Format list of not supported files
        
        $('#dropzone').append($('<ul>' + output.join('') + '</ul>'));							// Update div with all the files in upload progress
        
        // Building request for multiple file upload.
        var xhr = new XMLHttpRequest()
        
		var formData = new FormData();
		for (var i = 0; i < validFiles.length; i++) {
			var file = validFiles[i];
			formData.append('user_file[]', file);
		}          

		xhr.open('POST', 'lib/doUpload.php', true);
		xhr.send(formData);
		
		// Once all files are got uploaded and converted
		xhr.onload = function(event) {
    		
    		$('#dropzone').css('background-color', '#fff');										// Make background back to white
    		
    		$('#dropzone').empty();																// Show "Drop ATutor files here
    		$('#dropzone').append($('<div id="dropzone_text">Drop Atutor files here</div>'));
    		
    		
    		$('#resultConverstionTxt').html(xhr.responseText + that.notSupportedFiles);
		}; 
        
        event.stopPropagation();
    }
});