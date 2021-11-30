function startup()
{
    // if page is reloaded, check for hash 
    if(window.location.hash!=="") { hashChanged();
    }
    
    jQuery(window).on('hashchange', hashChanged);
    jQuery(".close-button").on("click", closePopup);
}

function closePopup(e)
{
    // close the popup window
    jQuery(".popup").fadeOut();
    
    // reset hash
    window.location.hash="";
}

function hashChanged(e)
{
    
    // get the userid from hash
    var userId= window.location.hash.replace("#","");
    
    // if it is valid
    if(Number(userId)>0) {
        jQuery(".loader").fadeIn();
        
        jQuery.ajax(
            {
                type: "get",
                dataType: "json",
                url: ajaxURL,
                data: {action:"userDetail", userId:userId, nonce:wpNonce},
            }
        ).done(
            function (jsonData) {
                jQuery(".loader").fadeOut();
                
                if(jsonData.data.error) {
                    alert("Failed to load data..");
                }else{
                    fillData(jsonData);
                    jQuery(".popup").fadeIn();
                }
            }
        ).fail(
            function (jqXHR, st) {
                jQuery(".loader").fadeOut();
                alert("Failed to load data..");
            }
        );
    }
}

function fillData(jsonData)
{
    jQuery(".popup-name").text(jsonData.data.name);
    jQuery(".popup-email").text(jsonData.data.email);
    jQuery(".popup-phone").text(jsonData.data.phone);
    jQuery(".popup-website").text(jsonData.data.website);
    jQuery(".popup-company").text(jsonData.data.company.name);
    jQuery(".popup-address").html(
        "<a target=_blank href='https://www.google.com/maps/search/?api=1&query="+jsonData.data.address.geo.lat+","+jsonData.data.address.geo.lng+"'>"+
            jsonData.data.address.suite+", "+jsonData.data.address.street+", "+jsonData.data.address.city+
        "</a>"
    );
}


/* 
Add the jQuery library if it is not loaded
*/
if(typeof jQuery==='undefined') {
    var headTag = document.getElementsByTagName("head")[0];
    var jqueryTag = document.createElement('script');
    jqueryTag.type = 'text/javascript';
    jqueryTag.src = 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js';
    jqueryTag.onload = startup;
    headTag.appendChild(jqueryTag);
} else {
     startup();
}