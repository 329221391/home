// JavaScript Document
//滚动条在Y轴上的滚动距离

function getScrollTop(){
　　var scrollTop = 0, bodyScrollTop = 0, documentScrollTop = 0;
　　if(document.body){
　　　　bodyScrollTop = document.body.scrollTop;
　　}
　　if(document.documentElement){
　　　　documentScrollTop = document.documentElement.scrollTop;
　　}
　　scrollTop = (bodyScrollTop - documentScrollTop > 0) ? bodyScrollTop : documentScrollTop;
　　return scrollTop;
}

//文档的总高度

function getScrollHeight(){
　　var scrollHeight = 0, bodyScrollHeight = 0, documentScrollHeight = 0;
　　if(document.body){
　　　　bodyScrollHeight = document.body.scrollHeight;
　　}
　　if(document.documentElement){
　　　　documentScrollHeight = document.documentElement.scrollHeight;
　　}
　　scrollHeight = (bodyScrollHeight - documentScrollHeight > 0) ? bodyScrollHeight : documentScrollHeight;
　　return scrollHeight;
}

//浏览器视口的高度

function getWindowHeight(){
　　var windowHeight = 0;
　　if(document.compatMode == "CSS1Compat"){
　　　　windowHeight = document.documentElement.clientHeight;
　　}else{
　　　　windowHeight = document.body.clientHeight;
　　}
　　return windowHeight;
}

window.onscroll = function(){
　　if(getScrollTop() + getWindowHeight() == getScrollHeight()){
　　　　alert("you are in the bottom!");
　　}
　　if(getScrollTop() ==0){
　　　　alert("you are in the top!");
　　}
function topadd()
{
    var aWidth = window.screen.availWidth; //   获取客户端分辨率的宽度
    var aHeight = window.screen.availHeight; //   获取客户端分辨率的高度

    var sWidth = document.body.scrollWidth; //    获取浏览器的宽度
    var sHeight = document.body.scrollHeight; //    获取浏览器的高度

    var tWidth = sWidth - aWidth;
    var tHeight = sHeight - aHeight;

    window.scrollTo((tWidth / 2), (tHeight / 5));
}
function bottomadd()
{
    var aWidth = window.screen.availWidth; //   获取客户端分辨率的宽度
    var aHeight = window.screen.availHeight; //   获取客户端分辨率的高度

    var sWidth = document.body.scrollWidth; //    获取浏览器的宽度
    var sHeight = document.body.scrollHeight; //    获取浏览器的高度

    var tWidth = sWidth - aWidth;
    var tHeight = sHeight - aHeight;

    window.scrollTo((tWidth / 2), (tHeight / 2));
}

};