function initCanvasEvents(lcanvas) {

    if(lcanvas.initated) return;    
    lcanvas.initated = true;

    if(lcanvas) canvas = lcanvas;

    var selectedObject="";
    canvas.observe('object:selected', function (e) {
        for (var i = 0, j = 0; i <= canvasindex; i++) {
            $("#canvas" + i).css("box-shadow", "");
        }
        $("#canvas" + currentcanvasid).css("box-shadow", "3px 3px 3px #888888");
        $(".tools-top").css("visibility", "visible");

        selectedObject = e.target;
        setControlsVisibility(selectedObject);
        if (selectedObject.lockMovementY) {
        	selectedObject.hasControls = false;
        	selectedObject.hoverCursor = 'url("http://www.zipoly.com/editor/img/lockcursor.png") 10 10, pointer';
        } else {
        	selectedObject.hasControls = true;
        	selectedObject.hoverCursor = 'pointer';
		}
		$('#storkewidth').val(selectedObject.strokeWidth);
		$('#shapeslider').slider('value', selectedObject.opacity);
		if (selectedObject.type == "rect" || selectedObject.type == "circle" || selectedObject.type == "triangle" || selectedObject.type == "line") {
			$('#strokeline i').css('color', selectedObject.stroke);
			$('#fillshape i').css('color', selectedObject.fill);
		} 
        if (selectedObject.type == "textbox" || selectedObject.type == "i-text" || selectedObject.type == "text") {
            $(".textelebtns").show();
            $("#showmoreoptions").show();
            $("#fontbold").show();
            $("#fontitalic").show();
            $("#textuppercase").show();
            $("#textlowercase").show();
            $("#textcapitalize").show();
            $("#showmoreoptionstxtali").show();
            $(".alignment").show().html('<i class="fa fa-align-' + selectedObject.textAlign + '"></i>');
            $('#colorSelector').css('backgroundColor', selectedObject.fill);
            selectedObject.selectionColor = 'rgba(0, 123, 240, 0.3)';            
            $('#font-selected').html('<span style="overflow:hidden">' + selectedObject.fontFamily + '&nbsp;&nbsp;<span class="caret"></span></span>')
			
            document.getElementById('fontsize').value = Math.round(selectedObject.fontSize);
            document.getElementById('fontsize').focus();
            if (selectedObject.lineHeight != undefined) {
                var newValue = selectedObject.lineHeight;
                $('#changelineheight').slider('setValue', newValue, true);
            }
            if (selectedObject.charSpacing != undefined) {
                var newValue = selectedObject.charSpacing;
                $('#changecharspacing').slider('setValue', newValue, true);
            }
			selectedObject.setControlsVisibility({
				bl: false,
				br: false,
				tl: false,
				tr: false,
				mt: false,
				mb: false,
			});
        } 
		if (selectedObject.type == "rect" || selectedObject.type == "circle" || selectedObject.type == "triangle"|| selectedObject.type == "square" || selectedObject.type == "line") { 

            $("#textuppercase").hide();
            $("#textlowercase").hide();
            $("#textcapitalize").hide();
            $("#fontbold").hide();
            $("#fontitalic").hide();
            $("#showmoreoptionstxtali").hide();
            $("#showmoreoptions").hide();            
            $("#cropimage").hide();  
            $(".textelebtns").hide();
            $("#imagecropOptions").hide();
            $("#replace_image").hide();
            $('#colorSelector').css('backgroundColor', selectedObject.fill);
        }
        $("#dynamiccolorpickers").html('');
        if (selectedObject.type == 'path-group') {
            var colorarray = [];
            var objects = selectedObject.getObjects();
            for (var i = 0; i < objects.length; i++) {
                var colorString = objects[i].fill;
                if(colorString && (typeof colorString === 'string')) {
                    var rgb = colorString.substring(colorString.indexOf('(') + 1, colorString.lastIndexOf(')')).split(/,\s*/);
                    if(rgb && rgb != "") {
                        var red = parseInt(rgb[0]);
                        var green = parseInt(rgb[1]);
                        var blue = parseInt(rgb[2]);
                        hexCode = rgbToHex(red, green, blue);
                        objects[i].fill = hexCode;
                        colorarray.push(hexCode);
                    } else
                    colorarray.push(objects[i].fill);
                }
            }
            colorarray = colorarray.filter(onlyUnique); // returns ['a', 1, 2, '1']
            console.log(colorarray);
            $("#colorSelector").hide();
            var colorpickerhtml = "";
            for (var i = 0; i < colorarray.length; i++) {
                console.log(colorarray[i]);
                colorpickerhtml += "<input type='text' class='dynamiccolorpicker' value='" + colorarray[i] + "' />";
            }
            $("#dynamiccolorpickers").html(colorpickerhtml);
            var objinitcolor = "";
            $(".dynamiccolorpicker").spectrum({
            	hideAfterPaletteSelect: true,
                show: function (color) {
                    objinitcolor = color.toHexString(); // #ff0000
                },
                move: function (color) {
                    var newcolorVal = color.toHexString(); // #ff0000
                    var objects = selectedObject.getObjects();
                    for (var i = 0; i < objects.length; i++) {
                        if (objects[i].fill && objinitcolor.toLowerCase() == objects[i].fill.toString().toLowerCase()) {

                            var option = { };
                            option['fill'] = newcolorVal;
                            option['stroke'] = newcolorVal;
                            objects[i].set(option);

                        }
                    }

                    var option = { };
                    option['fill'] = newcolorVal;
                    option['stroke'] = newcolorVal;
                    selectedObject.set(option);
                    objinitcolor = newcolorVal;
                    canvas.renderAll();
                    saveState();
                }
            });
  			$("#showmoreoptionstxtali").hide();
        } else {
            $("#colorSelector").show();
        }
        if (selectedObject.type == "textbox" ||selectedObject.type == "i-text" || selectedObject.type == "text" || selectedObject.type == "path-group") {
            $("#imagecropOptions").hide();
            $("#replace_image").hide();
            $("#cropimage").hide();
        } 
        if (selectedObject.type == "path-group") {
            $("#textuppercase").hide();
            $("#textlowercase").hide();
            $("#textcapitalize").hide();
            $(".textelebtns").hide();
            $("#replace_image").hide();
            $("#cropimage").hide();
            $("#fontbold").hide();
            $("#fontitalic").hide();
            $("#showmoreoptionstxtali").hide();
            $("#showmoreoptions").hide();
        } 
		if (selectedObject.type == 'cropzoomimage') {
            $("#textuppercase").hide();
            $("#textlowercase").hide();
            $("#textcapitalize").hide();
			$(".textelebtns").hide();
			$("#colorSelector").hide();
            $("#imagecropOptions").show();
            $("#replace_image").show();
            $("#cropimage").show();
            $("#colorSelector").hide();
            $("#showmoreoptionstxtali").hide();
            $("#showmoreoptions").hide();
            $("#fontbold").hide();
            $("#fontitalic").hide();
        }
        canvas.renderAll();        
    });
    canvas.observe('selection:cleared', function (e) {
        $(".tools-top").css("visibility", "hidden");
        groupselobject = '';        
        $(".custom-menu").hide();
    });

    canvas.observe('object:moving', function (e) {
        $(".tools-top").css("visibility", "hidden");

        if(e.target && e.target.locked) {
            e.target.left = e.target.lockedleft;
            e.target.top = e.target.lockedtop;
        }

        e.target.setCoords();
        e.target.modified = true;
    });

    canvas.observe('object:rotating', function (e) {
        e.target.setCoords();
        e.target.modified = true;
    });

    canvas.observe('object:scaling', function (e) {
		//Show font size as object is scaling
        if (selectedObject.type == "textbox" ||selectedObject.type == "i-text" || selectedObject.type == "text") {
			if (e.target) {
				//$("#fontsize").val(((e.target.fontSize * e.target.scaleX) / 2 ).toFixed(0));
			}    	
		}
        e.target.setCoords();
        e.target.modified = true;
    });

    canvas.observe('object:modified', function (e) {
        $(".tools-top").css("visibility", "visible");
        console.log(e.target.type);

        if(e.target && e.target.locked) {
            e.target.left = e.target.lockedleft;
            e.target.top = e.target.lockedtop;
        }

        e.target.setCoords();
        
        if(e.target.modified) {
            saveState();   
            e.target.modified = false;
        }
    });

    canvas.observe('text:editing:exited', function(e) {

        if(e.target.modified) {
            saveState();   
            e.target.modified = false;
        }
    });

    canvas.observe('text:changed', function(e) {
        e.target.modified = true;
    });

    $( "body" ).mousedown(function(e) {
        
        e.stopImmediatePropagation();

        console.log(e.target.nodeName)
        console.log(e.target.className)
        var actobj = canvas.getActiveObject();
        if(!actobj && e.target.nodeName != "LI")
            $(".custom-menu").hide();
        if (e.target.nodeName != 'CANVAS' && e.target.nodeName == 'DIV' && e.target.className != 'sp-preview') {
            canvas.deactivateAllWithDispatch().renderAll();
        	//$(".tools-top").css("visibility", "visible");
        }        
        if (e.target.nodeName == 'CANVAS') {
            $('div.tab-content>div.tab-pane.active').removeClass('active', 4000);
            $('ul.nav.nav-tabs>li.active').removeClass('active', 4000);
            $("#leftsection").css("width","120px");
            
        }
    });
}