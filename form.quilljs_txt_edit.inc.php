<?php
/*————————————————————————————————————————————————————————————————————
 * 
	   DISPLAYS QUILLJS TEXTEDITOR
 * 
  ————————————————————————————————————————————————————————————————————*/
?>
<link href="quilljs/quill.snow.css" rel="stylesheet"> 
<!--<link href="quilljs/styles.css" rel="stylesheet">--> 
<link href="../css/style.css" rel="stylesheet"> 
		<script src="quilljs/quill.js"></script>
	
                <div class="editor-wrapper"main_form>
                    <div id="<?php echo $var; ?>_editor-container">
                    </div>
                </div>
	    <textarea id="<?php echo $var; ?>_textarea" style="display:none;" name="<?php echo $var; ?>"></textarea>
	    <script id="rendered-js">
	   
	    var quill_<?php echo $var; ?> = new Quill('#<?php echo $var; ?>_editor-container', {
	    modules: {
            toolbar: [
                ['bold', 'italic', 'underline'], // toggled buttons
                ['blockquote', 'code-block'],
                [{'header': 1}, {'header': 2}], // custom button values
                [{'list': 'ordered'}, {'list': 'bullet'}],
           //     [{'script': 'sub'}, {'script': 'super'}],
                // superscript/subscript
                [{'indent': '-1'}, {'indent': '+1'}], // outdent/indent
                [{'direction': 'rtl'}], // text direction

                [{'size': ['small', false, 'large', 'huge']}],
                // custom dropdown
                [{'header': [1, 2, 3, 4, 5, 6, false]}],
                [{'color': []}, {'background': []}],
                // dropdown with defaults from theme
                [{'font': []}],
                [{'align': []}],
                ['clean'],
                ['image', 'code-block']]},
        placeholder: 'Your text here ...',
        theme: 'snow' // or 'bubble'
    });
    //# sourceURL=pen.js



    quill_<?php echo $var; ?>.clipboard.dangerouslyPasteHTML('<?php echo $value; ?>')



    var form =  document.getElementById("main_form");
    
      if (typeof event == 'undefined') { 
	var event = new Event('_submit_');
	event.initEvent('_submit_', true, true);
	 }
    
    form.onsubmit = function (ev) {
	
	dispatchEvent(event);
        event.preventDefault();
        event.stopPropagation();
      
       //return false;
    };
    
    addEventListener('_submit_', call_<?php echo $var; ?>_quill, false);
    function call_<?php echo $var; ?>_quill() 
    {  
	var quillHtml = quill_<?php echo $var; ?>.root.innerHTML.trim();
	// alert(quillHtml)
        document.getElementById("<?php echo $var; ?>_textarea").value = quillHtml; 
    }
        </script>