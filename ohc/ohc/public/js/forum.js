$(function() {
    var checkA = document.getElementById('checkA');
    var isAnonymous = document.getElementById("isAnonymous");
    var minTopicDiv = document.getElementById("minTopicDiv");
    var mainTopicDiv = document.getElementById("mainTopicDiv");
    var followText = document.getElementById('txt1');
    var helpMessage = document.getElementById("helpMessage");
    var num = document.getElementById("num");
    var numSpan = document.getElementById("numSpan");
    var worldNum;
    var flag;
    isLog();
    worldNum = 1400 - followText.value.length;
    num.innerHTML = worldNum;
    numSpan.style.display = 'block';
    if (worldNum < 0) {
        num.style.color = 'red';
    }
    else {
        num.style.color = 'black';
    }
    followText.oninput = function() {
        numSpan.style.display = 'block';
        helpMessage.style.display = "none";
        worldNum = 1400 - followText.value.length;
        num.innerHTML = worldNum;
        if (worldNum <= 0) {
            num.style.color = 'red';
            followText.value = followText.value.substring(0, 1400);
            num.innerHTML = 1400 - followText.value.length;
        }
        else {
            num.style.color = 'black';
        }
    }
    followText.onpropertychange = function() {
        numSpan.style.display = 'block';
        helpMessage.style.display = "none";
        worldNum = 1400 - followText.value.length;
        num.innerHTML = worldNum;
        if (worldNum <= 0) {
            num.style.color = 'red';
            followText.value = followText.value.substring(0, 1400);
            num.innerHTML = 1400 - followText.value.length;
        } else {
            num.style.color = 'black';
        }
    }
    function isLog() {
        //alert(mainTopicDiv.offsetHeight<=500);
        if (document.getElementById("islog").value == '0') {
            document.getElementById("inputDiv").style.display = 'none';
            if (mainTopicDiv.offsetHeight <= 500) {
                minTopicDiv.style.height = (500 - mainTopicDiv.offsetHeight) + "px";
            }

        }
        else {
            document.getElementById("inputDiv").style.display = 'block';
            minTopicDiv.style.height = '0px';
        }
    }
    $("td>div>div").click(function() {
        $(this).parent().html(
                $(this).parent().parent().find("input").val()
                );
    });
}
)