tinymce.init({selector:'textarea'});
$(document).ready(function(){
    $('#selectAllBoxes').click(function(event){
        if(this.checked) {
            $('.checkBoxes').each(function(){
                this.checked = true;
            });
        }
        else {
            $('.checkBoxes').each(function(){
                this.checked = false;
            });
        }
    });
    var div_box = "<div id='load-screen'><div id='loading'></div></div>";
    $("body").prepend(div_box);
    $('#load-screen').delay(700).fadeOut(600, function(){
        $(this).remove();
    });
});
function loadUsersOnline() {
    $.get("functions.php?onlineusers=result", function(data){
        $(".usersonline").text(data);
    });
}
setInterval(function(){
    loadUsersOnline();
},500);

// Normal JS
// function toggle(source) {
//   let checkboxes = document.getElementsByName('checkBoxArray[]');
//   for(var i=0, n=checkboxes.length;i<n;i++) {
//     checkboxes[i].checked = source.checked;
//   }
// }
