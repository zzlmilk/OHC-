/*
 *	WuBin-jsScroll V2.1 - simple gallery with jQuery
 *	made by Wubin.chen 2010-09-08
 *	作者：陈武彬  2010-09-08
 *	欢迎交流转载，但请尊重作者劳动成果，标明插件来源及作者
 */

(function ($) {
	$.fn.WBjsScroll = function (o) {
		var settings = {
			autoArrows:1,//是否显示根据内容自动显示滚动条，1：自动、2：只显示垂直直滚动条、3：只显示水平滚动条。默认为true。
			showArrows:true,//是否显示箭头，默认为true
			wheelSpeed:18,//鼠标滚动速度
			IntervalIime:80//鼠标按定是主显示区及滚动条的移动速度,单位毫秒，默认为80
		};
		
		var self,self_data,set,Scroll_main,Scroll_Outside,Scroll_y,Scroll_y_Drag,Scroll_y_Drag_Bar,Scroll_y_Up,Scroll_y_Down,ArrowDirection;
		var ArrowsInterval,KeyIntervalArr,DragInterval,TextMoveInterval;
		
		//开始初始化
		var set = $.extend({}, settings, o || {});
		init(this);
		
		//初始化函数
		function init(e) {
			self = $(e);
			
			//给主体加强制加入自动换行样式
			self.css({ "overflow": "auto", "word-wrap": "break-word", "word-break": "keep-all" }); 
			
			//主体数据组
			self_data = {
				height:self.height(),
				innerHeight:self.innerHeight(),
				Scroll_main_Height:0,
				Scroll_main_max:0,
				Scroll_y_show:0,
				Scroll_y_Drag_height:0,
				Scroll_y_Bar_height:0,
				Scroll_y_max:0,
				WheelMultiplier:0,
				dragPosition:0,
				mouseInBarposition:0
			};			
			
			self.wrapInner("<div class='Scroll_main'></div>"); 
			Scroll_main = self.find(".Scroll_main");
			if (Scroll_main.height() > self_data.height) {
				self.attr('tabindex', 0);
				self.css({"outline":"none"}); 
				Scroll_main.wrap("<div class='Scroll_Outside' style='position:relative; overflow:hidden; width:100%; height:100%'></div>"); 
				Scroll_Outside = self.find(".Scroll_Outside")
				Scroll_main.css({"position":"relative"}); 
                                self.append("<div id='ddddd' style=' position:absolute;width: 295px;*width: 83.5%;  right:28px;*margin-left:0;overflow: hidden; top:-1px;line-height:0px; border:1px solid black;*margin-right: 15px;z-index: 999;'></div>");
				self.append("<div id='dddd' style=' position:absolute;width: 295px;*width: 84%;  right:28px; top:128px;line-height:0px;overflow: hidden;border-top:1px solid #fff; border-bottom:1px solid black;*margin-right: 15px;z-index: 999;'></div>");
				ShowScroll_y();
				SetScroll_size();
				SetScroll_bind();
				self_data.Scroll_y_show = 1;
				self_data.Scroll_main_max = self_data.Scroll_main_Height - self_data.height;//内容显示区最大活动空间
				self_data.Scroll_y_max = self_data.Scroll_y_Drag_height - self_data.Scroll_y_Bar_height;//计算滚动条最大活动空间
				self_data.WheelMultiplier = 2 * set.wheelSpeed * self_data.Scroll_y_max / self_data.Scroll_main_Height;//计算滚动条滚动比例值
			}
		};
		
		function ShowScroll_y() {
			self.append("<div id='Scroll_y'class='Scroll_y' style=' position:absolute; right:23px; *right:25px; top:0px;margin-top: -1px;'></div>");
			Scroll_y = self.find(".Scroll_y");
			self.css({ "padding-right": parseInt(self.css("padding-right").replace("px","")) + Scroll_y.width() + "px", "word-break": "keep-all"}); 
			
			if (set.showArrows) Scroll_y.append("<div id='Scroll_y_Up' class='Scroll_y_Up'></div>");
			Scroll_y.append("<div  id='Scroll_y_Drag' class='Scroll_y_Drag' style='position:relative; overflow:hidden;'><div  id='Scroll_y_Drag_Bar'class='Scroll_y_Drag_Bar' style=' position:relative;'></div></div>");
			
			Scroll_y_Drag = Scroll_y.find(".Scroll_y_Drag");
			Scroll_y_Drag_Bar = Scroll_y.find(".Scroll_y_Drag_Bar");

			Scroll_y_Drag_Bar.append("<div   id='Scroll_y_DBT' class='Scroll_y_DBT'></div>")
			.append("<div id='Scroll_y_DBM' class='Scroll_y_DBM'><div class='Scroll_y_DBMB' id='Scroll_y_DBMB'></div></div>")
			.append("<div id='Scroll_y_DBB'   class='Scroll_y_DBB'></div>");

			if (set.showArrows) Scroll_y.append("<div class='Scroll_y_Down' id='Scroll_y_Down'></div>");
			
			Scroll_y_Up = Scroll_y.find(".Scroll_y_Up");
			Scroll_y_Down = Scroll_y.find(".Scroll_y_Down");
		}

		function SetScroll_size(){
			with (Scroll_y){
				var Scroll_y_Drag_height = Scroll_y_Drag.height();
				self_data.Scroll_main_Height = Scroll_main.height();
				
				css({"height": self_data.innerHeight});
				Scroll_y_Drag.height(self_data.innerHeight - Scroll_y_Up.outerHeight() - Scroll_y_Down.outerHeight() + "px");
				
//				if (Scroll_y_Drag.outerHeight() > Scroll_y_Drag_height){Scroll_y_Drag.height(Scroll_y_Drag_height - (Scroll_y_Drag.outerHeight() - Scroll_y_Drag_height) + "px")};
				
				self_data.Scroll_y_Drag_height = Scroll_y_Drag.height();
				
				var Proportion =  self_data.height / self_data.Scroll_main_Height;
				Scroll_y_Drag_Bar.height(Scroll_y_Drag.height() * Proportion  + "px");
				self_data.Scroll_y_Bar_height = Scroll_y_Drag_Bar.outerHeight();
				
				var Scroll_y_DBT = find(".Scroll_y_DBT");
				var Scroll_y_DBM = find(".Scroll_y_DBM");
				var Scroll_y_DBMB = find(".Scroll_y_DBMB");
				var Scroll_y_DBB = find(".Scroll_y_DBB");
				
				var BarMinHeight = Scroll_y_DBT.height() + Scroll_y_DBM.height() + Scroll_y_DBB.height();
				
				if (BarMinHeight >= Scroll_y_Drag_Bar.height()){
					Scroll_y_Drag_Bar.height(BarMinHeight + "px");
					self_data.Scroll_y_Bar_height = Scroll_y_Drag_Bar.outerHeight();
				}
				else{					
					Scroll_y_DBM.height(Scroll_y_Drag_Bar.height() - Scroll_y_DBT.height() - Scroll_y_DBB.height() + "px");
					Scroll_y_DBMB.height(Scroll_y_DBM.height() + "px");
				}
			}
		};
		
		function SetScroll_bind(){
			self.bind("keydown",function(e){	
				switch (e.keyCode) {
					case 38: //up
						ArrowsUpdate();
						if (!KeyIntervalArr) KeyIntervalArr = setInterval(Arrowsclick,set.IntervalIime);
						return false;
					case 40: //down
						ArrowsDowndate();	
						if (!KeyIntervalArr) KeyIntervalArr = setInterval(Arrowsclick,set.IntervalIime);
						return false;
					case 33: // page up
					case 34: // page down
						// TODO
						return false;
					default:
				}
			}).bind('keyup',function(e) {
				if (e.keyCode == 38 || e.keyCode == 40) {
					resetArrowsClsaa();
					clearInterval(KeyIntervalArr);
					return false;
				}
			});
			
			var Scroll_y_Up_On = 0
			Scroll_y_Up.bind("mouseenter",function(){
				if (Scroll_y_Up_On){ArrowsUpdate();ArrowsInterval = setInterval(Arrowsclick,set.IntervalIime);}
			}).bind("mouseleave",ArrowsLeave)
			.bind("mousedown", function(){
				Scroll_y_Up_On = 1
				ArrowsUpdate();
				ArrowsMouseDown();
			});	
			
			var Scroll_y_Down_On = 0
			Scroll_y_Down.bind("mouseenter",function(){
				if (Scroll_y_Down_On){ArrowsDowndate();ArrowsInterval = setInterval(Arrowsclick,set.IntervalIime);}
			}).bind("mouseleave",ArrowsLeave)
			.bind("mousedown", function(){
				Scroll_y_Down_On = 1
				ArrowsDowndate();
				ArrowsMouseDown();
			});
			
			function ArrowsLeave(){
				if (Scroll_y_Up_On) resetArrowsClsaa();
				if (Scroll_y_Down_On) resetArrowsClsaa();
			};
			
			function ArrowsMouseDown(){
				ignoreNativeDrag();
				ArrowsInterval = setInterval(Arrowsclick,set.IntervalIime);
				ArrowsToDocumentMouseup();
			};
			
			function ArrowsToDocumentMouseup(){
				$(document).bind("mouseup",function(){					
					Scroll_y_Up_On = 0;
					Scroll_y_Down_On = 0;
					resetArrowsClsaa();
					$(document).unbind("mouseup");
					ResumeNativeDrag();
				})
			};
			
			var Scroll_y_Drag_Down_On = 0;
			Scroll_y_Drag.bind("mouseenter",function(e){
				if (Scroll_y_Drag_Down_On){DraglickDirection(e);DragInterval = setInterval(Draglick,set.IntervalIime);}
			}).bind("mouseleave",Dragmouseleave)
			.bind("mouseup", function(e){
				Scroll_y_Drag_Down_On = 0;
				Scroll_y_Drag_Bar.removeClass("Scroll_y_Drag_Bar_D");
				clearInterval(DragInterval);
			}).bind("mousedown",Scroll_y_Drag_mousedown);	
			
			var Scroll_y_Bar_Down_On = 0;
			Scroll_y_Drag_Bar.bind("mousedown", function(e){
				Scroll_y_Drag.unbind("mousedown").unbind("mouseleave");
				Scroll_y_Drag_Bar.addClass("Scroll_y_Drag_Bar_D");
				Scroll_y_Bar_Down_On = 1;
				self_data.mouseInBarposition = getPos(e,"Y") - Scroll_y_Drag.offset().top - Scroll_y_Drag_Bar.position().top;
				ignoreNativeDrag();
				
				$(document).bind("mouseup",function(){					
					Scroll_y_Bar_Down_On = 0;
					Scroll_y_Drag_Bar.removeClass("Scroll_y_Drag_Bar_D");
					Scroll_y_Drag.bind("mousedown",Scroll_y_Drag_mousedown).bind("mouseleave",Dragmouseleave);	
					$(document).unbind("mouseup").unbind("mousemove")
					ResumeNativeDrag();
				})
				.bind("mousemove", function(e){if (Scroll_y_Bar_Down_On) Barclick(e);});
				
			}).bind("mousemove", function(e){
				if (Scroll_y_Bar_Down_On) Barclick(e);
			});	
			
			self.bind('mousewheel',mousewheel).bind('DOMMouseScroll',mousewheel);
			
			var selectDirection = 0;
			var moveIncrease = 1;
			Scroll_Outside.bind("mousedown",function(){
				var maxIntervalTime = 100;
				var minIntervalTime = 1;
				
				$(document).bind("mouseup",function(){	
					clearInterval(TextMoveInterval);
					$(this).unbind("mouseup").unbind("mousemove");	
				})
				.bind("mousemove", function(e){
					var mouseposition = getPos(e,"Y") - Scroll_Outside.offset().top;
					selectDirection = mouseposition < 0  ? -1 : (mouseposition > Scroll_Outside.height()) ? 1 : 0;
					if (selectDirection){
						var marginLong = mouseposition < 0 ? -mouseposition : mouseposition - Scroll_Outside.height();
						moveIncrease = marginLong / 10;
						clearInterval(TextMoveInterval);
						TextMove();
						TextMoveInterval = setInterval(TextMove,50);
					}
				});				
			});

			function Dragmouseleave(){
				clearInterval(DragInterval)
				$(document).bind("mouseup",function(){
					Scroll_y_Drag_Down_On = 0;
					Scroll_y_Drag_Bar.removeClass("Scroll_y_Drag_Bar_D");
					clearInterval(DragInterval);
					ResumeNativeDrag();
				})
			};
			
			function Scroll_y_Drag_mousedown(e){
				Scroll_y_Drag_Bar.addClass("Scroll_y_Drag_Bar_D");
				ignoreNativeDrag();
				Scroll_y_Drag_Down_On = 1;
				DraglickDirection(e);
				DragInterval = setInterval(Draglick,set.IntervalIime);
				Scroll_y_Drag_Bar.bind("mousemove", function(e){moveY = getPos(e,"Y")});
			};
			
			function mousewheel(event,delta){
				delta = delta || (event.wheelDelta ? event.wheelDelta / 120 : (event.detail) ? -event.detail/3 : 0);
				
				var d = self_data.dragPosition;
				positionDrag(self_data.dragPosition - delta * self_data.WheelMultiplier);
				var dragOccured = d != self_data.dragPosition;
				return !dragOccured;
			};
			
			var TextMove = function(){				
				var Scroll_main_position = Scroll_main.position().top - selectDirection * moveIncrease;
				Scroll_main_position = Scroll_main_position < -self_data.Scroll_main_max ? -self_data.Scroll_main_max : Scroll_main_position > 0 ? 0 : Scroll_main_position;
				self_data.dragPosition = self_data.Scroll_y_max * (-Scroll_main_position / self_data.Scroll_main_max);
				
				Scroll_main.css({'top':Scroll_main_position+'px'});
				Scroll_y_Drag_Bar.css({'top':self_data.dragPosition+'px'});
			}
		};
		
		var ignoreNativeDrag = function() {$('html').bind('dragstart',function(){return false;}).bind('selectstart',function(){return false;});};
		var ResumeNativeDrag = function() {$('html').unbind('dragstart').unbind('selectstart');};
		
		function resetArrowsClsaa(){
			clearInterval(ArrowsInterval);
			if (set.showArrows){
				Scroll_y_Up.removeClass("Scroll_y_Up_D");
				Scroll_y_Down.removeClass("Scroll_y_Down_D");
			}
		};
		
		var ArrowsUpdate = function(){
			if (set.showArrows) Scroll_y_Up.addClass("Scroll_y_Up_D");
			ArrowDirection = -1;
			Arrowsclick();
		};

		var ArrowsDowndate = function(){
			if (set.showArrows) Scroll_y_Down.addClass("Scroll_y_Down_D");
			ArrowDirection = 1;
			Arrowsclick();
		};
		
		var moveY = 0;
		var DraglickDirection = function(e){
			moveY = getPos(e,"Y")
			Draglick();
		};
		
		var Arrowsclick = function() {positionDrag(self_data.dragPosition + ArrowDirection * self_data.WheelMultiplier);};
		
		var Draglick = function() {
			var mouseposition = moveY - Scroll_y_Drag.offset().top;
			var BarHalf = Scroll_y_Drag_Bar.position().top + self_data.Scroll_y_Bar_height / 2		;	
			ArrowDirection = (mouseposition < BarHalf - self_data.WheelMultiplier / 2) ? -1 : (mouseposition > BarHalf + self_data.WheelMultiplier / 2) ? 1 : 0;
			
			positionDrag(self_data.dragPosition + ArrowDirection * self_data.WheelMultiplier);
			if (!ArrowDirection || (self_data.dragPosition == 0) || (self_data.dragPosition == self_data.Scroll_y_max)){clearInterval(DragInterval);return false;}
		};
		
		function Barclick(e){
			var mouseposition = getPos(e,"Y") - Scroll_y_Drag.offset().top;
			positionDrag(mouseposition - self_data.mouseInBarposition);	
		}		
		
		var positionDrag = function(destY){	
			destY = destY < 0 ? 0 : (destY > self_data.Scroll_y_max ? self_data.Scroll_y_max : destY);//判断滚动条移动位置是否超出可移动区域
			self_data.dragPosition = destY;	

			Scroll_y_Drag_Bar.css({'top':destY+'px'});
			var p = destY / self_data.Scroll_y_max;
			Scroll_main.css({'top':((self_data.height-self_data.Scroll_main_Height)*p ) + 'px'});
		};

		var getPos = function (event, c) {
			var p = c.toUpperCase() == 'X' ? 'Left' : 'Top';
			return event['page' + c] || (event['client' + c] + (document.documentElement['scroll' + p] || document.body['scroll' + p])) || 0;
		};
    };	
})(jQuery);