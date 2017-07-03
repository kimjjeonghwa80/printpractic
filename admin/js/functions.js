var groupselobject;
var canvasScale = 1;
var roundedcanvasScale = 1;
var SCALE_FACTOR = 1.2;
var savestateaction = true;
var currentcanvasid = 0;
var canvasindex = 0;
var pageindex = -1;
var canvasarray = [];
var isdownloadpdf = false;
var issaveastemplate = false;
var issavetemplate = false;
var isadmin = false;
var isclient = false;
var totalsvgs = 0;
var convertedsvgs = 0;
var loadedtemplateid = 0;
var activeObjectCopy, activeGroupCopy;
var keystring = "";
var isReplaceImage = false;
var remstring = "";

function addheadingText() {
    var txtBox = new fabric.Textbox("Heading Text", {
        fontFamily: selectedFont,
        fontSize: 36,
        textAlign: "center",
        fill: fillColor,
        scaleX: canvasScale,
        scaleY: canvasScale,
        lineHeight: 1,
        width: 400,
    });
    canvas.add(txtBox);
    setControlsVisibility(txtBox);
    txtBox.center();
    txtBox.setCoords();
    canvas.calcOffset();
    saveState();
    canvas.renderAll();
}

function addsubheadingText() {
    var txtBox = new fabric.Textbox("Subheading text", {
        fontFamily: selectedFont,
        fontSize: 24 ,
        textAlign: "center",
        fill: fillColor,
        scaleX: canvasScale,
        scaleY: canvasScale,
        lineHeight: 1,
        width: 350,
    });
    canvas.add(txtBox);
    setControlsVisibility(txtBox);
    txtBox.center();
    txtBox.setCoords();
    canvas.calcOffset();
    saveState();
    canvas.renderAll();
}

function addText() {
    var txtBox = new fabric.Textbox("Text element", {
        fontFamily: selectedFont,
        fontSize: 12,
        textAlign: "center",
        fill: fillColor,
        scaleX: canvasScale,
        scaleY: canvasScale,
        lineHeight: 1,
        width: 150,
        fontWeight: "normal",
    });
    canvas.add(txtBox);
    setControlsVisibility(txtBox);
    txtBox.center();
    txtBox.setCoords();
    canvas.calcOffset();
    saveState();
    canvas.renderAll();
}

function addSVGToCanvas(logosvgimg, svgoptions) {
    fabric.loadSVGFromURL(logosvgimg, function(objects, options) {
        var loadedObject = fabric.util.groupSVGElements(objects, options);
        loadedObject.set({
            scaleX: canvasScale,
            scaleY: canvasScale
        });
        var objects = loadedObject.getObjects()
        loadedObject.src = logosvgimg;
        canvas.add(loadedObject);
        loadedObject.center();
        if (svgoptions) {
            loadedObject.left = svgoptions.left;
            loadedObject.top = svgoptions.top;
            loadedObject.scaleX = svgoptions.scaleX;
            loadedObject.scaleY = svgoptions.scaleY;
            loadedObject.angle = svgoptions.angle;
            loadedObject.flipX = svgoptions.flipX;
            loadedObject.flipY = svgoptions.flipY;
        }
        loadedObject.setCoords();
        saveState();
        loadedObject.hasRotatingPoint = true;
        canvas.renderAll();
    });
}

function addUploadedSVGToCanvas(svgimg) {
    var svgImgPath = "./uploads/" + svgimg;
    fabric.loadSVGFromURL(svgImgPath, function(objects, options) {
        var loadedObject = fabric.util.groupSVGElements(objects, options);
        loadedObject.set({
            left: 200,
            top: 200,
            scaleX: canvasScale,
            scaleY: canvasScale
        });
        loadedObject.src = svgImgPath;
        canvas.add(loadedObject);
        loadedObject.center();
        loadedObject.setCoords();
        saveState();
        loadedObject.hasRotatingPoint = true;
        canvas.renderAll();
    });
}

function setControlsVisibility(object) {
    object.setControlsVisibility({
        tl: true, // top left
        tr: true, // top right
        bl: true, // bottom left
        br: true, // bottom right
        mt: true, // middle top disable
        mb: true, // midle bottom disable
        ml: true, // middle left disable
        mr: true, // middle right disable
    });
    object.hasControls = true;
}

function addCanvasToPage(dupflag, pageid, jsonarray) {
    var rows = document.getElementById("numOfcanvasrows").value,
        cols = document.getElementById("numOfcanvascols").value;
    $('.deletecanvas').css('display', 'block');
    var rc = parseInt(rows) * parseInt(cols) * parseInt(pageid);
    var dupcount = 0;
    var jsonarrcount = 1;
    for (var i = 1; i <= rows; i++) {
        $("#page" + pageindex).append("<table><tr>");
        for (var j = 1; j <= cols; j++) {
            addNewCanvas();
            if (dupflag) {
                var currentcanvasjson = canvasarray[rc + dupcount].toDatalessJSON();
                canvas.loadFromDatalessJSON(currentcanvasjson);
                canvas.renderAll();
                dupcount++;
            }
        }
        $("#page" + pageindex).append("</tr></table>");
    }
    var dupcanvicon = $("#duplicatecanvas").clone(true).prop('id', 'duplicatecanvas' + pageindex);
    var addnewpagebutton = $("#addnewpagebutton").clone(true).prop('id', 'addnewpagebutton' + pageindex);
    var delcanvicon = $("#deletecanvas").clone(true).prop('id', 'deletecanvas' + pageindex);
    var moveupicon = $("#moveup").clone(true).prop('id', 'moveup' + pageindex);
    var pagenumbericon = $("#pagenumber").clone(true).prop('id', 'pagenumber' + pageindex);
    var movedownicon = $("#movedown").clone(true).prop('id', 'movedown' + pageindex);
    var moveforwardicon = $("#forward").clone(true).prop('id', 'forward' + pageindex);
    var movebackwardicon = $("#backward").clone(true).prop('id', 'backward' + pageindex);
    dupcanvicon.appendTo("#page" + pageindex);
    addnewpagebutton.appendTo("#page" + pageindex);
    delcanvicon.appendTo("#page" + pageindex);


    if(pageindex != 0)
    moveupicon.appendTo("#page" + pageindex);
    pagenumbericon.appendTo("#page" + pageindex);
    movedownicon.appendTo("#page" + pageindex);

    if(selectedcategory == 'geofilters') {
        moveforwardicon.appendTo("#page" + pageindex);
        movebackwardicon.appendTo("#page" + pageindex);
        nextback();
    }

    $("#canvaspages").find(".page").each(function() {
        var nextid = this.id;
        nextid = nextid.replace("page", "");
        adjustIconPos(nextid);
    });

}
function setCanvasSize() {
    var width = document.getElementById("loadCanvasWid").value,
        height = document.getElementById("loadCanvasHei").value;

    //inch to pixel
    width = width * 96;
    height = height * 96;

    setCanvasWidthHeight(width, height);
    for (var i = 0; i <= pageindex; i++) {
        adjustIconPos(i);
    }
    $("#canvaswh_modal").modal('hide');
    $('.deletecanvas').css('display', 'none');
}

function setCanvasBg(lcanvas, bgsrc, bgcolor, scalex) {
    if(!scalex)
        $('#img-width').val(100);

    deleteCanvasBg(lcanvas);
    if (bgcolor) {
        var bg = new fabric.Rect({
            originX: "center",
            originY: "center",
            strokeWidth: 1,
            fill: bgcolor,
            opacity: 1,
            selectable: false,
            width: canvas.getWidth(),
            height: canvas.getHeight()
        });
        lcanvas.add(bg);
        bg.center();
        lcanvas.sendToBack(bg);
        lcanvas.bgcolor = bgcolor;
        bg.bg = true;
        saveState();
    }
    if (bgsrc) {
          if(!scalex) scalex = 1;
          var img = new Image();
          img.onload = function(){
              var imgwidth = this.width * scalex;
              var imgheight = this.height * scalex;
              for(var left=imgwidth/2;left < (canvas.width + (imgwidth/2));left+=imgwidth) {
                  for(var top=imgheight/2;top < (canvas.height + (imgheight/2));top+=imgheight) {
                        (function(leftpos, toppos) {
                              fabric.util.loadImage(bgsrc, function(img) {
                                    var bg = new fabric.Image(img);
                                    bg.set({
                                          originX: 'center',
                                          originY: 'center',
                                          opacity: 1,
                                          selectable: false,
                                          hasBorders: false,
                                          hasControls: false,
                                          hasCorners: false,
                                          width: img.width*scalex,
                                          height: img.height*scalex,
                                          left: leftpos,
                                          top: toppos
                                    });
                                    lcanvas.add(bg);
                                    canvas.sendToBack(bg);            
                                    lcanvas.bgsrc = bgsrc;
                                    bg.bg = true;
                                    saveState();
                              });
                        })(left, top);                  
                  }                  
              }

          };
          img.src = bgsrc;
    }
}

function hideshowCanvasBg(lcanvas, hideorshow) {

    var objects = canvas.getObjects().filter(function(o) {
        return o.bg == true;
    });

    for(var i=0; i < objects.length; i++) {
        objects[i].opacity = hideorshow;
    }       
}

function deleteCanvasBg(lcanvas) {

    var objects = canvas.getObjects().filter(function(o) {
        return o.bg == true;
    });

    for(var i=0; i < objects.length; i++) {
        canvas.remove(objects[i]);
    }
    canvas.bgsrc = "";
    canvas.bgcolor = "";
    saveState();            
}

var bgscale;
$('#img-width').on("change", function() {

      if(this.value == bgscale) return;
      bgscale = this.value;

      bgsrc = canvas.bgsrc;

      deleteCanvasBg();
      
      console.log(this.value);

      setCanvasBg(canvas, bgsrc, false, this.value/100);
});

function setStyle(object, styleName, value) {
    if (!object) return;

    if (object.setSelectionStyles && object.isEditing) {
        var style = { };
        style[styleName] = value;
        object.setSelectionStyles(style);
        object.set(styleName, value).setCoords();
    } else {

        if (object.styles) {
            var styles = object.styles;
            for (var row in styles) {
              for (var char in styles[row]) {
                if (styleName in styles[row][char]) {
                  delete styles[row][char][styleName];
                }
              }
            }
        }

        object.set(styleName, value).setCoords();
    }

    canvas.renderAll();
    saveState();
}

var fontBoldValue = "normal";
var fontBoldSwitch = document.getElementById('fontbold');
if (fontBoldSwitch) {
    fontBoldSwitch.onclick = function() {
        fontBoldValue = (fontBoldValue == "normal") ? "bold" : "normal";
        var activeObject = canvas.getActiveObject();
        var activeGroup = canvas.getActiveGroup();
        if (activeGroup) {
             activeGroup.forEachObject(function(object) {
                setStyle(object, 'fontWeight', fontBoldValue);
                canvas.renderAll();
             }); 
        } else {
            setStyle(activeObject, 'fontWeight', fontBoldValue);
            canvas.renderAll();
        }
    };
}
var fontItalicValue = "normal";
var fontItalicSwitch = document.getElementById('fontitalic');
if (fontItalicSwitch) {
    fontItalicSwitch.onclick = function() {
        fontItalicValue = (fontItalicValue == "normal") ? "italic" : "normal";
        var activeObject = canvas.getActiveObject();
        var activeGroup = canvas.getActiveGroup();
        if (activeGroup) {
            activeGroup.forEachObject(function(object) {
                setStyle(object, 'fontStyle', fontItalicValue);
                canvas.renderAll();
             }); 
        }else {
            setStyle(activeObject, 'fontStyle', fontItalicValue);
            canvas.renderAll();
        }
    };
}
var fontUnderlineValue = "normal";
var fontUnderlineSwitch = document.getElementById('fontunderline');
if (fontUnderlineSwitch) {
    fontUnderlineSwitch.onclick = function() {
        fontUnderlineValue = (fontUnderlineValue == "normal") ? "underline" : "normal";
        var activeObject = canvas.getActiveObject();
        var activeGroup = canvas.getActiveGroup();
        if (activeGroup) {
            activeGroup.forEachObject(function(object) {
                setStyle(object, 'textDecoration', fontUnderlineValue);
                canvas.renderAll();
             }); 
        }else {
            setStyle(activeObject, 'textDecoration', fontUnderlineValue);
            canvas.renderAll();
        }
    };
}
//Font line height
var ChangeLineHeight = function() {
    var activeObject = canvas.getActiveObject();
    var activeGroup = canvas.getActiveGroup();
    if (activeGroup) {
        activeGroup.forEachObject(function(object) {
            setStyle(object, 'lineHeight', clh.getValue());
            canvas.renderAll();
         }); 
    } else {
        setStyle(activeObject, 'lineHeight', clh.getValue());
        canvas.renderAll();
    }
};
var clh = $("#changelineheight").slider().on('slide', ChangeLineHeight).data('slider');

//Font char spacing
var ChangeCharSpacing = function() {
    var activeObject = canvas.getActiveObject();
    var activeGroup = canvas.getActiveGroup();
    if (activeGroup) {
        activeGroup.forEachObject(function(object) {
            setStyle(object, 'charSpacing', ccs.getValue());        
            var newVal = parseFloat($("#fontsize").val()) + 1;
            $("#fontsize").val(newVal);
            $("#fontsize").change();
            newVal = newVal - 1;
            $("#fontsize").val(newVal);
            $("#fontsize").change();
            canvas.renderAll();
         }); 
    } else {
        setStyle(activeObject, 'charSpacing', ccs.getValue());        
        var newVal = parseFloat($("#fontsize").val()) + 1;
        $("#fontsize").val(newVal);
        $("#fontsize").change();
        newVal = newVal - 1;
        $("#fontsize").val(newVal);
        $("#fontsize").change();
        canvas.renderAll();
    }
};
var ccs = $("#changecharspacing").slider().on('slide', ChangeCharSpacing).data('slider');

var deleteitembtn = document.getElementById('deleteitem');
if (deleteitembtn) {
    deleteitembtn.onclick = function() {
        deleteItem();
    }
}

