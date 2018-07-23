var oFocus=document.querySelectorAll(".option ul li span"),
	oRight=document.getElementsByClassName("right-content"),
	oExchange=document.querySelector(".exchange form input"),
	oExHidden=document.querySelector(".exchange-hidden"),
	oTxt=document.querySelector(".exchange-hidden form .txt"),
	oNone=document.querySelector(".exchange-hidden i"),
	index=0,
	length=oFocus.length;
	for(var i=0;i<length;i++){
		oFocus[i].index=i; 
		oFocus[i].onclick=function(){
			oFocus[index].className="";
			oRight[index].classList.remove("on");
			index=this.index;
			oFocus[index].className="focus";
			oRight[index].classList.add("on");
		}
	};
	oExchange.onclick=function(){
		oExHidden.style.display="block";
		oTxt.focus();
	}
	oNone.onclick=function(){
		oExHidden.style.display="none";
	}