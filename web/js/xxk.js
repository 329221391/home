// JavaScript Document
function setTab03Syn ( i )
	{
		selectTab03Syn(i);
	}
	
	function selectTab03Syn ( i )
	{
//	var yuanzhang=document.getElementById("font1");
//	var jiazhang=document.getElementById("font2");
		switch(i){
			case 1:
			document.getElementById("bg").style.backgroundImage='url(images/yzd_bg.gif)';
			document.getElementById("TabTab03Con1").style.display="block";
			document.getElementById("TabTab03Con2").style.display="none";
			document.getElementById("font1").innerText="园长端";
			document.getElementById("font2").innerText="家长";
			document.getElementById("font1").className="tab1";
			document.getElementById("font2").className="tab2";

			break;
			case 2:
			document.getElementById("bg").style.backgroundImage='url(images/jzd_bg.gif)';
			document.getElementById("TabTab03Con1").style.display="none";
			document.getElementById("TabTab03Con2").style.display="block";
			document.getElementById("font1").innerText="园长";
			document.getElementById("font2").innerText="家长端";
			document.getElementById("font1").className="tab4";
			document.getElementById("font2").className="tab3";
			break;
		}
	}