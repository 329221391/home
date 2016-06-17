var listTable = new Object;
listTable.query = "query";
listTable.filter = new Object;
listTable.url = edit_url;
/**
 * 创建一个可编辑区
 */
listTable.edit = function (obj, act, id, url) {
    if (url) {
        listTable.url = url;
    }
    var tag = obj.firstChild.tagName;
    if (typeof(tag) != "undefined" && tag.toLowerCase() == "input") {
        return;
    }
    /* 保存原始的内容 */
    var org = obj.innerHTML;
    var val = obj.innerText.trim();//add trim,otherwise has one space
    /* 创建一个输入框 */
    var txt = document.createElement("INPUT");
    txt.className = 'form-control';
    if (act == 'password') {
        txt.value = '';
    } else {
        txt.value = (val == 'N/A') ? '' : val;
    }
    txt.style.width = (obj.offsetWidth + 30) + "px";
    txt.style.width = "90%";
    /* 隐藏对象中的内容，并将输入框加入到对象中 */
    obj.innerHTML = "";
    obj.appendChild(txt);
    txt.focus();
    /* 编辑区输入事件处理函数 */
    txt.onkeypress = function (e) {
        var evt = Utils.fixEvent(e);
        var obj = Utils.srcElement(e);
        if (evt.keyCode == 13) {
            obj.blur();
            return false;
        }
        if (evt.keyCode == 27) {
            obj.parentNode.innerHTML = org;
        }
    }
    /* 编辑区失去焦点的处理函数 */
    txt.onblur = function (e) {
        if (txt.value.length > 0) {
            $.getJSON(listTable.url + "&field=" + act + "&val=" + encodeURIComponent(txt.value) + "&id=" + id, function (res) {
                if (res.error > 0) {
                    alert(res.message);
                }
                obj.innerHTML = (res.error == 0) ? res.content : org;
                var options = {
                    animation: true,
                    delay: {"show": 500, "hide": 500},
                    title: '更新成功',
                    trigger: 'manual',
                    template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content">更新成功</div></div>'
                }
                $(obj).tooltip(options);
                $(obj).tooltip('show');
                setTimeout(function () {
                    $(obj).tooltip('hide');
                }, 600);
            });
        }
        else {
            obj.innerHTML = org;
        }
    }
}
/**
 * 切换状态
 */
listTable.toggle = function (obj, act, id) {
    var val = (obj.src.match('212.png')) ? 211 : 212;
    $.getJSON(listTable.url + "&field=" + act + "&val=" + val + "&id=" + id, function (res) {
        if (res.error == 0) {
            obj.src = 'images/' + res.content + '.png';
        }
    });
}
listTable.change_bg = function (str) {
    $("#" + str).css("color", "red");
    $("#" + str).onmouseout = function (e) {
        $("#" + str).css("color", "black");
    }
}
 
 
 
 
 
 