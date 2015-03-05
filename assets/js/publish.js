//var a;
function showDown(a,text)
{
    if(document.getElementById(a).value==text)
    {
        document.getElementById(a).value = "";
    }
}
function showUp(a,text)
{
    if(document.getElementById(a).value=="")
    {
        document.getElementById(a).value = text;
    }

}
FaceBook = {
    act:0,
    toggle:function() {
        if (FaceBook.act) {
            $('#facebook_fly').hide();
            FaceBook.act = 0;
        } else {
            $('#facebook_fly').show();
            FaceBook.act = 1;
        }
    }
}
function replaceHtm(){
 
document.getElementById('main').style.backgroundImage='url(/images/button.gif)';
document.getElementById('add').style.backgroundImage='url(/images/button.gif)';
document.getElementById('contacts').style.backgroundImage='url(/images/button.gif)';
document.getElementById("about").style.backgroundImage='url(/images/button_active.gif)';
document.getElementById("main_part").innerHTML = "Lorem ipsum dolor sit amet, consectetuer adipi \n\
scing elit.Mauris urna urna, varius et, interdum a, tincidunt quis, libero. Aenean sit amturpis. \n\
Maecenas hendrerit, massa ac laoreet iaculipede mnisl ullamcorper- massa, cosectetuer feipsum eget pede. \n\
Proin nunc. Donec nonummy, tellus er sodales enim, in tincidunmauris in odio. Massa ac laoreet iaculipede nisl \n\
ullamcor- permassa, ac con- sectetuer feipsum eget pede. Proin nunc. ";
}
function replaceHtmContact(){

document.getElementById('main').style.backgroundImage='url(/images/button.gif)';
document.getElementById('add').style.backgroundImage='url(/images/button.gif)';
document.getElementById('about').style.backgroundImage='url(/images/button.gif)';
document.getElementById("contacts").style.backgroundImage='url(/images/button_active.gif)';
document.getElementById("main_part").innerHTML = "Lorem ipsum dolor sit amet, consectetuer adipi \n\
scing elit.Mauris urna urna, varius et, interdum a, tincidunt quis, libero. Aenean sit amturpis. \n\
Maecenas hendrerit, massa ac laoreet iaculipede mnisl ullamcorper- massa, cosectetuer feipsum eget pede. \n\
Proin nunc. Donec nonummy, tellus er sodales enim, in tincidunmauris in odio. Massa ac laoreet iaculipede nisl \n\
ullamcor- permassa, ac con- sectetuer feipsum eget pede. Proin nunc. ";
}