function deleteItem() {
    var activeObject = canvas.getActiveObject();
    var activeGroup = canvas.getActiveGroup();
    if (!activeObject && !activeGroup) return;
    if (activeGroup) {
        canvas.discardActiveGroup().renderAll();
        activeGroup.forEachObject(function(object) {
            canvas.remove(object);
        });
    } else {
        canvas.remove(activeObject);
    }
    saveState();
}
var objectalignleftSwitch = document.getElementById('objectalignleft');
if (objectalignleftSwitch) {
    objectalignleftSwitch.onclick = function() {
        activeGroup = canvas.getActiveGroup();
        activeObject = canvas.getActiveObject();
        if (activeGroup) {
            activeGroup.forEachObject(function(object) {
                object.left = -(activeGroup.width * activeGroup.scaleX) / 2 + (object.width * object.scaleX) / 2;
                object.originX = 'center';
                if (object && (/textbox/.test(object.type) || /textbox/.test(object.type))) {
                    setStyle(object, 'textAlign', "left");
                    $(".alignment").show().html('<i class="fa fa-align-left"></i>');
                    canvas.renderAll();
                }
            });
            canvas.renderAll();
            objectalignrightSwitch.click();
        } else if (activeObject) {
            if (activeObject && (/textbox/.test(activeObject.type) || /textbox/.test(activeObject.type))) {
                setStyle(activeObject, 'textAlign', "left");
                $(".alignment").show().html('<i class="fa fa-align-left"></i>');
                canvas.renderAll();
            }
        }
    };
}
var objectaligncenterSwitch = document.getElementById('objectaligncenter');
if (objectaligncenterSwitch) {
    objectaligncenterSwitch.onclick = function() {
        activeGroup = canvas.getActiveGroup();
        activeObject = canvas.getActiveObject();
        if (activeGroup) {
            activeGroup.forEachObject(function(object) {
                object.left = 0;
                object.originX = 'center';
                if (object && (/textbox/.test(object.type) || /textbox/.test(object.type))) {
                    setStyle(object, 'textAlign', "center");
                    $(".alignment").show().html('<i class="fa fa-align-center"></i>');
                    canvas.renderAll();
                }
            });
            canvas.renderAll();
            objectaligncenterSwitch.click();
            objectaligncenterSwitch.click();
        } else if (activeObject) {
            if (activeObject && (/textbox/.test(activeObject.type) || /textbox/.test(activeObject.type))) {
                setStyle(activeObject, 'textAlign', "center");
                $(".alignment").show().html('<i class="fa fa-align-center"></i>');
                canvas.renderAll();
            }
        }
    };
}
var objectalignrightSwitch = document.getElementById('objectalignright');
if (objectalignrightSwitch) {
    objectalignrightSwitch.onclick = function() {
        activeGroup = canvas.getActiveGroup();
        activeObject = canvas.getActiveObject();
        if (activeGroup) {
            activeGroup.forEachObject(function(object) {
                object.left = activeGroup.width / 2 - (object.width * object.scaleX) / 2;
                object.originX = 'center';
                if (object && (/textbox/.test(object.type) || /textbox/.test(object.type))) {
                    setStyle(object, 'textAlign', "right");
                    $(".alignment").show().html('<i class="fa fa-align-right"></i>');
                    canvas.renderAll();
                }
            });
            canvas.renderAll();
            objectalignleftSwitch.click();
        } else if (activeObject) {
            if (activeObject && (/textbox/.test(activeObject.type) || /textbox/.test(activeObject.type))) {
                setStyle(activeObject, 'textAlign', "right");
                $(".alignment").show().html('<i class="fa fa-align-right"></i>');
                canvas.renderAll();
            }
        }
    };
}

var objectalignjustifySwitch = document.getElementById('objectalignjustify');
if (objectalignjustifySwitch) {
    objectalignjustifySwitch.onclick = function() {
        activeGroup = canvas.getActiveGroup();
        activeObject = canvas.getActiveObject();
        if (activeGroup) {
            activeGroup.forEachObject(function(object) {
                object.left = activeGroup.width / 2 - (object.width * object.scaleX) / 2;
                object.originX = 'center';
                if (object && (/textbox/.test(object.type) || /textbox/.test(object.type))) {
                    setStyle(object, 'textAlign', "justify");
                    $(".alignment").show().html('<i class="fa fa-align-justify"></i>');
                    canvas.renderAll();
                }
            });
            canvas.renderAll();
            objectalignleftSwitch.click();
        } else if (activeObject) {
            if (activeObject && (/textbox/.test(activeObject.type) || /textbox/.test(activeObject.type))) {
                setStyle(activeObject, 'textAlign', "justify");
                $(".alignment").show().html('<i class="fa fa-align-justify"></i>');
                canvas.renderAll();
            }
        }
    };
}

function resetState() {
    canvas.state = [];
    canvas.index = 0;
}

function saveState() {
    if (savestateaction && canvas.state) {
        var state = canvas.state;
        myjson = JSON.stringify(canvas);
        console.log("savestate" + state.length + " " + arguments.callee.caller.name);
        state.push(myjson);
        if(state.length >= 30) 
            state = state.splice(-5, 5);
        canvas.state = state;
    }
};

var undoSwitch = document.getElementById('undo');
if (undoSwitch) {
    undoSwitch.onclick = function() {
        undo();
        return false;
    };
}

function undo() {

    savestateaction = false;
    var index = canvas.index;
    var state = canvas.state;

    if (index < state.length && state.length-1-index+1 > 1) {
        canvas.clear().renderAll();
        canvas.loadFromJSON(state[state.length - 1 - index - 1], function() {
            canvas.renderAll();

            setTimeout(function() {
                restorePattern(canvas);
            }, 300);
        });
        index += 1;
        canvas.index = index;
    }

    savestateaction = true;
    canvas.renderAll();

}

var redoSwitch = document.getElementById('redo');
if (redoSwitch) {
    redoSwitch.onclick = function() {
        redo();
        return false;
    };
}

function redo() {

    var index = canvas.index;
    var state = canvas.state;
    savestateaction = false;
    if (index > 0) {
        canvas.clear().renderAll();
        canvas.loadFromJSON(state[state.length - 1 - index + 1], function() {
            canvas.renderAll();

            setTimeout(function() {
                restorePattern(canvas);
            }, 300);
        });
        index -= 1;
        canvas.index = index;
    }
    savestateaction = true;
    canvas.renderAll();    
}

function changeObjectColor(hex) {
    var obj = canvas.getActiveObject();
    if(obj) {
        if (groupselobject) groupselobject.setFill(hex);
        else if (obj.paths) {
            for (var i = 0; i < obj.paths.length; i++) {
                obj.paths[i].setFill(hex);
            }
		}
		else if (obj.type == "rect" || obj.type == "circle" || obj.type == "triangle"|| obj.type == "square") {
            obj.setFill(hex);
            obj.setStroke(hex);
        } else obj.setFill(hex);
    }
    var grpobjs = canvas.getActiveGroup();
    if(grpobjs) {
        grpobjs.forEachObject(function(object) {

            if(object.paths) {
                for (var i = 0; i < object.paths.length; i++) {
                    object.paths[i].setFill(hex);
                }                
            } else object.setFill(hex);
        }); 
    }
    canvas.renderAll();
    saveState();
}

function setCanvasWidthHeight(width, height) {
    for (var i = 0; i <= canvasindex; i++) {
        if (!canvasarray[i]) continue;

        canvasarray[i].setDimensions({width: width,height: height});
        canvasarray[i].calcOffset();
        canvasarray[i].renderAll();
    }
    $("#canvaswidth").val(Math.round(canvas.getWidth()));
    $("#canvasheight").val(Math.round(canvas.getHeight()));
}
// button Zoom In
$("#btnZoomIn").click(function() {
    zoomIn();
    resetState();
    for (var i = 0; i <= pageindex; i++) {
        adjustIconPos(i);
    }
    initCenteringGuidelines(canvas);
});
// button Zoom Out
$("#btnZoomOut").click(function() {
    zoomOut();
    resetState();
    for (var i = 0; i <= pageindex; i++) {
        adjustIconPos(i);
    }
    initCenteringGuidelines(canvas);
});
// Zoom In
function zoomIn() {
    // Set max zoom at 500%
    if (canvasScale * SCALE_FACTOR > 5) {
        $("#zoomperc").html(Math.round(5 * 100) + '%');
        return;
    }
    canvas.deactivateAllWithDispatch().renderAll();
    canvasScale = canvasScale * SCALE_FACTOR;
    setCanvasWidthHeight(canvas.getWidth() * SCALE_FACTOR, canvas.getHeight() * SCALE_FACTOR);
    for (var j = 0; j < canvasindex; j++) {
        if (!canvasarray[j]) continue;
        var objects = canvasarray[j].getObjects();
        for (var i in objects) {
            var scaleX = objects[i].scaleX;
            var scaleY = objects[i].scaleY;
            var left = objects[i].left;
            var top = objects[i].top;
            var tempScaleX = scaleX * SCALE_FACTOR;
            var tempScaleY = scaleY * SCALE_FACTOR;
            var tempLeft = left * SCALE_FACTOR;
            var tempTop = top * SCALE_FACTOR;
            objects[i].scaleX = tempScaleX;
            objects[i].scaleY = tempScaleY;
            objects[i].left = tempLeft;
            objects[i].top = tempTop;
            objects[i].setCoords();
        }
        canvasarray[j].renderAll();
    }
    $("#zoomperc").html('');
    $("#zoomperc").html(Math.round(canvasScale * 100) + '%');
}
// Reset Zoom
function resetZoom() {
    canvas.deactivateAllWithDispatch().renderAll();
    resetState();
    setCanvasWidthHeight(canvas.getWidth() * (1 / canvasScale), canvas.getHeight() * (1 / canvasScale));
    for (var j = 0; j < canvasindex; j++) {
        if (!canvasarray[j]) continue;
        var objects = canvasarray[j].getObjects();
        for (var i in objects) {
            var scaleX = objects[i].scaleX;
            var scaleY = objects[i].scaleY;
            var left = objects[i].left;
            var top = objects[i].top;
            var tempScaleX = scaleX * (1 / canvasScale);
            var tempScaleY = scaleY * (1 / canvasScale);
            var tempLeft = left * (1 / canvasScale);
            var tempTop = top * (1 / canvasScale);
            objects[i].scaleX = tempScaleX;
            objects[i].scaleY = tempScaleY;
            objects[i].left = tempLeft;
            objects[i].top = tempTop;
            objects[i].setCoords();
        }
        canvasarray[j].renderAll();
    }
    canvasScale = 1;
    $("#zoomperc").html('');
    $("#zoomperc").html(Math.round(canvasScale * 100) + '%');    
    initCenteringGuidelines(canvas);
    $("#canvaspages").find(".page").each(function() {
        var nextid = this.id;
        nextid = nextid.replace("page", "");
        adjustIconPos(nextid);
    });
}
// Zoom Out
function zoomOut() {
    canvas.deactivateAllWithDispatch().renderAll();
    canvasScale = canvasScale / SCALE_FACTOR;
    setCanvasWidthHeight(canvas.getWidth() * (1 / SCALE_FACTOR), canvas.getHeight() * (1 / SCALE_FACTOR));
    for (var j = 0; j < canvasindex; j++) {
        if (!canvasarray[j]) continue;
        var objects = canvasarray[j].getObjects();
        for (var i in objects) {
            var scaleX = objects[i].scaleX;
            var scaleY = objects[i].scaleY;
            var left = objects[i].left;
            var top = objects[i].top;
            var tempScaleX = scaleX * (1 / SCALE_FACTOR);
            var tempScaleY = scaleY * (1 / SCALE_FACTOR);
            var tempLeft = left * (1 / SCALE_FACTOR);
            var tempTop = top * (1 / SCALE_FACTOR);
            objects[i].scaleX = tempScaleX;
            objects[i].scaleY = tempScaleY;
            objects[i].left = tempLeft;
            objects[i].top = tempTop;
            objects[i].setCoords();
        }
        canvasarray[j].renderAll();
    }
    $("#zoomperc").html('');
    $("#zoomperc").html(Math.round(canvasScale * 100) + '%');
}
$("#saveastemplate").click(function() {
    issaveastemplate = true;
    $('#templateSaveModal').modal('hide');
    $('#savetemplate_modal').modal('show');
});
$("#downloadtemplate").click(function() {
    $('#downloadtemplate_modal').modal('show');
});
$("#downloadAsPNG").click(function() {
    downloadImage();
});
$("#downloadAsJPEG").click(function() {
    downloadjpeg();
});
$(".downloadAsPDF").click(function() {
    $(".se-pre-con").fadeIn('slow');
    isdownloadpdf = true;
    resetZoom();
    converttextpatterntoimg();
    setTimeout(function() {
        downloadPdf();
    }, 3000);    
});

function downloadTemplateFile() {
    $(".se-pre-con").fadeIn('slow');
    $('#downloadtemplate_modal').modal('hide');
    var jsonCanvasArray = [];
    var width = document.getElementById("loadCanvasWid").value,
        height = document.getElementById("loadCanvasHei").value,
        rows = document.getElementById("numOfcanvasrows").value,
        cols = document.getElementById("numOfcanvascols").value;
    //inch to pixel
    width = width * 96;
    height = height * 96;
    var wh = '{"width": ' + width + ', "height": ' + height + ', "rows": ' + rows + ', "cols": ' + cols + '}';
    jsonCanvasArray.push(wh);
    for (var i = 0; i < canvasindex; i++) {
        if (!canvasarray[i]) continue;
        canvasarray[i].deactivateAll().renderAll();
        if ($("#divcanvas" + i).is(":visible")) {
            jsonCanvasArray.push(canvasarray[i].toDatalessJSON());
        }
    }
    var jsonData = JSON.stringify(jsonCanvasArray);
    console.log(jsonData);
    var filename = $('#downtemplatename').val();
    var path = "uploads/savetemplate/";
    $.ajax({
        type: 'POST',
        url: 'downloadtemplate.php',
        data: {
            path: path,
            filename: filename,
            jsonData: jsonData
        },
        success: function(msg) {
            window.location.href = 'downloadfile.php?file=uploads/savetemplate/' + filename + '.pt';
            $(".se-pre-con").fadeOut('slow');
        }
    })    
}

function savetextfromselection() {
    var actobj = canvas.getActiveObject();
    var actgroupobjs = canvas.getActiveGroup();
    if (actobj && (actobj.type == 'textbox' || actobj.type == 'textbox')) {
        var clone = actobj.clone();
        var jsonData = JSON.stringify(clone.toJSON());
        var pngdataURL = clone.toDataURL("image/png");
        console.log(jsonData);
        var path = "uploads/savetext/";
        var filename = $('#textname').val();
        var categoryId = $('#text_category option:selected').val();
        $.ajax({
            type: 'POST',
            url: 'savetext.php',
            data: {
                path: path,
                pngimageData: pngdataURL,
                filename: filename,
                category: categoryId,
                jsonData: jsonData
            },
            success: function(msg) {
                getTexts('');
            }
        })
    } else if (actgroupobjs) {
        var jsonData = "";
        var objects = actgroupobjs.getObjects();
        jsonData += JSON.stringify(actgroupobjs.toJSON());
        var pngdataURL = actgroupobjs.toDataURL("image/png");
        console.log(jsonData);
        var path = "uploads/savetext/";
        var filename = $('#textname').val();
        var categoryId = $('#text_category option:selected').val();
        $.ajax({
            type: 'POST',
            url: 'savetext.php',
            data: {
                path: path,
                pngimageData: pngdataURL,
                filename: filename,
                category: categoryId,
                jsonData: jsonData
            },
            success: function(msg) {
                getTexts('');
            }
        })
    } else {
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the Text object, you wish to save.');
    }
}

