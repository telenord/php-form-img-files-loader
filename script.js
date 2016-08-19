$(document).ready(function() { 
            var options = { 
        target:        '.sending',   // target element(s) to be updated with server response 
        error:  showResponse,  // pre-submit callback 
        success:       showResponse,  // post-submit callback 
 
        // other available options: 
        url:'../res_docs.php',        // override for form's 'action' attribute 
        type:'POST',        // 'get' or 'post', override for form's 'method' attribute 
        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
        //clearForm: true        // clear all form fields after successful submit 
        resetForm: true        // reset the form after successful submit 
 
        // $.ajax options can be used here too, for example: 
        //timeout:   3000 
    }; 
 
    // bind to the form's submit event 
    $('#form_docs').submit(function() { 
        // inside event callbacks 'this' is the DOM element so we first 
        // wrap it in a jQuery object and then invoke ajaxSubmit 
        $(this).ajaxSubmit(options); 
 
        // !!! Important !!! 
        // always return false to prevent standard browser submit and page navigation 
        return false; 
    }); 
}); 
 
// pre-submit callback 
function showRequest(formData, jqForm, options) { 
    // formData is an array; here we use $.param to convert it to a string to display it 
    // but the form plugin does this for you automatically when it submits the data 
    var queryString = $.param(formData); 
 
    // jqForm is a jQuery object encapsulating the form element.  To access the 
    // DOM element for the form do this: 
    // var formElement = jqForm[0]; 
 
    //alert('About to submit: \n\n' + queryString); 
 
    // here we could return false to prevent the form from being submitted; 
    // returning anything other than false will allow the form submit to continue 
    return true; 
} 
 
// post-submit callback 
function showResponse(responseText, statusText, xhr, $form)  { 
    // for normal html responses, the first argument to the success callback 
    // is the XMLHttpRequest object's responseText property 
 
    // if the ajaxSubmit method was passed an Options Object with the dataType 
    // property set to 'xml' then the first argument to the success callback 
    // is the XMLHttpRequest object's responseXML property 
 
    // if the ajaxSubmit method was passed an Options Object with the dataType 
    // property set to 'json' then the first argument to the success callback 
    // is the json data object returned by the server 
 
    // alert('status: ' + statusText + '\n\nresponseText: \n' + responseText + 
    //     '\n\nThe output div should have already been updated with the responseText.');
	//console.log(statusText);
    if(statusText=='success'){
    	// dataLayer.push({'event': 'senddocs'});
    	// yaCounter38204575.reachGoal('senddocs');
    	$('.docs_result').show().text('Спасибо! Скоро мы свяжемся с Вами!');
      	$('#form_docs input').val('');
        $('#form_docs textarea').val(''); 
    }
    else {$('.docs_result').show().text('Возникла ошибка. Попробуйте позже или отправьте документы на почту info@fox-taxi.ru');}
        
}