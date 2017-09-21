function mainmenu(){
$(" #navg ul ").css({display: "none"}); // Opera Fix
$(" #navg li").hover(function(){
		$(this).find('ul:first').css({visibility: "visible",display: "none"}).show(200);
		},function(){
		$(this).find('ul:first').css({visibility: "hidden"});
		});
}

 $(document).ready(function(){					
	mainmenu();
});