    var oWrap=document.getElementById("wrap"),
    		oLogin=document.querySelector(".login"),
        oControl=document.querySelector("#wrap .control"),
        oColor1=document.querySelectorAll(".iconfont")[0],
        oColor2=document.querySelectorAll(".iconfont")[1],
        oPass=document.querySelector(".pass"),
    		oNo=document.querySelector(".none"),
    		oAccount=document.querySelector(".account"),
        oSure=document.querySelectorAll(".login-hidden>input")[0],
    		oHidden=document.querySelector(".login-hidden");
    		oLogin.onclick=function(){
  			oHidden.className+=" on";
				oWrap.style.opacity = '.5';
				oAccount.focus();
        oControl.className+=" on";
    		};
    		oNo.onclick=function(){
    			oHidden.className="login-hidden";
    			oWrap.style.opacity = '1';
          oControl.className="control";
    		};
        oAccount.onfocus=function(){
          oColor1.className+=" on";
        }
        oAccount.onblur=function(){
          oColor1.className="iconfont icon-zhanghao1";
        }
        oPass.onfocus=function(){
          oColor2.className+=" on";
        }
        oPass.onblur=function(){
          oColor2.className="iconfont icon-mima";
        }
          //   function check() {
          //   var formname=document.loginForm;
          //       if (oNumber.value == "") {
          //           alert("请输入用户名！");
          //           oNumber.focus();
          //           return false;
          //       }
          //       if (oPwd.value == "") {
          //           alert("请输入密码！");
          //           oPwd.focus();
          //           return false;
          //       }
          //       formname.submit();
          //   }
          // //回车时，默认是登陆
          //   function on_return(){
          //       if(window.event.keyCode == 13){
          //           if (document.all('sub')!=null){
          //           document.all('sub').click();
          //           }
          //       }
          //   }