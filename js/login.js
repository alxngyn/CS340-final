function checkLogin(){
    username = document.getElementById('userName').value;
    password = document.getElementById('password').value;
    var xhttp = new XMLHttpRequest();
    // since were running async, we need to define wat to do with the result
    xhttp.onreadystatechange = function() {
      if (xhttp.readyState == 4 && xhttp.status == 200) {
          if(xhttp.responseText == "<h5>Successfully logged in</h5>"){
                location.reload();
          }else{
                document.getElementById("ajaxResponse").innerHTML = xhttp.responseText;
            }
      }
    };
    // setup POST w/ data and send
    xhttp.open("POST", "checkLogin.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // parse the user ID to check for validity
    xhttp.send("username="+ username + "&password=" + password );

}