function saveelementsfromselection() {
    var actobj = canvas.getActiveObject();
    var actgroupobjs = canvas.getActiveGroup();
    tempcanvas.clear();
    if (actobj) {
        if (fabric.util.getKlass(actobj.type).async) {
            actobj.clone(function(clone) {
                tempcanvas.width = clone.width * clone.scaleX;
                tempcanvas.height = clone.height * clone.scaleY;
                clone.originX = 'center';
                clone.originY = 'center';
                tempcanvas.add(clone);
                clone.center();
                var svgData = tempcanvas.toSVG();
                var jsonData = JSON.stringify(clone.toJSON());
                saveassvg(svgData, jsonData);
            });
        } else {
            var clone = actobj.clone();
            tempcanvas.width = clone.width * clone.scaleX;
            tempcanvas.height = clone.height * clone.scaleY;
            clone.originX = 'center';
            clone.originY = 'center';
            tempcanvas.add(clone);
            clone.center();
            var svgData = tempcanvas.toSVG();
            var jsonData = JSON.stringify(clone.toJSON());
            saveassvg(svgData, jsonData);
        }
    } else if (actgroupobjs) {
        tempcanvas.width = actgroupobjs.width * actgroupobjs.scaleX;
        tempcanvas.height = actgroupobjs.height * actgroupobjs.scaleY;
        var totalobjs = actgroupobjs.getObjects().length;
        var loadedobjs = 0;
        var jsonData = "";
        actgroupobjs.forEachObject(function(object) {
            if (fabric.util.getKlass(object.type).async) {
                object.clone(function(clone) {
                    tempcanvas.add(clone);
                    clone.setLeft(clone.left + tempcanvas.width / 2);
                    clone.setTop(clone.top + tempcanvas.height / 2);
                    loadedobjs++;
                    if (loadedobjs >= totalobjs) {
                        var svgData = tempcanvas.toSVG();
                        var objects = actgroupobjs.getObjects();
                        jsonData += JSON.stringify(actgroupobjs.toJSON());
                        saveassvg(svgData, jsonData);
                    }
                });
            } else {
                var clone = object.clone();
                tempcanvas.add(clone);
                clone.setLeft(clone.left + tempcanvas.width / 2);
                clone.setTop(clone.top + tempcanvas.height / 2);                
                loadedobjs++;
                if (loadedobjs >= totalobjs) {
                    var svgData = tempcanvas.toSVG();
                    var objects = actgroupobjs.getObjects();
                    jsonData += JSON.stringify(actgroupobjs.toJSON());
                    saveassvg(svgData, jsonData);
                }
            }
        });
    } else {
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the object, you wish to save.');
    }
}

function saveassvg(svgData, jsonData) {
    console.log(jsonData)
    var filename = $('#elmtname').val();
    var categoryId = $('#elmt_category option:selected').val();
    var path = "uploads/";
    $.ajax({
        type: 'POST',
        url: 'saveassvg.php',
        data: {
            path: path,
            filename: filename,
            svgData: svgData,
            jsonData: jsonData,
            category: categoryId,
        },
        success: function(msg) {
            $('#catimage_container').empty();
            getcatimages('');
        }
    })
}

function downloadImage() {
    resetZoom();
    $('#publishModal').modal('hide');
    $(".se-pre-con").fadeIn('slow');
    var cwidth = document.getElementById("loadCanvasWid").value;
    var cheight = document.getElementById("loadCanvasHei").value;
    var cols = document.getElementById("numOfcanvascols").value;
    var rows = document.getElementById("numOfcanvasrows").value;
    //inch to pixel
    cwidth = canvas.width;
    cheight = canvas.height;
    var buffer = document.getElementById("outputcanvas");
    var buffer_context = buffer.getContext("2d");
    buffer.width = parseInt(cwidth) * parseInt(cols);
    var hiddencanvascount = parseInt(cols) * parseInt(rows) * (pageindex + 1) - $(".divcanvas:visible").length;
    buffer.height = parseInt(cheight) * ((parseInt(rows) * (pageindex + 1)) - hiddencanvascount/parseInt(cols));

    var h = 0;
    var writtenpages = 0;
    var processpages = 0;
    var rowcount = 0;
    var colcount = 0;
    for (var i = 0; i < canvasindex; i++) {
        if (!canvasarray[i]) continue;

        hideshowobjects(canvasarray[i], false);
        canvasarray[i].deactivateAll().renderAll();
        var ito = getinfotextobj(canvasarray[i]);
        if (ito) ito.opacity = 0;
        if ($("#divcanvas" + i).is(":visible")) {
            processpages++;
            if (colcount >= cols) {
                colcount = 0;
                rowcount++;
            }
            w = cwidth * colcount;
            h = cheight * rowcount;
            colcount++;
            (function(li, c, r) {

                if(canvasarray[li].backgroundColor == '#ffffff')
                    canvasarray[li].setBackgroundColor(null, canvasarray[li].renderAll.bind(canvasarray[li]));

                hideshowCanvasBg(canvasarray[li], 0);
                
                var img = new Image();
                img.onload = function() {
                    buffer_context.drawImage(this, c, r);
                    writtenpages++;
                    if (writtenpages == processpages) {

                        var pngdataURL = buffer.toDataURL("image/png", 0.95);
                        pngdataURL = pngdataURL.replace('data:image/png;base64,', '');

                        var currentTime = new Date();
                        var month = currentTime.getMonth() + 1;
                        var day = currentTime.getDate();
                        var year = currentTime.getFullYear();
                        var hours = currentTime.getHours();
                        var minutes = currentTime.getMinutes();
                        var seconds = currentTime.getSeconds();
                        var filename = month + '' + day + '' + year + '' + hours + '' + minutes + '' + seconds;
                        var path = "uploads/savetemplate/";
                        $.ajax({
                            type: 'POST',
                            url: 'saveimage.php',
                            data: {
                                pngimageData: pngdataURL,
                                path: path,
                                filename: filename
                            },
                            success: function(msg) {

                                resetZoom();

                                window.location.href = 'downloadfile.php?file=uploads/savetemplate/' + filename + '.png';
                                setTimeout(function() {
                                    deleteImage(msg);
                                }, 12000);

                                if(canvasarray[li].backgroundColor == null)
                                    canvasarray[li].setBackgroundColor('#ffffff', canvasarray[li].renderAll.bind(canvasarray[li]));

                                $(".se-pre-con").fadeOut('slow');

                                hideshowobjects(canvasarray[li], true);
                            }
                        })
                    }
                };
                img.src = canvasarray[li].toDataURL({format: 'png',multiplier:1/fabric.devicePixelRatio});

            })(i, w, h);
        }
    }
}
function downloadjpeg() {
    resetZoom();
    $('#publishModal').modal('hide');
    $(".se-pre-con").fadeIn('slow');
    var cwidth = document.getElementById("loadCanvasWid").value;
    var cheight = document.getElementById("loadCanvasHei").value;
    var cols = document.getElementById("numOfcanvascols").value;
    var rows = document.getElementById("numOfcanvasrows").value;
    //inch to pixel
    cwidth = canvas.width;
    cheight = canvas.height;
    var buffer = document.getElementById("outputcanvas");
    var buffer_context = buffer.getContext("2d");
    buffer.width = parseInt(cwidth) * parseInt(cols);
    var hiddencanvascount = parseInt(cols) * parseInt(rows) * (pageindex + 1) - $(".divcanvas:visible").length;
    buffer.height = parseInt(cheight) * ((parseInt(rows) * (pageindex + 1)) - hiddencanvascount/parseInt(cols));

    var h = 0;
    var writtenpages = 0;
    var processpages = 0;
    var rowcount = 0;
    var colcount = 0;
    for (var i = 0; i < canvasindex; i++) {
        if (!canvasarray[i]) continue;

        hideshowobjects(canvasarray[i], false);
        canvasarray[i].deactivateAll().renderAll();
        var ito = getinfotextobj(canvasarray[i]);
        if (ito) ito.opacity = 0;
        if ($("#divcanvas" + i).is(":visible")) {
            processpages++;
            if (colcount >= cols) {
                colcount = 0;
                rowcount++;
            }
            w = cwidth * colcount;
            h = cheight * rowcount;
            colcount++;
            (function(li, c, r) {
                var img = new Image();
                img.onload = function() {
                    buffer_context.drawImage(this, c, r);
                    writtenpages++;
                    if (writtenpages == processpages) {
                        
                        var jpegdataURL = buffer.toDataURL("image/jpeg", 0.95);

                        jpegdataURL = jpegdataURL.replace('data:image/jpeg;base64,', '');

                        var currentTime = new Date();
                        var month = currentTime.getMonth() + 1;
                        var day = currentTime.getDate();
                        var year = currentTime.getFullYear();
                        var hours = currentTime.getHours();
                        var minutes = currentTime.getMinutes();
                        var seconds = currentTime.getSeconds();
                        var filename = month + '' + day + '' + year + '' + hours + '' + minutes + '' + seconds;
                        var path = "uploads/savetemplate/";
                        $.ajax({
                            type: 'POST',
                            url: 'saveimage.php',
                            data: {
                                jpegimageData: jpegdataURL,
                                path: path,
                                filename: filename
                            },
                            success: function(msg) {

                                resetZoom();

                                window.location.href = 'downloadfile.php?file=uploads/savetemplate/' + filename + '.jpeg';
                                setTimeout(function() {
                                    deleteImage(msg);
                                }, 12000);
                                $(".se-pre-con").fadeOut('slow');

                                hideshowobjects(canvasarray[li], true);
                            }
                        })                    
                    }
                };
                img.src = canvasarray[li].toDataURL({format: 'png',multiplier:1/fabric.devicePixelRatio});
            })(i, w, h);
        }
    }
}

function hideshowobjects(lcanvas, showflag) {

    var objs = lcanvas.getObjects().map(function(o) {
        if(!o.selectable && !o.bg) {
            o.opacity = showflag;
        }
        return o;
    });
    
    canvas.renderAll();
}

function converttextpatterntoimg() {

    for (var i = 0; i < canvasindex; i++) {
        if ($("#divcanvas" + i).is(":visible")) {
            objs = canvasarray[i].getObjects().filter(function(o) {
                return o.type == "textbox" && (typeof o.fill == 'object');
            });

            objs.forEach(function(o) {
                (function(index, io) {
                    var img = new Image();
                    
                    var textpattern = io.clone();

                    io.padding = 200;

                    img.onload = function() {
                        var object = new fabric.Image(img, {
                            left: io.left - 200,
                            top: io.top - 200
                        });

                        canvasarray[index].add(object);

                        object.textpattern = textpattern;

                        canvasarray[index].renderAll();

                        canvasarray[index].remove(io);
                    };
                    img.src = io.toDataURL({quality: 1});
                })(i, o);
            });
        }
    }
}

function convertimgtotextpattern() {

    for (var i = 0; i < canvasindex; i++) {
        if ($("#divcanvas" + i).is(":visible")) {
            objs = canvasarray[i].getObjects().filter(function(o) {
                return o.textpattern && o.textpattern.fill;
            });

            objs.forEach(function(o) {
                
                var textpattern = o.textpattern.clone();

                canvasarray[i].add(textpattern);

                canvasarray[i].remove(o);

                (function(index) {
                    setTimeout(function() {
                        restorePattern(canvasarray[index]);
                    }, 300);
                })(i);
            });

            canvasarray[i].renderAll();
        }
    }
}

var savecrop = false;
function downloadPdf() {
    if (totalsvgs == convertedsvgs) {
        isdownloadpdf = false;
        if ($('input#savecrop').is(':checked')) {
            savecrop = true;
        }
        var currentTime = new Date();
        var month = currentTime.getMonth() + 1;
        var day = currentTime.getDate();
        var year = currentTime.getFullYear();
        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes();
        var seconds = currentTime.getSeconds();
        var filename = month + '' + day + '' + year + '' + hours + '' + minutes + '' + seconds;

        filename = filename + ".pdf";
        var jsonCanvasArray = [];
        for (var i = 0; i < canvasindex; i++) {
            if ($("#divcanvas" + i).is(":visible")) {
                hideshowobjects(canvasarray[i], false);
                jsonCanvasArray.push(canvasarray[i].toSVG());
            }
        }
        var jsonData = JSON.stringify(jsonCanvasArray);
        console.log(jsonData);
        var cwidth = document.getElementById("loadCanvasWid").value;
        var cheight = document.getElementById("loadCanvasHei").value;
        var rows = document.getElementById("numOfcanvasrows").value;
        var cols = document.getElementById("numOfcanvascols").value;

        //inch to pixel
        cwidth = cwidth * 96;
        cheight = cheight * 96;
        var path = "uploads/savetemplate/";
        $.ajax({
            type: 'POST',
            url: '../admin/pdf.php',
            data: {
                filename: filename,
                jsonData: jsonData,
                cwidth: cwidth,
                cheight: cheight,
                rows: rows,
                cols: cols,
                savecrop: savecrop
            },
            success: function(msg) {
		        console.log(msg);
                window.location.href = "../admin/downloadfile.php?file=" + msg;
                savecrop = false;
                setTimeout(function() {
                    deleteImage(msg);
                }, 8000);
                for (var i = 0; i < canvasindex; i++) {
                    if ($("#divcanvas" + i).is(":visible")) {
                        hideshowobjects(canvasarray[i], true);
                    }
                }

                convertimgtotextpattern();
                resizeDownCanvas();

                $(".se-pre-con").fadeOut('slow');
            },
            error: function(err) {
            	console.log(err);
            } 
        })
    }
}

function deleteImage(file_name) {
    $.ajax({
        type: 'POST',
        url: 'deleteimage.php',
        data: {
            filename: file_name,
        },
        success: function(msg) {
        }
    });
}
// JavaScript Document
$("#addCategory").click(function() {
    $("#Addcategoryodal").modal('show');
});
$("#addTemplateCategory").click(function() {
    $("#AddTemplatecategoryModal").modal('show');
});
$("#addBGCategory").click(function() {
    $("#AddBGcategoryodal").modal('show');
});
$("#addTextCategory").click(function() {
    $("#AddTextcategoryModal").modal('show');
});
$("#saveText").click(function() {
    $('#savetext_modal').modal('show');
});
$("#saveElement").click(function() {
    $('#saveelement_modal').modal('show');
});
$("#addElement").click(function() {
    $("#AddelementModal").modal('show');
});

$("#upload_image").click(function() {
    $("#AdduploadimageModal").modal('show');
});
$("#upload_file").click(function() {
    $("#AdduploadfileModal").modal('show');
});

$("#cropimage").click(function() {

    var actobj = canvas.getActiveObject();

    if(actobj.type == "cropzoomimage") {
        $("#imagetocrop").attr('src', actobj.src);
        $('#crop_imagepopup').modal('show');
    }
});

$("#replace_image").click(function() {
    isReplaceImage = true;
    $("#AdduploadimageModal").modal('show');
});
$("#addBackground").click(function() {
    $("#AddbackgroundModal").modal('show');
});
$("#deletetempcat").click(function() {
    var sel_tempcatid = $('#tempcat-select').val();
    if (sel_tempcatid != '') {
        $("#Del_templatecatmodal").modal('show');
    } else {
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the Category, you wish to delete.');
    }
});
$("#deleteCategory").click(function() {
    var sel_catid = $('#cat-select').val();
    if (sel_catid != '') {
        $("#Del_catmodal").modal('show');
    } else {
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the Category, you wish to delete.');
    }
});
$("#deleteBGCategory").click(function() {
    var sel_bgcatid = $('#bgcat-select').val();
    if (sel_bgcatid != '') {
        $("#Del_bgcatmodal").modal('show');
    } else {
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the Category, you wish to delete.');
    }
});
$("#deletetextcat").click(function() {
    var sel_textcatid = $('#textcat-select').val();
    if (sel_textcatid != '') {
        $("#Del_textcatmodal").modal('show');
    } else {
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the Category, you wish to delete.');
    }
});
$('#deleteEle').click(function() {
    $(".se-pre-con").fadeIn('slow');
    var selectedImg = [];
    $('.catimg-checkbox:checked').each(function() {
        selectedImg.push($(this).val());
    });
    if (selectedImg != '') {
        selectedImg = selectedImg.join(',');
        $.post("actions/deleteElement.php", {
            "elementid": selectedImg
        }, function(data) {
            $(".se-pre-con").fadeOut('hide');
            $('#catimage_container').empty();
            getcategory();
            getcatimages('');
            document.getElementById("successMessage").innerHTML = data;
            $('#successModal').modal('show');
        });
    } else {
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the Element(s), you wish to delete.');
    }
});
$('#deleteText').click(function() {
    $(".se-pre-con").fadeIn('slow');
    var selectedTxt = [];
    $('.textimg-checkbox:checked').each(function() {
        selectedTxt.push($(this).val());
    });
    if (selectedTxt != '') {
        selectedTxt = selectedTxt.join(',');
        $.post("actions/deleteText.php", {
            "textid": selectedTxt
        }, function(data) {
            $(".se-pre-con").fadeOut('hide');
            $('#text_container').empty();
            getTexts('');
            document.getElementById("successMessage").innerHTML = data;
            $('#successModal').modal('show');
        });
    } else {
        $(".se-pre-con").fadeOut('hide');
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the Text(s), you wish to delete.');
    }
});
$('#deleteBackground').click(function() {
    $(".se-pre-con").fadeIn('slow');
    var selectedImg = [];
    $('.bgimg-checkbox:checked').each(function() {
        selectedImg.push($(this).val());
    });
    if (selectedImg != '') {
        selectedImg = selectedImg.join(',');
        $.post("actions/deleteBackground.php", {
            "bgid": selectedImg
        }, function(data) {
            $(".se-pre-con").fadeOut('hide');
            $('#background_container').empty();
            //IsBgselected = true;
            getBgcategory();
            getbgimages('');
            document.getElementById("successMessage").innerHTML = data;
            $('#successModal').modal('show');
        });
    } else {
        $(".se-pre-con").fadeOut('hide');
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the Background(s), you wish to delete.');
    }
});
$('#geofilterBackground').click(function() {
    $(".se-pre-con").fadeIn('slow');
    var selectedGeoImg = [];
    $('.bgimg-checkbox:checked').each(function() {
        selectedGeoImg.push($(this).val());
    });
    if (selectedGeoImg != '') {
        selectedGeoImg = selectedGeoImg.join(',');
        $.post("actions/Addgeofilter.php", {
            "bgGeoid": selectedGeoImg
        }, function(data) {
            $(".se-pre-con").fadeOut('hide');
            $('#background_container').empty();
            getBgcategory();
            getbgimages('');
            document.getElementById("successMessage").innerHTML = data;
            $('#successModal').modal('show');
        });
    } else {
        $(".se-pre-con").fadeOut('hide');
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the Background(s), you wish to delete.');
    }
});
$('#deleteTemp').click(function() {
    $(".se-pre-con").fadeIn('slow');
    var selectedTemp = [];
    $('.templateimg-checkbox:checked').each(function() {
        selectedTemp.push($(this).val());
    });

    if (selectedTemp != '') {
        selectedTemp = selectedTemp.join(',');
        $.post("actions/deleteTemplate.php", {
            "templateid": selectedTemp
        }, function(data) {
            $(".se-pre-con").fadeOut('hide');
            console.log(data);
            document.getElementById("successMessage").innerHTML = data;
            $('#successModal').modal('show');
            $('#template_container').empty();
            getTemplates();
        });
    } else {
        $(".se-pre-con").fadeOut('hide');
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the Flyer(s), you wish to delete.');
    }
});
function myFunction(id){
	$("#edit_tid").val(id);
	$.ajax({
		type: 'POST',
		url: 'actions/edittemp.php',
		data: 'tem_id=' + id,
		success: function(rettempname) { 
		var arr = rettempname.split('+');
		$("#edit_tmpcat").val(arr[1]).attr("selected", "selected");
		$("#edit_tmpname").val(arr[0]);
		$('#edit_proid').val(arr[2]);
		$('#edit_listid').val(arr[3]);
		$('#edit_tempname').modal('show');
		}
	});
}
function updatetemp() {
	var edittemid = $('#edit_tid').val();
	var edittemname = $('#edit_tmpname').val();
	var edittmpcat = $('#edit_tmpcat').val();
	var editproid = $('#edit_proid').val();
	var editlist = $('#edit_listid').val();
	$.ajax({
		type: 'POST',
		url: 'actions/edittemp.php',
		data: { e_name: edittemname, e_id: edittemid, e_cat: edittmpcat, e_pid: editproid, e_list: editlist },
		success: function(data) {
			$('#edit_tempname').modal('hide');
			document.getElementById("successMessage").innerHTML = data;
			$('#successModal').modal('show');
			$('#template_container').empty();
			getTemplates();
		}
	});
}

function getcategory() {
    $.ajax({
        type: "GET",
        url: "actions/getCategory.php",
        success: function(data) {
            $("#cat-select").empty();
            $("#cat-select").html(data);
            $("#element_category").empty();
            $("#element_category").html(data);
            $("#elmt_category").empty();
            $("#elmt_category").html(data);
        }
    });
}

/*Edit Template Category*/
$("#editcategory").click(function() {
    var tempcat_id = $('#tempcat-select').val();
    if (tempcat_id != '') {
        $.ajax({
            type: 'POST',
            url: 'actions/editcategory.php',
            data: 'res_id=' + tempcat_id,
            success: function(rettempname) { 
            var arr = rettempname.split('+');
            $("#edit_cid").val(arr[1]);
            $("#edit_cname").val(arr[0]);
            $('#edit_catname').modal('show');
            }
        });
    } else {
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the Category, you wish to delete.');
    }
});

function updatecat() {
    var editcid = $('#edit_cid').val();
    var editcname = $('#edit_cname').val();
    $.ajax({
        type: 'POST',
        url: 'actions/editcategory.php',
        data: { c_name: editcname, c_id: editcid },
        success: function(data) {
            $('#edit_catname').modal('hide');
            document.getElementById("successMessage").innerHTML = data;
            $('#successModal').modal('show');
            $("#template_category").empty();
            gettempcategory();
        }
    });
}

/*Edit Text Category*/
$("#edittext").click(function() {
    var cat_textid = $('#textcat-select').val();
    if (cat_textid != '') {
        $.ajax({
            type: 'POST',
            url: 'actions/editText.php',
            data: 'cat_id=' + cat_textid,
            success: function(rettextname) { 
            var arr = rettextname.split('+');
            $("#edit_textcid").val(arr[1]);
            $("#edit_textcname").val(arr[0]);
            $('#edit_textcatname').modal('show');
            }
        });
    } else {
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the Category, you wish to delete.');
    }
});

function updatetextcat() {
    var edittextcid = $('#edit_textcid').val();
    var edittextcname = $('#edit_textcname').val();
    $.ajax({
        type: 'POST',
        url: 'actions/editText.php',
        data: { c_name: edittextcname, c_id: edittextcid },
        success: function(data) {
            $('#edit_textcatname').modal('hide');
            document.getElementById("successMessage").innerHTML = data;
            $('#successModal').modal('show');
            $("#text_category").empty();
            getTextcategory();
        }
    });
}

/*Edit Element Category*/
$("#editelement").click(function() {
    var tempcat_Eid = $('#cat-select').val();
    if (tempcat_Eid != '') {
        $.ajax({
            type: 'POST',
            url: 'actions/editElement.php',
            data: 'res_Eid=' + tempcat_Eid,
            success: function(retelemname) { 
            var arr = retelemname.split('+');
            $("#edit_elecid").val(arr[1]);
            $("#edit_elecname").val(arr[0]);
            $('#edit_elecatname').modal('show');
            }
        });
    } else {
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the Category, you wish to delete.');
    }
});

function updateelecat() {
    var editelecid = $('#edit_elecid').val();
    var editelecname = $('#edit_elecname').val();
    $.ajax({
        type: 'POST',
        url: 'actions/editElement.php',
        data: { c_name: editelecname, c_id: editelecid },
        success: function(data) {
            $('#edit_elecatname').modal('hide');
            document.getElementById("successMessage").innerHTML = data;
            $('#successModal').modal('show');
            $("#elmt_category").empty();
            getcategory();
        }
    });
}

/*Edit Background Category*/
$("#editbackground").click(function() {
    var tempcat_Bid = $('#bgcat-select').val();
    if (tempcat_Bid != '') {
        $.ajax({
            type: 'POST',
            url: 'actions/editBackground.php',
            data: 'res_Bid=' + tempcat_Bid,
            success: function(retbackname) { 
            var arr = retbackname.split('+');
            $("#edit_backcid").val(arr[1]);
            $("#edit_backcname").val(arr[0]);
            $('#edit_backname').modal('show');
            }
        });
    } else {
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the Category, you wish to delete.');
    }
});

function updatebackcat() {
    var editbcid = $('#edit_backcid').val();
    var editbcname = $('#edit_backcname').val();
    $.ajax({
        type: 'POST',
        url: 'actions/editBackground.php',
        data: { c_name: editbcname, c_id: editbcid },
        success: function(data) {
            $('#edit_backname').modal('hide');
            document.getElementById("successMessage").innerHTML = data;
            $('#successModal').modal('show');
            $("#bg_category").empty();
            getBgcategory();
        }
    });
}

function gettempcategory() {
    $.ajax({
        type: "GET",
        url: "actions/gettempCategory.php",
        success: function(data) {
            $("#tempcat-select").empty();
            $("#tempcat-select").html(data);
            $("#template_category").empty();
            $("#template_category").html(data);
        }
    });
}

function getBgcategory() {
    $.ajax({
        type: "GET",
        url: "actions/getBgCategory.php",
        success: function(data) {
            $("#bgcat-select").empty();
            $("#bgcat-select").html(data);
            $("#bg_category").empty();
            $("#bg_category").html(data);
        }
    });
}

function getTextcategory() {
    $.ajax({
        type: "GET",
        url: "actions/getTextCategory.php",
        success: function(data) {
            $("#textcat-select").empty();
            $("#textcat-select").html(data);
            $("#text_category").empty();
            $("#text_category").html(data);
        }
    });
}

function getTemplatesName() {
    $.ajax({
        type: "GET",
        url: "actions/getTemplate_name.php",
        success: function(data) {
            $("#template-select").empty();
            $("#template-select").html(data);
        }
    });
}
<!-- Category form validate -->
$(document).ready(function() {
    $('#addcategoryform').validate({
        rules: {
            category: {
                required: true
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function(element) {
            element.text('').addClass('valid').closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        submitHandler: function(form) { // <- only fires when form is valid
            var newcategory = $("#category").val();
            $('#Addcategoryodal').modal('hide');
            $(".se-pre-con").fadeIn('slow');
            $.post("actions/addcategory.php", {
                "categoty": newcategory
            }, function(data) {
                $(".se-pre-con").fadeOut('slow');
                $('#catimage_container').empty();
                getcategory();
                getcatimages('');
                document.getElementById("successMessage").innerHTML = data;
                $('#successModal').modal('show');
                $('#addcategoryform')[0].reset();
            });
        }
    });
});
<!-- Save Template  admin form validate -->
$(document).ready(function() {
    $('#savetemplateform').validate({
        rules: {
            template_category: {
                required: true
            },
            templatename: {
                required: true
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function(element) {
            element.text('').addClass('valid').closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        submitHandler: function(form) {
            isadmin = true; 
			proceed_savetemplate();
        }
    });
});
<!-- Save as Template client form validate -->
$(document).ready(function() {
    $('#savetemplateformclient').validate({
        rules: {
            templatename: {
                required: true
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function(element) {
            element.text('').addClass('valid').closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        submitHandler: function(form) {
            isclient = true; 
            proceed_savetemplate();
        }
    });
});
$(document).ready(function() {
    $('#addtextcategoryform').validate({
        rules: {
            textcategory: {
                required: true
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function(element) {
            element.text('').addClass('valid').closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        submitHandler: function(form) { // <- only fires when form is valid
            var newTxtcategory = $("#textcategory").val();
            $('#AddTextcategoryModal').modal('hide');
            $(".se-pre-con").fadeIn('slow');
            $.post("actions/addcategory.php", {
                "textcategoty": newTxtcategory
            }, function(data) {
                $(".se-pre-con").fadeOut('slow');
                getTextcategory();
                document.getElementById("successMessage").innerHTML = data;
                $('#successModal').modal('show');
                $('#addtextcategoryform')[0].reset();
            });
        }
    });
});

function proceed_tempcatdelete() {
    var sel_tmpcatid = $('#tempcat-select').val();
    $('#Del_templatecatmodal').modal('hide');
    $(".se-pre-con").fadeIn('slow');
    $.post("actions/deletetempcategory.php", {
        "categoty": sel_tmpcatid
    }, function(data) {
        $(".se-pre-con").fadeOut('slow');
        $('#template_container').empty();
        getTemplates();
        gettempcategory('');
        document.getElementById("successMessage").innerHTML = data;
        $('#successModal').modal('show');
    });
}

function proceed_catdelete() {
    var sel_catid = $('#cat-select').val();
    $('#Del_catmodal').modal('hide');
    $(".se-pre-con").fadeIn('slow');
    $.post("actions/deletecategory.php", {
        "categoty": sel_catid
    }, function(data) {
        $(".se-pre-con").fadeOut('slow');
        $('#catimage_container').empty();
        getcategory();
        getcatimages('');
        document.getElementById("successMessage").innerHTML = data;
        $('#successModal').modal('show');
    });
}

function proceed_Bgcatdelete() {
    var sel_bgcatid = $('#bgcat-select').val();
    $('#Del_bgcatmodal').modal('hide');
    $(".se-pre-con").fadeIn('slow');
    $.post("actions/deletebgcategory.php", {
        "bgcategoty": sel_bgcatid
    }, function(data) {
        $(".se-pre-con").fadeOut('slow');
        $('#background_container').empty();
        getBgcategory();
        getbgimages('');
        document.getElementById("successMessage").innerHTML = data;
        $('#successModal').modal('show');
    });
}

function proceed_textcatdelete() {
    var sel_textcatid = $('#textcat-select').val();
    $('#Del_textcatmodal').modal('hide');
    $(".se-pre-con").fadeIn('slow');
    $.post("actions/deletetextcategory.php", {
        "textcategoty": sel_textcatid
    }, function(data) {
        $(".se-pre-con").fadeOut('slow');
        getTextcategory();
        document.getElementById("successMessage").innerHTML = data;
        $('#successModal').modal('show');
    });
}
$(document).ready(function() {
    $('#addbgcategoryform').validate({
        rules: {
            bgcategory: {
                required: true
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function(element) {
            element.text('').addClass('valid').closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        submitHandler: function(form) { // <- only fires when form is valid
            var newcategory = $("#bgcategory").val();
            $('#AddBGcategoryodal').modal('hide');
            $(".se-pre-con").fadeIn('slow');
            $.post("actions/addcategory.php", {
                "bgcategoty": newcategory
            }, function(data) {
                $(".se-pre-con").fadeOut('slow');
                $('#background_container').empty();
                getBgcategory();
                getbgimages('');
                document.getElementById("successMessage").innerHTML = data;
                $('#successModal').modal('show');
                $('#addbgcategoryform')[0].reset();
            });
        }
    });
});
<!-- Teremplate Category form validate -->
$(document).ready(function() {
    $('#addtemplatecategoryform').validate({
        rules: {
            templatecategory: {
                required: true
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function(element) {
            element.text('').addClass('valid').closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        submitHandler: function(form) { // <- only fires when form is valid
            var tempcategory = $("#templatecategory").val();
            $('#AddTemplatecategoryModal').modal('hide');
            $(".se-pre-con").fadeIn('slow');
            $.post("actions/addcategory.php", {
                "templatecat": tempcategory
            }, function(data) {
                $(".se-pre-con").fadeOut('slow');
                gettempcategory();
                getcatimages('');
                document.getElementById("successMessage").innerHTML = data;
                $('#successModal').modal('show');
                $('#addtemplatecategoryform')[0].reset();
            });
        }
    });
});
<!-- File Upload --->
function readIMG(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#previewImage').show();
            $('#previewImage').attr('src', e.target.result).width(150).height(150);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
var files;
$('#element_img').on('change', prepareUpload);

function prepareUpload(event) {
    files = event.target.files;
}

function uploadimage() {
    var data = new FormData();
    //adding file content to data
    $.each(files, function(key, value) {
        data.append("element_img", value);
    });

    $.ajax({
        url: 'upload.php?files',
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function(data) {
            alert(data)
        }
    });
}
<!-- PAttern file upload -->
var files;
$('#pattern_img').on('change', preparepatternUpload);

function preparepatternUpload(event) {
    $(".se-pre-con").fadeIn('slow');
    files = event.target.files;
    var fileName = files[0].name;
    uploadpatternimage();
    $.ajax({
        url: 'patt_save.php',
        type: 'POST',
        data: {
            pat_fileName: fileName
        },
        cache: false,
        success: function(data) {
            $(".se-pre-con").fadeOut('slow');
            document.getElementById("successMessage").innerHTML = data;
            $('#successModal').modal('show');
            $('#pattern_imagelist').empty();
            displaypattern();
        }
    });
}

function uploadpatternimage() {
    var data = new FormData();
    //adding file content to data
    $.each(files, function(key, value) {
        data.append("pattern_img", value);
    });
    $.ajax({
        url: 'upload.php?files',
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function(data) {
            document.getElementById("successMessage").innerHTML = data;
            $('#successModal').modal('show');
        }
    });
}
<!-- File Upload --->
function readBGIMG(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#previewBGImage').show();
            $('#previewBGImage').attr('src', e.target.result).width(150).height(150);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
var bgfiles;
$('#bg_img').on('change', prepareBGUpload);

function prepareBGUpload(event) {
    bgfiles = event.target.files;
}

function uploadBgimage() {
    var data = new FormData();
    //adding file content to data
    $.each(bgfiles, function(key, value) {
        data.append("bg_img", value);
    });
    $.ajax({
        url: 'upload.php?files',
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function(data) {
            alert(data)
        }
    });
}

function addNewCanvasPage(dupflag, pageid) {
    pageindex++;
    $("#canvaspages").append("<div class='page' id='page" + pageindex + "'></div>");
    addCanvasToPage(dupflag, pageid);
}

function addNewCanvas() {
    var ito = getinfotextobj();
    if (ito) ito.opacity = 0;
    if(canvas)
    canvas.deactivateAllWithDispatch().renderAll();
    $("#page" + pageindex).append("<td align='center' id='divcanvas" + canvasindex + "' onmousedown='javascript:selectCanvas(this.id);' onClick='javascript:selectCanvas(this.id);' oncontextmenu='javascript:selectCanvas(this.id);' class='divcanvas'><div class='canvascontent'><canvas id='canvas" + canvasindex + "' class='canvas'></canvas></div></td>");
    canvas = new fabric.Canvas(document.getElementById('canvas' + canvasindex));
    canvas.preserveObjectStacking = true;    
    canvas.backgroundColor = '#ffffff';
    canvas.index = 0;
    canvas.state = [];
    canvas.rotationCursor = 'url("img/rotatecursor2.png") 10 10, crosshair';
    canvas.selectionColor = 'rgba(255,255,255,0.3)';
    canvas.selectionBorderColor = 'rgba(0,0,0,0.1)';
    canvas.hoverCursor = 'pointer';
    canvasarray.push(canvas);
    var width = document.getElementById("loadCanvasWid").value,
        height = document.getElementById("loadCanvasHei").value;
    //inch to pixel
    width = width * 96;
    height = height * 96;
    setCanvasWidthHeight(width * canvasScale, height * canvasScale);
    
    initCanvasEvents(canvas);
    initAligningGuidelines(canvas)
    initCenteringGuidelines(canvas);
    initKeyboardEvents();

    canvas.calcOffset();
    canvas.renderAll();
    index = 0;
    state = [];
    currentcanvasid = canvasindex;
    canvasindex++;
}

function selectCanvas(id) {
    var ito = getinfotextobj();
    if (ito) ito.opacity = 0;
    id = id.replace("divcanvas", "");
    if (currentcanvasid == parseInt(id)) return;
    s
    savestateaction = true;

    canvas.deactivateAllWithDispatch().renderAll();
    for (var i = 0, j = 0; i < canvasindex; i++) {
        $("#canvas" + i).css("box-shadow", "");
    }
    $("#canvas" + id).css("box-shadow", "3px 3px 3px #888888");
    if (currentcanvasid == parseInt(id)) return;

    currentcanvasid = parseInt(id);
    var tempcanvas = canvasarray[parseInt(id)];
    if (tempcanvas) canvas = tempcanvas;

    canvas.renderAll();
}

function adjustIconPos(id) {
    //set duplicate / delete icons left top positions.
    var p = $("#page" + id);
    var position = p.position();
    // .outerWidth() takes into account border and padding.
    var width = p.outerWidth();
    var height = p.outerHeight();
    $("#duplicatecanvas" + id).css({
        position: "absolute",
        top: (position.top + 55) + "px",
        left: (position.left + width + 10) + "px"
    }).show();
    $("#addnewpagebutton" + id).css({
        position: "absolute",
        top: (position.top + 85 ) + "px",
        left: (position.left + width + 10) + "px"
    }).show();
    $("#deletecanvas" + id).css({
        position: "absolute",
        top: (position.top + 115) + "px",
        left: (position.left + width + 10) + "px"
    }).show();
    
    $("#moveup" + id).css({
        position: "absolute",
        top: (position.top + height / 2 - 10) + "px",
        left: (position.left + width + 10) + "px"
    }).show();

    $("#forward" + id).css({
        position: "absolute",
        top: (position.top + height / 2 - 50) + "px",
        left: (position.left + width + 10) + "px"
    }).show();  

    $("#backward" + id).css({
        position: "absolute",
        top: (position.top + height / 2 - 50) + "px",
        left: (position.left - 40) + "px"
    }).show();

    $("#pagenumber" + id).css({
        position: "absolute",
        top: (position.top + height / 2) + "px",
        left: (position.left + width + 10) + "px"
    }).show();

    var hiddenpages = 0;
    for (var i = 0; i < pageindex && i < parseInt(id)+1; i++) {
        if (!$("#page" + i).is(":visible")) 
            hiddenpages++;
    }

    $("#pagenumber" + id).html(parseInt(id)+1 - hiddenpages);

    $("#movedown" + id).css({
        position: "absolute",
        top: (position.top + height / 2 + 10) + "px",
        left: (position.left + width + 10) + "px"
    }).show();

    if(id == pageindex) 
        $("#movedown" + id).hide();

    if ($(".page:visible").length == 1) {
        $('.deletecanvas').css('display', 'none');
        $('.moveup').css('display', 'none');
        $('.movedown').css('display', 'none');
    }
}

function nextback() {

    $.ajax({

        type: 'GET',

        url: 'actions/nextbackbg.php',

        cache: false,
        
        success: function(data) {

            var array = data.split(','); 

            var arraylength = array.length;

            var img = [];

            for(var i = 0;i <= arraylength;i++) {

                if(array[i]) {                   

                    img[i] = array[i];
                }

            }

            if(img.length == 1){

                $('.backward').css('display', 'none');

                $('.forward').css('display', 'none');

                var keng = data.replace(",", '');

                setCanvasBg(canvas, keng);

            }


            var currentIndex = 0;

            $(".forward").click(function() {

                if(currentIndex >= 0 && currentIndex <= (img.length-2)) {

                    currentIndex++;

                    var test = img.length-2;

                    setCanvasBg(canvas, img[currentIndex]);

                    if(currentIndex == (test+1)){

                        $('.forward').css('display', 'none');

                        $('.backward').css('display', 'block');

                    } else {

                        $('.forward').css('display', 'block');

                        $('.backward').css('display', 'block');

                    }

                } else {

                }

            });
            
            $('.forward').trigger('click');

            $(".backward").click(function() {

                if(currentIndex > 0){
                    
                    currentIndex--;

                    setCanvasBg(canvas, img[currentIndex]);

                    if(currentIndex == 0){

                        $('.backward').css('display', 'none');

                        $('.forward').css('display', 'block');

                    }else{

                        $('.backward').css('display', 'block');

                        $('.forward').css('display', 'block');

                    }

                } else {

                }

            });

        }

    });

}

$(".moveup").click(function() {
    var id = this.id;
    id = parseInt(id.replace("moveup", ""));

    if(id-1 >= 0) {

        var currentcanvasjson = canvasarray[id].toDatalessJSON();
        var upcanvasjson = canvasarray[id-1].toDatalessJSON();

        canvasarray[id-1].loadFromDatalessJSON(currentcanvasjson);
        canvasarray[id-1].renderAll();

        canvasarray[id].loadFromDatalessJSON(upcanvasjson);
        canvasarray[id].renderAll();
    }
});

$(".movedown").click(function() {
    var id = this.id;
    id = parseInt(id.replace("movedown", ""));

    if(id+1 < pageindex) {
        var currentcanvasjson = canvasarray[id].toDatalessJSON();
        var downcanvasjson = canvasarray[id+1].toDatalessJSON();

        canvasarray[id+1].loadFromDatalessJSON(currentcanvasjson);
        canvasarray[id+1].renderAll();

        canvasarray[id].loadFromDatalessJSON(downcanvasjson);
        canvasarray[id].renderAll();        
    }
});

$(".deletecanvas").click(function() {
    var id = this.id;
    id = id.replace("deletecanvas", "");
    var pageid = "#page" + id;
    
    //clear and hide
    canvasarray[id].clear();
    $(pageid).hide();

    $("#canvaspages").find(".page").each(function() {
        var nextid = this.id;
        nextid = nextid.replace("page", "");
        adjustIconPos(nextid);
    });
});
$(".addnewpagebutton").click(function() {
    addNewCanvasPage();
    $("#canvaspages").find(".page").each(function() {
        var nextid = this.id;
        nextid = nextid.replace("page", "");
        adjustIconPos(nextid);
    });
});

function openTemplate(jsons) {
    var jsonCanvasArray = JSON.parse(jsons);
    if (!jsonCanvasArray || jsonCanvasArray.length <= 0) return;
    var wh = jsonCanvasArray[0];
    wh = JSON.parse(wh);
    //pixel to inch
    document.getElementById("loadCanvasWid").value = parseFloat(wh.width / 96);
    document.getElementById("loadCanvasHei").value = parseFloat(wh.height / 96);
    document.getElementById("numOfcanvasrows").value = parseInt(wh.rows);
    document.getElementById("numOfcanvascols").value = parseInt(wh.cols);
    var rc = parseInt(wh.rows) * parseInt(wh.cols);
    $("#canvaspages").html('');
    pageindex = 0;
    canvasindex = 0;
    canvasarray = [];
    for (var i = 0; i < (jsonCanvasArray.length - 1) / rc; i++) {
        pageindex = i;
        $("#canvaspages").append("<div class='page' id='page" + pageindex + "'></div>");
        addCanvasToPage(false, i, jsonCanvasArray);
    }
    setCanvasSize();

    var js = jsonCanvasArray[1];
    var ffs = getValues(js,'fontFamily');
    ffs = remove_duplicates(ffs);

    if(ffs && ffs.length == 0) ffs.push('Droid Sans');

    WebFont.load({
        google: {
          families: ffs
        },
        active: function() {

            var totalloaded = 0;
            for (var i = 0; i < canvasindex; i++) {
                (function(lcanvas, json, pos) {
                    lcanvas.clear();
                    
                    lcanvas.loadFromJSON(json, function () {
                        //first render
                        lcanvas.renderAll.bind(lcanvas);

                        initCanvasEvents(lcanvas);
                        initAligningGuidelines(lcanvas);
                        initCenteringGuidelines(lcanvas);

                        lcanvas.index = 0;
                        lcanvas.state = [];

                        totalloaded++;

                        lcanvas.renderAll();

                        $('div.tab-content>div.tab-pane.active').removeClass('active', 2000);
                        $('ul.nav.nav-tabs>li.active').removeClass('active', 2000);
                        $("#leftsection").css("width","120px");

                        setTimeout(function() {
                            restorePattern(lcanvas);
                        }, 300);

                        for (var i = 0; i <= pageindex; i++) {
                            adjustIconPos(i);
                        }

                        if(totalloaded == canvasindex) {

                            resizeDownCanvas();

                            $(".se-pre-con").fadeOut('slow');
                        }
                    });
                })(canvasarray[i], jsonCanvasArray[i+1], i+1);
            }
        },
        classes: false
    });

    //resizeDownCanvas();
    initKeyboardEvents();
}

$(".duplicatecanvas").click(function() {
    var id = this.id;
    id = id.replace("duplicatecanvas", "");
    addNewCanvasPage(true, id);
});

function initKeyboardEvents() {

    $('#canvaspages').keyup(function(e) {

        switch (e.keyCode) {
        case 17:
            remstring = 'ctrl ';
            break;

        case 67:
            remstring = ' c';
            break;

        case 88:
            remstring = ' x';
            break;

        case 86:
            remstring = ' v';
            break;

        case 89:
            remstring = ' z';
            break;

        case 90:
            remstring = ' y';
            break;

        default:
            break;
        }
    
        if (keystring.indexOf(remstring) != -1)
            keystring = keystring.replace(remstring, '');
    });

    $('#canvaspages').keydown(function(e) {

        e.stopImmediatePropagation();

        if(e.target && e.target.nodeName == 'INPUT') return false;

        console.log(keystring)

        switch (e.keyCode) {

            case 17: //ctrl
                e.preventDefault();
                keystring = 'ctrl';
                break;

            case 90: // ctrl + z
                e.preventDefault();
                keystring += ' z';
                if (keystring == "ctrl z") {
                    undo();
                    keystring = 'ctrl';
                }
                break;

            case 89: // ctrl + y
                e.preventDefault();
                keystring += ' y';
                if (keystring == "ctrl y") {
                    redo();
                    keystring = 'ctrl';
                }
                break;

            default:
                break;
        }

        var activeobject = canvas.getActiveObject();
        if (!activeobject) activeobject = canvas.getActiveGroup();
        if (!activeobject && !activeObjectCopy && !activeGroupCopy) return;
        if (activeobject && activeobject.isEditing) return;

        switch (e.keyCode) {
            case 8:
                e.preventDefault();
                deleteItem();
                break;
            case 17://ctrl
                e.preventDefault();
                keystring = 'ctrl';
                break;
            case 173:
            case 109: // -
                e.preventDefault();
                if (e.ctrlKey || e.metaKey) {
                    return objManip('zoomBy-z', -10);
                }
                return true;
            case 61:
            case 107: // +
                if (e.ctrlKey || e.metaKey) {
                    return demo.objManip('zoomBy-z', 10);
                }
                return true;
            case 37: // left
                if (e.shiftKey) {
                    return objManip('zoomBy-x', -1);
                    return false;
                }
                if (e.ctrlKey || e.metaKey) {
                    return objManip('angle', -1);
                }
                return objManip('left', -1);
            case 39: // right
                if (e.shiftKey) {
                    return objManip('zoomBy-x', 1);
                    return false;
                }
                if (e.ctrlKey || e.metaKey) {
                    return objManip('angle', 1);
                }
                return objManip('left', 1);
            case 38: // up
                if (e.shiftKey) {
                    return objManip('zoomBy-y', -1);
                }
                if (!e.ctrlKey && !e.metaKey) {
                    return objManip('top', -1);
                }
                return true;
            case 40: // down
                if (e.shiftKey) {
                    return objManip('zoomBy-y', 1);
                }
                if (!e.ctrlKey && !e.metaKey) {
                    return objManip('top', 1);
                }
                return true;

            case 67: // ctrl + c

                e.preventDefault();
                keystring += ' c';
                if (keystring == "ctrl c") {
                    copyobjs();
                }
                break;

            case 88: // ctrl + x
                e.preventDefault();
                keystring += ' x';
                if (keystring == "ctrl x") {
                    cutobjs();
                }
                break;

            case 86: // ctrl + v
                e.preventDefault();
                keystring += ' v';
                if (keystring == "ctrl v") {
                    pasteobjs();
                }
                break;

            case 46:
                e.preventDefault();
                deleteItem();

                break;
            default:
                break;
        }
        canvas.renderAll();  
        return true;
    });
}

var fontSizeSwitch = document.getElementById('fontsize');
if (fontSizeSwitch) {
    fontSizeSwitch.onchange = function() {
        if (this.value > 200) this.value = 200;
        if (this.value < 6) this.value = 6;
        var fontsize = Math.round(this.value.toLowerCase());
        var activeObject = canvas.getActiveObject();
        if (activeObject && /text/.test(activeObject.type)) {
            setStyle(activeObject, 'fontSize', fontsize);
            activeObject.setCoords();
            canvas.renderAll();
        }
    };
}
$("#font-size-dropdown li a").click(function() {
    var selSize = $(this).text();
    var activeObject = canvas.getActiveObject();
    var activeGroup = canvas.getActiveGroup();
    if(activeGroup){
        activeGroup.forEachObject(function(object) {
            selectedFontSize = selSize;
            setStyle(object, 'fontSize', selectedFontSize);
            object.setCoords();
            canvas.renderAll();
        });
    } else {
        selectedFontSize = selSize;
        setStyle(activeObject, 'fontSize', selectedFontSize);
        activeObject.setCoords();
        canvas.renderAll();
    }
    $(this).parents('.input-group').find('.fontinput').val(selectedFontSize);
});


<!-- Element form validate -->
$(document).ready(function() {
    sortUnorderedList("fonts-dropdown");
    $("#fonts-dropdown li a").click(function() {
        var selText = $(this).text();
        var activeObject = canvas.getActiveObject();
        var activeGroup = canvas.getActiveGroup();
        if(activeGroup){
            activeGroup.forEachObject(function(object) {
                selectedFont = selText;
                setStyle(object, 'fontFamily', selectedFont);
                canvas.renderAll();
            });
        } else {
            selectedFont = selText;
            setStyle(activeObject, 'fontFamily', selectedFont);
            canvas.renderAll();
            cutobjs();
            pasteobjs();
            canvas.setActiveObject(activeObject);
            canvas.renderAll();
        }
        $(this).parents('.btn-group').find('.dropdown-toggle').html('<span style="overflow:hidden">' + selText + '&nbsp;&nbsp;<span class="caret"></span></span>');
    });

    $('#addelementform').validate({
        rules: {
            element_category: {
                required: true
            },
            element_name: {
                required: true
            },
        },
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function(element) {
            element.text('').addClass('valid').closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        submitHandler: function(form) { // <- only fires when form is valid
            var newelmcategory = $("#element_category").val();
            var newelementName = $("#element_name").val();
            var newelement = $("#element_img").val();
			if (!(/\.(svg)$/i).test(newelement)) {              
                $("#AddelementModal").modal('hide');
                $("#svgalertModal").modal('show');
            } else {
                var elementpath = 'uploads/' + newelement;
                $.post("actions/addelement.php", {
                    "elementCategoty": newelmcategory,
                    "elementName": newelementName,
                    "element": elementpath
                }, function(data) {
                    $('#AddelementModal').modal('hide');
                    uploadimage();
                    document.getElementById("successMessage").innerHTML = data;
                    $('#successModal').modal('show');
                    setTimeout(function() {
                        $('#catimage_container').empty();
                        getcategory();
                        getcatimages('');
                    }, 2000);
                    $('#previewImage').hide();
                    $('#addelementform')[0].reset();
                });
            }
        }
    });
});

$('#addbackgroundform').validate({
    rules: {
        bg_category: {
            required: true
        },
        bg_name: {
            required: true
        },
    },
    highlight: function(element) {
        $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
    },
    success: function(element) {
        element.text('').addClass('valid').closest('.form-group').removeClass('has-error').addClass('has-success');
    },
    submitHandler: function(form) { // <- only fires when form is valid
        var newbgcategory = $("#bg_category").val();
        var newbgName = $("#bg_name").val();
        var newbackground = $("#bg_img").val();
        var bgpath = '../admin/uploads/' + newbackground;
        $.post("actions/addbackground.php", {
            "bgCategoty": newbgcategory,
            "bgName": newbgName,
            "background": bgpath
        }, function(data) {
            $('#AddbackgroundModal').modal('hide');
            uploadBgimage();
            document.getElementById("successMessage").innerHTML = data;
            $('#successModal').modal('show');
            setTimeout(function() {
                getBgcategory();
                getbgimages('');
            }, 2000);
            $('#previewBGImage').hide();
            $('#addbackgroundform')[0].reset();
        });
    }
});

function sortUnorderedList(ul, sortDescending) {
    if (typeof ul == "string") ul = document.getElementById(ul);
    // Idiot-proof, remove if you want
    if (!ul) {
        alert("The UL object is null!");
        return;
    }
    // Get the list items and setup an array for sorting
    var lis = ul.getElementsByTagName("LI");
    var vals = [];
    // Populate the array
    for (var i = 0, l = lis.length; i < l; i++) vals.push(lis[i].innerHTML);
    // Sort it
    vals.sort();
    // Sometimes you gotta DESC
    if (sortDescending) vals.reverse();
    // Change the list on the page
    for (var i = 0, l = lis.length; i < l; i++) lis[i].innerHTML = vals[i];
}

function loadTemplate(templateid) {
    $(".se-pre-con").fadeIn('slow');    
    loadedtemplateid = templateid;
    resetZoom();
    deleteCanvasBg(canvas);
    canvas.clear();
    selectedcategory = "";
    $.ajax({
        type: 'GET',
        url: 'actions/findgeofilter.php',
        data:  {
            id: parseInt(templateid)
        },
        success: function(checkgeoval) { 
            if(checkgeoval == 'geofilters') {
                selectedcategory = 'geofilters';
                nextback();
            }
        }
    });

    $.ajax({
        url: "loadtemplate.php",
        type: "get",
        cache: false,
        data: {
            id: parseInt(templateid)
        },
        success: function(data) {
            console.log(data)
            if (data != "empty") {

                savestateaction = false;

                openTemplate(data)
                canvas.calcOffset();
                canvas.renderAll();

                savestateaction = true;
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
            switch (jqXHR.status) {
                case 400:
                    var excp = $.parseJSON(jqXHR.responseText).error;
                    console.log("UnableToComplyException:" + excp.message, 'warning');
                    break;
                case 500:
                    console.log(jqXHR.responseText)
                    var excp = $.parseJSON(jqXHR.responseText).error;
                    console.log("PanicException:" + excp.message, 'panic');
                    break;
                default:
                    console.log("HTTP status=" + jqXHR.status + "," + textStatus + "," + errorThrown + "," + jqXHR.responseText);
            }
        }
    });
}

function loadText(textid) {
    $(".se-pre-con").fadeIn('slow');
    $.ajax({
        url: "loadtext.php",
        type: "get",
        data: {
            id: parseInt(textid)
        },
        success: function(data) {
            console.log(data)
            if (data != "empty") {
                var json = JSON.parse(data);
                var objects = json.objects;
                console.log(objects.length);
                for (var i = 0; i < objects.length; i++) {
                    var object = objects[i];
                    console.log(object)
                    if (object.type == 'textbox') {
                        var txtBox = new fabric.Textbox(object.text, object);
                        canvas.add(txtBox);
                        txtBox.setScaleX(canvasScale);
                        txtBox.setScaleY(canvasScale);
                        setControlsVisibility(txtBox);
                        txtBox.center();
                        txtBox.setCoords();
                        saveState();
                        canvas.calcOffset();
                        canvas.renderAll();
                    }
                    if (object.type == 'group') {
                        var group = object;
                        var groupleft = group.left;
                        var grouptop = group.top;
                        var grpobjects = group.objects;
                        for (var j = 0; j < grpobjects.length; j++) {
                            var object = grpobjects[j];
                            if (object.type == 'textbox') {
                                var txtBox = new fabric.Textbox(object.text, object);
                                canvas.add(txtBox);
                                txtBox.setLeft(txtBox.left + canvas.width / 2);
                                txtBox.setTop(txtBox.top + canvas.height / 2);
                                txtBox.setScaleX(canvasScale);
                                txtBox.setScaleY(canvasScale);
                                txtBox.setCoords();
                            }
                        }
                        canvas.calcOffset();
                        saveState();
                        canvas.renderAll();
                    }
                }
                $(".se-pre-con").fadeOut('slow');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            switch (jqXHR.status) {
                case 400:
                    var excp = $.parseJSON(jqXHR.responseText).error;
                    console.log("UnableToComplyException:" + excp.message, 'warning');
                    break;
                case 500:
                    var excp = $.parseJSON(jqXHR.responseText).error;
                    console.log("PanicException:" + excp.message, 'panic');
                    break;
                default:
                    console.log("HTTP status=" + jqXHR.status + "," + textStatus + "," + errorThrown + "," + jqXHR.responseText);
            }
        }
    });
}

function loadElement(elementid) {
    $(".se-pre-con").fadeIn('slow');
    $.ajax({
        url: "loadelement.php",
        type: "get",
        data: {
            id: parseInt(elementid)
        },
        success: function(data) {
            var json = JSON.parse(data);
            fabric.util.enlivenObjects([json], function(objects) {
                var origRenderOnAddRemove = canvas.renderOnAddRemove;
                canvas.renderOnAddRemove = false;
                objects.forEach(function(o) {
                    canvas.add(o);
                    o.setCoords();
                    o.center();
                    var items = o._objects;
                    o._restoreObjectsState();
                    canvas.remove(o);
                    for(var i = 0; i < items.length; i++) {
                      canvas.add(items[i]);
                    }
                });
                canvas.renderOnAddRemove = origRenderOnAddRemove;
                canvas.renderAll();
            });
            $(".se-pre-con").fadeOut('slow');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            switch (jqXHR.status) {
                case 400:
                    var excp = $.parseJSON(jqXHR.responseText).error;
                    console.log("UnableToComplyException:" + excp.message, 'warning');
                    break;
                case 500:
                    var excp = $.parseJSON(jqXHR.responseText).error;
                    console.log("PanicException:" + excp.message, 'panic');
                    break;
                default:
                    console.log("HTTP status=" + jqXHR.status + "," + textStatus + "," + errorThrown + "," + jqXHR.responseText);
            }
        }
    });
}
var objectFlipHorizontalSwitch = document.getElementById('objectfliphorizontal');
if (objectFlipHorizontalSwitch) {
    objectFlipHorizontalSwitch.onclick = function() {
        var activeObject = canvas.getActiveObject();
        var grpobjs = canvas.getActiveGroup();
        if(grpobjs) {
            grpobjs.forEachObject(function(object) {
                if (object.flipX) object.flipX = false;
                else object.flipX = true;
                canvas.renderAll();
                saveState();
            }); 
        } else {
            if (activeObject.flipX) activeObject.flipX = false;
            else activeObject.flipX = true;
            canvas.renderAll();
            saveState();
        }
    };
}
var objectFlipVerticalSwitch = document.getElementById('objectflipvertical');
if (objectFlipVerticalSwitch) {
    objectFlipVerticalSwitch.onclick = function() {
        var activeObject = canvas.getActiveObject();
        var grpobjs = canvas.getActiveGroup();
        if(grpobjs) {
            grpobjs.forEachObject(function(object) {
                if (object.flipY) object.flipY = false;
                else object.flipY = true;
                canvas.renderAll();
                saveState();
            }); 
        } else {
            if (activeObject.flipY) activeObject.flipY = false;
            else activeObject.flipY = true;
            canvas.renderAll();
            saveState();
        }
    };
}
//Lock object
var objectLock = document.getElementById('objectlock');
if (objectLock) {
    objectLock.onclick = function() {
        var activeObject = canvas.getActiveObject();
        if (!activeObject) return;
        if (activeObject.type == "group") {
            canvas.deactivateAllWithDispatch().renderAll();
            activeObject.forEachObject(function(object) {
                lockSelObject(object);
            });
        } else {
            lockSelObject(activeObject);
        }
    };
}

function lockSelObject(selObj) {

    if (selObj) {
        if (selObj.lockMovementY) {
            selObj.lockMovementY = selObj.lockMovementX = selObj.lockScalingY = selObj.lockScalingX = false;
            selObj.hasControls = true;
            selObj.hoverCursor = 'pointer';
            selObj.locked = false;
        } else {
            selObj.lockMovementY = selObj.lockMovementX = selObj.lockScalingY = selObj.lockScalingX = true;
            selObj.hasControls = false;
            selObj.hoverCursor = 'url("../img/lockcursor.png") 10 10, pointer';
            selObj.locked = true;
            selObj.lockedleft = selObj.left;
            selObj.lockedtop = selObj.top;
        }
        canvas.renderAll();
        saveState();
    }
}

//Changes opacity of active object
var ChangeOpacity = function() {
    var activeObject = canvas.getActiveObject();
    var grpobjs = canvas.getActiveGroup();
    if(grpobjs) {
        grpobjs.forEachObject(function(object) {
            object.setOpacity(co.getValue());
            canvas.renderAll();
            saveState();
        }); 
    } else {
        activeObject.setOpacity(co.getValue());
        canvas.renderAll();
        saveState();
    }
};
var co = $("#changeopacity").slider().on('slide', ChangeOpacity).data('slider');

var clonebtn = document.getElementById('clone');
if (clonebtn) {
    clonebtn.onclick = function() {
        var activeObject = canvas.getActiveObject();
        var activeGroup = canvas.getActiveGroup();
        if (activeGroup) {
            activeGroup.forEachObject(function(object) {
                cloneSelObject(object);
            });
        } else {
            cloneSelObject(activeObject);
        }
    }
}

function cloneSelObject(actobj) {
    if (fabric.util.getKlass(actobj.type).async) {
        actobj.clone(function(clone) {
            clone.set({
                left: actobj.getLeft() + 70,
                top: actobj.getTop() + 70
            });
            canvas.add(clone);
        });
    } else {
        canvas.add(actobj.clone().set({
            left: actobj.getLeft() + 70,
            top: actobj.getTop() + 70
        }));
    }
}
var sendLayerBackSwitch = document.getElementById('sendbackward');
if (sendLayerBackSwitch) {
    sendLayerBackSwitch.onclick = function() {
        var activeObject = canvas.getActiveObject();
        var grpobjs = canvas.getActiveGroup();
        if(grpobjs) {
            grpobjs.forEachObject(function(object) {
                canvas.sendBackwards(object);
                canvas.renderAll();
                saveState();
            }); 
        } else {
            canvas.sendBackwards(activeObject);
            canvas.renderAll();
            saveState();
        }
    }
}
var bringLayerFrontSwitch = document.getElementById('bringforward');
if (bringLayerFrontSwitch) {
    bringLayerFrontSwitch.onclick = function() {
        var activeObject = canvas.getActiveObject();
        var grpobjs = canvas.getActiveGroup();
        if(grpobjs) {
            grpobjs.forEachObject(function(object) {
                canvas.bringForward(object);
                canvas.renderAll();
                saveState();
            }); 
        } else {
            canvas.bringForward(activeObject);
            canvas.renderAll();
            saveState();
        }
    }
}

fabric.Cropzoomimage = fabric.util.createClass(fabric.Image, {
    type: 'cropzoomimage',
    zoomedXY: false,
    initialize: function(element, options) {
        options || (options = {});
        this.callSuper('initialize', element, options);
        this.set({
            orgSrc: element.src,
            cx: 0, // clip-x
            cy: 0, // clip-y
            cw: element.width, // clip-width
            ch: element.height, // clip-height
            asw: element.width, //aspect ratio width
            ash: element.height //aspect ratio height
        });
    },
    zoomBy: function(x, y, z, callback) {
        if (x || y) {
            this.zoomedXY = true;
        }
        this.cx += x;
        this.cy += y;

        if (z && (((this.cw-z) > this.asw) || ((this.ch - z / (this.width / this.height)) > this.ash)))
            return false;

        if (z) {
            this.cw -= z;
            this.ch -= z / (this.width / this.height);
        }

        if (z && !this.zoomedXY) {
            // Zoom to center of image initially
            this.cx = this.width / 2 - (this.cw / 2);
            this.cy = this.height / 2 - (this.ch / 2);
        }
        if (this.cw > this.width) {
            this.cw = this.width;
        }
        if (this.ch > this.height) {
            this.ch = this.height;
        }
        if (this.cw < 1) {
            this.cw = 1;
        }
        if (this.ch < 1) {
            this.ch = 1;
        }
        if (this.cx < 0) {
            this.cx = 0;
        }
        if (this.cy < 0) {
            this.cy = 0;
        }
        if (this.cx > this.width - this.cw) {
            this.cx = this.width - this.cw;
        }
        if (this.cy > this.height - this.ch) {
            this.cy = this.height - this.ch;
        }
        this.rerender(callback);
    },
    rerender: function(callback) {
        var img = new Image(),
            obj = this;
        img.onload = function() {
            var canvas = fabric.util.createCanvasElement();
            canvas.width = obj.width;
            canvas.height = obj.height;
            canvas.getContext('2d').drawImage(this, obj.cx, obj.cy, obj.cw, obj.ch, 0, 0, obj.width, obj.height);
            img.onload = function() {
                obj.setElement(this);
                obj.applyFilters(canvas.renderAll);
                obj.set({
                    left: obj.left,
                    top: obj.top,
                    angle: obj.angle
                });
                obj.setCoords();
                if (callback) {
                    callback(obj);
                }
            };
            img.src = canvas.toDataURL('image/png');
        };
        img.src = this.orgSrc;
    },
    toObject: function() {
        return fabric.util.object.extend(this.callSuper('toObject'), {
            orgSrc: this.orgSrc,
            cx: this.cx,
            cy: this.cy,
            cw: this.cw,
            ch: this.ch
        });
    }
});
fabric.Cropzoomimage.async = true;
fabric.Cropzoomimage.fromObject = function(object, callback) {
    fabric.util.loadImage(object.src, function(img) {
        fabric.Image.prototype._initFilters.call(object, object, function(filters) {
            object.filters = filters || [];
            var instance = new fabric.Cropzoomimage(img, object);
            if (callback) {
                callback(instance);
            }
        });
    }, null, object.crossOrigin);
};
zoomBy = function(x, y, z) {
    var activeObject = canvas.getActiveObject();
    if (activeObject) {
        activeObject.zoomBy(x, y, z, function() {
            canvas.renderAll()
        });
    }
};
objManip = function(prop, value) {
    var obj = canvas.getActiveObject();
    var grpobjs = canvas.getActiveGroup();
    if (!obj && !grpobjs) {
        return true;
    }
    switch (prop) {
        case 'zoomBy-x':
            obj.zoomBy(value, 0, 0, function() {
                canvas.renderAll()
            });
            break;
        case 'zoomBy-y':
            obj.zoomBy(0, value, 0, function() {
                canvas.renderAll()
            });
            break;
        case 'zoomBy-z':
            obj.zoomBy(0, 0, value, function() {
                canvas.renderAll()
            });
            break;
        default:
            if(obj && obj.lockMovementX == false) {
                obj.set(prop, obj.get(prop) + value);
            }
            if(grpobjs) {
                grpobjs.set(prop, grpobjs.get(prop) + value);
                grpobjs.setCoords();
            }
            break;
    }
    if (obj && ('left' === prop || 'top' === prop)) {
        obj.setCoords();
    }
    canvas.renderAll();
    return false;
};

function rgbToHex(r, g, b) {
    return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
}

function onlyUnique(value, index, self) {
    return self.indexOf(value) === index;
}

function getinfotextobj(lcanvas) {
    //to improve the performance of the movement the coords are disabled.
    return;
}

function cutobjs() {
    activeObjectCopy = canvas.getActiveObject();
    activeGroupCopy = canvas.getActiveGroup();
    if (activeObjectCopy || activeGroupCopy) {
        var jsonData;
        if (activeGroupCopy) {
            var jsonCanvas = activeGroupCopy.toJSON();
            jsonData = JSON.stringify(jsonCanvas);
        } else if (activeObjectCopy) {
            var jsonCanvas = activeObjectCopy.toJSON();
            jsonData = JSON.stringify(jsonCanvas);
        }
    }
    if (activeGroupCopy) {
        var objectsInGroup = activeGroupCopy.getObjects();
        canvas.discardActiveGroup();
        objectsInGroup.forEach(function(object) {
            canvas.remove(object);
        });
    } else if (activeObjectCopy) {
        canvas.remove(activeObjectCopy);
    }
}

function selectallobjs() {
    var objs = canvas.getObjects().map(function(o) {
        return o.set('active', true);
    });

    var objs = canvas.getObjects().filter(function(o) {
        return o.bg != true;
    });

    var group = new fabric.Group(objs, {
        originX: 'center',
        originY: 'center'
    });
    canvas._activeObject = null;
    canvas.setActiveGroup(group.setCoords()).renderAll();
}

function copyobjs() {
    activeObjectCopy = canvas.getActiveObject();
    activeGroupCopy = canvas.getActiveGroup();
    if (activeObjectCopy || activeGroupCopy) {
        var jsonData;
        if (activeGroupCopy) {
            var jsonCanvas = activeGroupCopy.toJSON();
            jsonData = JSON.stringify(jsonCanvas);
        } else if (activeObjectCopy) {
            var jsonCanvas = activeObjectCopy.toJSON();
            jsonData = JSON.stringify(jsonCanvas);
        }
    }
}

function pasteobjs() {
    if (activeGroupCopy) {
        var objectsInGroup = activeGroupCopy.getObjects();
        canvas.discardActiveGroup();
        objectsInGroup.forEach(function(object) {
            if (fabric.util.getKlass(object.type).async) {
                object.clone(function(clone) {
                    canvas.add(clone);
                });
            } else {
                canvas.add(object.clone());
            }
        });
    } else if (activeObjectCopy) {
        if (fabric.util.getKlass(activeObjectCopy.type).async) {
            activeObjectCopy.clone(function(clone) {
                canvas.add(clone);
            });
        } else {
            canvas.add(activeObjectCopy.clone());
        }
    }
    canvas.renderAll();
}

function toSVG() {    
    window.open(
      'data:image/svg+xml;utf8,' +
      encodeURIComponent(canvas.toSVG()));
}

function resizeDownCanvas() {
    if(Math.round(canvas.width) - 20 >= $("#rightsection").width()) {
        zoomOut();
        resizeDownCanvas();
    }
}

$('#strokeline').spectrum({
	parts: ['header', 'cmyk', 'preview', 'swatches', 'footer'],
	alpha: true,
	layout: {
		preview: [0, 0, 0, 1],
	  //  swatches: [2, 2, 1, 4],
	  //  cmyk:       [1, 5, 1, 2]
	},
	position: {
		my: 'top+5%',
		at: 'left+100',
		of: '#strokeline'
	},
	init: function() {
		var activeobject = canvas.getActiveObject();
		if (activeobject) {
			$('#strokeline i').css('color', activeobject.fill);
		}
	},
	move: function(color) {
        var colorVal = color.toHexString(); // #ff0000
        var activeobject = canvas.getActiveObject();
        if (activeobject) {
            changeStorkColor(colorVal);
            $('#strokeline i').css('color', colorVal);
        } else {
            changeStorkColor('#000000');
        }
    },
	select: function(event, color) {
		var colorval = ('#' + color.formatted);
		$('#strokeline i').css('color', colorval);
		changeStorkColor(colorval);
	}
});

$('#nofill').click(function () {
    var isShapeNoFill = $('#nofill').is(":checked");
    var obj = canvas.getActiveObject();
    if (obj && obj.type == "rect" || obj.type == "circle" || obj.type == "triangle") {
        if (obj && isShapeNoFill == true) {
            obj.prevfill = obj.fill;
            obj.fill = 'Transparent';
            obj.set('onfill', true);
        } else if (obj && isShapeNoFill == false) {            
            if(obj.prevfill) {
                obj.setFill(obj.prevfill);
            } else
            obj.set('onfill', false);
        }
        saveState();
    }
    canvas.renderAll();
});

$('#storkewidth').change(function () {
    var strokeWidth = $(this).val();
    var obj = canvas.getActiveObject();
    if (obj) {
        obj.strokeWidth = parseInt(strokeWidth);
        obj.setCoords();
    }
    canvas.calcOffset();
    canvas.renderAll();
});

function addShape(shape) {
    var stroke = $('#strokeline i').css('color');
    var fill = $('#fillshape i').css('color');
    var strokewidth = parseInt($('#storkewidth').val());

    var isShapeNoFill = $('#nofill').is(":checked");

    $('#shapeselectdropdown').val("");

    if(isShapeNoFill) 
        fill = 'Transparent';

    if(!fill) fill = 'black';

    if (shape == 'circle') {

        var circle = new fabric.Circle({
            radius: 40,
            originX: "center",
            originY: "center",
            strokeWidth: strokewidth,
            fill: fill,
            stroke: stroke,
            onfill: false
                //opacity: 0.5
        });

        savestateaction = false;
        canvas.add(circle);        
        savestateaction = true;
        circle.center();
        circle.setCoords();
        canvas.setActiveObject(circle);
        canvas.renderAll();
    } else if (shape == 'rectangle') {
        var rectangle = new fabric.Rect({

            width: 100,
            height: 60,
            originX: 'left',
            originY: 'top',
            strokeWidth: strokewidth,
            fill: fill,
            stroke: stroke,
            onfill: false
                //opacity: 0.5

        });

        savestateaction = false;
        canvas.add(rectangle);    
        savestateaction = true;
        rectangle.center();
        rectangle.setCoords();
        canvas.renderAll();
        canvas.setActiveObject(rectangle);

    } else if (shape == 'square') {
        var square = new fabric.Rect({
            width: 60,
            height: 60,
            originX: 'left',
            originY: 'top',
            strokeWidth: strokewidth,
            fill: fill,
            stroke: stroke,
            onfill: false
                //opacity: 0.5
        });

        savestateaction = false;
        canvas.add(square);
        savestateaction = true;
        square.center();
        square.setCoords();
        canvas.renderAll();
        canvas.setActiveObject(square);

    } else if (shape == 'triangle') {
        var triangle = new fabric.Triangle({
            top: 250,
            left: 96,
            width: 100,
            height: 100,
            strokeWidth: strokewidth,
            fill: fill,
            stroke: stroke,
            onfill: false
                //opacity: 0.5
        });
        savestateaction = false;
        canvas.add(triangle);
        savestateaction = true;
        triangle.center();
        triangle.setCoords();
        canvas.renderAll();
        canvas.setActiveObject(triangle);
		
    } else if (shape == 'line') {
		var line = new fabric.Line([50, 50, 100, 50], {            
            fill: fill,
            stroke: stroke,
            onfill: false
        });
        savestateaction = false;
        canvas.add(line);
        savestateaction = true;
        line.center();
        line.setCoords();
        canvas.renderAll();
        canvas.setActiveObject(line);

	}
}
function changeStorkColor(hex) {
    var obj = canvas.getActiveObject();
    if (obj) {
        obj.setStroke(hex);
        saveState();
    }
    canvas.renderAll();
}

function changefillColor(hex) {
    var obj = canvas.getActiveObject();
    if(!obj) return;
    if (obj.onfill == false) {
        obj.setFill(hex);
    } else if (obj.onfill == true) {
        obj.fill = 'Transparent';
    }
    saveState();
    canvas.renderAll();
}
var files;
$('#bg_uploadimg').on('change', prepareimageBGUpload);

function prepareimageBGUpload(event) {
    $(".se-pre-con").fadeIn('slow');
    $("#AdduploadimageModal").modal('hide')
    files = event.target.files;
}

function upload_imge() {
    var data = new FormData();
    //adding file content to data
    $.each(files, function(key, value) {
        data.append("bg_uploadimg", value);
    });
    $.ajax({
        url: 'uploadimage.php?files',
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function(data) {
            alert(data)
             $(".se-pre-con").fadeOut('slow');
        }
    });
}

// function to remove duplicates from the array
function remove_duplicates(arr) {
    var obj = {};
    for (var i = 0; i < arr.length; i++) {
        obj[arr[i]] = true;
    }
    arr = [];
    for (var key in obj) {
        arr.push(key);
    }
    return arr;
}

//return an array of objects according to key, value, or key and value matching
function getObjects(obj, key, val) {
    var objects = [];
    for (var i in obj) {
        if (!obj.hasOwnProperty(i)) continue;
        if (typeof obj[i] == 'object') {
            objects = objects.concat(getObjects(obj[i], key, val));
        } else
        //if key matches and value matches or if key matches and value is not passed (eliminating the case where key matches but passed value does not)
        if (i == key && obj[i] == val || i == key && val == '') { //
            objects.push(obj);
        } else if (obj[i] == val && key == ''){
            //only add if the object is not already in the array
            if (objects.lastIndexOf(obj) == -1){
                objects.push(obj);
            }
        }
    }
    return objects;
}

//return an array of values that match on a certain key
function getValues(obj, key) {
    var objects = [];
    for (var i in obj) {
        if (!obj.hasOwnProperty(i)) continue;
        if (typeof obj[i] == 'object') {
            objects = objects.concat(getValues(obj[i], key));
        } else if (i == key) {
            objects.push(obj[i]);
        }
    }
    return objects;
}

//return an array of keys that match on a certain value
function getKeys(obj, val) {
    var objects = [];
    for (var i in obj) {
        if (!obj.hasOwnProperty(i)) continue;
        if (typeof obj[i] == 'object') {
            objects = objects.concat(getKeys(obj[i], val));
        } else if (obj[i] == val) {
            objects.push(i);
        }
    }
    return objects;
}

function proceed_savetemplate() {
    $("#savetemplate_modal").modal('hide');
    $(".se-pre-con").fadeIn('slow');
    resetZoom();
    canvas.deactivateAllWithDispatch().renderAll();
    $(".se-pre-con").fadeIn('slow');
    if (issaveastemplate) {
        if (isadmin) { saveAsTemplateFile(); }
        if (isclient) { saveAsTemplateFileclient(); }
    }
    if (issavetemplate) {
        if (isadmin) { saveTemplateFile(); }
        if (isclient) { saveTemplateFileclient(); }
    }
}

function saveTemplateFile() {
	if (totalsvgs == convertedsvgs && loadedtemplateid != 0) {
		issavetemplate = false;
        isadmin = false;
		var jsonCanvasArray = [];
		var width = document.getElementById("loadCanvasWid").value,
			height = document.getElementById("loadCanvasHei").value,
			rows = document.getElementById("numOfcanvasrows").value,
			cols = document.getElementById("numOfcanvascols").value;
		//inch to pixel
		width = width * 96;
		height = height * 96;
		var wh = '{\"width\": ' + width + ', \"height\": ' + height + ', \"rows\": ' + rows + ', \"cols\": ' + cols + '}';
		jsonCanvasArray.push(wh);
		var firstcanvas;
		for (var i = 0; i < canvasindex; i++) {
			if (!canvasarray[i]) continue;
			canvasarray[i].deactivateAll().renderAll();
			if ($("#divcanvas" + i).is(":visible")) {
				if (!firstcanvas || (firstcanvas.getObjects().length < canvasarray[i].getObjects().length)) firstcanvas = canvasarray[i];
				jsonCanvasArray.push(canvasarray[i].toDatalessJSON());
			}
		}
/*        alert(isadmin);
        alert(isclient);
*/		var jsonData = JSON.stringify(jsonCanvasArray);
		var pngdataURL = firstcanvas.toDataURL("image/png");
		var path = "templates";
		$.ajax({
			type: 'POST',
			url: 'savetemplate.php',
			data: {
				pngimageData: pngdataURL,
				path: path,
				jsonData: jsonData,
				templateid: loadedtemplateid/*,
                isadmin: isadmin,
                isclient: isclient*/
			},
			success: function(msg) {
/*                isadmin=false;
                isclient=false;
*/                // loadedtemplateid = templateid;
				getTemplates('', true, loadedtemplateid);				
                resizeDownCanvas();
				$(".se-pre-con").fadeOut('slow');
			}
		})
	} else if(totalsvgs == convertedsvgs && loadedtemplateid == 0) {
		issavetemplate = false;
		issaveastemplate = true;
        isadmin=false;
        isclient=false;
		$(".se-pre-con").fadeOut('slow');
		$('#templateSaveModal').modal('hide');
		$('#savetemplate_modal').modal('show');
	}
}
function saveTemplateFileclient() {
    // showCanvasBg();
    issavetemplate = false;
    isclient = false;
    var jsonCanvasArray = [];
    var width = document.getElementById("loadCanvasWid").value,
        height = document.getElementById("loadCanvasHei").value,
        rows = document.getElementById("numOfcanvasrows").value,
        cols = document.getElementById("numOfcanvascols").value;
    //inch to pixel
    width = width * 96;
    height = height * 96;
    var wh = '{\"width\": ' + width + ', \"height\": ' + height + ', \"rows\": ' + rows + ', \"cols\": ' + cols + '}';
    jsonCanvasArray.push(wh);
    var firstcanvas;
    for (var i = 0; i < canvasindex; i++) {
        if (!canvasarray[i]) continue;
        canvasarray[i].deactivateAll().renderAll();
        if ($("#divcanvas" + i).is(":visible")) {
            if (!firstcanvas || (firstcanvas.getObjects().length < canvasarray[i].getObjects().length)) firstcanvas = canvasarray[i];
            jsonCanvasArray.push(canvasarray[i].toDatalessJSON());
        }
    }
    var jsonData = JSON.stringify(jsonCanvasArray);
    var pngdataURL = firstcanvas.toDataURL("image/png");
    var filename = $('#flyername').val();
    var path = "../client/templates/";

    var url = "../client/updatetemplate.php";
    if (loadedtemplateid == 0)
        url = '../client/saveastemplate.php';

    $.ajax({
        type: 'POST',
        url: url,
        data: {
            pngimageData: pngdataURL,
            path: path,
            filename: filename,
            jsonData: jsonData,
            templateid: loadedtemplateid
        },
        success: function(templateid) {
            loadedtemplateid = templateid;
            getTemplates('', true, templateid);
            resetZoom();
            $('#saveflyer_modal').modal('hide');
            $(".se-pre-con").fadeOut('slow');
        }
    })
}

function newtemp(isfind) {

    if(isfind == "admin") {

        location.href= "../admin/index.php?newtemplate";

    }

    if (isfind == "client") {

        location.href= "../client/index.php?newtemplate";

    }

}

if (window.location.href.indexOf('?newtemplate') != -1) {

    $("#canvaswh_modal").modal('show');

}

function saveAsTemplateFile() {
	if (totalsvgs == convertedsvgs) {
		issaveastemplate = false;
		var jsonCanvasArray = [];
		var width = document.getElementById("loadCanvasWid").value,
			height = document.getElementById("loadCanvasHei").value,
			rows = document.getElementById("numOfcanvasrows").value,
			cols = document.getElementById("numOfcanvascols").value;
		width = width * 96;
		height = height * 96;
		var wh = '{\"width\": ' + width + ', \"height\": ' + height + ', \"rows\": ' + rows + ', \"cols\": ' + cols + '}';
		jsonCanvasArray.push(wh);
		var firstcanvas;
		for (var i = 0; i < canvasindex; i++) {
			if (!canvasarray[i]) continue;
			canvasarray[i].deactivateAll().renderAll();
			if ($("#divcanvas" + i).is(":visible")) {
				if (!firstcanvas || (firstcanvas.getObjects().length < canvasarray[i].getObjects().length)) firstcanvas = canvasarray[i];
				jsonCanvasArray.push(canvasarray[i].toDatalessJSON());
			}
		}
		var jsonData = JSON.stringify(jsonCanvasArray);
        var pngdataURL = firstcanvas.toDataURL("image/png");
		var filename = $('#templatename').val();
		var categoryId = $('#template_category option:selected').val();
		var path = "templates";
		$.ajax({
			type: 'POST',
			url: 'saveastemplate.php',
			data: {
				pngimageData: pngdataURL,
				path: path,
				filename: filename,
				category: categoryId,
                jsonData: jsonData
			},
			success: function(msg) {
				loadedtemplateid = msg;
				getTemplates('', true);
                resizeDownCanvas();
				$(".se-pre-con").fadeOut('slow');
			}
		})
	}
}

function saveAsTemplateFileclient() {
    // showCanvasBg();
    issaveastemplate = false;
    var jsonCanvasArray = [];
    var width = document.getElementById("loadCanvasWid").value,
        height = document.getElementById("loadCanvasHei").value,
        rows = document.getElementById("numOfcanvasrows").value,
        cols = document.getElementById("numOfcanvascols").value;
    //inch to pixel
    width = width * 96;
    height = height * 96;
    var wh = '{\"width\": ' + width + ', \"height\": ' + height + ', \"rows\": ' + rows + ', \"cols\": ' + cols + '}';
    jsonCanvasArray.push(wh);
    var firstcanvas;
    for (var i = 0; i < canvasindex; i++) {
        if (!canvasarray[i]) continue;
        canvasarray[i].deactivateAll().renderAll();
        if ($("#divcanvas" + i).is(":visible")) {
            if (!firstcanvas || (firstcanvas.getObjects().length < canvasarray[i].getObjects().length)) firstcanvas = canvasarray[i];
            jsonCanvasArray.push(canvasarray[i].toDatalessJSON());
        }
    }

    var jsonData = JSON.stringify(jsonCanvasArray);
    var pngdataURL = firstcanvas.toDataURL("image/png");
    var filename = $('#templatename').val();
    var path = "../client/templates";

    $.ajax({
        type: 'POST',
        url: '../client/saveastemplate.php',
        data: {
            pngimageData: pngdataURL,
            path: path,
            filename: filename,
            jsonData: jsonData
        },
        success: function(templateid) {
            loadedtemplateid = templateid;
            getTemplates('', true, templateid);
            resetZoom();
            $('#savetemplate_modal').modal('hide');
            $(".se-pre-con").fadeOut('slow');
        }
    })

}


$("#savetemplateadmin").click(function() {
    issavetemplate = true;
    isadmin = true;
    proceed_savetemplate();
});
$("#savetemplateclient").click(function() {
    issavetemplate = true;
    isclient = true;
    proceed_savetemplate();
});

function restorePattern(lcanvas) {

    savestateaction = false;

    objs = lcanvas.getObjects().filter(function(o) {
        return o.type == "textbox" && (typeof o.fill == 'object');
    });

    objs.forEach(function(o) {
        lcanvas.setActiveObject(o);                
    });

    lcanvas.renderAll();

    savestateaction = true;
}

function loadPattern(url) {
    var actobj = canvas.getActiveObject();
    if(actobj && ( actobj.type == 'textbox' ||  actobj.type == 'text' ||  actobj.type == 'textbox'))
    fabric.util.loadImage(url, function(img) {

        var pattern = new fabric.Pattern({
            source: img,
            repeat: 'repeat'
        });
        
        actobj.fill = pattern;

        var option = {};
        option['fill'] = pattern;
        actobj.set(option);

        actobj.setCoords();
        canvas.setActiveObject(actobj);
        canvas.renderAll();
    });
}

var textuppercaseSwitch = document.getElementById('textuppercase');
if (textuppercaseSwitch) {
    textuppercaseSwitch.onclick = function() {
    var activeObject = canvas.getActiveObject();
    var activeGroup = canvas.getActiveGroup();
    if (!activeObject && !activeGroup) return;
        if (activeGroup) {
            canvas.discardActiveGroup().renderAll();
             activeGroup.forEachObject(function(object) {
               if (object && /textbox/.test(object.type)) {
                    object.text = object.text.toUpperCase();
                    canvas.renderAll();
                }
            });
        }  else {
            activeObject.text = activeObject.text.toUpperCase();
            canvas.renderAll();
        }
    };
}

var textlowercaseSwitch = document.getElementById('textlowercase');
if (textlowercaseSwitch) {
    textlowercaseSwitch.onclick = function() {
    var activeObject = canvas.getActiveObject();
    var activeGroup = canvas.getActiveGroup();
    if (!activeObject && !activeGroup) return;
        if (activeGroup) {
            canvas.discardActiveGroup().renderAll();
             activeGroup.forEachObject(function(object) {
               if (object && /textbox/.test(object.type)) {
                    object.text = object.text.toLowerCase();
                    canvas.renderAll();
                }
            });
        }  else {
            activeObject.text = activeObject.text.toLowerCase();
            canvas.renderAll();
        }
    };
}

var textcapitalizeSwitch = document.getElementById('textcapitalize');
if (textcapitalizeSwitch) {
    textcapitalizeSwitch.onclick = function() {
    var activeObject = canvas.getActiveObject();
    var activeGroup = canvas.getActiveGroup();
    if (!activeObject && !activeGroup) return;
        if (activeGroup) {
            canvas.discardActiveGroup().renderAll();
             activeGroup.forEachObject(function(object) {
               if (object && /textbox/.test(object.type)) {
                    object.text = object.text.toLowerCase();
                    object.text = capitalizeFirstAllWords(object.text);
                    canvas.renderAll();
                }
            });
        }  else {
            activeObject.text = activeObject.text.toLowerCase();
            activeObject.text = capitalizeFirstAllWords(activeObject.text);
            canvas.renderAll();
        }
    };
}

function capitalizeFirstAllWords( str )
{
    var pieces = str.split(" ");
    for ( var i = 0; i < pieces.length; i++ )
    {
        var j = pieces[i].charAt(0).toUpperCase();
        pieces[i] = j + pieces[i].substr(1);
    }
    return pieces.join(" ");
}


function loadAdminTemplate(templateid) {
    $(".se-pre-con").fadeIn('slow');
    selectedcategory = "";
    chkdatcatid = "";
    $.ajax({
        type: 'get',
        url: '../client/actions/check_geo.php',
        data: {
            id: parseInt(templateid)
        },
        success: function(checkeddata) { 
            var arrchekdat = checkeddata.split('+');
            var chkdat = arrchekdat[0];
            chkdatcatid = arrchekdat[1];
            if(chkdat == "geofilters"){
                hideCanvasBg();
                selectedcategory = chkdat;
                $('.forward').css('display', 'block');
                $('.backward').css('display', 'block');
            } else {
                $('.forward').css('display', 'none');
                $('.backward').css('display', 'none');
            }
        }
    });

    $.ajax({
        url: "../client/loadadmintemplate.php",
        type: "get",
        data: {
            id: parseInt(templateid)
        },
        cache: false,
        success: function(data) {
            if (data=="") {
                $(".se-pre-con").fadeOut('hide');
            } else {
                savestateaction = false;
                isadmintemplate = true;
                openTemplate(data)
                canvas.calcOffset();
                canvas.renderAll();
                savestateaction = true;
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            switch (jqXHR.status) {
                case 400:
                    var excp = $.parseJSON(jqXHR.responseText).error;
                    console.log("UnableToComplyException:" + excp.message, 'warning');
                    break;
                case 500:
                    var excp = $.parseJSON(jqXHR.responseText).error;
                    console.log("PanicException:" + excp.message, 'panic');
                    break;
                default:
                    console.log("HTTP status=" + jqXHR.status + "," + textStatus + "," + errorThrown + "," + jqXHR.responseText);
            }
        }
    });
}
